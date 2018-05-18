<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use \Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Api\Utils;
use Api\Auth\ApiHasher;
/**
 * Users Model
 *
 * @property \Api\Model\Table\UsersLogsTable|\Cake\ORM\Association\HasMany $UsersLogs
 *
 * @method \Api\Model\Entity\User get($primaryKey, $options = [])
 * @method \Api\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);
        
        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserLogs', [
            'foreignKey' => 'user_id',
            'className' => 'Api.UserLogs'
        ]);
        $this->hasMany('UserImages', [
            'foreignKey' => 'user_id',
            'className' => 'Api.UserImages'
        ]);
        $this->hasMany('JoinedSpayc', [
            'foreignKey' => 'user_id',
            'className' => 'Api.JoinedSpayc'
        ]);
        $this->hasOne('PhysicalLocation', [
            'foreignKey' => 'user_id',
            'className' => 'Api.PhysicalLocation'
        ]);
        $this->hasMany('SubscribedUsers', [
            'foreignKey' => 'user_id',
            'className' => 'Api.SubscribedUsers'
        ]);
        
        $this->hasMany('Requestedby', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER',
            'className' => 'Api.FriendRequest'
        ]);
        $this->hasMany('Requestedto', [
            'foreignKey' => 'requested_to',
            'joinType' => 'INNER',
            'className' => 'Api.FriendRequest'
        ]);
        
        $this->hasMany('FriendRequest', [
            'foreignKey' => 'requested_by',
            'targetForeignKey'=>'requested_to',
            'joinType' => 'INNER',
            'className' => 'Api.FriendRequest'
        ]);
        
        $this->hasMany('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Api.Users'
        ]);
        $this->hasMany('Spaycs', [
            'foreignKey' => 'user_id',
            'className' => 'Api.Spaycs'
        ]);
        $this->hasMany('NotificationTo', [
            'foreignKey' => 'requested_to',
            'className' => 'Api.Notifications'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('username', 'create',__('Username is required field.'))
                ->notEmpty('username',__('Please enter a user name'))                
                ->maxLength('username', 30,__('User name cannot exceed to 30 characters.'))
                ->add('username', 'unique', ['rule' => 'validateUnique','message'=>__('Username already exist.'), 'provider' => 'table'])
                 ->add("username",'custom',[
                    'rule'=>function($value,$context){
                        return (bool)(preg_match('/^[\w\s\.\_\-\@\#]+$/', $value));
                    },
                    'message'=>__('Username is not valid.'),
                ]);
                
        $validator
                ->requirePresence('password', 'create',__('Password is required field.'))
                ->notEmpty('password',__('Password is required field.'))
                ->add("password",'custom',[
                    'rule'=>function($value,$context) {
                        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'message'=>__('Password must contain 8-30 character length, at least one letter and one number.'),
                ]);
        
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm password is required field.'))
                ->notEmpty('confirm_password', __('Confirm password is required field.'))
                ->sameAs('confirm_password', 'password',__('Passwords don\'t match, try again please!'));
        
        $validator
                ->requirePresence('email', 'create',__('Email is required field.'))
                ->notEmpty('email',__('Email is required field.'))
                ->email('email', false, __('Invalid email address.'))                
                ->add('email', 'unique', [
                    'rule' => function($value,$context){
                        if(!empty($value)){                            
                             return !$this->exists(['LOWER(email)'=> strtolower($value)]);
                        }else{
                            return false;
                        }
                    },
                    'message'=>__('Email already exist.')]) ;
        
        $validator
                ->notEmpty('country_code',__('Country code is required field.'),function($context){
                     return !empty($context['data']['phone']);
                })
                ->add('country_code', 'countrycode', [
                    'rule' => function($value,$context){
                         return (bool)(preg_match('/^([\+\s\(\)\-]*\d[\+\s\(\)\-]*){1,5}$/',$value));
                    },
                    'message'=>__('Country Code is not valid.')
                    ]);
                
        
        $validator
                ->allowEmpty('phone')                
                ->add('phone', 'valid', [
                    'rule' => function($value,$context){
                        return (bool)(preg_match('/^([\+\s\(\)\-]*\d[\+\s\(\)\-]*){3,15}$/',$value));
                    },
                    'message'=>__('Phone no is not valid.')
                    ]);

        $validator
                ->allowEmpty('dob')
                ->add('dob',[
                    'date' => [
                        'rule'=> ['date',['mdy']],
                        'last'=>true,
                        'message'=>__('Date of birth is not valid format.')
                        ]
                    ])
                ->add('dob','custom',[
                    'rule'=>function($value,$context){
                            $timezone = Configure::read('timezone');
                            $now = new Time('now',$timezone);
                            $dob = Time::createFromFormat('m-d-Y',$value,$timezone);
                            $age = $now->diff($dob)->format("%Y");                            
                            return ($age >= 13);
                        },
                    'message'=>__('ssAge must be 13 or greater than 13 year\'s old.'),
                ]); 
        $validator
            //->requirePresence('gender', 'create',__('Gender is required field.'))                
            //->notEmpty('gender',__('Gender is required field.'))
            ->allowEmpty('gender')        
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.'));      
        $validator
                //->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->allowEmpty('longitude')
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                //->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->allowEmpty('latitude')
                ->latitude('latitude',__('Please enter valid latitude.'));
        return $validator;
    }
    
    /**
     * Facebook Signup validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
    */
    public function validationFacebookSignup(Validator $validator) {
        
        $validator
            ->requirePresence('fb_id', true, __('Facebook id is required field.'))
            ->notEmpty('fb_id',__('Facebook id is required field.'));
        $validator
            ->requirePresence('fb_access_key', true, __('Facebook access key is required field.'))
            ->notEmpty('fb_access_key',__('Facebook access key is required field.'));
        
        $validator
                ->requirePresence('username', true, __('Username is required field.'))
                ->notEmpty('username',__('Username is required field.'))                
                ->maxLength('username', 30,__('Username cannot exceed to 30 characters.'))
                ->add('username', 'unique', ['rule' => 'validateUnique','message'=>__('Username already exist.'), 'provider' => 'table'])
                 ->add("username",'custom',[
                    'rule'=>function($value,$context){
                        return (bool)(preg_match('/^[\w\s\.\_\-\@\#]+$/', $value));
                    },
                    'message'=>__('Username is not valid.'),
                ]);
        
        $validator
                ->email('email',false,__('Email is required field.'))
                //->requirePresence('email', true, __('Email is required field.'))
                ->email('email', false, __('Invalid email address.'))
                //->add('email', 'unique', ['rule' => 'validateUnique','message'=>'Email has been used.', 'provider' => 'table']) 
                ->allowEmpty('email');
        
        $validator
            ->allowEmpty('dob')
            ->add('dob',[
                'date' => [
                    'rule'=> ['date',['mdy']],
                    'last'=>true,
                    'message'=>__('Date of birth is not valid format.')
                    ]
                ])
            ->add('dob','custom',[
                'rule'=>function($value,$context){
                        $timezone = Configure::read('timezone');
                        $now = new Time('now',$timezone);
                        $dob = Time::createFromFormat('m-d-Y',$value,$timezone);
                        $age = $now->diff($dob)->format("%Y");
                        return ($age >= 13);                        
                    },
                'message'=>__('Age must be 13 or greater than 13 year\'s old.'),
            ]);
                
        $validator
            //->requirePresence('gender', true, __('Gender is required field.'))    
            //->notEmpty('gender',__('Gender is required field.'))
            ->allowEmpty('gender')    
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.')           );
        
        $validator
            ->allowEmpty('phone')                
            ->add('phone', 'valid', [
                'rule' => function($value,$context){
                    return (bool)(preg_match('/^([\+\s\(\)\-]*\d[\+\s\(\)\-]*){3,15}$/',$value));
                },
                'message'=>__('Phone no is not valid.')
                ]);
        $validator
                ->requirePresence('device_id', true, __('Device id is required field.'))
                ->notEmpty('device_id', __('Please enter a device id.'))
                ->maxLength('device_id', 100,__('Device id cannot exceed to 100 characters.'));
        $validator
                //->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->allowEmpty('longitude')
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                //->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->allowEmpty('latitude')
                ->latitude('latitude',__('Please enter valid latitude.'));
        return $validator;
    }
    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUpdateUser(Validator $validator) {
        
        $validator
            ->requirePresence('username', 'create',__('Username is required field.'))
            ->notEmpty('username',__('Username is required field.'))                
            ->maxLength('username', 30,__('Username cannot exceed to 30 characters.'))
            ->add('username', 'unique', ['rule' => 'validateUnique','message'=>__('Username already exist.'), 'provider' => 'table'])
             ->add("username",'custom',[
                'rule'=>function($value,$context){
                    return (bool)(preg_match('/^[\w\s\.-@#]+$/', $value));
                },
                'message'=>__('Username is not valid.'),
            ]);
        
        $validator
            ->allowEmpty('phone')                
            ->add('phone', 'valid', [
                'rule' => function($value,$context){
                    return (bool)(preg_match('/^([\+\s\(\)\-]*\d[\+\s\(\)\-]*){3,15}$/',$value));
                },
                'message'=>__('Phone no is not valid.')
                ]);

        $validator
            ->allowEmpty('dob')
            ->add('dob',[
                'date' => [
                    'rule'=> ['date',['mdy']],
                    'last'=>true,
                    'message'=>__('Date of birth is not valid format.')
                    ]
                ])
            ->add('dob','custom',[
                'rule'=>function($value,$context){
                        $timezone = Configure::read('timezone');
                        $now = new Time('now',$timezone);
                        $dob = Time::createFromFormat('m-d-Y',$value,$timezone);
                        $age = $now->diff($dob)->format("%Y");
                        return ($age >= 13);                        
                    },
                'message'=>__('Age must be 13 or greater than 13 year\'s old.'),
            ]);

        $validator
            //->requirePresence('gender', 'create',__('Gender is required field.'))    
            //->notEmpty('gender',__('Gender is required field.'))
            ->allowEmpty('gender')      
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.'));
        $validator
                //->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->allowEmpty('longitude')
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                //->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->allowEmpty('latitude')
                ->latitude('latitude',__('Please enter valid latitude.'));
        
        return $validator;
    }
    /**
     * friendRequestValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function friendRequestValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend request is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('friend_requested_status'),__('Friend status must be any one '.implode(',',Configure::read('friend_requested_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * addFriendValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function addFriendValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend request is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('add_friend'),__('Friend status must be '.implode(',',Configure::read('add_friend')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * requestAcceptDeclinedValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function requestAcceptDeclinedValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend id is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('accept_decline_status'),__('Friend status must be any one '.implode(',',Configure::read('accept_decline_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * requestBlockedValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function requestBlockedValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend id is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('block_status'),__('Friend status must be '.implode(',',Configure::read('block_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * requestUnblockedValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function requestUnblockedValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend id is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('unblock_status'),__('Friend status must be '.implode(',',Configure::read('unblock_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * requestUnfriendValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function requestUnfriendValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend id is required field.'))
            ->notEmpty('friend_id',__('Friend request is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('unfriend_status'),__('Friend status must be '.implode(',',Configure::read('unfriend_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * friendRequestResponseValidate rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function friendRequestResponseValidate($data) {
        $validator = new Validator();        
        $validator
            ->requirePresence('friend_id', 'create',__('Friend request id is required field.'))
            ->notEmpty('friend_id',__('Friend request id is required field.'));
        
        $validator
            ->requirePresence('friend_status', 'create',__('Status is required field.'))    
            ->notEmpty('friend_status',__('Status is required field.'))
            ->inList('friend_status', Configure::read('friend_requested_status'),__('Friend status must be any one '.implode(',',Configure::read('friend_requested_status')).'.'));
        return $validator->errors($data);
    }
    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangePassword($data,$userId = null) {
        $validator = new Validator();
        $validator
                ->requirePresence('old_password', 'create',__('Previous password is required field.'))
                ->notEmpty('old_password',__('Previous password is required field.'))
                ->add('old_password','custom', [
                    'rule'=>function($value, $context) use($userId) {
                        $password = $this->get($userId, ['fields'=>'password']);
                        if (!ApiHasher::check($value, $password['password'])) {
                            return false;
                        }
                        return true;
                    },
                    'message'=>__('Previous password is not correct.'),
                ]);
        
        $validator
                ->requirePresence('new_password', 'create',__('New password is required field.'))
                ->notEmpty('new_password',__('New password is required field.'))
                ->add("new_password",'passwordrule',[
                    'rule'=>function($value,$context) {
                        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message'=>__('New password must contain 8-30 character length and at least one letter and one number.'),
                ])
                ->add('new_password', 'custom', [
                    'rule' => function($value, $context) {
                        if ($value === $context['data']['old_password']) {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'New password and previous password couldn\'t be same.']);
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm password is required field.'))
                ->notEmpty('confirm_password', __('Confirm password is required field.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password must be matched.'));
        return $validator->errors($data);
    }
    /**
     * validationResetPassword validation rules.
     *
     * @param Array $data input data
     * @return \Cake\Validation\Validator
     */
    public function validationResetPassword($data) {
        $validator = new Validator();
        $validator
                ->requirePresence('new_password', 'create',__('New password is required field.'))
                ->notEmpty('new_password',__('New password is required field.'))
                ->add("new_password",'passwordrule',[
                    'rule'=>function($value,$context) {
                        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message'=>__('New password must contain 8-30 character length and at least one letter and one number.'),
                ]);
                
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm password is required field.'))
                ->notEmpty('confirm_password', __('Confirm password is required field.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password must be matched.'));
        return $validator->errors($data);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        //$rules->add($rules->isUnique(['email'], 'Email has already been used.'));
        //$rules->add($rules->isUnique(['username'], 'Username has already been used.'));
        return $rules;
    }
    
    /**
     * usrLog to manage user login details from user logs table
     * 
     * @param Array $user user details
     * 
     * @return Bool 
     */
    public function usrLog($user = []){
        if(empty($user)){
            return false;
        }
        $plain_token = \Api\Utils\Utils::getToken();
        $hasher = new DefaultPasswordHasher();
        $userLogs = TableRegistry::get('Api.UserLogs');
        $userLogs->deleteAll(['user_id'=>$user['id']]);
        $logItems = $userLogs->newEntity();        
        $logItems->user_id = $user['id'];
        $logItems->last_login = Time::now();
        $logItems->token = $hasher->hash($plain_token);
        $logItems->plain_token = $plain_token;
        $logItems->device_id = $user['device_id'];
        $logItems->matrix_access_token = $user['matrix_access_token'];
        $logItems->matrix_user_id = $user['matrix_user_id'];
        $logItems->login_status = 1;
        $logItems->created = Time::now();
        $logItems->modified = Time::now();
        if ($userLogs->save($logItems,['checkRules'=>false,'atomic'=>false])) {
            return $user+['token'=>$plain_token];
        }else{
            return false;
        }
    }
    
    public function searchUsers($userId = null, $request = []) {
        $blockedFriendIds = TableRegistry::get('Api.FriendRequest')->getFriendIdsByStatus($userId, 'Blocked');
        $cond['Users.status'] = 'Active';
        if(!empty($blockedFriendIds)) {
            $cond['Users.id NOT IN'] = $blockedFriendIds;
        } else {
            $cond['Users.id !='] = $userId;
        }
        $users = $this->find('all', ['fields'=>['Users.id', 'Users.username','Users.display_name', 'Users.email', 'Users.matrix_user_id']])->where($cond);
        $users->contain([
            /*
            'JoinedSpayc'=>function($q) {
                return $q->select(['JoinedSpayc.user_id', 'joined_spaycs'=>$q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.user_id']);
            },
            'Spaycs'=>function($q) {
                return $q->select(['Spaycs.user_id', 'created_spaycs'=>$q->func()->count('Spaycs.id')])->group(['Spaycs.user_id']);
            },*/
            'Requestedby' => function($q) use($userId) {
                return $q->select(['Requestedby.id', 'Requestedby.requested_by', 'Requestedby.requested_to', 'Requestedby.requested_status', 'Requestedby.matrix_room_id'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]]]);
            },
            'Requestedto' => function($q) use($userId) {
                return $q->select(['Requestedto.id', 'Requestedto.requested_by', 'Requestedto.requested_to', 'Requestedto.requested_status', 'Requestedto.matrix_room_id'])->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]]]);
            },
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            }
            
        ]);
        $users->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $uId = ApiHasher::decrypt($row->id);
                $row['friend'] = !empty($row['requestedto'][0])? $row['requestedto'][0] : [];
                $row['friend'] = !empty($row['requestedby'][0]) && empty($row['friend'])?$row['requestedby'][0]:$row['friend'];
                $row['matrix_room_id'] = !empty($row['friend']['matrix_room_id'])?$row['friend']['matrix_room_id']:null;
                unset($row['friend']['matrix_room_id']);
                $row['friend']['total_friends'] = TableRegistry::get('Api.FriendRequest')->getFriendCountByUserId($uId);
                $row['image_url'] = !empty($row['user_images'][0]['image_url'])?$row['user_images'][0]['image_url']:'';
                unset($row['user_images']);
                unset($row['requestedto']);
                unset($row['requestedby']);
                return $row;
            });
        });
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $users->order(['Users.username'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $users->where(['LOWER(Users.username) LIKE'=>"%".strtolower($request['keyword'])."%"]);
        }
        $page = (!empty($request['page']) && is_numeric($request['page']))?$request['page']:1;
        if($page < 0) {
            $page = $page*-1;
            $users->page($page);
        } else {
            $users->page($page);
        }
        $data['count'] = $users->count();
        $data['records'] = [];
        if($users->count()) {
            $data['records'] = $users->toArray();
        }
        return $data;
    }
    public function validateLatLong($data){
        $validator = new Validator();
        $validator->requirePresence('latitude', true,__('Latitude key is missing.'))
                ->notEmpty('latitude', __('Please enter latitude.'))
                ->latitude('latitude', __('Latitude is not valid.'));
        $validator->requirePresence('longitude', true,__('Longitude key is missing.'))
                ->notEmpty('longitude', __('Please enter longitude.'))
                ->longitude('longitude', __('Longitude is not valid.'));
        return $validator->errors($data);
    }
    public function ValidatechangeRole($data){
        $validator = new Validator();
        $validator->requirePresence('spayc_id', true,__('Warp id key is missing.'))
                ->notEmpty('spayc_id', __('Please enter warp id.'));
        $validator->requirePresence('user_id', true,__('User id key is missing.'))
                ->notEmpty('user_id', __('Please enter User id.'));
        $validator->requirePresence('user_id', true,__('User id key is missing.'))
                ->notEmpty('user_id', __('Please enter User id.'));
        $validator->requirePresence('role', true,__('Role key is missing.'))
                ->notEmpty('role', __('Please enter role.'))
                ->inList('role', [0,1],__('Role must be either o or 1.'));
        return $validator->errors($data);
    }
    
    public function findJoinedSpayc($userid){
        $joinedSpayc = TableRegistry::get('Api.JoinedSpayc')->find()
                ->contain('Spaycs')
                ->where(['JoinedSpayc.status'=>'Joined','JoinedSpayc.user_id'=>$userid,'Spaycs.parent_id IS'=>null]);
        if($joinedSpayc->isEmpty()){
            return [];
        }else{
            return $joinedSpayc->toArray();
        }
    }
    
    /**
     * pusherNotification method to manage the chat data
     * 
     * @param Array $data array of object containing pusher data
     * @return Array|false either array containig push data or false
     */
    public function pusherNotification($data = [],$comment=false){
        if(empty($data['notification']['devices'])) { 
            \Cake\Log\Log::info(__('Device token is not available.'));
            return false;
        }
        
        $items = ['message'=>'','event_id'=>''];
        if(!empty($data['notification']['content']['eventId'])){
            $items['event_id'] = $data['notification']['content']['eventId'];
        }elseif(!empty($data['notification']['event_id'])){
            $items['event_id'] = $data['notification']['event_id'];
        }
        $spayc  = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($data['notification']['room_id'])->first();
        
        //\Cake\Log\Log::info($data);
        $msgType = $data['notification']['content']['msgtype'];
        $items['spayc_image'] = null;
        if(!empty($spayc)){
            $items['spayc_image'] = $spayc->image;
        }
        $items['matrix_room_id'] = $data['notification']['room_id'];
        
        if($msgType == 'm.likeMessage'){
            $notify = $this->storeMsg('a-user-liked-your-comment', $data['notification']['sender_display_name'], $data['notification']['content']['body']);          
             $notify->message = str_replace(["<USERNAME>","<COMMENT>"], [ucwords($data['notification']['sender_display_name']),$data['notification']['content']['body']], $notify->message);;
        }elseif($msgType == 'm.replyText'){
            $notify = $this->storeMsg('someone-replyed-to-your-comment', $data['notification']['sender_display_name'], $data['notification']['content']['body']);
            $notify->message = str_replace(["<USERNAME>","<COMMENT>"], [ucwords($data['notification']['sender_display_name']),$data['notification']['content']['body']], $notify->message);;
        }else{
            $notify = $this->storeMsg('someone-commented', $data['notification']['sender_display_name'], $data['notification']['content']['body']);
            if(strstr($data['notification']['room_name'],'#direct')){
                $notify->message = str_replace(["<USERNAME>","<COMMENT>","in your warp, <SpaycName>"],[ucwords($data['notification']['sender_display_name']),$data['notification']['content']['body'],""], $notify->message);
            }else{
                $notify->message = str_replace(["<USERNAME>","<COMMENT>","<SpaycName>"],[ucwords($data['notification']['sender_display_name']),$data['notification']['content']['body'],ucwords($data['notification']['room_name'])], $notify->message);
            }            
        }
        $items['message']  = $notify->message;
        $items['notification_type'] = $notify->type; 
        $items['spayc_id'] = $spayc->id;
        TableRegistry::get('Api.Comments')->spaycActivities($spayc->id,$items);
        return $items;
    }
    
    public function storeMsg($slug,$username,$body){
        if (($notify = \Cake\Cache\Cache::read($slug,'long')) === false) {
            $notify = TableRegistry::get('Api.Notifications')->message($slug);
            \Cake\Cache\Cache::write($slug, $notify,'long');
        }
       
        return $notify;
    }
    
    public function pusherData($data){
        $pushData['post_value'] = json_encode($data);
        $pushData['created'] = date("Y-m-d H:i:s");
        $pusher = TableRegistry::get("Api.PusherData");
        $push = $pusher->newEntity();
        $item = $pusher->patchEntity($push, $pushData);
        return $pusher->save($item);
    }
    
}
