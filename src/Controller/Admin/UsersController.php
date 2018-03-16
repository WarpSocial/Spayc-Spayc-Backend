<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Api\Auth\ApiHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AdminController
{

    public function initialize() {
        parent::initialize();        
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout','forgotPassword']);
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
                $error['email'] = ['_required' => "email is required"];
            }
            if (!isset($data_item['password'])) {
                $error['password'] = ['_required' => "password is required"];
            }
            if (empty($error)) {
                $hasher = new DefaultPasswordHasher();
                $user_query = $this->Users->find('all', [
                    'conditions' => ['Users.email' => $this->request->data['email'],
                        'Users.role_id' => ROLE_ADMIN
                    ],
                    'limit' => '1'
                ]);                
                $user = $user_query->first();                            
                if ($user) {              
                    if (!ApiHasher::check(trim($data_item['password']), $user->password)) {                       
                        $this->Flash->error(__('Invalid email or password.'));
                    }else{                       
                        $this->Auth->setUser($user);                        
                        return $this->redirect($this->Auth->redirectUrl());
                    }               
                } else {
                    $this->Flash->error(__('Invalid email or password.'));
                }
            } else {
                $this->Flash->error(__('Enter email and password.'));
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
               $error['old_password'] = ['_required' => "current password is required"];
            }
            if (!isset($data_item['new_password'])) {
               $error['new_password'] = ['_required' => "new password is required"];
            }
            if (!isset($data_item['confirm_password'])) {
               $error['confirm_password'] = ['_required' => "confirm password is required"];
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
                    $this->Flash->error(__('Invalid current password.'));
                }
            } else {
                $this->Flash->error(__('All fields are required.'));
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
                $error = "Email is required";
            } else if (!filter_var($data_item['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter your valid email.";
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
                    
                   $result_arr = ['result' => true, 'message' => 'Password changed successfully.'];
                } else {
                    $result_arr = ['result' => false, 'message' => 'Invalid email id.'];
                }
            } else {                
                $result_arr = ['result' => false, 'message' => $error];
            }
            echo json_encode($result_arr);
            die;
        }
    }








}


    