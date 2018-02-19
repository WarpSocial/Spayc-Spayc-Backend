<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
use \Cake\ORM\TableRegistry;
use Api\Utils\Utils;
use Cake\Log\Log;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Api\Model\Entity\UserImage;
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
        $this->Auth->allow(['login', 'add', 'facebookSignup', 'forgotPassword', 'reverification', 'verifyAccount', 'resetPassword']);
    }
    
    public function avatars() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $this->loadModel('Api.UserImages');
        $data  = $this->request->getData();
        if(!is_array($data)) {
            $this->restException(['status'=>'failed','message'=>'Invalid requested data format.'], 400);
        }
        $defaultImg  = [];
        foreach($data as $key=>$img) {
            $exists = $this->UserImages->findByUserIdAndOrderIndex($this->Auth->user('id'), $key);
            $imgData = ['user_id'=>$this->Auth->user('id'), 'image_url'=>$img, 'order_index'=>$key];
            if($exists->count()) {
                $entity = $this->UserImages->get($exists->first()->id);
            } else {
                if($key==1) { 
                    $imgData['is_profile'] = 'Yes';                    
                }
                $entity = $this->UserImages->newEntity();
            }
            $items = $this->UserImages->patchEntity($entity, $imgData);
            if(!empty($items->errors())) {
                $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
            }
            $this->UserImages->save($items);            
            if(!empty($items->is_profile) && ($items->is_profile == 'Yes')){
                $defaultImg = $items;
            }
        }
        if(!empty($defaultImg) ){            
            /*Event to bind to update the set upload room image */
            $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                'options' => [
                    'matrix_token'=>$this->Auth->user('UserLogs.matrix_access_token'),
                    'image'=> $defaultImg->image_url,
                    'matrix_user_id'=> $this->Auth->user('UserLogs.matrix_user_id'),
                    ]
            ]);
            EventManager::instance()->dispatch($event);
        }
        $response = ['status'=>'success','message'=>__('Profile image uploaded successfully.')];
        $this->set($response);
    }
    
    public function setProfileImage() {
        if (!$this->request->is('put')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data  = $this->request->getData();
        if(empty($data['id'])) {
            $this->restException(['status'=>'failed', 'message'=>'Order index is required field.'], 400);
        }
        $this->loadModel('Api.UserImages');
        $entity = $this->UserImages->get($data['id']);
        if(empty($entity)) {
            $this->restException(['status'=>'failed', 'message'=>'Invalid image id.'], 400);
        }
        $this->UserImages->updateAll(['is_profile'=>'No'], ['user_id'=>$this->Auth->user('id')]);
        $this->UserImages->updateAll(['is_profile'=>'Yes'], ['id'=>$data['id']]);
        /*Event to bind to update the set upload room image */
        $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
            'options' => [
                'matrix_token'=>$this->Auth->user('UserLogs.matrix_access_token'),
                'image'=> $entity->image_url,
                'matrix_user_id'=> $this->Auth->user('UserLogs.matrix_user_id'),
                ]
        ]);
        EventManager::instance()->dispatch($event);
        $response = ['status'=>'success', 'message'=>__('Profile image set as default.')];
        $this->set($response);
    }
    
    /**
     * login method to login and generate the token
     */
    
    public function login() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $data_item = \Api\Utils\Utils::escape($this->request->data);        
        
        $validator = new \Cake\Validation\Validator();
        $validator
                ->requirePresence('email', true, __('Email is required field.'))
                ->notEmpty('email', __('Email is required field.'))
                ->requirePresence('password', true, __('Password is required field.'))
                ->notEmpty('password', __('Password is required field.'))
                ->requirePresence('device_id', true, __('Device id is required field.'))
                ->notEmpty('device_id', __('Device id is required field.'));
        $errors = $validator->errors($data_item);
        if (!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $user = $this->Auth->identify();
        if(empty($user)){
            $this->restException(['status' => "failed", 'message' => __('Sign in credentials ain\'t right, try again buddy.')], 401);
        }
        $this->loadComponent('Api.Matrix');
        $matrix = $this->Matrix->login($data_item+['username'=>$user['username']]); 
        if(empty($matrix)){
            $this->restException(['status'=>'failed','message'=>__('Matrix login failed.')], 401);
        }
        $user['matrix_user_id'] = $matrix['user_id'];
        $user['matrix_access_token'] = $matrix['access_token'];
        $user['device_id'] = $matrix['device_id'];
        $this->Auth->setUser($user);
        $user = $this->Users->usrLog($user);
        $userImages = TableRegistry::get("Api.UserImages")->findByUserId($user['id'])->select(['id', 'user_id', 'image_url', 'is_profile', 'order_index']);
        $data = [
            'id'=>  ApiHasher::encrypt($user['id']),
            'username'=>$user['username'],
            'email'=>$user['email'],
            'gender'=>$user['gender'],
            'dob'=>(new \Cake\I18n\Time($user['dob']))->format("Y-m-d"),
            'country_code'=>$user['country_code'],
            'phone'=>$user['phone'],
            'website_url'=>$user['website_url'],
            'address'=>$user['address'],
            'bio_data'=>$user['bio_data'],
            'device_id'=>$user['device_id'],
            'matrix_user_id'=>$user['matrix_user_id'],
            'token'=>$user['token'],
            'matrix_token'=>$user['matrix_access_token'],
            'user_images'=>$userImages
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
        if(!$this->request->is('get')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $type = !empty($this->request->query['type'])?$this->request->query['type']:'';
        if(!empty($type) && ($type=='all' || $type=='spaycs')) {
            if(!Utils::isValidLatitude($this->request->query('latitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
            }
            if(!Utils::isValidLongitude($this->request->query('longitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
            }
        }
        if(!empty($type) && $type=='users') {
            $data['users'] = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
        } else if(!empty($type) && $type=='spaycs') {
            $data['spaycs'] = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query);
        } else if(!empty($type) && $type=='hashtags') {
            $data['hashtags'] = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
        } else {
            $data['users'] = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
            $data['spaycs'] = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query);
            $data['hashtags'] = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
        }
        if(empty($data['users']['records']) && empty($data['spaycs']['records']) && empty($data['hashtags']['records'])) {
            $this->response->statusCode(204);
        }
        $response = ['status' => "success", 'message' => __('Search Lists.'), 'data' => $data];
        $this->set($response);
    }

    public function reverification() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['email'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Email is required field.')], 400);
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid email address.')], 400);
        }
        $user = $this->Users->findByEmail($data['email']);
        if(!$user->count()) {
            $this->restException(['status'=>'failed', 'message'=>__('Email does not exists.')], 400);
        }
        $user = $user->first();
        $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
        $this->Users->updateAll($data, ['email'=>$data['email']]);
        $this->getMailer('Api.User')->send('reverification', [$user]);
        $response = ['status' => "success", 'message' => __('Re-verification email sent successfully.')];
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
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $this->loadComponent('Api.Matrix');
        $data = $this->request->getData(); 
        $data['gender'] = !empty($data['gender'])?ucfirst($data['gender']):'';
        $items = $this->Users->patchEntity($entity, $data);
        if($items->errors()) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
        $matrix = $this->Matrix->register($data);
        if(!$matrix) {       
            $this->restException(['status' => "failed", 'message' => __('Matrix registration failed.')], 401);
        }            
        $items->set('status', 'Active');        
        $items->set('token_verification', Security::hash($data['email'], 'sha1', true));
        $items->set('matrix_user_id', $matrix['user_id']);
        $items->set('matrix_access_token', $matrix['access_token']);
        #echo $data['token_verification'];die;
        if ($this->Users->save($items)) {           
            $this->getMailer('Api.User')->send('signup', [$items]);
            $response = ['status' => "success", 'message' => __('Registration done successfully.'), 'data' =>
                [
                    'username'=>$data['username'],
                    'email'=>$data['email'],
                    'dob'=>$data['dob'],
                    'gender'=>trim($data['gender']),
                    'country_code'=> Utils::getVar('country_code',$data),
                    'phone'=>$data['phone'],
                    'latitude'=>$data['latitude'],
                    'longitude'=>$data['longitude']
                ]];
            $this->response->statusCode(201);
        } else {
            Log::info(['status' => "failed", 'message' =>__('Failed to saved data.')]);
            $response = ['status' => "failed", 'message' => $this->mapErrors($items->errors())];
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
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')],405);
        }
        $this->loadComponent('Api.Matrix');
        $data = $this->request->getData();
        $data['gender'] = !empty($data['gender'])?ucfirst($data['gender']):'';
        $data['status'] = 'Active';
        if(empty($data['email']) or empty($data['fb_id'])) {
            $this->restException(['status' => "failed", 'message' => __('Email and fb_id are required field.')], 400);
        }
        /* find user if already registered */
        $alreadyExist = $this->Users->findByEmailOrFbId($data['email'], $data['fb_id']);
        if($alreadyExist->count()) {
            $alreadyExist = $alreadyExist->first()->toArray();
            $data['id'] = ApiHasher::decrypt($alreadyExist['id']);
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
            $this->restException(['status' => "failed", 'message' => $this->mapErrors($items->errors())], 400);
        }
        if(empty($data['id'])) {
            $mdata = $data;
            $mdata['password'] = base64_encode($data['email']);
            $matrix = $this->Matrix->register($mdata);
            if(!$matrix) {
                $this->restException(['status' => "failed", 'message' => __('Matrix registration failed.')], 401);
            }
        }
        $saved = $this->Users->save($items);
        $data['id'] = $saved['id'];
        /*---login authentication---*/
        $user = $this->Auth->identify();
        if(!$user) {
            $this->restException(['status' => "failed", 'message' => __('Sign in credentials ain\'t right, try again buddy.')],  401);
        }
        $user['id'] = ApiHasher::decrypt($user['id']);
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
        if(!empty($data['image_url'])) {
            TableRegistry::get('Api.UserImages')->uploadFacebookImage($data['image_url'], $this->Auth->user('id'));
        }
        $data = [
            'username'=>$user['username'],
            'email'=>$user['email'],
            'gender'=>$user['gender'],
            'dob'=>(new \Cake\I18n\Time($user['dob']))->format("Y-m-d"),
            'country_code'=>$user['country_code'],
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
        $this->response->statusCode(201);
        $response = ['status' => "success", 'message' => __('Saved successfully.'), 'data' => $data];
        $this->set($response);
    }
    
    /**
     * forgot password api
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    */
    public function forgotPassword() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['email'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Email is required field.')], 400);
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid email address.')], 400);
        }
        $user = $this->Users->findByEmail($data['email']);
        if(!$user->count()) {
            $this->restException(['status'=>'failed', 'message'=>__('Email does not exists.')], 400);
        }
        $user = $user->first();
        $data['forgot_password_token'] = Security::hash($data['email'], 'sha1', true);
        $data['forgot_password_timestamp'] = time();
        $d = $this->Users->updateAll($data, ['email'=>$data['email']]);
        $this->getMailer('Api.User')->send('forgotPassword', [$user]);
        $response = ['status' => "success", 'message' => __('Reset password link send to your email address.')];
        $this->set($response);
    }
    
    public function resetPassword($token, $email) {
        if (!$token || !$email) {
            throw new NotFoundException(__('Missing required information. Please read email carefully and try again.'));
        }
        $user = $this->Users->findByEmail($email)->first();
        if (!$user) {
            throw new RecordNotFoundException(__('Account not found or already activated. Please read email carefully and try again.'));
        }
        
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
        $this->render('Users/reset_password',false);
    }
    
    public function changePassword() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data_item = \Api\Utils\Utils::escape($this->request->data);
        $validator = new \Cake\Validation\Validator();
        $validator = $this->Users->validationChangePassword($validator, $this->Auth->user('id'));
        $errors = $validator->errors($data_item);
        if($errors) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        if(!empty($this->Auth->user('matrix_user_id')) && !empty($this->Auth->user('matrix_access_token'))) {
            $this->loadComponent('Api.Matrix');
            $data_item['matrix_user_id'] = $this->Auth->user('matrix_user_id');
            $data_item['matrix_access_token'] = $this->Auth->user('matrix_access_token');
            $matrix = $this->Matrix->changePassword($data_item);
            if($matrix === false) {
                $this->restException(['status'=>'failed', 'message'=>"Unable to change password on matrix"], 400);
            }
        }
        $this->Users->updateAll(['password'=>ApiHasher::hash($data_item['new_password'])], ['id'=>$this->Auth->user('id')]);
        $response = ['status' => "success", 'message' => __('Password changed successfully.')];
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
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $id = $this->Auth->user('id');
        $data = $this->request->getData();
        $data['gender'] = !empty($data['gender'])?ucfirst($data['gender']):'';
        $entity = $this->Users->get($id);
        $items = $this->Users->patchEntity($entity, $data, ['validate' =>'UpdateUser']);
        if($items->errors()){
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
        if ($this->Users->save($items)) {
            $response = ['status' => "success", 'message' => __('Updated successfully.'), 'data' => $data];
        } else {
            $response = ['status' => "failed", 'message' => $this->mapErrors($items->errors())];
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
    
    public function friendRequest() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['friend_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Friend id is required field.')], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $isUserExist = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$isUserExist) {
            $this->restException(['status'=>'failed','message'=>__('Invalid friend id.')], 400);
        }
        $frend = TableRegistry::get("Api.FriendRequest");
        $exists = $frend->find('all', ['conditions'=>['OR'=>[['FriendRequest.requested_to'=>$data['friend_id'], 'FriendRequest.requested_by'=>$this->Auth->user('id')], ['FriendRequest.requested_to'=>$this->Auth->user('id'), 'FriendRequest.requested_by'=>$data['friend_id']]]]])->first();
        if(!empty($exists) && ($exists->friend_status!='Unfriend')) {
            $friendStatus = !empty($exists->friend_status)?$exists->friend_status:$exists->requested_status;
            $this->restException(['status'=>'failed', 'message'=>__('Friend request already sent status is '.$friendStatus)], 400);
        } else if(!empty($exists) && ($exists->friend_status=='Unfriend')) {
            $friendReq['friend_status'] = NULL;
            $friendReq['modified'] = date("Y-m-d H:i:s");
        }
        $friendReq['requested_by'] = $this->Auth->user('id');
        $friendReq['requested_to'] = $data['friend_id'];
        $friendReq['requested_status'] = 'Requested';
        $friendReq['created'] = date("Y-m-d H:i:s");
        if(empty($exists->id)){
            $entity = $frend->newEntity();
            $items = $frend->patchEntity($entity, $friendReq);
            if($items->errors()) {
                $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
            }
            $frend->save($items);
        } else {
            $frend->updateAll($friendReq,['id'=>ApiHasher::decrypt($exists->id)]);
        }
        $this->response->statusCode(201);
        $response = ['status'=>'success', 'message'=>__('Friend request sent successfully.')];
        $this->set($response);
    }
    
    public function directChatRequest() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['friend_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Friend id is required field.')], 400);
        }
        if(empty($data['matrix_room_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Matrix room id is required field.')], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $isUserExist = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$isUserExist) {
            $this->restException(['status'=>'failed','message'=>__('Invalid friend id.')], 400);
        }
        $frend = TableRegistry::get("Api.FriendRequest");
        $exists = $frend->find('all', ['conditions'=>['OR'=>[['FriendRequest.requested_to'=>$data['friend_id'], 'FriendRequest.requested_by'=>$this->Auth->user('id')], ['FriendRequest.requested_to'=>$this->Auth->user('id'), 'FriendRequest.requested_by'=>$data['friend_id']]]]])->first();
        if(!empty($exists) && ($exists->friend_status=='Unfriend')) {
            $friendReq['friend_status'] = NULL;
        }
        $friendReq['matrix_room_id'] = $data['matrix_room_id'];
        if(empty($exists->id)) {
            $friendReq['requested_by'] = $this->Auth->user('id');
            $friendReq['requested_to'] = $data['friend_id'];
            $friendReq['requested_status'] = 'Anonymous';
            $friendReq['created'] = date("Y-m-d H:i:s");
            $entity = $frend->newEntity();
            $items = $frend->patchEntity($entity, $friendReq);
            if($items->errors()) {
                $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
            }
            $frend->save($items);
        } else {
            $friendReq['modified'] = date("Y-m-d H:i:s");
            $frend->updateAll($friendReq, ['id'=>ApiHasher::decrypt($exists->id)]);
        }
        $this->response->statusCode(201);
        $response = ['status'=>'success', 'message'=>__('Friend request sent successfully.')];
        $this->set($response);
    }
    
    public function getFriends() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $friendStatus = !empty($this->request->query['friend_status'])?$this->request->query['friend_status']:'Accepted';
        $status = array_merge(Configure::read('friend_requested_status'), Configure::read('friend_status'));
        if(empty($friendStatus) || !in_array(ucfirst($friendStatus), $status)) {
            $this->restException(['status'=>'failed', 'message'=>__('Status is required fields and status must be in('.  implode(',', $status).').')], 400);
        }
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, $friendStatus);
        $friends = $this->Users->find("all", ['fields'=>['Users.id', 'Users.username', 'Users.matrix_user_id', 'Users.matrix_access_token'], 'conditions'=>['Users.id IN'=>$friend, 'Users.id !='=>$userId, 'Users.status'=>'Active']]);
        $friends->contain([
            'Requestedby' => function($q) use($userId) {
                return $q->select(['Requestedby.id','Requestedby.requested_by', 'Requestedby.requested_status', 'Requestedby.requested_to', 'Requestedby.friend_status', 'Requestedby.matrix_room_id'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]], ['OR'=>['friend_status !='=>'Anonymous', 'friend_status IS'=>NULL]]]);
            },
            'Requestedto' => function($q) use($userId) {
                return $q->select(['Requestedto.id', 'Requestedto.requested_by', 'Requestedto.requested_to', 'Requestedto.requested_status', 'Requestedto.friend_status', 'Requestedto.matrix_room_id'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]], ['OR'=>['friend_status !='=>'Anonymous', 'friend_status IS'=>NULL]]]);
            },
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            }
        ]);
        $friends->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->friend = !empty($row['requestedto'][0])? $row['requestedto'][0] : [];
                $row->friend = !empty($row['requestedby'][0]) && empty($row->friend)? $row['requestedby'][0] : $row->friend;
                $row->image_url = !empty($row['user_images'][0]['image_url'])?$row['user_images'][0]['image_url']:'';
                unset($row['requestedto']);
                unset($row['requestedby']);
                unset($row['user_images']);
                return $row;
            });
        });
        $limit = (!empty($this->request->query['limit']) && is_numeric($this->request->query['limit']))?$this->request->query['limit']:5;
        $friends->order(['Users.username'=>'ASC'])->limit($limit);
        $page = (!empty($this->request->query['limit']) && is_numeric($this->request->query['page']))?$this->request->query['page']:1;
        if($page < 0) {
            $page = $page*-1;
            $friends->page($page);
        } else {
            $friends->page($page);
        }
        $data = [];
        $data['count'] = $friends->count();
        if($friends->count()) {
            $data['records'] = $friends->toArray();
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success', 'message'=>__('Friend lists.'), 'data'=>$data];
        $this->set($response);
    }
    
    public function setFriendResponse() {
        if (!$this->request->is(['put'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['id'])) {
            $this->restException(['status'=>'failed','message'=>__('Id is required field.')], 400);
        }
        $data['id'] = ApiHasher::decrypt($data['id']);
        $friendStatus = array_merge(Configure::read('friend_requested_status'), Configure::read('friend_status'));
        if(empty($data['status']) || !in_array(ucfirst($data['status']), $friendStatus)) {
            $this->restException(['status'=>'failed', 'message'=>__('Status is required fields and status must be in('.  implode(',', $friendStatus).').')], 400);
        }
        $status = ucfirst($data['status']);
        $friendRequest = TableRegistry::get('Api.FriendRequest');
        
        $exist = $friendRequest->exists(['id'=>$data['id']]);
        if(!$exist) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid requested id.')], 400);
        }
        $entity = $friendRequest->get($data['id']);
        if(in_array($status, Configure::read('friend_requested_status')) && ($entity->requested_by == $this->Auth->user('id'))) {
            $this->restException(['status'=>'failed', 'message'=>__("You can\'t change friend request as ".$status )], 400);
        }
        if($entity->requested_status!='Accepted' && in_array($status, Configure::read('friend_status'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Friend requested status should be accepted for '.$status.' status')], 400);
        }
        if(in_array($status, Configure::read('friend_requested_status'))) {
            $friend['requested_status'] = $status;
        } else if(in_array($status, Configure::read('friend_status'))) {
            $friend['friend_status'] = ($status=='Unblock')?NULL:$status;
            $friend['blocked_by'] = ($status=='Blocked')?$this->Auth->user('id'):NULL;
        }
        if($status=='Unblock') {
            $friendRequest->deleteAll(['id'=>$data['id']]);
        } else {
            $friendRequest->updateAll($friend, ['id'=>$data['id']]);
        }
        $response = ['status'=>'success', 'message'=>__('Friend status updated successfully.')];
        $this->set($response);
    }
    
    public function viewProfile($id = null) {
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        if(empty($id)) {
            $this->restException(['status'=>'failed', 'message'=>__('User id is required field.')], 400);
        }
        $id = ApiHasher::decrypt($id);
        $exist = $this->Users->exists(['id'=>$id]);
        if(!$exist) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid user id')], 400);
        }
        $user = $this->Users->find('all', ['fields'=>['Users.id', 'Users.username', 'Users.email', 'Users.gender', 'Users.dob','Users.country_code', 'Users.phone', 'Users.website_url', 'Users.address', 'Users.bio_data', 'Users.longitude', 'Users.latitude', 'Users.matrix_user_id']])->where(['Users.id'=>$id]);
        $userId = $this->Auth->user('id');
        $user->contain([
            'Requestedby' => function($q) use($userId) {
                return $q->select(['Requestedby.id','Requestedby.requested_by', 'Requestedby.requested_status', 'Requestedby.requested_to', 'Requestedby.friend_status'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]], ['OR'=>['friend_status !='=>'Anonymous', 'friend_status IS'=>NULL]]]);
            },
            'Requestedto' => function($q) use($userId) {
                return $q->select(['Requestedto.id', 'Requestedto.requested_by', 'Requestedto.requested_to', 'Requestedto.requested_status', 'Requestedto.friend_status'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]], ['OR'=>['friend_status !='=>'Anonymous', 'friend_status IS'=>NULL]]]);
            },
            'UserImages'=>function($q) {
                return $q->select(['UserImages.id', 'UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile', 'UserImages.order_index']);
            },
            'JoinedSpayc'=>function($q) {
                return $q->select(['JoinedSpayc.user_id', 'joined_spaycs'=>$q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.user_id']);
            },
            'Spaycs'=>function($q) {
                return $q->select(['Spaycs.user_id', 'created_spaycs'=>$q->func()->count('Spaycs.id')])->group(['Spaycs.user_id']);
            }
        ]);
        $user->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $uId = ApiHasher::decrypt($row['id']);
                $row['friend'] = !empty($row['requestedto'][0])? $row['requestedto'][0] : [];
                $row['friend'] = !empty($row['requestedby'][0]) && empty($row['friend'])?$row['requestedby'][0] : $row['friend'];
                $row['friend']['total_friends'] = TableRegistry::get('Api.FriendRequest')->getFriendCountByUserId($uId);
                $row['created_spaycs'] = !empty($row['spaycs'][0]['created_spaycs'])? $row['spaycs'][0]['created_spaycs'] : 0;
                $row['joined_spaycs'] = !empty($row['joined_spayc'][0]['joined_spaycs'])? $row['joined_spayc'][0]['joined_spaycs'] : 0;
                unset($row['spaycs']);
                unset($row['joined_spayc']);
                unset($row['requestedto']);
                unset($row['requestedby']);
                return $row;
            });
        });
        if($user->count()) {
            $user = $user->first()->toArray();
        }
        $response = ['status'=>'success', 'message'=>__('User profile.'), 'data'=>$user];
        $this->set($response);
    }
    
    public function getFacebookFriends() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = [];
        if(empty($this->Auth->user('fb_id')) || empty($this->Auth->user('fb_access_key'))) {
            $this->restException(['status'=>'failed', 'message'=>__('User not signup with facebook.')], 400);
        }
        $this->loadComponent('Api.Facebook');
        $friends = $this->Facebook->getFriends($this->Auth->user('fb_id'), $this->Auth->user('fb_access_key'));
        $friendIds = [0];
        if(!empty($friends)) {
            foreach($friends as $friend) {
                if(!empty($friend['id'])) { $friendIds[] = $friend['id']; }
            }
        } 
        $spaycFriends = $this->Users->find("all", ['fields'=>['Users.id', 'Users.username', 'Users.dob', 'Users.gender','Users.country_code', 'Users.phone'], 'conditions'=>['Users.fb_id IN'=>$friendIds, 'Users.id !='=>$this->Auth->user('id')]]);
        $spaycFriends->contain([
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            }
        ]);
        $spaycFriends->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->image_url = !empty($row['user_images'][0]['image_url'])? $row['user_images'][0]['image_url']:'';
                unset($row['user_images']);
                return $row;
            });
        });
        $limit = (!empty($this->request->query['limit']) && is_numeric($this->request->query['limit']))?$this->request->query['limit']:5;
        $spaycFriends->order(['Users.username'=>'ASC'])->limit($limit);
        $page = (!empty($this->request->query['limit']) && is_numeric($this->request->query['page']))?$this->request->query['page']:1;
        if($page < 0) {
            $page = $page*-1;
            $spaycFriends->page($page);
        } else {
            $spaycFriends->page($page);
        }
        $data['count'] = $spaycFriends->count();
        if($spaycFriends->count()) {
            $data['records'] = $spaycFriends->toArray();
        }
        if(empty($data)) {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success', 'message'=>__('Facebook friend lists.'), 'data'=>$data];
        $this->set($response);
    }
    
    public function pushNotification() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $this->loadComponent('Api.Push');
        if(empty($data['notification']['devices'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Notification data not found.')], 400);
        }
        $message = !empty($data['notification']['content']['body'])?$data['notification']['content']['body']:'';
        foreach($data['notification']['devices'] as $key=>$device) {
            if(!empty($device['pushkey']) && !empty($message)) {
                $this->Push->sendOnIOS($device['pushkey'], $message);
            }
        }
    }
}
