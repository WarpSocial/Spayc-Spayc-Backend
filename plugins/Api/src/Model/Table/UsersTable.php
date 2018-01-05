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
        /*$this->addBehavior('ImgUpload', [
            'field' => ['image'],
            'uploadPath' => 'pages/',
            'where' => 's3', // local and s3 
        ]);*/

        $this->hasMany('UsersLogs', [
            'foreignKey' => 'user_id',
            'className' => 'Api.UsersLogs'
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
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->allowEmpty('first_name')
                ->add('first_name', 'length', ['rule' => ['maxLength', 30], 'message' => 'First name should be less than 30 chars.']);

        $validator
                ->allowEmpty('last_name')
                ->add('last_name', 'length', ['rule' => ['maxLength', 30], 'message' => 'Last name should be less than 30 chars.']);

        $validator
                ->requirePresence('user_name', 'create','Username is required field.')
                ->notEmpty('user_name','Username  is required field.')                
                ->add('user_name', 'unique', ['rule' => 'validateUnique','message'=>'Username has been used.', 'provider' => 'table'])                
                ->add('user_name', [
                    'lengthBetween' => [
                        'rule' => ['lengthBetween', 3, 30],
                        'message' => 'Username length must be between 3-30 alphanumeric.'
                    ]
                ]);
        $validator
                ->requirePresence('device_id', 'create','Device id is required field.')
                ->notEmpty('device_id','Device id is required field.')                
                ->add('device_id', 'unique', ['rule' => 'validateUnique','message'=>'Device id has been used.', 'provider' => 'table']);
                
        $validator
                ->requirePresence('password', 'create','Password is required field.')
                ->notEmpty('password','Password is required field.')
                ->add("password",'custom',[
                    'rule'=>function($value,$context){
                        if(preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}/', $value)){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'message'=>'Password must be between 4-8 charecters length.',
                ]);

        $validator
                ->email('email',false,'Email is required field.')
                ->requirePresence('email', 'create','Email is required field.')
                ->add('email', 'unique', ['rule' => 'validateUnique','message'=>'Email has been used.', 'provider' => 'table']) 
                ->notEmpty('email','Email is required field.');
        
        $validator
                ->allowEmpty('phone')
                ->requirePresence('phone', 'create','Phone must exist.')
                ->add('phone', 'valid', [
                    'rule' => function($value,$context){
                        if(preg_match('/[\d]{10}$/m/',$value)){
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
                            $today = new Time('now');
                            $udob = Time::createFromFormat('Y-m-d',$value);
                            return ($udob<$today);
                        },
                    'message'=>'Date of birth must be below the current date.',
                ]); 

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
            ->allowEmpty('first_name')
            ->add('first_name', 'length', ['rule' => ['maxLength', 30], 'message' => 'First name should be less than 30 chars.']);

        $validator
            ->allowEmpty('last_name')
            ->add('last_name', 'length', ['rule' => ['maxLength', 30], 'message' => 'Last name should be less than 30 chars.']);
        $validator
                ->requirePresence('user_name', 'create','Username is required field.')
                ->allowEmpty('user_name');
        $validator
            ->allowEmpty('email')
            ->email('email',false,'Email is required field.')
            ->requirePresence('email', 'create','Email is required field.');
            //->add('email', 'unique', ['rule' => 'validateUnique','message'=>'Email has been used.', 'provider' => 'table']) 
            //->notEmpty('email','Email is required field.');

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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        //$rules->add($rules->isUnique(['email'], 'Email has already been used.'));
        //$rules->add($rules->isUnique(['user_name'], 'Username has already been used.'));
        return $rules;
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
