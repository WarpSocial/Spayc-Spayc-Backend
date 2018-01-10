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
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('username', 'create','Username is required field.')
                ->notEmpty('username','Please enter a user name')                
                ->maxLength('username', 30,__('User name cannot exceed to 30 characters.'))
                ->add('username', 'unique', ['rule' => 'validateUnique','message'=>__('User name already exist.'), 'provider' => 'table'])
                 ->add("username",'custom',[
                    'rule'=>function($value,$context){
                        return (bool)(preg_match('/^[\w\s\.-@#]+$/', $value));
                    },
                    'message'=>__('Username is not valid.'),
                ]);;
                
        
        $validator
                ->requirePresence('device_id', __('create','Device id is required field.'))
                ->notEmpty('device_id',__('Please enter a device id.'))
                ->maxLength('username', 30,__('Device id cannot exceed to 30 characters.'));
                
        $validator
                ->requirePresence('password', 'create',__('Password key is missing.'))
                ->notEmpty('password',__('Please enter password.'))
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
                ->requirePresence('confirm_password', 'create', __('Confirm password key is missing.'))
                ->notEmpty('confirm_password', __('Please enter confirm password.'))
                ->sameAs('confirm_password', 'password',__('Passwords don\'t match, try again please!'));
        
        $validator
                ->requirePresence('email', 'create',__('Email key is missing.'))
                ->notEmpty('email',__('Pease enter a email.'))
                ->email('email',false,__('Email is not valid.'))                
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
                        'message'=>'Date of birth is not valid format.'
                        ]
                    ])
                ->add('dob','custom',[
                    'rule'=>function($value,$context){
                            $now = new Time('now');
                            $dob = Time::createFromFormat('m-d-Y',$value);
                            $age = $now->diff($dob)->format("%Y");
                            return ($age > 13);
                        },
                    'message'=>'Age must be 13 or greater than 13 year\'s old.',
                ]); 
        $validator
            ->requirePresence('gender', 'create',__('Gender key is missing.'))    
            ->notEmpty('gender',__('Please enter gender.'))
            ->inList('gender', Configure::read('gender'),__('Gender must be any one '.implode(',',Configure::read('gender')).'.'));      

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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('fb_id')
            ->requirePresence('fb_id', 'create','Facebook id is required field.')
            ->notEmpty('fb_id','Facebook id is required field.');
        
        $validator
                ->requirePresence('username', 'create','Username is required field.')
                ->notEmpty('username','Username  is required field.')                
                ->add('username', 'unique', ['rule' => 'validateUnique','message'=>'Username has been used.', 'provider' => 'table'])                
                ->add('username', [
                    'lengthBetween' => [
                        'rule' => ['lengthBetween', 3, 30],
                        'message' => 'Username length must be between 3-30 alphanumeric.'
                    ]
                ]);
        
        $validator
            ->allowEmpty('email')
            ->email('email',false,'Email is required field.')
            ->requirePresence('email', 'create','Email is required field.');
            //->add('email', 'unique', ['rule' => 'validateUnique','message'=>'Email has been used.', 'provider' => 'table']) 
            //->notEmpty('email','Email is required field.');
        $validator
            ->allowEmpty('password')
            ->add("password",'custom',[
                'rule'=>function($value,$context) {
                    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                        return false;
                    }else{
                        return true;
                    }
                },
                'message'=>'Password must contain 8-30 character length, at least one letter and one number.',
            ]);
        $validator
            ->allowEmpty('dob')
            ->add('dob',[
                'date' => [
                    'rule'=> ['date',['ymd']],
                    'last'=>true,
                    'message'=>'Date of birth is not valid format.'
                    ]
                ])
            ->add('dob','custom',[
                'rule'=>function($value,$context){
                        $today = new Time('now');
                        $udob = Time::createFromFormat('Y-m-d',$value);
                        return ($udob<$today);
                    },
                'message'=>'Date of birth must be below the current date.',
            ]);
                    
        $validator
            ->requirePresence('device_id', 'create','Device id is required field.')
            ->notEmpty('device_id','Device id is required field.')                
            ->add('device_id', 'unique', ['rule' => 'validateUnique','message'=>'Device id has been used.', 'provider' => 'table']);
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
                ->requirePresence('username', 'Username is required field.')
                ->notEmpty('username','Username  is required field.')                
                ->add('username', 'unique', ['rule' => 'validateUnique','message'=>'Username has been used.', 'provider' => 'table'])                
                ->add('username', [
                    'lengthBetween' => [
                        'rule' => ['lengthBetween', 3, 30],
                        'message' => 'Username length must be between 3-30 alphanumeric.'
                    ]
                ]);
        
        $validator
                ->allowEmpty('phone')
                ->add('phone', 'valid', [
                    'rule' => function($value,$context){
                        if(preg_match('/[\d]{16}$/',$value)){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'message'=>'Phone no is not valid'
                    ]);

        $validator
                ->allowEmpty('dob')
                ->add('dob',[
                    'date' => [
                        'rule'=> ['date',['ymd']],
                        'last'=>true,
                        'message'=>'Date of birth is not valid format.'
                        ]
                    ])
                ->add('dob','custom',[
                    'rule'=>function($value,$context){
                            $now = new Time('now');
                            $dob = Time::createFromFormat('Y-m-d',$value);
                            $age = $now->diff($dob)->format("%Y");
                            return ($age > 13);
                        },
                    'message'=>'Age must be 13 or greater than 13 year\'s old.',
                ]); 
        $validator
            ->notEmpty('gender', "Gender is required field.")
            ->add('gender', 'custom', [
                        'rule' => function ($value, $context){
                          return in_array($value, \Cake\Core\Configure::read('gender'));
                        },
                        'message' => 'Gender value must be any one male,female or other only.'
                    ]);                

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
        $logItems->matrix_access_token = $user['access_token'];
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
    
    public function getAlreadyExistsUser($data = []) {
        if(!empty($data['email'])) {
            $user = $this->find("all", ['conditions'=>['email'=>$data['email']]]);
            if($user->count()) {
                return $user->first()->toArray();
            }
        }
        if(!empty($data['fb_id'])) {
            $user = $this->find("all", ['conditions'=>['fb_id'=>$data['fb_id']]]);
            if($user->count()) {
                return $user->first()->toArray();
            }
        }
        return false;
    }
    
    public function uploadImages($oldEntity, $files) {
        $entity = [];
        if(!empty($files)) { 
            $ids = [];
            if(!empty($oldEntity['user_images'])) {
                foreach($oldEntity['user_images'] as $profile) {
                    if(!empty($profile['image_url']) and file_exists(WWW_ROOT.'img/profile/'.$profile['image_url'])) {
                        chmod(WWW_ROOT.'img/profile/'.$profile['image_url'], 0777);
                        unlink(WWW_ROOT.'img/profile/'.$profile['image_url']);
                        $ids[] = $profile['id']; 
                    }
                }
                if(!empty($oldEntity['user_images'][0]['user_id'])) {
                    TableRegistry::get('UserImages')->deleteAll(['user_id'=>$oldEntity['user_images'][0]['user_id']]);
                }
            }
            $uploadPath = WWW_ROOT.'img/profile/';
            foreach($files as $key=>$file) {
                if(!empty($file['tmp_name'])) {
                    $fileName = time().'-'.str_replace(' ', '-', $file['name']);
                    $uploadFile = $uploadPath.$fileName;
                    if(move_uploaded_file($file['tmp_name'], $uploadFile)){
                        $entity['user_id'] = $oldEntity['id'];
                        $entity['image_url'] = $fileName;
                        $entity['created'] = date('Y-m-d');
                        $entity['modified'] = date('Y-m-d'); //pr($entity);
                        $newEntity = TableRegistry::get('UserImages')->newEntity();
                        $item = TableRegistry::get('UserImages')->patchEntity($newEntity, $entity);
                        TableRegistry::get('UserImages')->save($item);
                    }
                }
            }
        }
        return $entity;
    }
}
