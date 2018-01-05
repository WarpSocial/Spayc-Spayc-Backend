<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
/**
 * Users Controller
 *
 *
 * @method \Api\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    use MailerAwareTrait;
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
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
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $entity = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->loadComponent('Api.Matrix');
            $data = $this->request->getData();            
            $items = $this->Users->patchEntity($entity, $data);
            if($items->errors()){
                $this->restException($this->mapErrors($items->errors()));
            }
            $matrix = $this->Matrix->register($data);
            if(!$matrix){                
                $this->restException(['status' => "failed", 'message' => 'Matrix registration failed.'],401);
            }
            
            $items->set('matrix_token', $matrix->access_token);
            $items->set('matrix_id', $matrix->user_id);
            $items->set('home_server', $matrix->home_server);
            $items->set('token_verification', Security::hash($data['email'], 'sha1', true));
            #echo $data['token_verification'];die;
            if ($this->Users->save($items)) {                
                 $this->getMailer('Api.User')->send('signup', [$items]);
                 
                $response = ['status' => "success", 'message' => 'Saved successfully.', 'data' => $this->request->data];
            } else {
                $response = ['status' => "failed", 'message' => 'Failed to saved data.', 'data' => $this->request->data,'errors'=>$this->mapErrors($items->errors())];
            }
        }
        $this->set($response);
    }
    
    /**
     * verifyAccount to verify the email account
     * 
     * @param string $token token id attached with url
     * @param string $email email id which have to verify
     * 
     * @return success message
     * 
     */
    
    public function verifyAccount($token = null, $email = null) {
        
        if (!$token || !$email) {
            throw new NotFoundException(__('Missing required information. Please read email carefully and try again.'));
        }
        $user = $this->Users->findByEmail($email)->first();
        if (!$user) {
            throw new RecordNotFoundException(__('Account not found or already activated. Please read email carefully and try again.'));
        }
        if ($user->status == 'active') {
            $this->Flash->success(__('Your Account has been already activated. You can now log in using the username and password you chose during the registration'));
            //return $this->redirect('/');
        } else {
            if ($token != Security::hash($user->email, 'sha1', true)) {
                throw new ForbiddenException(__('Invalid token. Please read email carefully and try again.'));
            }
            $user->status = 'active';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your Account has been successfully activated. You can now log in using the username and password you chose during the registration.'));
                //return $this->redirect(['action' => 'login']);    
            } else {
                $this->Flash->success(__('This link has no longer existing.'));
                //return $this->redirect(['action' => 'login']);    
            }
            $this->set(compact('user'));
            $this->render('Users/verify_account',false);
        }
    }
    
    /**
     * facebook signup
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    */
    public function facebookSignup() {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $alreadyExist = $this->Users->getAlreadyExistsUser($data);
            if(!empty($alreadyExist['id'])) {
                $data['id'] = $alreadyExist['id'];
                $data['fb_id'] = !empty($alreadyExist['fb_id'])?$alreadyExist['fb_id']:$data['fb_id'];
                //$data['user_name'] = !empty($alreadyExist['user_name'])?$alreadyExist['user_name']:$data['user_name'];
                $data['email'] = !empty($alreadyExist['email'])?$alreadyExist['email']:$data['email'];
                $entity = $this->Users->get($data['id']);
            } else {
                $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
                $entity = $this->Users->newEntity($data, ['validate' => 'FacebookSignup']);
            }
            $items = $this->Users->patchEntity($entity, $data, ['validate' => 'FacebookSignup']);
            if ($this->Users->save($items)) {      
                //$this->getMailer('Api.User')->send('signup', [$items]);
                $response = ['status' => "success", 'message' => 'Saved successfully.', 'data' => ['ones', $this->request->data]];
            } else {
                $response = ['status' => "failed", 'message' => 'Failed to saved data.', 'data' => $this->request->data,'errors'=>$this->mapErrors($items->errors())];
            }
        }
        $this->set($response);
    }
    
    /**
     * forgot password api
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    */
    public function forgotPassword() {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(!empty($data['email'])) {
                $isExists = $this->Users->exists(['email' => $data['email']]);
                if($isExists) {
                    $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
                    $this->getMailer('Api.User')->send('forgotPassword', [$items]);
                }
            } else {
                $response = ['status' => "failed", 'message' => 'Failed to send email.', 'data' => $this->request->data,'errors'=>'email:Email is required field.'];
            }
        }
        $this->set($response);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
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
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
