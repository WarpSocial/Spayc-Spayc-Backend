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
        $this->hasMany('Advertisement', [
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
                    'rule'=>[$this, '_getCustomPasswordRule'],
                    'message'=>__('New password must contain 8-30 character length, at least one letter and one number.'),
                ]);                
        $validator
                ->requirePresence('confirm_password', 'create', __('Please enter password.'))
                ->notEmpty('confirm_password', __('Please enter password.'))
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
                    'rule'=>[$this, '_getCustomPasswordRule'],
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

    public function _getCustomPasswordRule($value){        
        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}$/', $value))
           return false;
        else 
           return true;
    }

    public function getUsersList($userId) {

        $query=$this->find();
        if(!empty($userId)){
            $friends = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, FRIEND_REQUESTED_STATUS);
            $query->where(['Users.id IN'=> $friends]);
        }
        $query->where(['Users.role_id IS'=> null])
            ->contain([                                       
                'JoinedSpayc'=>function($q) {
                    $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);                  
                    $q->innerJoinWith('Spaycs',function($qq) {
                        $qq->select(['Spaycs.user_id','Spaycs.id','Spaycs.parent_id'])->where(['Spaycs.group_type !=' =>'trusted_private','Spaycs.parent_id IS'=>null]); 
                        return $qq;                        
                    });
                    return $q;
                },
                'Requestedby' => function($q) {
                   return $q->select(['Requestedby.requested_by','count' => $q->func()->count('Requestedby.id')])->group(['Requestedby.requested_by'])->Where(['Requestedby.requested_status'=>FRIEND_REQUESTED_STATUS]);
                },
                'Requestedto' => function($q) {
                   return $q->select(['Requestedto.requested_to','count' => $q->func()->count('Requestedto.id')])->group(['Requestedto.requested_to'])->Where(['Requestedto.requested_status'=>FRIEND_REQUESTED_STATUS]);
                },
                'Advertisement' => function($q) {
                   return $q->select(['Advertisement.user_id','count' => $q->func()->count('Advertisement.id')])->group(['Advertisement.user_id'])->where(["Advertisement.status !=" => ADVERTISEMENTSTATUS]);
                }
        ]); 
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->createdSpayc=$row->joinedSpayc=0;
                if(isset($row['joined_spayc']) && !empty($row['joined_spayc'])) {
                $joinedSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined]');
                $createdSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[is_admin=2,status=Joined]');
                $row->joinedSpayc=count($joinedSpayc);
                $row->createdSpayc=count($createdSpayc);
                unset($row['joined_spayc']);
                }               
                $row->friend = !empty($row['requestedto'][0]['count'])? $row['requestedto'][0]['count'] : BLANK_COUNT;
                $row->friend += !empty($row['requestedby'][0]['count'])? $row['requestedby'][0]['count'] : BLANK_COUNT;
                $row->userAdvertisement = !empty($row['advertisement'][0]['count'])? $row['advertisement'][0]['count'] : BLANK_COUNT;
                unset($row['requestedby']);
                unset($row['requestedto']);
                unset($row['advertisement']);
                return $row;
            });
        });
        return $query;
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
      
    public function getUserTokenScraper() {
        $obj = TableRegistry::get("Users")->find('all',
                ['fields' =>['user_logs.plain_token',]])
                ->join([
                            'table' => 'user_logs',
                            'type' => 'INNER',
                            'conditions' => [
                                'Users.id = user_logs.user_id',
                                'Users.email' => trim(SCRAPER_EMAIL),
                            ]])
                ->first();
        if(!empty($obj)){
            return $plain_token=$obj->user_logs['plain_token'];
        }else{
            return false;
        }
        
    }
}
