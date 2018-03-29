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
            'joinType' => 'INNER',
            'className' => 'FriendRequest'
        ]);
        $this->hasMany('Requestedto', [
            'foreignKey' => 'requested_to',
            'joinType' => 'INNER',
            'className' => 'FriendRequest'
        ]);        
        $this->hasMany('FriendRequest', [
            'foreignKey' => 'requested_by',
            'targetForeignKey'=>'requested_to',
            'joinType' => 'INNER',
            'className' => 'FriendRequest'
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
    public function validationLogin($data) {
        $validator = new \Cake\Validation\Validator(); 
        $validator
                ->requirePresence('email', true, __('Please enter your email.'))
                ->notEmpty('email', __('Please enter your email.'))
                ->requirePresence('password', true, __('Please enter your password.'))
                ->notEmpty('password', __('Please enter your password.'));
        $error = $validator->errors($data);    
        return $error;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */   
    public function validationResetPassword($data) {
        $validator = new \Cake\Validation\Validator(); 
        $validator
                ->requirePresence('new_password', 'create',__('Please enter new password.'))
                ->notEmpty('new_password',__('Please enter new password.'))
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
                ->requirePresence('confirm_password', 'create', __('Confirm Please enter your password.'))
                ->notEmpty('confirm_password', __('Confirm Please enter your password.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password should be matched, try again please!'));
        
        $error = $validator->errors($data);    
        return $error;
    }
    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationChangePassword($data) {
        $validator = new \Cake\Validation\Validator();
        $validator
                ->requirePresence('old_password', 'create',__('Please enter your current password.'))
                ->notEmpty('old_password',__('Please enter your current password.'))
                ->add('old_password','custom', [
                    'rule'=>function($value, $context) use($data) {
                        $password = $this->get($data['userId'], ['fields'=>'password']);
                        if (!ApiHasher::check($value, $password['password'])) {
                            return false;
                        }
                        return true;
                    },
                    'message'=>__('Old passwords don\'t match, try again please!'),
                ]);
        
        $validator
                ->requirePresence('new_password', 'create',__('Please enter new password.'))
                ->notEmpty('new_password',__('Please enter new password.'))
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
                    'message' => 'New password and current password should not be same, try again please!']);
        $validator
                ->requirePresence('confirm_password', 'create', __('Confirm Please enter your password.'))
                ->notEmpty('confirm_password', __('Confirm Please enter your password.'))
                ->sameAs('confirm_password', 'new_password',__('New password and confirm password should be matched, try again please!'));
        
        $error = $validator->errors($data);    
        return $error;
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
