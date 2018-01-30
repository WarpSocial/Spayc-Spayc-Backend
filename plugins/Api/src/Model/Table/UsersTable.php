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
                        return (bool)(preg_match('/^[\w\s\.-@#]+$/', $value));
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
                ->email('email',false,__('Email is required field.'))                
                ->add('email', 'unique', ['rule' => 'validateUnique','message'=>__('Email already exist.'), 'provider' => 'table']) ;
                
        
        $validator
                ->allowEmpty('phone')                
                ->add('phone', 'valid', [
                    'rule' => function($value,$context){
                        return (bool)(preg_match('/^[\d\s\+\(\)]{3,15}$/',$value));
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
                            $now = new Time('now');
                            $dob = Time::createFromFormat('m-d-Y',$value);
                            $age = $now->diff($dob)->format("%Y");
                            return ($age > 13);
                        },
                    'message'=>__('Age must be 13 or greater than 13 year\'s old.'),
                ]); 
        $validator
            ->requirePresence('gender', 'create',__('Gender is required field.'))    
            ->notEmpty('gender',__('Gender is required field.'))
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.'));      
        $validator
                ->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->notEmpty('longitude',__('Please enter longitude.'))
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                ->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->notEmpty('latitude',__('Please enter latitude.'))
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
                ->requirePresence('username', true, __('Username is required field.'))
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
                ->email('email',false,__('Email is required field.'))
                ->requirePresence('email', true, __('Email is required field.'))
                //->add('email', 'unique', ['rule' => 'validateUnique','message'=>'Email has been used.', 'provider' => 'table']) 
                ->notEmpty('email',__('Email is required field.'));
        
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
                        $now = new Time('now');
                        $dob = Time::createFromFormat('m-d-Y',$value);
                        $age = $now->diff($dob)->format("%Y");
                        return ($age > 13);
                    },
                'message'=>__('Age must be 13 or greater than 13 year\'s old.'),
            ]);
                
        $validator
            ->requirePresence('gender', true, __('Gender is required field.'))    
            ->notEmpty('gender',__('Gender is required field.'))
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.')           );
        
        $validator
            ->allowEmpty('phone')                
            ->add('phone', 'valid', [
                'rule' => function($value,$context){
                    return (bool)(preg_match('/^[\d\s\+\(\)]{3,15}$/',$value));
                },
                'message'=>__('Phone no is not valid.')
                ]);
        $validator
                ->requirePresence('device_id', true, __('Device id is required field.'))
                ->notEmpty('device_id', __('Please enter a device id.'))
                ->maxLength('device_id', 100,__('Device id cannot exceed to 100 characters.'));
        $validator
                ->requirePresence('longitude', true, __('Longitude key is missing.'))
                ->notEmpty('longitude',__('Please enter longitude.'))
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                ->requirePresence('latitude', true, __('Latitude key is missing.'))
                ->notEmpty('latitude',__('Please enter latitude.'))
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
                    return (bool)(preg_match('/^[\d\s\+\(\)]{3,15}$/',$value));
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
                        $now = new Time('now');
                        $dob = Time::createFromFormat('m-d-Y',$value);
                        $age = $now->diff($dob)->format("%Y");
                        return ($age > 13);
                    },
                'message'=>__('Age must be 13 or greater than 13 year\'s old.'),
            ]);

        $validator
            ->requirePresence('gender', 'create',__('Gender is required field.'))    
            ->notEmpty('gender',__('Gender is required field.'))
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.'));
        $validator
                ->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->allowEmpty('longitude')
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                ->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->allowEmpty('latitude')
                ->latitude('latitude',__('Please enter valid latitude.'));
        
        return $validator;
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
        $userLogs = TableRegistry::get('UserLogs');
        
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
        if ($userLogs->save($logItems)) {
            return $user+['token'=>$plain_token];
        }else{
            return false;
        }
    }
    
    public function searchUsers($userId = null, $request = []) {
        $users = $this->find('all', ['fields'=>['Users.id', 'name'=>'Users.username','Users.email','Users.gender','Users.phone','Users.dob','Users.status','Users.website_url','Users.address','Users.bio_data','Users.created','Users.modified']])->where(['Users.status'=>'Active']);
        $users->contain([
            'Requestedby' => function($q) use($userId) {
                return $q->select(['Requestedby.id', 'Requestedby.requested_by', 'Requestedby.requested_to', 'Requestedby.requested_status', 'Requestedby.friend_status'])->Where(['OR'=>['Requestedby.requested_by'=>$userId, 'Requestedby.requested_to'=>$userId]]);
            },
            'Requestedto' => function($q) use($userId) {
                return $q->select(['Requestedto.id', 'Requestedto.requested_by', 'Requestedto.requested_to', 'Requestedto.requested_status', 'Requestedto.friend_status'])->Where(['OR'=>['Requestedto.requested_by'=>$userId, 'Requestedto.requested_to'=>$userId]]);
            },
            'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url']);
            },
            'JoinedSpayc'=>function($q) {
                return $q->select(['JoinedSpayc.user_id', 'joined_spaycs'=>$q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.user_id']);
            },
            'Spaycs'=>function($q) {
                return $q->select(['Spaycs.user_id', 'created_spaycs'=>$q->func()->count('Spaycs.id')])->group(['Spaycs.user_id']);
            }
        ]);
        $users->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row['friend'] = !empty($row['requestedto'][0])? $row['requestedto'][0] : [];
                $row['friend'] = !empty($row['requestedby'][0]) && empty($row['friend'])?$row['requestedby'][0]:$row['friend'];
                $row['friend']['total_friends'] = TableRegistry::get('Api.FriendRequest')->getFriendCountByUserId($row->id);
                unset($row['requestedto']);
                unset($row['requestedby']);
                return $row;
            });
        });
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $users->order(['Users.username'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $users->where(['Users.username LIKE'=>"%".$request['keyword']."%"]);
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
}
