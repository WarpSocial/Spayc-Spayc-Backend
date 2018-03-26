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
        
        $this->paginate = [
            'contain' => ['Fbs', 'MatrixUsers', 'Roles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
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
        $this->set('title', 'Admin Panel'); 
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
                        $this->Flash->error(__($this->errorSuccessMessage['32']));
                    }else{                       
                        $this->Auth->setUser($user);                        
                        return $this->redirect($this->Auth->redirectUrl());
                    }               
                } else {
                    $this->Flash->error(__($this->errorSuccessMessage['32']));
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
        $this->set('title', 'Change Password');
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
                    $this->Flash->success(__($this->errorSuccessMessage['40']));
                }
            } else {
                $user->errors($errors);
            }
        }
        $this->set(compact('user'));
    }

    public function success() {
        $this->set('title', 'Change Password');
        $this->set('base_url_admin',$this->base_url_admin);
    }

    public function manageUsers() {
        $this->set('title', 'Manage User');
        
        $keyword=($this->request->query('keyword'))?trim($this->request->query('keyword')):'';
        $query=$this->Users->find()
            ->where(['Users.role_id IS'=> null])
            ->contain([            
                'JoinedSpayc'=>function($q) {
                    return $q->select(['JoinedSpayc.user_id', 'joined_spaycs'=>$q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.user_id']);
                },
                'Spaycs'=>function($q) {
                    return $q->select(['Spaycs.user_id', 'created_spaycs'=>$q->func()->count('Spaycs.id')])->group(['Spaycs.user_id']);
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
                $row->friend = !empty($row['requestedto'][0]['count'])? $row['requestedto'][0]['count'] : BLANK_COUNT;
                $row->friend += !empty($row['requestedby'][0]['count'])? $row['requestedby'][0]['count'] : BLANK_COUNT;
                unset($row['requestedby']);
                unset($row['requestedto']);
                return $row;
            });
        });

        if(!empty($keyword)){
            $query->where(['OR' => [['username LIKE' => "%".$keyword."%"], ['email LIKE' => "%".$keyword."%"]]]);
        } 
        $users = $this->paginate($query);    
        //pr($users);die;
        $this->set(compact('users','keyword'));
        $this->set('_serialize', ['users']);
    }

    public function forgotPassword() {
        $this->set('title', 'Forgot password'); 
        $this->viewBuilder()->layout('');
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data_item = $this->request->data;           
            $error = array();
            if (!isset($data_item['email'])) {
                $error = $this->errorSuccessMessage['3'];
            } else if (!filter_var($data_item['email'], FILTER_VALIDATE_EMAIL)) {
                $error = $this->errorSuccessMessage['3'];
            }
            if (empty($error)) {                  
                $user = $this->getUserObj($data_item['email'])->first();
                if ($user) {
                    $data['forgot_password_token'] = Security::hash($user->email, 'sha1', true);
                    $data['forgot_password_timestamp'] = time();
                    $d = $this->Users->updateAll($data, ['email'=>$user->email]);
                    $this->getMailer('User')->send('forgotPassword', [$user]);
                   $result_arr = ['result' => true, 'message' => $this->errorSuccessMessage['35']];
                } else {
                    $result_arr = ['result' => false, 'message' => $this->errorSuccessMessage['43']];
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
        $this->set('title', 'Reset password');        
        if (!$token || !$email) {            
            $this->Flash->error(__($this->errorSuccessMessage['42']));
            return $this->redirect(['action' => 'login']);  
        }
        $user = $this->getUserObj($email)->first();          
        if (!$user) {
            $this->Flash->error(__($this->errorSuccessMessage['36']));
            return $this->redirect(['action' => 'login']); 
        }
        if ($token != Security::hash($user->email, 'sha1', true)) {            
            $this->Flash->error(__($this->errorSuccessMessage['37']));
            return $this->redirect(['action' => 'login']); 
        } 
        if ($token != $user->forgot_password_token) {            
            $this->Flash->error(__($this->errorSuccessMessage['38']));
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
                    $this->Flash->success(__($this->errorSuccessMessage['21']));
                    return $this->redirect(['action' => 'login']);    
                } else {                    
                    $this->Flash->error(__($this->errorSuccessMessage['40']));
                    return $this->redirect(['action' => 'login']);    
                }
            } else {     
                $user->errors($errors);      
            }
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


}


    