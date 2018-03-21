<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Api\Utils;
use Api\Auth\ApiHasher;


/**
 * Users Model
 *
 * @property \App\Model\Table\FbsTable|\Cake\ORM\Association\BelongsTo $Fbs
 * @property \App\Model\Table\MatrixUsersTable|\Cake\ORM\Association\BelongsTo $MatrixUsers
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserLogs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('UserImages', [
            'foreignKey' => 'user_id'           
        ]);
        $this->hasMany('JoinedSpayc', [
            'foreignKey' => 'user_id'            
        ]);
        $this->hasMany('SubscribedUsers', [
            'foreignKey' => 'user_id'
        ]);        
        $this->hasMany('Requestedby', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Requestedto', [
            'foreignKey' => 'requested_to',
            'joinType' => 'INNER'
        ]);        
        $this->hasMany('FriendRequest', [
            'foreignKey' => 'requested_by',
            'targetForeignKey'=>'requested_to',
            'joinType' => 'INNER'
        ]);        
        $this->hasMany('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Spaycs', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmpty('password');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 50)
            ->allowEmpty('gender');

        $validator
            ->date('dob')
            ->allowEmpty('dob');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmpty('phone');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('website_url')
            ->maxLength('website_url', 150)
            ->allowEmpty('website_url');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('bio_data')
            ->allowEmpty('bio_data');

        $validator
            ->scalar('fb_access_key')
            ->maxLength('fb_access_key', 1000)
            ->allowEmpty('fb_access_key');

        $validator
            ->numeric('longitude')
            ->allowEmpty('longitude');

        $validator
            ->numeric('latitude')
            ->allowEmpty('latitude');

        $validator
            ->scalar('timezone')
            ->maxLength('timezone', 100)
            ->allowEmpty('timezone');

        $validator
            ->scalar('matrix_access_token')
            ->maxLength('matrix_access_token', 1000)
            ->allowEmpty('matrix_access_token');

        $validator
            ->scalar('token_verification')
            ->maxLength('token_verification', 255)
            ->allowEmpty('token_verification');

        $validator
            ->scalar('forgot_password_token')
            ->maxLength('forgot_password_token', 255)
            ->allowEmpty('forgot_password_token');

        $validator
            ->dateTime('forgot_password_timestamp')
            ->allowEmpty('forgot_password_timestamp');

        $validator
            ->scalar('country_code')
            ->maxLength('country_code', 10)
            ->allowEmpty('country_code');

        $validator
            ->scalar('is_notify')
            ->maxLength('is_notify', 10)
            ->allowEmpty('is_notify');

        $validator
            ->numeric('current_latitude')
            ->allowEmpty('current_latitude');

        $validator
            ->numeric('current_longitude')
            ->allowEmpty('current_longitude');

        return $validator;
    }

    public function validationResetPassword(Validator $validator) {
        
        $validator
                ->requirePresence('new_password', 'create',__('New password is required field.'))
                ->notEmpty('new_password',__('New password is required field.'))
                ->add("new_password",'custom',[
                    'rule'=>function($value,$context) {
                        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message'=>__('New password must contain 8-30 character length, at least one letter and one number.'),
                ]);                
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm password is required field.'))
                ->notEmpty('confirm_password', __('Confirm password is required field.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password should be matched, try again please!'));
        
        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangePassword(Validator $validator, $userId = null) {
        
        $validator
                ->requirePresence('old_password', 'create',__('Old password is required field.'))
                ->notEmpty('old_password',__('Old password is required field.'))
                ->add('old_password','custom', [
                    'rule'=>function($value, $context) use($userId) {
                        $password = $this->get($userId, ['fields'=>'password']);
                        if (!ApiHasher::check($value, $password['password'])) {
                            return false;
                        }
                        return true;
                    },
                    'message'=>__('Old passwords don\'t match, try again please!'),
                ]);
        
        $validator
                ->requirePresence('new_password', 'create',__('New password is required field.'))
                ->notEmpty('new_password',__('New password is required field.'))
                ->add("new_password",'custom',[
                    'rule'=>function($value,$context) {
                        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value)){
                            return false;
                        } else {
                            return true;
                        }
                    },
                    'message'=>__('New password must contain 8-30 character length, at least one letter and one number.'),
                ])
                ->add('new_password', 'custom', [
                    'rule' => function($value, $context) {
                        if ($value === $context['data']['old_password']) {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'New password and old password should not be same, try again please!']);
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm password is required field.'))
                ->notEmpty('confirm_password', __('Confirm password is required field.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password should be matched, try again please!'));
        
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
