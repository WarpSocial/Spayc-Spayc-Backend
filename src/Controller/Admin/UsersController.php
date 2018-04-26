<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Api\Auth\ApiHasher;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Api\Utils\Utils;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AdminController
{
    use MailerAwareTrait;
    public function initialize() {
        parent::initialize();        
        $this->loadComponent('Api.Push');
        $this->Spaycs = TableRegistry::get('Spaycs');
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout','forgotPassword', 'resetPassword','getUserObj', 'success']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {           
        $this->set('title', $this->siteTitleMessage['MANAGEUSER']);
        $conditions_array = [];
        $ageArr = unserialize(USER_AGE);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):'';
        $query=$this->Users->find()
            ->where(['Users.role_id IS'=> null])
            ->contain([                                       
                'JoinedSpayc'=>function($q) {
                    $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);                  
                    $q->innerJoinWith('Spaycs',function($qq) {
                        $qq->select(['Spaycs.user_id','Spaycs.id','Spaycs.parent_id'])->where(['Spaycs.group_type !=' =>'trusted_private','Spaycs.parent_id IS'=>null]); 
                        return $qq;                        
                    });
                    return $q;
                },
                'Requestedby' => function($q) {
                   return $q->select(['Requestedby.requested_by','count' => $q->func()->count('Requestedby.id')])->group(['Requestedby.requested_by'])->Where(['Requestedby.requested_status'=>FRIEND_REQUESTED_STATUS]);
                },
                'Requestedto' => function($q) {
                   return $q->select(['Requestedto.requested_to','count' => $q->func()->count('Requestedto.id')])->group(['Requestedto.requested_to'])->Where(['Requestedto.requested_status'=>FRIEND_REQUESTED_STATUS]);
                }
              
            ]);  
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->createdSpayc=$row->joinedSpayc=0;
                if(isset($row['joined_spayc']) && !empty($row['joined_spayc'])) {
                $joinedSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined]');
                $createdSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[is_admin=2,status=Joined]');
                $row->joinedSpayc=count($joinedSpayc);
                $row->createdSpayc=count($createdSpayc);
                unset($row['joined_spayc']);
                }               
                $row->friend = !empty($row['requestedto'][0]['count'])? $row['requestedto'][0]['count'] : BLANK_COUNT;
                $row->friend += !empty($row['requestedby'][0]['count'])? $row['requestedby'][0]['count'] : BLANK_COUNT;
                unset($row['requestedby']);
                unset($row['requestedto']);
                return $row;
            });
        });
         if ($this->request->query('gender') && $this->request->query('gender') !='All') {
            $conditions_array['Users.gender'] = $this->request->query('gender');
        }
        if ($this->request->query('from_date')) {            
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') >="] = date(DATEFORMAT,strtotime($this->request->query('from_date')));
        }
        if ($this->request->query('to_date')) {
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') <="] = date(DATEFORMAT,strtotime($this->request->query('to_date')));
        }
        if ($this->request->query('age_filter')) {
            $getage=$ageArr[$this->request->query('age_filter')];
            $getage = explode("-", $getage );   
            $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) >="] = $getage['0'];           
            if((int)($getage['1'])){                
               $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) <="] = $getage['1'];
            } 
        }         
        if(!empty($keyword)){
            $query->where(['OR' => [['LOWER(Users.display_name) LIKE' => "%".$keyword."%"], ['LOWER(Users.email) LIKE' => "%".$keyword."%"], ['LOWER(Users.address) LIKE' => "%".$keyword."%"],['LOWER(Users.username) LIKE' => "%".$keyword."%"]]]);
        } 
        if (count($conditions_array)) {
            $query->where($conditions_array);
        }  
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);   
        $this->set(compact('users','keyword'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Fbs', 'MatrixUsers', 'Roles']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $fbs = $this->Users->Fbs->find('list', ['limit' => 200]);
        $matrixUsers = $this->Users->MatrixUsers->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'fbs', 'matrixUsers', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $fbs = $this->Users->Fbs->find('list', ['limit' => 200]);
        $matrixUsers = $this->Users->MatrixUsers->find('list', ['limit' => 200]);
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'fbs', 'matrixUsers', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function login() {        
        
        $this->set('title', $this->siteTitleMessage['ADMINPANEL']);
        if($this->Auth->user('id')){
            return $this->redirect($this->Auth->redirectUrl());       
        }
        $user= $this->Users->newEntity();
        if ($this->request->is(['post','put'])) { 
            $data = $this->request->getData();
            $errors = $this->Users->validationLogin($data);
            if (empty($errors)) {                                     
                $user = $this->getUserObj($data['email'])->first();
                if ($user) {              
                    if (!ApiHasher::check(trim($data['password']), $user->password)) {                       
                        $this->Flash->error(__($this->errorSuccessMessage['INVALIDEMAILNPASS']));
                    }else{                       
                        $this->Auth->setUser($user);                        
                        return $this->redirect($this->Auth->redirectUrl());
                    }               
                } else {
                    $this->Flash->error(__($this->errorSuccessMessage['INVALIDEMAILNPASS']));
                }
            } else {
                $user->errors($errors);
            }
        }
        $this->set('base_url_admin',$this->base_url_admin);
        $this->set(compact('user'));
    }

    public function logout()
    {        
        return $this->redirect($this->Auth->logout());
    }

    public function changePassword() {                

        $this->set('title', $this->siteTitleMessage['CHANGEPASSWORD']);
        $user = $this->Users->get($this->Auth->user('id'));                
        if ($this->request->is(['post','put'])) {          
            $data = $this->request->getData();
            $data['userId'] = $user->id;
            $errors = $this->Users->validationChangePassword($data);            
            if (empty($errors)) {
                $user->password = ApiHasher::hash(trim($data['new_password']));
                if ($this->Users->save($user)) {
                    return $this->redirect(['action' => 'success']);
                } else {                    
                    $this->Flash->success(__($this->errorSuccessMessage['SYSTEMERR']));
                }
            } else {
                $user->errors($errors);
            }
        }
        $this->set(compact('user'));
    }

    public function success($page = null) {        
        if(!$this->Auth->user('id')){
            $this->viewBuilder()->layout('');
        }
        if(!empty($page)){
            $this->viewBuilder()->layout('admin');
        }
        $this->set(['title' => $this->siteTitleMessage['CHANGEPASSWORD'],'base_url_admin'=>$this->base_url_admin,'page' => $page]);
    }
    
    public function forgotPassword() {        

        $this->set('title', $this->siteTitleMessage['FORGOTPASSWORD']);
        $this->viewBuilder()->layout('');
        $this->autoRender = false;
        if ($this->request->is('post')) {            
            $data_item = $this->request->data;           
            $error = array();
            if (!isset($data_item['email'])) {
                $error = $this->errorSuccessMessage['BLANKEMAIL'];
            } else if (!filter_var($data_item['email'], FILTER_VALIDATE_EMAIL)) {
                $error = $this->errorSuccessMessage['INVALIDEMAIL'];
            }
            if (empty($error)) {                  
                $user = $this->getUserObj($data_item['email'])->first();
                if ($user) {
                    $data['forgot_password_token'] = Security::hash($user->email.strtotime("now"), 'sha1', true);
                    $data['forgot_password_timestamp'] = time();
                    $this->Users->updateAll($data, ['email'=>$user->email]);
                    $user =$this->Users->get($user->id);
                    $this->getMailer('User')->send('forgotPassword', [$user]);
                   $result_arr = ['result' => true, 'message' => $this->errorSuccessMessage['RESETLINKMSG']];
                } else {
                    $result_arr = ['result' => false, 'message' => $this->errorSuccessMessage['INVALIDEMAIL']];
                }
            } else {                
                $result_arr = ['result' => false, 'message' => $error];
            }
            echo json_encode($result_arr);
            die;
        } else {
            $this->render('forgotPassword');
        }
    }

    public function resetPassword($token, $email) {                      
        $this->set('title', $this->siteTitleMessage['RESETPASSWORD']);   
        if (!$token || !$email) {  
            $this->Flash->error(__($this->errorSuccessMessage['INVALIDLINK']));
            return $this->redirect(['action' => 'login']);  
        }
        $user = $this->getUserObj($email)->first(); 
        if (!$user) {
            $this->Flash->error(__($this->errorSuccessMessage['INVALIDUSER']));
            return $this->redirect(['action' => 'login']); 
        }        
        if ($token != $user->forgot_password_token) {   
            $this->Flash->error(__($this->errorSuccessMessage['INVALIDLINK']));
            return $this->redirect(['action' => 'login']); 
        }                
        if ($this->request->is(['post','put'])) {   
            $data = $this->request->getData();                 
            $errors = $this->Users->validationResetPassword($data);    

            if (!$errors) {
                $user->forgot_password_token = null;
                $user->forgot_password_timestamp = null;                
                $user->password = ApiHasher::hash($data['new_password']);
                if ($this->Users->save($user)) {
                    return $this->redirect(['action' => 'success','login']);    
                } else {                    
                    $this->Flash->error(__($this->errorSuccessMessage['SYSTEMERR']));
                    return $this->redirect(['action' => 'login']);    
                }
            } else {     
                $user->errors($errors);      
            }
        }        
        $this->set(compact('user'));        
    }

    public function adminResetPassword($id) {

        $this->viewBuilder()->layout('');
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);  
        }        
        $user = $this->Users->get($id);  
        if ($this->request->is(['post','put'])) { 
            $data = $this->request->getData();
            $error = '';
            if (!isset($data['new_password'])) {
                $error = $this->errorSuccessMessage['BLANKNPASS'];
            } else if(!$this->Users->_getCustomPasswordRule($data['new_password'])) {
                $error = $this->errorSuccessMessage['PASSERRMSG'];
            }             
            if($data['new_password']!=$data['confirm_password']){
                $error = $this->errorSuccessMessage['PASSMISSMATCH'];
            }
            if (!$error) {               
                $user->password = ApiHasher::hash($data['new_password']);
                if ($this->Users->save($user)) {
                    $result_arr = ['result' => true, 'message' => $this->errorSuccessMessage['PASSSUCCESS']];
                } 
            } else {                   
                $result_arr = ['result' => false, 'message' => $error]; 
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('user'));
    }

    public function getUserObj($email){        
        $obj = '';
        if(isset($email) && !empty($email)) {
            $obj = $this->Users->find('all', [
                    'conditions' => 
                            ['Users.email' => trim($email),
                             'Users.role_id' => ROLE_ADMIN
                            ],
                    'limit' => '1'
                ]);
        }
        return $obj;
    }

    public function setUserStatus($id, $status = 'Blocked') {
        $this->viewBuilder()->layout('');
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);  
        }        
        $user = $this->Users->get($id);  
        $statusArr = unserialize(STATUS_ARR);
        $pushNotificationAdminSlug = unserialize(PUSH_NOTIFICATION_ADMIN_SLUG);
        $txtMassage = unserialize(TEXT_MASSAGE);               
        if ($this->request->is(['post','put'])) {    
            if(!empty($user->status) && ucfirst($user->status) == $statusArr['active'] )
                $user->status = $statusArr['inactive'];
            else
                $user->status = $statusArr['active'];

            if ($this->Users->save($user)) {
                $user =$this->Users->get($user->id);
                $displayName = !empty($user->display_name)? $user->display_name :'User';
                if (ucfirst($user->status) == $statusArr['active']) { 
                    $user->statusTxt = $txtMassage['unblock'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['unblocked'];
                    $result_arr = ['result' => true, 'status'=>$statusArr['active'], 'message' => $displayName.' '.$this->errorSuccessMessage['UNBLOCKED-MSG']]; 
                } else {                       
                    $user->statusTxt = $txtMassage['block'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['blocked'];
                    $result_arr = ['result' => true, 'status'=>$statusArr['inactive'], 'message' => $displayName.' '.$this->errorSuccessMessage['BLOCKED-MSG']];   
                }                
                if(!empty($user->email))
                    $this->getMailer('User')->send('userStatus', [$user]);   
                // for push notification
                $push['requested_by'] = $this->Auth->user('id');
                $push['username'] = $this->Auth->user('display_name');
                $push['requested_to'] = $user->id;
                $push['slug'] = $pushNotificationAdminSlug;
                $this->Push->sendPushNotification($push);
            } else {                
                $result_arr = ['result' => false, 'status'=>'', 'message' => $this->errorSuccessMessage['SYSTEMERR']];   
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('user'));
    }
}


    