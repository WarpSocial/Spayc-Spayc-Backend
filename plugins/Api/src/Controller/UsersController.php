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
        #$this->Users->uploadProfileImages();
        $data  = $this->request->getData();
        $data['user_id'] = $this->Auth->user('id');
        if(isset($data['image_url'][0])) {
            foreach($data['image_url'] as $img) {
                $imgData = ['user_id'=>$this->Auth->user('id'),'image_url'=>$img];
                
                $entity = $this->UserImages->newEntity();
                $items = $this->UserImages->patchEntity($entity, $imgData);
                if(!empty($items->errors())){
                     $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
                }
                $this->UserImages->save($items);
            }
        } else {
            $entity = $this->UserImages->newEntity();
            $items = $this->UserImages->patchEntity($entity, $data);
            if(!empty($items->errors())) {
                 $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
            }
            $this->UserImages->save($items);
        }
        $response = ['status'=>'success','message'=>__('Profile image uploaded successfully.')];
        $this->set($response);
    }
    
    /**
     * login method to login and generate the token
     */
    
    public function login() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')],405);
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
            $this->restException(['status'=>'failed','message'=>__('Friend id is required fields.')], 400);
        }
        $data['friend_id'] = ApiHasher::decrypt($data['friend_id']);
        $isUserExist = $this->Users->exists(['id'=>$data['friend_id']]);
        if(!$isUserExist) {
            $this->restException(['status'=>'failed','message'=>__('Invalid friend id.')], 400);
        }
        $frend = TableRegistry::get("Api.FriendRequest");
        $exists = $frend->exists(['FriendRequest.requested_to'=>$data['friend_id'], 'FriendRequest.requested_by'=>$this->Auth->user('id')]);
        if($exists) {
            $this->restException(['status'=>'failed','message'=>__('Friend request already sent.')], 400);
        }
        $friendReq['requested_by'] = $this->Auth->user('id');
        $friendReq['requested_to'] = $data['friend_id'];
        $friendReq['requested_status'] = 'Requested';
        $friendReq['created'] = date("Y-m-d H:i:s");
        $entity = $frend->newEntity();
        $items = $frend->patchEntity($entity, $friendReq);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $frend->save($items);
        $this->response->statusCode(201);
        $response = ['status'=>'success', 'message'=>__('Friend request sent successfully.')];
        $this->set($response);
    }
    
    public function getFriends() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $friendStatus = !empty($this->request->query['friend_status'])?$this->request->query['friend_status']:'Accepted';
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($this->Auth->user('id'), $friendStatus);
        $friends = $this->Users->find("all", ['fields'=>['Users.id', 'name'=>'Users.username', 'Users.matrix_user_id', 'Users.matrix_access_token'], 'conditions'=>['Users.id IN'=>$friend, 'Users.id !='=>$this->Auth->user('id'), 'Users.status'=>'Active']]);
        $friends->contain([
            'Requestedby' => function($q) use($userId) {
                return $q->select(['Requestedby.id','Requestedby.requested_by', 'Requestedby.requested_status', 'Requestedby.requested_to', 'Requestedby.friend_status'])->Where(['OR'=>['Requestedby.requested_by'=>$userId, 'Requestedby.requested_to'=>$userId]]);
            },
            'Requestedto' => function($q) use($userId) {
                return $q->select(['Requestedto.id', 'Requestedto.requested_by', 'Requestedto.requested_to', 'Requestedto.requested_status', 'Requestedto.friend_status'])->Where(['OR'=>['Requestedto.requested_by'=>$userId, 'Requestedto.requested_to'=>$userId]]);
            },
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url']);
            }
        ]);
        $friends->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->friend = !empty($row['requestedto'][0])? $row['requestedto'][0] : [];
                $row->friend = !empty($row['requestedby'][0]) && empty($row->friend)? $row['requestedby'][0] : $row->friend;
                unset($row['requestedto']);
                unset($row['requestedby']);
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
            $data = $friends->toArray();
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
            $this->restException(['status'=>'failed','message'=>__('id is required fields.')], 400);
        }
        $data['id'] = ApiHasher::decrypt($data['id']);
        $friendRequest = TableRegistry::get('Api.FriendRequest');
        $exists = $friendRequest->exists(['id'=>$data['id']]);
        if(!$exists) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid requested id.')], 400);
        }
        $friendStatus = array_merge(Configure::read('friend_requested_status'), Configure::read('friend_status'));
        if(empty($data['status']) || !in_array(ucfirst($data['status']), $friendStatus)) {
            $this->restException(['status'=>'failed', 'message'=>__('Status is required fields and status must be in('.  implode(',', $friendStatus).').')], 400);
        }
        $status = ucfirst($data['status']);
        if(in_array($status, Configure::read('friend_requested_status'))) {
            $friend['requested_status'] = $status;
        } else if(in_array($status, Configure::read('friend_status'))) {
            $friend['friend_status'] = $status;
        }
        $friendRequest->updateAll($friend, ['id'=>$data['id']]);
        $response = ['status'=>'success', 'message'=>__('Friend status updated successfully.')];
        $this->set($response);
    }
    
    public function getFacebookFriends() {
        $data = [];
        if(!empty($this->Auth->user('fb_id')) and !empty($this->Auth->user('fb_access_key'))) {
            $data = $this->Auth->user();
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success', 'message'=>__('Facebook friend lists.'), 'data'=>$data];
        $this->set($response);
    }
}
