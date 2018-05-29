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
use Cake\Utility\Text;
use Cake\Utility\Hash;
/**
 * Users Controller
 *
 *
 * @method \Api\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    use MailerAwareTrait;
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
    }
    
    /**
     * beforeFilter overwrite the default function
     * 
     * @param object $event 
     */
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'add', 'facebookSignup', 'forgotPassword', 'reverification', 'verifyAccount', 'resetPassword', 'pushNotification','facebookFriends','testPushnotification']);
    }
    
    public function avatars() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $this->loadModel('Api.UserImages');
        $data  = $this->request->getData();
        if(empty($data)) {
            $this->restException(['status'=>'failed','message'=>'Invalid requested data.'], 400);
        }
        $defaultImg  = [];
        $images = [];
        foreach($data as $key=>$img) {
            $exists = $this->UserImages->findByUserIdAndOrderIndex($this->Auth->user('id'), $key);
            $imgData = ['user_id'=>$this->Auth->user('id'), 'image_url'=>$img, 'order_index'=>$key];
            if($exists->count()) { 
                $entity = $exists->first();
                //$entity = $this->UserImages->get($exists->first()->id);
            } else {
                $entity = $this->UserImages->newEntity();
            }
            $items = $this->UserImages->patchEntity($entity, $imgData);
            if(!empty($items->errors())) {
                $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
            }
            $this->UserImages->save($items);
            $images[$key] = $items->image_url;
        }
        $response = ['status'=>'success','message'=>__('Profile image uploaded successfully.'),'data'=>$images];
        $this->set($response);
    }
    
    public function setProfileImage($orderId = null) {
        if (!$this->request->is('put')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        if($orderId == null) {
            $this->restException(['status'=>'failed', 'message'=>'Profile image index is required'], 400);
        }
        $this->loadModel('Api.UserImages');
        $entity = $this->UserImages->findByUserIdAndOrderIndex($this->Auth->user('id'), $orderId);
        if(!$entity->count()) {
            $this->restException(['status'=>'failed', 'message'=>'Order index number not found.'], 400);
        }
        $conn = $this->Users->getConnection();
        $conn->execute('UPDATE '.$this->UserImages->getTable().' SET is_profile = CASE WHEN order_index='.$orderId.' THEN \'Yes\' else \'No\' END WHERE user_id='.$this->Auth->user('id'));
        $entity = $entity->first();
        $this->loadComponent('Api.Matrix');
        $this->Matrix->uploadMediaImage([
                'image_url'=>$entity->image_url,
                'matrix_token'=>$this->Auth->user('UserLogs.matrix_access_token'),
                'matrix_user_id'=>$this->Auth->user('UserLogs.matrix_user_id')
                ]);
        $response = ['status'=>'success', 'message'=>__('Profile image set as default.')];
        $this->set($response);
    }
    
    /**
     * remvoeAvatar method to remove profile image
     * 
     * @method Get
     * @param int $order order of profile image
     * @param Strng $token comes from header or auth
     * 
     * @return json http response message
     */
    
    public function removeAvatar($order = null) {
        if (!$this->request->is('put')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        if($order == null){
            $this->restException(['status'=>'failed', 'message'=>'Profile image index is required'], 400);
        }
        $user = $this->Auth->user();
        $profileImg = TableRegistry::get('Api.UserImages')->find()->where(['user_id'=>$user['id'],'order_index'=>$order]);
        if($profileImg->isEmpty()){
            $this->restException(['status'=>'failed', 'message'=>'Record not found'], 400);
        }
        $image = $profileImg->first();
        if(TableRegistry::get('UserImages')->delete($image)) {
            if(($image->is_profile == 'Yes')){
                $this->loadComponent('Api.Matrix');
                $this->Matrix->setAvatarUrl(null,[
                    'matrix_token'=>$user['UserLogs']['matrix_access_token'],
                    'matrix_user_id'=>$user['UserLogs']['matrix_user_id']
                ]);
            }
            $response = ['status'=>'success', 'message'=>__('Profile image has been removed.'),'data'=>['index'=>$order]];        
        } else {
            $response = ['status'=>'failed', 'message'=>__('Failed to remove profile image.'), 400];        
        }
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
            'display_name'=>$user['display_name'],
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
        if(!empty($type) && ($type=='all' || $type=='spaycs') && !empty($this->request->query['latitude']) && !empty($this->request->query['longitude'])) {
            if(!Utils::isValidLatitude($this->request->query('latitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
            }
            if(!Utils::isValidLongitude($this->request->query('longitude'))) {
                $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
            }
        }
        $userId = $this->Auth->user('id');
        if(!empty($type) && $type=='users') {
            $allUsers = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
            if($allUsers['count'] > 0){
                $data['users'] = $allUsers;
            }
        } else if(!empty($type) && $type=='spaycs') {
            $allSpaycs = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query, $userId);
            if($allSpaycs['count'] > 0){
                $data['spaycs'] = $allSpaycs;
            }
        } else if(!empty($type) && $type=='hashtags') {
            $hashTagSpayc = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
            if($hashTagSpayc['count'] >0){
                $data['hashtags'] = $hashTagSpayc;
            }
            
        } else {
            $allUsers = $this->Users->searchUsers($this->Auth->user('id'), $this->request->query);
            if($allUsers['count'] > 0){
                $data['users'] = $allUsers;
            }
            $allSpaycs = TableRegistry::get('Api.Spaycs')->searchSpaycs($this->request->query, $userId);
            if($allSpaycs['count'] > 0){
                $data['spaycs'] = $allSpaycs;
            }
            $hashTagSpayc = TableRegistry::get('Api.Hashtags')->searchHashtags($this->request->query);
            if($hashTagSpayc['count'] >0){
                $data['hashtags'] = $hashTagSpayc;
            }
            
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
        $data['timezone'] = !empty($data['timezone'])?$data['timezone']:date_default_timezone_get();
        $data['physical_location']['current_latitude'] = Utils::getVar('latitude', $data);
        $data['physical_location']['current_longitude'] = Utils::getVar('longitude', $data);
        
        $items = $this->Users->patchEntity($entity, $data,['associated'=>['PhysicalLocation']]);
        if($items->errors()) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
        $data['display_name'] = $data['username'];
        $data['username'] = \Cake\Utility\Inflector::slug($data['username']).'_'.time();
        $items->set('username',$data['username']);
        $items->set('display_name',$data['display_name']);
        $matrix = $this->Matrix->register($data);
        if($matrix['status'] == 'failed') {       
            $this->restException(['status' => "failed", 'message' => $matrix['message']], 401);
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
                    'id'=>$items->id,
                    'username'=>$data['username'],
                    'display_name'=>$data['display_name'],
                    'email'=>$data['email'],
                    'dob'=> Utils::getVar('dob',$data),
                    'gender'=> Utils::getVar('gender',$data),
                    'country_code'=> Utils::getVar('country_code',$data),
                    'phone'=>Utils::getVar('phone',$data),
                    'latitude'=>  Utils::getVar('latitude',$data),
                    'longitude'=>Utils::getVar('longitude',$data)
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
        if (!empty($user)) {
            if ($user->status == 'Active') {
                $this->Flash->error(__('Your Account has been already activated. You can now log in using the email and password you has chosen during the registration'));
            }else{
                if ($token != Security::hash($user->email, 'sha1', true)) {
                    $this->Flash->error(__('Invalid token. Please read email carefully and try again.'));
                }else{
                     $user->status = 'Active';
                     if ($this->Users->save($user)) {
                         $this->Flash->success(__('Your Account has been successfully activated. You can now log in using the email and password you had chosen during the registration.'));
                    } else {
                        $this->Flash->success(__('This link has no longer existing.'));
                    }
                }
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
        $data['timezone'] = !empty($data['timezone'])?$data['timezone']:date_default_timezone_get();
        $data['status'] = 'Active';
        if(empty($data['fb_id'])) {
            $this->restException(['status' => "failed", 'message' => __('fb_id is required field.')], 400);
        }
        $data['email'] = !empty($data['email'])?$data['email']:null;
        /* find user if already registered */
        $alreadyExist = $this->Users->findByEmailOrFbId($data['email'], $data['fb_id']);
        if($alreadyExist->count()) {
            $alreadyExist = $alreadyExist->first()->toArray();
            $data['id'] = ApiHasher::decrypt($alreadyExist['id']);
            $data['fb_id'] = !empty($data['fb_id'])?$data['fb_id']:$alreadyExist['fb_id'];
            $data['display_name'] = $alreadyExist['display_name'];
            $data['username'] = $alreadyExist['username'];
            $data['email'] = !empty($data['email'])?$data['email']:$alreadyExist['email'];
            $data['password'] = $alreadyExist['password'];
            $entity = $this->Users->get($data['id']);
            $this->Users->PhysicalLocation->deleteAll(['user_id'=>$entity->id]);
        } else {
            $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
            $data['password'] = Text::uuid();
            $data['display_name'] = $data['username'];
            $data['username'] = \Cake\Utility\Inflector::slug($data['username']).'_'.time();
            $entity = $this->Users->newEntity();
        }
        $data['physical_location']['current_latitude'] = Utils::getVar('latitude', $data);
        $data['physical_location']['current_longitude'] = Utils::getVar('longitude', $data);
        $items = $this->Users->patchEntity($entity, $data,['validate' => 'facebookSignup','associated'=>['PhysicalLocation']]);
        
        if($items->errors()) {
            $this->restException(['status' => "failed", 'message' => $this->mapErrors($items->errors())], 400);
        }
        if(empty($data['id'])) {            
            $matrix = $this->Matrix->register($data);
            if(!$matrix) {
                $this->restException(['status' => "failed", 'message' => __('Matrix registration failed.')], 401);
            }
            $items->set("matrix_user_id", $matrix['user_id']);
            $items->set("matrix_access_token", $matrix['access_token']);
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
        $mdata['password'] = ApiHasher::dehash($items->password);
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
            $items = TableRegistry::get('Api.UserImages')->uploadFacebookImage($data['image_url'], $this->Auth->user('id'));
            $this->Matrix->uploadMediaImage([
                'image_url'=>$items['image_url'],
                //'image_url'=>$data['image_url'],
                'matrix_token'=>$user['matrix_access_token'],
                'matrix_user_id'=>$user['matrix_user_id']
                ]);
        }
        $data = [
            'id'=>$user['id'],
            'username'=>$user['username'],
            'display_name'=>$user['display_name'],
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
        if(!empty($items->email)) {
            $this->getMailer('Api.User')->send('signup', [$items]);
        }
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
        $user = $this->Users->find()->where(['LOWER(email)'=> strtolower($data['email'])]);
        if(!$user->count()) {
            $this->restException(['status'=>'success', 'message'=>__('Reset password link has been sent to your email address if you are registered with us.')], 200);
        }
        $user = $user->first();
        $user->email = strtolower($user->email);
        $user['forgot_password_token'] = $data['forgot_password_token'] = sha1(uniqid(rand(), true));
        $data['forgot_password_timestamp'] = time();
        $d = $this->Users->updateAll($data, ['LOWER(email)'=> strtolower($data['email'])]);
        $this->getMailer('Api.User')->send('forgotPassword', [$user]);
        $response = ['status' => "success", 'message' => __('Reset password link has been sent to your email address if you are registered with us.')];
        $this->set($response);
    }
    
     /**
     * resetPassword to reset the user password
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    */
    public function resetPassword($token, $email) {
        $status = 'success';
        $done = $this->request->getQuery('status');
        if (!$token || !$email) { 
            throw new NotFoundException(__('Missing required information. Please read email carefully and try again.'));
        }
        $user = $this->Users->find()->where(['LOWER(email)'=> strtolower($email),'forgot_password_token'=>$token])->first();
        if (!$user) {
            $status = 'error';
            $this->Flash->error(__('Password reset link has either expired or invalid.'));            
        }
        if($this->request->is(['post','put']) && ($status == 'success')){
            $data = $this->request->getData();
            $error = $this->Users->validationResetPassword($data);
            if(empty($error)){                
                $previousPassword = ApiHasher::dehash($user->password);
                $user->status = 'Active';
                $user->password = $data['new_password'];
                $user->forgot_password_token = null;
                $user->forgot_password_timestamp = null;
                if ($this->Users->save($user)) {
                    $matrixData = [
                        'old_password' => $previousPassword,
                        'new_password' => $data['new_password'],
                        'matrix_user_id' => $user->matrix_user_id,
                        'matrix_access_token' => $user->matrix_access_token,
                    ];
                    //pr($matrixData);die;
                    $this->loadComponent('Api.Matrix');
                    $this->Matrix->changePassword($matrixData);
                    $status = 'done';
                    //$this->Flash->success(__('Your new password has been reset successfully.'),['status'=>'done']);
                    //return $this->redirect(['users/reset-password/'.$token.'/'.$email.'?status=done']);    
                } else {
                    $status = 'failed';
                    $this->Flash->error(__('Failed to reset the password.'));
                    //return $this->redirect(['action' => 'login']);    
                }
            }else{
                $status = 'failed';
                $user->errors($error);
            }
            
        }        
        $this->set(compact('user'));
        $this->set(compact('status'));
        $this->render('Users/reset_password',false);
    }
    
    /**
     * changePassword method to change the user password
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function changePassword() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data_item = \Api\Utils\Utils::escape($this->request->data);
        $errors = $this->Users->validationChangePassword($data_item, $this->Auth->user('id'));
        if($errors) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        if(!empty($this->Auth->user('UserLogs.matrix_user_id')) && !empty($this->Auth->user('UserLogs.matrix_access_token'))) {
            $this->loadComponent('Api.Matrix');
            $data_item['matrix_user_id'] = $this->Auth->user('UserLogs.matrix_user_id');
            $data_item['matrix_access_token'] = $this->Auth->user('UserLogs.matrix_access_token');
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
        if(empty($data)){
            $this->restException(['status'=>'failed', 'message'=>__('Invalid Request.')], 400);
        }
        $data['gender'] = !empty($data['gender'])?ucfirst($data['gender']):'';
        $entity = $this->Users->get($id);
        $username = $entity->username;
        $items = $this->Users->patchEntity($entity, $data, ['validate' =>'UpdateUser']);
        if($items->errors()){
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
        /* At the time of update username will not update and maintain the prev username by swaping the value*/
        $items->set('username',$username);
        if(!empty($data['username'])){
            $items->set('display_name',$data['username']);
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
        if (!$this->request->is(['post', 'delete'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
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
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
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
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $loggedUser = $this->Auth->user();   
        $errors = $this->Users->friendRequestValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr){
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        if($data['friend_id'] == $loggedUser['id']){
            $this->restException(['status'=>'failed','message'=>__('You could not {0} himself.', strtolower($data['friend_status']))],400);
        }
        
        
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
            ]]);
        
        if(!$requestedFrnd->isEmpty() && $data['friend_status'] == 'Unfriend'){
            $currentStatus = $requestedFrnd->first()->requested_status;
            if($currentStatus == 'Blocked'){
                $this->restException(['status'=>'failed', 'message'=>__('User has been blocked.')], 400);
            }
        }
        
        if($requestedFrnd->isEmpty()){
            $newObj = $frObj->newEntity();
            $newObj->requested_by = $loggedUser['id'];
            $newObj->requested_to = $data['friend_id'];
            $newObj->action_by = $loggedUser['id'];
            $newObj->requested_status = $data['friend_status'];
            if($frObj->save($newObj)) {
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status']=='Pending') { 
                    $push['slug'] = 'friend-request';
                    $this->Push->sendPushNotification($push);
                } else if($data['friend_status']=='Blocked') {
                    $push['slug'] = 'blocked';
                    $this->Push->sendPushNotification($push);
                }elseif(($data['friend_status']=='Accepted')) {
                    $push['slug'] = 'friend-added';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=>Configure::read('requestMsg.'.$data['friend_status']),'data'=>[
                    'id'=>$newObj->id,
                    'requested_by'=>$newObj->requested_by,
                    'requested_to'=>$newObj->requested_to,
                    'requested_status'=>$newObj->requested_status,
                    'action_by'=>$newObj->action_by
                    ]
                ]);
            } else {
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        }else{
            $frndRequest = $requestedFrnd->first();            
            if($data['friend_status'] == $frndRequest->requested_status){
                $this->restException(['status'=>'failed', 'message'=>__('Friend request already sent with same status.')], 400);
            }  
            if($frndRequest->requested_status=='Unfriend' || $frndRequest->requested_status=='Decline') {
                $frndRequest->set('requested_by', $loggedUser['id']);
                $frndRequest->set('requested_to', $data['friend_id']);
            }
            $frndRequest->set('requested_status',$data['friend_status']);
            $frndRequest->set('action_by',$loggedUser['id']);
            if($frObj->save($frndRequest)){
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status']=='Pending') {
                    $push['slug'] = 'friend-request';
                    $this->Push->sendPushNotification($push);
                } else if($data['friend_status']=='Blocked') {
                    $push['slug'] = 'blocked';
                    $this->Push->sendPushNotification($push);
                }elseif(($data['friend_status']=='Accepted')) {
                    $push['slug'] = 'friend-added';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                    'id'=>$frndRequest->id,
                    'requested_by'=>$frndRequest->requested_by,
                    'requested_to'=>$frndRequest->requested_to,
                    'requested_status'=>$frndRequest->requested_status,
                    'action_by'=>$frndRequest->action_by
                ]]);
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        }
    }
    
    /**
     * addFriend method to send the friend request
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function addFriend() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $errors = $this->Users->addFriendValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr){
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $loggedUser = $this->Auth->user();   
        
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
            ]]);
        
        if(!$requestedFrnd->isEmpty()){
            $currentStatus = $requestedFrnd->first()->requested_status;
            if(in_array($currentStatus, ['Pending', 'Accepted', 'Blocked'])) {
                $this->restException(['status'=>'failed', 'message'=>__('You have been already '.$currentStatus.'.')], 400);
            }
        }
        if($requestedFrnd->isEmpty()){
            $newObj = $frObj->newEntity();
            $newObj->requested_by = $loggedUser['id'];
            $newObj->requested_to = $data['friend_id'];
            $newObj->action_by = $loggedUser['id'];
            $newObj->requested_status = $data['friend_status'];
            if($frObj->save($newObj)) {
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status']=='Pending') { 
                    $push['slug'] = 'friend-request';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=>Configure::read('requestMsg.'.$data['friend_status']),'data'=>[
                    'id'=>$newObj->id,
                    'requested_by'=>$newObj->requested_by,
                    'requested_to'=>$newObj->requested_to,
                    'requested_status'=>$newObj->requested_status,
                    'action_by'=>$newObj->action_by
                    ]
                ]);
            } else {
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        }else{
            $frndRequest = $requestedFrnd->first();            
            if($data['friend_status'] == $frndRequest->requested_status){
                $this->restException(['status'=>'failed', 'message'=>__('Friend request already sent with same status.')], 400);
            }  
            //if($frndRequest->requested_status=='Unfriend' || $frndRequest->requested_status=='Decline') {
            if(in_array($currentStatus, ['Unblock', 'is_direct', 'Decline', 'Unfriend'])) {
                $frndRequest->set('requested_by', $loggedUser['id']);
                $frndRequest->set('requested_to', $data['friend_id']);
            }
            $frndRequest->set('requested_status',$data['friend_status']);
            $frndRequest->set('action_by',$loggedUser['id']);
            if($frObj->save($frndRequest)){
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status']=='Pending') {
                    $push['slug'] = 'friend-request';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                    'id'=>$frndRequest->id,
                    'requested_by'=>$frndRequest->requested_by,
                    'requested_to'=>$frndRequest->requested_to,
                    'requested_status'=>$frndRequest->requested_status,
                    'action_by'=>$frndRequest->action_by
                ]]);
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        }
    }
    /**
     * requestAcceptDeclined method to accept or declined the request
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function requestAcceptDeclined() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $errors = $this->Users->requestAcceptDeclinedValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr) {
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $loggedUser = $this->Auth->user();
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
        ]]);
        if($requestedFrnd->isEmpty()) {
            $this->restException(['status'=>'failed', 'message'=>__('Friend request not sent yet.')], 400);
        } else {
            $currentStatus = $requestedFrnd->first()->requested_status;
            if($currentStatus != 'Pending') {
                $this->restException(['status'=>'failed', 'message'=>__('Friend status must be pending, current friend status is '.$currentStatus.'.')], 400);
            }
        }
        $frndRequest = $requestedFrnd->first();
        $frndRequest->set('requested_status', $data['friend_status']);
        $frndRequest->set('action_by', $loggedUser['id']);
        if($frObj->save($frndRequest)) {
            //data prepaire for push notification//
            $push['requested_by'] = $loggedUser['id'];
            $push['username'] = $loggedUser['username'];
            $push['display_name'] = $loggedUser['display_name'];
            $push['requested_to'] = $data['friend_id'];
            $push['spayc_id'] = null; //provide spayc id if push related to spayc
            if(($data['friend_status']=='Accepted')) {
                $push['slug'] = 'friend-added';
                $this->Push->sendPushNotification($push);
            }
            $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                'id'=>$frndRequest->id,
                'requested_by'=>$frndRequest->requested_by,
                'requested_to'=>$frndRequest->requested_to,
                'requested_status'=>$frndRequest->requested_status,
                'action_by'=>$frndRequest->action_by
            ]]);
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
        }
    }
    /**
     * blockFriend method to block the friend
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function blockFriend() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $loggedUser = $this->Auth->user();
        $errors = $this->Users->requestBlockedValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        if($loggedUser['id'] == $data['friend_id']) {
            $this->restException(['status'=>'failed', 'message'=>__('You couldn\'t block himself.')], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr) {
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
        ]]);
        if(!$requestedFrnd->isEmpty()) {
            $currentStatus = $requestedFrnd->first()->requested_status;
             if($currentStatus == 'Blocked') {
                $this->restException(['status'=>'failed', 'message'=>__('User has been already blocked.')], 400);
            }
        }
        
        if($requestedFrnd->isEmpty()) {
            $newObj = $frObj->newEntity();
            $newObj->requested_by = $loggedUser['id'];
            $newObj->requested_to = $data['friend_id'];
            $newObj->action_by = $loggedUser['id'];
            $newObj->requested_status = $data['friend_status'];
            if($frObj->save($newObj)) {
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status'] == 'Blocked') {
                    $push['slug'] = 'blocked';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=>Configure::read('requestMsg.'.$data['friend_status']),'data'=>[
                    'id'=>$newObj->id,
                    'requested_by'=>$newObj->requested_by,
                    'requested_to'=>$newObj->requested_to,
                    'requested_status'=>$newObj->requested_status,
                    'action_by'=>$newObj->action_by
                    ]
                ]);
            } else {
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        } else {
            $frndRequest = $requestedFrnd->first();
            $frndRequest->set('requested_status', $data['friend_status']);
            $frndRequest->set('action_by', $loggedUser['id']);
            if($frObj->save($frndRequest)) {
                //data prepaire for push notification//
                $push['requested_by'] = $loggedUser['id'];
                $push['username'] = $loggedUser['username'];
                $push['display_name'] = $loggedUser['display_name'];
                $push['requested_to'] = $data['friend_id'];
                $push['spayc_id'] = null; //provide spayc id if push related to spayc
                if($data['friend_status'] == 'Blocked') {
                    $push['slug'] = 'blocked';
                    $this->Push->sendPushNotification($push);
                }
                $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                    'id'=>$frndRequest->id,
                    'requested_by'=>$frndRequest->requested_by,
                    'requested_to'=>$frndRequest->requested_to,
                    'requested_status'=>$frndRequest->requested_status,
                    'action_by'=>$frndRequest->action_by
                ]]);
            } else {
                $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
            }
        }
    }
    /**
     * unblockFriend method to unblock the friends
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function unblockFriend() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $errors = $this->Users->requestUnblockedValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr) {
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $loggedUser = $this->Auth->user();
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
        ]]);
        if($requestedFrnd->isEmpty()) {
            $this->restException(['status'=>'failed', 'message'=>__('Friend request not sent yet.')], 400);
        } else {
            $currentStatus = $requestedFrnd->first()->requested_status;
            if($currentStatus != 'Blocked') {
                $this->restException(['status'=>'failed', 'message'=>__('Friend status must be Blocked, current friend status is '.$currentStatus.'.')], 400);
            }
        }
        $frndRequest = $requestedFrnd->first();
        $frndRequest->set('requested_status', $data['friend_status']);
        $frndRequest->set('action_by', $loggedUser['id']);
        if($frObj->save($frndRequest)) {
            $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                'id'=>$frndRequest->id,
                'requested_by'=>$frndRequest->requested_by,
                'requested_to'=>$frndRequest->requested_to,
                'requested_status'=>$frndRequest->requested_status,
                'action_by'=>$frndRequest->action_by
            ]]);
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
        }
    }
    
    /**
     * unfriendRequest method to view the logged user friends
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function unfriendRequest() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $errors = $this->Users->requestUnfriendValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr) {
            $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $loggedUser = $this->Auth->user();
        $requestedFrnd = $frObj->find()->Where(['OR'=>[
            ['requested_by' => $loggedUser['id'],'requested_to'=>$data['friend_id']],
            ['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]
        ]]);
        if($requestedFrnd->isEmpty()) {
            $this->restException(['status'=>'failed', 'message'=>__('Friend request not sent yet.')], 400);
        } else {
            $currentStatus = $requestedFrnd->first()->requested_status;
            if($currentStatus == 'Unfriend') {
                $this->restException(['status'=>'failed', 'message'=>__('User has been already unfriend.')], 400);
            }
        }
        $frndRequest = $requestedFrnd->first();
        $frndRequest->set('requested_status', $data['friend_status']);
        $frndRequest->set('action_by', $loggedUser['id']);
        if($frObj->save($frndRequest)) {
            $this->restException(['status'=>'success', 'message'=> Configure::read('requestMsg.'.$data['friend_status']),'data'=>[                    
                'id'=>$frndRequest->id,
                'requested_by'=>$frndRequest->requested_by,
                'requested_to'=>$frndRequest->requested_to,
                'requested_status'=>$frndRequest->requested_status,
                'action_by'=>$frndRequest->action_by
            ]]);
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
        }
    }
    
    /**
     * setFriendResponse method to accept,block or decline the request
     * 
     * @param Integer $user_id Logged user id
     * @param Object $_POST containing friend id and status
     * @return Object Json object containig http response and message
     * 
     */
    public function setFriendResponse() {
        if (!$this->request->is(['put'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $errors = $this->Users->friendRequestResponseValidate($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $frObj = TableRegistry::get('Api.FriendRequest');
        $spaceUsr = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$spaceUsr){
             $this->restException(['status'=>'failed', 'message'=>__('User is not registered with warp.')], 400);
        }
        $loggedUser = $this->Auth->user();     
         if(in_array($data['friend_status'],['Decline','Unfriend'])){
            if($frObj->deleteAll(['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']])){
                $this->restException(['status'=>'success', 'message'=>Configure::read('requestMsg.'.$data['friend_status'])]);
            }
        }
        $requestedFrnd = $frObj->find()->where(['requested_by' => $data['friend_id'],'requested_to'=>$loggedUser['id']]);
        if($requestedFrnd->isEmpty()){
            $this->restException(['status'=>'failed', 'message'=>__('Record not found to update status.')], 400);
        }
        $frndRequest = $requestedFrnd->first();
        if($data['friend_status'] == $frndRequest->requested_status){
            $this->restException(['status'=>'failed', 'message'=>__('Friend request already update the status.')], 400);
       }            
        $frndRequest->set('requested_status',$data['friend_status']);
        $frndRequest->set('action_by',$loggedUser['id']);
        if($frObj->save($frndRequest)) {
            //data prepaire for push notification//
            $push['requested_by'] = $loggedUser['id'];
            $push['username'] = $loggedUser['username'];
            $push['display_name'] = $loggedUser['display_name'];
            $push['requested_to'] = $data['friend_id'];
            $push['spayc_id'] = null; //provide spayc id if push related to spayc
            if(($data['friend_status']=='Accepted')) {
                $push['slug'] = 'friend-added';
                $this->Push->sendPushNotification($push);
            } else if($data['friend_status']=='Blocked') {
                $push['slug'] = 'blocked';
                $this->Push->sendPushNotification($push);
            }
            
            $this->restException(['status'=>'success', 'message'=>Configure::read('requestMsg.'.$data['friend_status']),'data'=>[
                'id'=>$frndRequest->id,
                'requested_by'=>$frndRequest->requested_by,
                'requested_to'=>$frndRequest->requested_to,
                'requested_status'=>$frndRequest->requested_status,
                'action_by'=>$frndRequest->action_by
            ]]);
        }else{
            $this->restException(['status'=>'failed', 'message'=>__('Failed to update friend status.')],400);
        }
    }
    
    /**
     * getFriends method to view the logged user friends
     * 
     * @param Integer $user_id Logged user id
     * @param String $friend_status status of the friend like accepted or pending
     * @return Object Json object containig http response and message
     * 
     */
    public function getFriends() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $friendStatus = !empty($this->request->query['friend_status'])?$this->request->query['friend_status']:'Accepted';
        $status = Configure::read('friend_requested_status');
        if(empty($friendStatus) || !in_array(ucfirst($friendStatus), $status)) {
            $this->restException(['status'=>'failed', 'message'=>__('Status is required fields and status must be in('.  implode(',', $status).').')], 400);
        }
        $loggedUser = $this->Auth->user();
        $userId = !empty($this->request->query('user_id'))?$this->request->query('user_id'):$loggedUser['id'];
        
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, $friendStatus);
        if(!$friend){
            $this->restException(["status"=>"success",'message'=>__("Record not found")],204);
        }
        $friends = $this->Users->find("all", ['fields'=>['Users.id', 'Users.username','Users.display_name', 'Users.matrix_user_id', 'Users.matrix_access_token'], 'conditions'=>['Users.id IN'=>$friend, 'Users.id !='=>$userId, 'Users.status'=>'Active']]);
        $friends->contain([          
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            }
        ]);
        $friends->formatResults(function (\Cake\Collection\CollectionInterface $results) use($loggedUser) {
            return $results->map(function ($row) use($loggedUser) {                
                $uId = ApiHasher::decrypt($row['id']);
                $row['friend'] = TableRegistry::get('Api.FriendRequest')->myFriend($uId, $loggedUser['id']);
                $row['matrix_room_id'] = !empty($row['friend']['matrix_room_id'])?$row['friend']['matrix_room_id']:null;
                unset($row['friend']['matrix_room_id']);
                $row->image_url = !empty($row['user_images'][0]['image_url'])?$row['user_images'][0]['image_url']:'';
                
                unset($row['user_images'],$row['matrix_access_token']);
                return $row;
            });
        });
        $limit = (!empty($this->request->query['limit']) && is_numeric($this->request->query['limit']))?$this->request->query['limit']:5;
        $friends->order(['Users.username'=>'ASC'])->limit($limit);
        $page = (!empty($this->request->query['page']) && is_numeric($this->request->query['page']))?$this->request->query['page']:1;
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
    
    /**
     * viewProfile method to view the logged user profile
     * 
     * @param Integer $id Logged user id
     * @return Object Json object containig http response and message
     * 
     */
    
    public function viewProfile($id = null) {
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $loggedUser = $this->Auth->user();
        if(empty($id)) {
            $this->restException(['status'=>'failed', 'message'=>__('User id is required field.')], 400);
        }
        $user = $this->Users->find('all', ['fields'=>['Users.id', 'Users.username','Users.display_name', 'Users.email', 'Users.gender', 'Users.dob','Users.country_code', 'Users.phone', 'Users.website_url', 'Users.address', 'Users.bio_data', 'Users.longitude', 'Users.latitude', 'Users.matrix_user_id']])->where(['OR'=>['Users.id'=>$id,'Users.matrix_user_id'=>$id]]);

        $userId = $this->Auth->user('id');
        $user->contain([
            'UserImages'=>function($q) {
                return $q->select(['UserImages.id', 'UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile', 'UserImages.order_index']);
            },

            'NotificationTo'=>function($q) {
                return $q->select(['NotificationTo.requested_to', 'unread_notification'=>$q->func()->count('NotificationTo.id')])->group(['NotificationTo.requested_to'])->where(['NotificationTo.status'=>'Unread']);
            },
            'Spaycs'=>function($q) {
                return $q->select(['Spaycs.user_id', 'created_spaycs'=>$q->func()->count('Spaycs.id')])->group(['Spaycs.user_id'])->where(['Spaycs.group_type !='=>'trusted_private','Spaycs.parent_id IS'=>null ]);
            }
        ]);
        //pj($user);die;
        
        $user->formatResults(function (\Cake\Collection\CollectionInterface $results)use($loggedUser,$id) {
            return $results->map(function ($row)use($loggedUser,$id) {
                $uId = ApiHasher::decrypt($row['id']);
                $row['joined_spaycs'] = count($this->Users->findJoinedSpayc($id));
                $row['created_spaycs'] = !empty($row['spaycs'][0]['created_spaycs'])? $row['spaycs'][0]['created_spaycs'] : 0;
                $row['unread_notifications'] = !empty($row['notification_to'][0]['unread_notification'])? $row['notification_to'][0]['unread_notification'] : 0;
                
                $row['friend'] = TableRegistry::get('Api.FriendRequest')->myFriend($uId,$loggedUser['id']);
                $row['matrix_room_id'] = !empty($row['friend']['matrix_room_id'])?$row['friend']['matrix_room_id']:null;
                
                unset($row['friend']['matrix_room_id']);
                $row['friend']['pending_request'] = TableRegistry::get('Api.FriendRequest')->friendStatus($loggedUser['id'],PENDING);
                $row['friend']['total_friends'] = TableRegistry::get('Api.FriendRequest')->getFriendCountByUserId($uId);
                unset($row['joined_spayc'],$row['requestedto'],$row['requestedby'],$row['spaycs']);
                unset($row['notification_to']);
                return $row;
            });
        });
        if($user->isEmpty()){
            $this->restException(['status'=>'failed', 'message'=>__('Invalid user id')], 400);
        }
        $response = ['status'=>'success', 'message'=>__('User profile.'), 'data'=> $user->first()];
        $this->set($response);
    }
    
    /**
     * getFacebookFriends the the list of facebook friends from facebook portal
     * 
     * @param Object $_GET get the list of friend details
     * @return Object Response json object
     */
    
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
        $spaycFriends = $this->Users->find("all", ['fields'=>['Users.id', 'Users.username','Users.display_name'], 'conditions'=>['Users.fb_id IN'=>$friendIds, 'Users.id !='=>$this->Auth->user('id')]]);
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
        $page = (!empty($this->request->query['page']) && is_numeric($this->request->query['page']))?$this->request->query['page']:1;
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
        if(empty($data['records'])) {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success', 'message'=>__('Facebook friend lists.'), 'data'=>$data];
        $this->set($response);
    }
    
    /**
     * pushNotification method to get matrix notify data and send notification by using Queue workers
     * 
     * @param Request Object $_POST pusher data in post
     * @return Object Blank Object
     * 
     */
    
    public function pushNotification() {
        $blankObj = new \stdClass();
        
        if(!$this->request->is(['post'])) {
            $this->restException($blankObj); 
        }
        
        $data = $this->request->getData();
        Log::info($data);
        //$this->Users->pusherData($data);
        /* for direct notification */
        if(!empty($data['notification']['content']['actionBy']) && ($data['notification']['content']['actionBy'] == 'Self' )){
            $this->restException($blankObj); 
        }
        if(!empty($data['notification']['content']['msgtype'])){
            $msgType = $data['notification']['content']['msgtype'];
        }else{
            $this->restException($blankObj); 
        }
        if(!empty($msgType)){
            if( ($msgType == 'm.likeMessage') && !empty($data['notification']['content']['disLikeMembers'])){
                $this->restException($blankObj); 
            }
        }
        if(empty($data['notification']['devices'][0])){
            $this->restException($blankObj); 
        }
        $device = $data['notification']['devices'][0];
        $users = $this->Users->findByDeviceTokenOrMatrixUserId($device['pushkey'],$data['notification']['sender'])->select(['id','matrix_user_id','device_token']);
        
        $senderId = null;$receiverId = null;
        if(!$users->isEmpty()) {
            #pj($users);die;
            $senderId = $users->firstMatch(['matrix_user_id'=>$data['notification']['sender']]);
            $receiverId = $users->firstMatch(['device_token'=>$device['pushkey']]);
        }
        
        $items = $this->Users->pusherNotification($data);
        if(empty($items)){
            $this->restException($blankObj);
        }
        $items['device_token'] = $deviceToken = $device['pushkey'];
        $items['date_time'] = date('m-d-Y H:i:s',$device['pushkey_ts']);
        if(!empty($senderId) && !empty($receiverId) && in_array($msgType,['m.replyText','m.likeMessage'])){
            $saveNotification = TableRegistry::get("Api.Notifications")->addNotification(array_merge($items,['requested_by'=>$senderId->id,'requested_to'=>$receiverId->id,'date_time'=>$items['date_time']]));            
            $items['id'] = $saveNotification->id;
            $items['requested_by'] = $senderId->id;
        }
        $this->loadComponent('Api.Notification');
        //$this->Push->sendOnIOS($items);
        Log::info($items);
        $this->Notification->iosPush($items,$deviceToken);        
        /* Rest job will be done by workers */
        //$data['items'] = $items;
        //TableRegistry::get('Queue.QueuedJobs')->createJob('Pusher',$data);
        $this->restException($blankObj);  
        
    }
    
    public function testPushnotification() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        //$data['message'] = "test push notification for spayc";
        //$this->Push->sendOnIOS($data);
        $this->Push->sendPushNotification($data);
        $response = ['status'=>'success', 'message'=>__('notification sent')];
        $this->set($response);
    }
    
    /**
     * userCurrentStatus method to update the user current status
     * @param Double $latitude user current latitude
     * @param Double $longitude user current longitude
     * 
     * @return Object serialize json response with status
     */
    
    public function userCurrentStatus(){
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data  = $this->request->getData();
        $errors = $this->Users->validateLatLong($data);        
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $lat = (float)$data['latitude'];
        $long = (float)$data['longitude'];
        $user = $this->Auth->user();
        if($this->Users->PhysicalLocation->updateLocation($user,$lat,$long)){
            $response = ['status'=>'success', 'message'=>__('Request has been updated successfully.')];
        }else{
            $this->response->statusCode(400);
            $response =['status'=>'failed', 'message'=>__('System failed to update the status.')];
        }
        $this->set($response);
    }
    
    /**
     * getNotifications method to get the list of user notification
     * 
     * @param Int $limit no of record to retrieve
     * @param Int $page offset of pagination
     * 
     * @return Object json object of notification details
     * 
     */
    public function getNotifications() {
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $limit = (!empty($this->request->query['limit']) && is_numeric($this->request->query['limit']))?$this->request->query['limit']:5;
        $page = (!empty($this->request->query['page']) && is_numeric($this->request->query['page']))?$this->request->query['page']:1;
        
        $notifications = TableRegistry::get("Api.Notifications")->find()
            ->select(['id', 'status', 'date_time', 'message', 'notification_type'])
            ->where(['requested_to'=>$this->Auth->user('id')]);
        $notifications->contain([
            'NotificationBy' => function($q) {
                return $q->select(['NotificationBy.id', 'NotificationBy.username','NotificationBy.display_name'])->contain(['UserImages'=>['fields'=>['user_id', 'image_url'], 'conditions'=>['is_profile'=>'Yes']]]);
            },
            'Spaycs' => function($q) {
                return $q->select(['Spaycs.id', 'Spaycs.name', 'Spaycs.matrix_room_id', 'Spaycs.image']);
            }
        ]);
        $notifications->order(['date_time'=>'DESC']);
        $notifications->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                
                $row['space_name'] = !empty($row['spayc']['name'])?$row['spayc']['name']:null;
                $row['room_id'] = !empty($row['spayc']['matrix_room_id'])?$row['spayc']['matrix_room_id']:null;
                $row['spayc_image'] = !empty($row['spayc']['image'])?$row['spayc']['image']:null;
                $row['username'] = !empty($row['notification_by']['username'])?$row['notification_by']['username']:null;
                $row['display_name'] = !empty($row['notification_by']['display_name'])?$row['notification_by']['display_name']:null;
                $row['user_id'] = !empty($row['notification_by']['id'])?$row['notification_by']['id']:null;
                $row['user_image'] = !empty($row['notification_by']['user_images'][0]['image_url'])?$row['notification_by']['user_images'][0]['image_url']:null;
                $row['is_unread'] = ($row['status']=='Unread')?true:false;
                unset($row['spayc'],$row['status'],$row['notification_by']);
                return $row;
            });
        });
        $notifications->limit($limit);
        if($page < 0){
            $page = $page*-1;
            $notifications->page($page);
        } else {
            $notifications->page($page);
        }
        if($notifications->isEmpty()) {
            $this->response->statusCode(204);
        }
        $data['count'] = $notifications->count();
        $data['notification'] = $notifications;
        $response = ['status'=>'success', 'message'=>__('Notification Lists.'), 'data'=>$data];
        $this->set($response);
    }
    
    /**
     * updateDeviceToken update the device token 
     * 
     * @param Bool $is_notify to keep the status of notification
     * @param String $device_token device token
     * 
     * @return Object Json object containing the request message
     */
    public function updateDeviceToken() {
        if(!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
        if(empty($data['is_notify'])) {
            $this->restException(['status'=>'failed','message'=>'is_notify is required field.'], 400);
        }
        $isNotify = ucfirst($data['is_notify']);
        if(!in_array($isNotify, Configure::read('is_notify'))) {
            $this->restException(['status'=>'failed','message'=>'is_notify must be in ('.implode(',', Configure::read('is_notify')).').'], 400);
        }
        if($isNotify=='On' && empty($data['device_token'])) {
            $this->restException(['status'=>'failed','message'=>'Device token is required field.'], 400);
        }
        /*if(($isNotify=='On' && !empty($data['device_token'])) && strlen($data['device_token'])<64) {
            $this->restException(['status'=>'failed','message'=>'Invalid device token'], 400);
        }*/
        
        $modified = new \Cake\I18n\Time();
        $userToken = $this->Users->findByDeviceToken($data['device_token'])->first();
        /* if device token exist for different user then will reset previous value */
        if(!empty($userToken)){
            if($userToken->id != $user['id']){
                $userToken->device_token = null;
                $this->Users->save($userToken);
            }
        }
        $this->Users->UpdateAll(['is_notify'=>$isNotify,'device_token'=>$data['device_token'], 'modified'=>$modified], ['Users.id'=>$user['id']]);
        
        TableRegistry::get('Api.UserLogs')->UpdateAll(['device_token'=>$data['device_token'], 'modified'=>$modified], ['user_id'=>$this->Auth->user('id')]);
        $response = ['status'=>'success', 'message'=>__('Device token updated successfully.')];
        $this->set($response);
    }
    /**
     * changeRole method to make user as admin
     * @endpoint change-role.json
     */
    
    public function changeRole(){
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
        $errors = $this->Users->ValidatechangeRole($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $entities = $jsModel->find()
                ->contain(['Spaycs' => function($q) {
                    return $q->select(['Spaycs.id', 'Spaycs.name', 'Spaycs.matrix_room_id', 'Spaycs.image']);
            }])->where(['JoinedSpayc.spayc_id'=>$data['spayc_id'],'JoinedSpayc.user_id IN'=>[$data['user_id'],$user['id']]]);
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('User has not joined this warp.')], 400);
        }
        $adminEntity = Hash::extract($entities->toArray(), '{n}[user_id='.$user['id'].']');
        $userEntity = Hash::extract($entities->toArray(), '{n}[user_id='.$data['user_id'].']');
        if(empty($adminEntity[0]) || ($adminEntity[0]['status'] != 'Joined')){
            $this->restException(['status'=>'failed','message'=>__('You are not joined with this warp.')], 400);
        }
        if(empty($userEntity[0]) || ($userEntity[0]['status'] != 'Joined')){
            $this->restException(['status'=>'failed','message'=>__('user is not joined with this warp.')], 400);
        }
        if($adminEntity[0]['is_admin'] <= 0){
            $this->restException(['status'=>'failed','message'=>__('You have no privileges to make someone admin.')], 400);
        }
        if(($userEntity[0]['is_admin'] == $adminEntity[0]['is_admin'])){
            $this->restException(['status'=>'failed','message'=>__('You couldn\'t change the role with same privileges.')], 400);
        }
        if(($userEntity[0]['is_admin'] == 2) && ($data['role'] == 2)){
            $this->restException(['status'=>'failed','message'=>__('You couldn\'t change the role of superadmin.')], 400);
        }
        if($userEntity[0]['is_admin'] == $data['role']){
            $this->restException(['status'=>'failed','message'=>__('User has already with same privileges.')], 400);
        }
        $entity = $userEntity[0];
        if($entity->is_admin == $data['role']){
            $this->restException(['status'=>'failed','message'=>__('User has already been admin.')], 400);
        }
        $entity->is_admin = $data['role'];
        $entity->modified = new \Cake\I18n\Time();
        $entity->updated_by = $this->Auth->user('id');
        if($jsModel->save($entity)){
            $push['requested_by'] = $user['id'];
            $push['username'] = $user['username'];
            $push['display_name'] = $user['display_name'];
            $push['requested_to'] = $data['user_id'];
            $push['matrix_room_id'] = $entity->spayc->matrix_room_id;
            $push['spayc_id'] = $data['spayc_id']; //provide spayc id if push related to spayc
            $push['slug'] = 'admin-asigned';            
            if($data['role'] == 1){
                $this->Push->sendPushNotification($push);
                $message = __('User has been assigned as admin successfully.');
            }else{
                $message = __('Role has been changed  successfully.');
            }
            $response = ['status'=>'success','message'=>$message];
        }else{
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('System failed to change the role.')];
        }
        $this->set($response);
    }
    
    /**
     * readNotification to read the notification
     * 
     * @param Int $notification_ids id of notification
     * @return Object Json object containing the request message
     */
    public function readNotification() {
        if(!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['notification_ids'])) {
            $this->restException(['status'=>'failed','message'=>__('Notification id is missing.')], 400);
        }
        $data['notification_ids'] = explode(',', $data['notification_ids']);
        $user = $this->Auth->user();
        $notification = TableRegistry::get("Api.Notifications");
        $notify = $notification->find()->where(['id IN'=>$data['notification_ids'], 'requested_to'=>$user['id']]);
        if($notify->count() != count($data['notification_ids'])) {
            $this->restException(['status'=>'failed','message'=>__('Notification id is not valid.')], 400);
        }
        $notification->updateAll(['status'=>'Read'], ['id IN'=>$data['notification_ids']]);
        $response = ['status'=>'success','message'=>__('Notification read successfully.')];
        $this->set($response);
    }
    
    /**
     * unreadNotification method to retrieve the list of unread notification
     * 
     * @param Int $id id of logged user
     * @return Object Json object containing the request message
     */
    
    public function unreadNotification($id = null) {
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        $loggedUser = $this->Auth->user();
        $id=$loggedUser['id'];
        $user = $this->Users->find('all', ['fields'=>['Users.id']])->where(['OR'=>['Users.id'=>$id,'Users.matrix_user_id'=>$id]]);

        $userId = $this->Auth->user('id');
        $user->contain([
            'NotificationTo'=>function($q) {
                return $q->select(['NotificationTo.requested_to', 'unread_notification'=>$q->func()->count('NotificationTo.id')])->group(['NotificationTo.requested_to'])->where(['NotificationTo.status'=>'Unread']);
            }
        ]);
        //pj($user);die;
        $user->formatResults(function (\Cake\Collection\CollectionInterface $results)use($loggedUser,$id) {
            return $results->map(function ($row)use($loggedUser,$id) {
                $uId = ApiHasher::decrypt($row['id']);
                $row['unread_notifications'] = !empty($row['notification_to'][0]['unread_notification'])? $row['notification_to'][0]['unread_notification'] : 0;
                unset($row['notification_to']);
                return $row;
            });
        });
        if($user->isEmpty()){
            $this->restException(['status'=>'failed', 'message'=>__('Invalid user')], 400);
        }
        $notification=$user->first();
        if($notification['unread_notifications']){
            $data['is_unread_count']=true;
            $response = ['status'=>'success', 'message'=>__('Unread Notification Status.'), 'data'=> $data];
        }else{
            $data['is_unread_count']=false;
            $response = ['status'=>'success', 'message'=>__('No Unread count found.'), 'data'=> $data];
        }
        
        $this->set($response);
    }
    
    /**
     * facebookFriends method to get list of friends from facebook
     */
    public function facebookFriends(){
        $this->loadComponent('Api.Facebook');
        $fbId = $this->request->getQuery('fb_id');
        $fbAccessKey = $this->request->getQuery('fb_access_key');
        $data = $this->Facebook->friendLists($fbId,$fbAccessKey);
        $response = ['status'=>'success','message'=>'List of friends','data'=>$data];
        $this->set($response);
    }
}
