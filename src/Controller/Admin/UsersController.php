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
        $this->Auth->allow(['login', 'logout','forgotPassword', 'resetPassword']);
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
        if ($this->request->is('post')) {
            $data_item = $this->request->data;
            $error = array();
            if (!isset($data_item['email'])) {
                $error['email'] = ['_required' => $this->errorRequiredMessage['1']];
            }
            if (!isset($data_item['password'])) {
                $error['password'] = ['_required' => $this->errorRequiredMessage['2']];
            }
            if (empty($error)) {
                $hasher = new DefaultPasswordHasher();
                $user_query = $this->Users->find('all', [
                    'conditions' => ['Users.email' => trim($data_item['email']),
                        'Users.role_id' => ROLE_ADMIN
                    ],
                    'limit' => '1'
                ]);                
                $user = $user_query->first();                            
                if ($user) {              
                    if (!ApiHasher::check(trim($data_item['password']), $user->password)) {                       
                        $this->Flash->error(__($this->errorSuccessMessage['32']));
                    }else{                       
                        $this->Auth->setUser($user);                        
                        return $this->redirect($this->Auth->redirectUrl());
                    }               
                } else {
                    $this->Flash->error(__($this->errorSuccessMessage['32']));
                }
            } else {
                $this->Flash->error(__($this->errorSuccessMessage['33']));
            }
        }                
        $user= $this->Users->newEntity();
        $this->set(compact('user'));
    }
    public function logout()
    {        
        return $this->redirect($this->Auth->logout());
    }

    public function changePassword() {
        $this->set('title', 'Change Password');
        if ($this->request->is('post')) {
            $data_item = $this->request->data;
            $error = array();
            if (!isset($data_item['old_password'])) {
               $error['old_password'] = ['_required' => $this->errorRequiredMessage['3']];
            }
            if (!isset($data_item['new_password'])) {
               $error['new_password'] = ['_required' => $this->errorRequiredMessage['4']];
            }
            if (!isset($data_item['confirm_password'])) {
               $error['confirm_password'] = ['_required' => $this->errorRequiredMessage['5']];
            }
            if (empty($error)) {
                $admin_object = $this->Users->find('all', ['conditions' => ['Users.role_id' => ROLE_ADMIN]]);
                $admin_detail = $admin_object->first();                       
                if (ApiHasher::check(trim($data_item['old_password']), $admin_detail->password)) {
                    $admin_detail->password = ApiHasher::hash($data_item['new_password']);
                    if ($this->Users->save($admin_detail)) {
                        return $this->redirect(['action' => 'success']);
                    }
                } else {
                    $this->Flash->error(__($this->errorSuccessMessage['34']));
                }
            } else {
                $this->Flash->error(__($this->errorRequiredMessage['6']));
            }
        }
    }

    public function success() {
        $this->set('title', 'Change Password');
    }

    public function manageUser() {
        $this->set('title', 'Manage User');
    }

    public function forgotPassword() {
        $this->set('title', 'Forgot password'); 
        $this->viewBuilder()->layout('');
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $data_item = $this->request->data;           
            $error = array();
            if (!isset($data_item['email'])) {
                $error = $this->errorRequiredMessage['1'];
            } else if (!filter_var($data_item['email'], FILTER_VALIDATE_EMAIL)) {
                $error = $this->errorSuccessMessage['3'];
            }
            if (empty($error)) {
                $users_query = $this->Users->find('all', [
                    'conditions' => ['Users.email' =>trim($data_item['email']),
                        'Users.role_id' => ROLE_ADMIN
                    ],
                    'limit' => '1'
                ]);
                //debug($users_query);
                $user = $users_query->first();                
                if ($user) {
                    $data['forgot_password_token'] = Security::hash($user['email'], 'sha1', true);
                    $data['forgot_password_timestamp'] = time();
                    $d = $this->Users->updateAll($data, ['email'=>$user['email']]);
                    $this->getMailer('User')->send('forgotPassword', [$user]);
                   $result_arr = ['result' => true, 'message' => $this->errorSuccessMessage['35']];
                } else {
                    $result_arr = ['result' => false, 'message' => $this->errorSuccessMessage['3']];
                }
            } else {                
                $result_arr = ['result' => false, 'message' => $error];
            }
            echo json_encode($result_arr);
            die;
        }
    }

    public function resetPassword($token=null, $email=null) {    
        $this->set('title', 'Reset password');        
        if (!$token || !$email) {            
            $this->Flash->error(__($this->errorRequiredMessage['7']));
            return $this->redirect(['action' => 'login']);  
        }
        $user = $this->Users->find('all', [
                    'conditions' => 
                            ['Users.email' => trim($email),
                             'Users.role_id' => ROLE_ADMIN
                            ],
                    'limit' => '1'
                ])->first();                  
        if (!$user) {
            $this->Flash->error(__($this->errorSuccessMessage['36']));
            return $this->redirect(['action' => 'login']); 
        }
        if ($token != Security::hash($user->email, 'sha1', true)) {            
            $this->Flash->error(__($this->errorSuccessMessage['37']));
            return $this->redirect(['action' => 'login']); 
        }        
        $status = '';              
        if ($this->request->is('post')) {           
            $data = $this->request->getData();                        
            // if(empty($data['password']) || empty($data['confirm_password'])){
            //     $this->Flash->error(__('All fields are required.'));
            // }elseif($data['password'] != $data['confirm_password']){
            //     $this->Flash->error(__('Password not matched.'));
            // }else{ 
            //     $user->status = 'Active';
            //     $user->password = ApiHasher::hash($data['password']);
            //     if ($this->Users->save($user)) {
            //         $status = 'done';
            //         $this->Flash->success(__('Your new password has been reset successfully.'));
            //         return $this->redirect(['action' => 'login']);    
            //     } else {
            //         $status = 'failed';
            //         $this->Flash->success(__('System rejected to update the password.'));
            //         return $this->redirect(['action' => 'login']);    
            //     }
            // }
            
        }        
        $this->set(compact('user','status'));        
    }








}


    