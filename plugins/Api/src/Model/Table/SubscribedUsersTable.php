<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubscribedUsers Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\SubscribedUser get($primaryKey, $options = [])
 * @method \Api\Model\Entity\SubscribedUser newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\SubscribedUser[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\SubscribedUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\SubscribedUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\SubscribedUser[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\SubscribedUser findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubscribedUsersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('subscribed_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
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
                ->integer('user_id')
                ->requirePresence('user_id', 'create')
                ->notEmpty('user_id');

        $validator
                ->scalar('status')
                ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
    
    public function removeSubscription($userId=null,$spaycId){
        if(is_null($userId) || is_null($spaycId)){
            return false;
        }
        return $this->deleteAll(['spayc_id' => $spaycId,'user_id'=>$userId]);
    }
    
    public function isSubscribed($userId,$status='Active'){
        if(empty($userId)){
            return false;
        }
        return $this->exists(['user_id'=>$userId,'status'=>$status]);
    }
    
    /**
     * subscribedSpayc to give the list of spayc whom user subscribed
     * 
     * @param integer $userId get user subscribed user
     * @return Object array of object of spayc list
     */
    public function subscribedSpayc($userId = null,$status = null,$page = null,$limit =null){
        if(empty($userId)){
            return [];
        }
        $query = $this->Spaycs->find();
        $query->select(['Spaycs.id', 'Spaycs.matrix_room_id'])
                ->where(['Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private']);
        $query->innerJoinWith('SubscribedUsers',function($q)use($userId,$status) {
            if(!empty($status)){
                $q->where(['SubscribedUsers.status'=>$status]);
            }
            $q->where(['SubscribedUsers.user_id'=>$userId]);
            return $q;
        });
        $query->order(['Spaycs.created'=>'DESC']);
        if(!empty($limit)){
            $query->limit($limit);
        }
        
        if(!empty($page)){
            $query->page($page);
        }
        
        return $query;
    }

}
