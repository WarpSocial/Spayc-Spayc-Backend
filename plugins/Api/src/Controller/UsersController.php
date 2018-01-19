<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
use \Cake\ORM\TableRegistry;
use Api\Utils\Utils;
/**
 * Users Controller
 *
 *
 * @method \Api\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    use MailerAwareTrait;
    
    /**
     * beforeFilter overwrite the default function
     * 
     * @param object $event 
     */
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login','add','facebookSignup']);
    }
    
    public function avatars(){
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Invalid method')],405);
        }
        $this->loadModel('Api.UserImages');
        #$this->Users->uploadProfileImages();
        $data  = $this->request->getData();
        $data['user_id'] = $this->Auth->user('id');
        if(isset($data['image_url'][0])){
            foreach($data['image_url'] as $img){
                $imgData = ['user_id'=>$this->Auth->user('id'),'image_url'=>$img];
                
                $entity = $this->UserImages->newEntity();
                $items = $this->UserImages->patchEntity($entity, $imgData);
                if(!empty($items->errors())){
                     $this->restException(['status'=>'failed','message'=>__('Validataion error.'),'errors'=>$this->mapErrors($items->errors())],401);
                }
                $this->UserImages->save($items);
            }
        }else{
            $entity = $this->UserImages->newEntity();
            $items = $this->UserImages->patchEntity($entity, $data);
            if(!empty($items->errors())){
                 $this->restException(['status'=>'failed','message'=>__('Validataion error.'),'errors'=>$this->mapErrors($items->errors())],401);
            }
            $this->UserImages->save($items);
        }
        $response = ['status'=>'success','message'=>__('Profile image uploaded successfully.')];
        $this->set($response);
    }
    
    /**
     * login method to login and generate the token
     */
    
    public function login(){
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Invalid request type')],405);
        }
        $data_item = \Api\Utils\Utils::escape($this->request->data);        
        
        $validator = new \Cake\Validation\Validator();
        $validator
                ->requirePresence('email')
                ->notEmpty('email')
                ->requirePresence('password')
                ->notEmpty('password')
                ->requirePresence('device_id')
                ->notEmpty('device_id');
        $errors = $validator->errors($data_item);
        if (!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>__('All fields are required.'),'errors'=>$this->mapErrors($errors)]);
        }
        $user = $this->Auth->identify();
        if(empty($user)){
            $this->restException(['status' => "failed", 'message' => __('Sign in credentials ain\'t right, try again buddy.')]);
        }
        $this->loadComponent('Api.Matrix');
        $matrix = $this->Matrix->login($data_item+['username'=>$user['username']]); 
        if(empty($matrix)){
            $this->restException(['status'=>'failed','message'=>__('Matrix login failed.')]);
        }
        $user['matrix_user_id'] = $matrix['user_id'];
        $user['matrix_access_token'] = $matrix['access_token'];
        $user['device_id'] = $matrix['device_id'];
        $this->Auth->setUser($user);
        $user = $this->Users->usrLog($user);
        $data = [
            'username'=>$user['username'],
            'email'=>$user['email'],
            'gender'=>$user['gender'],
            'dob'=>(new \Cake\I18n\Time($user['dob']))->format("Y-m-d"),
            'phone'=>$user['phone'],
            'website_url'=>$user['website_url'],
            'address'=>$user['address'],
            'bio_data'=>$user['bio_data'],
            'device_id'=>$user['device_id'],
            'matrix_user_id'=>$user['matrix_user_id'],
            'token'=>$user['token'],
            'matrix_token'=>$user['matrix_access_token'],
            ];
        $response = ['status' => "success", 'message' => __('Login done successfully.'),'data'=>$data];
        
        $this->set($response);
    }


    /**
     * index method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function index() {
        if(!is_numeric($this->request->query('page'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Page number is not valid.')], 405);
        }
        $remark = $this->request->query['remark'];
        if(!empty($remark) && ($remark=='all' || $remark=='spaycs')) {
            if(!Utils::isValidLatitude($this->request->query('latitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 405);
            }
            if(!Utils::isValidLongitude($this->request->query('longitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 405);
            }
        }
        if(!empty($remark) && $remark=='users') {
            $data['users'] = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
        } else if(!empty($remark) && $remark=='spaycs') {
            $data['spaycs'] = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query);
        } else if(!empty($remark) && $remark=='hashtags') {
            $data['hashtags'] = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
        } else {
            $data['users'] = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
            $data['spaycs'] = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query);
            $data['hashtags'] = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
        }
        $response = ['status' => "success", 'message' => __('Search Lists.'), 'data' => $data];
        $this->set($response);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $entity = $this->Users->newEntity();
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Invalid method')], 405);
        }
        $this->loadComponent('Api.Matrix');
        $data = $this->request->getData(); 
        $items = $this->Users->patchEntity($entity, $data);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>__('Validation errors.'),'errors'=>$this->mapErrors($items->errors())],401);
        }
        $matrix = $this->Matrix->register($data);
        if(!$matrix) {       
            $this->restException(['status' => "failed", 'message' => __('Matrix registration failed.')],401);
        }            
        $items->set('status', 'Active');            
        $items->set('token_verification', Security::hash($data['email'], 'sha1', true));
        #echo $data['token_verification'];die;
        if ($this->Users->save($items)) {           
             $this->getMailer('Api.User')->send('signup', [$items]);
            $response = ['status' => "success", 'message' => __('Registration done successfully.'), 'data' =>
                [
                    'username'=>$data['username'],
                    'email'=>$data['email'],
                    'dob'=>$data['dob'],
                    'gender'=>trim($data['gender']),
                    'phone'=>$data['phone'],
                    'latitude'=>$data['latitude'],
                    'longitude'=>$data['longitude']
                ]];
        } else {
            $response = ['status' => "failed", 'message' => __('Failed to saved data.'), 'errors'=>$this->mapErrors($items->errors())];
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
        if ($user->status == 'Active') {
            $this->Flash->success(__('Your Account has been already activated. You can now log in using the username and password you chose during the registration'));
            //return $this->redirect('/');
        } else {
            if ($token != Security::hash($user->email, 'sha1', true)) {
                throw new ForbiddenException(__('Invalid token. Please read email carefully and try again.'));
            }
            $user->status = 'Active';
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
        if(!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Invalid request type')],405);
        }
        $this->loadComponent('Api.Matrix');
        $data = $this->request->getData();
        $data['status'] = 'Active';
        if(empty($data['email']) or empty($data['fb_id'])) {
            $this->restException(['status' => "failed", 'message' => __('Email and fb_id are required field.')],401);
        }
        /* find user if already registered */
        $alreadyExist = $this->Users->findByEmailOrFbId($data['email'], $data['fb_id']);
        if($alreadyExist->count()) {
            $alreadyExist = $alreadyExist->first()->toArray();
            $data['id'] = $alreadyExist['id'];
            $data['fb_id'] = !empty($data['fb_id'])?$data['fb_id']:$alreadyExist['fb_id'];
            $data['username'] = !empty($data['username'])?$data['username']:$alreadyExist['username'];
            $data['email'] = !empty($data['email'])?$data['email']:$alreadyExist['email'];
            $entity = $this->Users->get($data['id']);
        } else {
            $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
            $entity = $this->Users->newEntity();
        }
        $items = $this->Users->patchEntity($entity, $data, ['validate' => 'facebookSignup']);
        
        if($items->errors()) {
            $this->restException(['status' => "failed", 'message' => $this->mapErrors($items->errors())], 401);
        }
        if(empty($data['id'])) {
            $mdata = $data;
            $mdata['password'] = base64_encode($data['email']);
            $matrix = $this->Matrix->register($mdata);
            if(!$matrix) {
                $this->restException(['status' => "failed", 'message' => __('Matrix registration failed.')],401);
            }
        }
        $saved = $this->Users->save($items);
        $data['id'] = $saved['id'];
        /*---login authentication---*/
        $user = $this->Auth->identify();
        if(!$user) {
            $this->restException(['status' => "failed", 'message' => __('Sign in credentials ain\'t right, try again buddy.')], 401);
        }
        $mdata['username'] = $data['username'];
        $mdata['password'] = base64_encode($data['email']);
        $mdata['device_id'] = $data['device_id'];
        //$data_item = \Api\Utils\Utils::escape($mdata);pr($data_item);exit;
        $matrix = (array)$this->Matrix->login($mdata);
        if(empty($matrix['access_token'])) {
            $this->restException(['status' => "failed", 'message' => __('Invalid login credential for matrix.')], 401);
        }
        $user['matrix_user_id'] = $matrix['user_id'];
        $user['matrix_access_token'] = $matrix['access_token'];
        $user['device_id'] = $matrix['device_id'];
        $this->Auth->setUser($user);
        $user = $this->Users->usrLog($user);
        $data = [
            'username'=>$user['username'],
            'email'=>$user['email'],
            'gender'=>$user['gender'],
            'dob'=>(new \Cake\I18n\Time($user['dob']))->format("Y-m-d"),
            'phone'=>$user['phone'],
            'website_url'=>$user['website_url'],
            'address'=>$user['address'],
            'bio_data'=>$user['bio_data'],
            'device_id'=>$user['device_id'],
            'matrix_user_id'=>$user['matrix_user_id'],
            'token'=>$user['token'],
            'matrix_token'=>$user['matrix_access_token'],
            ];
        //$response = ['status' => "success", 'message' => 'Login successfully.', 'data'=>$data];
        /*---end login authentication---*/
        $this->getMailer('Api.User')->send('signup', [$items]);
        $response = ['status' => "success", 'message' => __('Saved successfully.'), 'data' => $data];
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
                $response = ['status' => "failed", 'message' => __('Failed to send email.'), 'data' => $this->request->data,'errors'=>__('email:Email is required field.')];
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
    public function edit() {
        if (!$this->request->is(['put'])) {
            $this->restException(['status'=>'failed','message'=>__('Method is not allowed.')],405);
        }
        $id = $this->Auth->user('id');
        $data = $this->request->getData();
        $entity = $this->Users->get($id);
        $items = $this->Users->patchEntity($entity, $data, ['validate' =>'UpdateUser']);
        if($items->errors()){
            $this->restException($this->mapErrors($items->errors()));
        }
        if ($this->Users->save($items)) {
            $response = ['status' => "success", 'message' => __('Updated successfully.'), 'data' => $data];
        } else {
            $response = ['status' => "failed", 'message' => __('Failed to update data.'), 'data' => $data, 'errors'=>$this->mapErrors($items->errors())];
        }
        $this->set($response);
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
        $user->status= 'trash';
        if ($this->Users->update($user)) {
            $response = ['status'=>'success',__('The user has been deleted.')];
        } else {
            $response = ['status'=>'success',__('The user could not be deleted. Please, try again.')];
        }
        $this->set($response);
    }
    
    public function logout() {
        $this->loadModel('UserLogs');
        //$user = $this->Auth->user();
        $token = $this->request->env('HTTP_TOKEN');
        $this->UserLogs->query()
                        ->delete()
                        //->set(['loginstatus' => 0])
                        ->where(['plain_token' =>  $token])
                        ->execute();
        $response = ['status'=>'success','message'=>__('Logout successfully.')];
        $this->set($response);
    }

}
