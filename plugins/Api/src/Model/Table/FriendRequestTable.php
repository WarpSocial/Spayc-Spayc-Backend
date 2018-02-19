<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * FriendRequest Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\FriendRequest get($primaryKey, $options = [])
 * @method \Api\Model\Entity\FriendRequest newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\FriendRequest[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\FriendRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\FriendRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\FriendRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\FriendRequest findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FriendRequestTable extends Table
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

        $this->setTable('friend_request');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('Requestedby', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        $this->belongsTo('Requestedto', [
            'foreignKey' => 'requested_to',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'requested_by',
            'targetForeignKey'=>'requested_to',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('requested_by')
            ->requirePresence('requested_by', 'create')
            ->notEmpty('requested_by');

        $validator
            ->integer('requested_to')
            ->notEmpty('requested_to',__('Requested user id is required field.'))
            ->requirePresence('requested_to', 'create');

        $validator
            ->scalar('requested_status')
            ->allowEmpty('requested_status');

        $validator
            ->scalar('friend_status')
            ->allowEmpty('friend_status');

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
        $rules->add($rules->existsIn(['requested_by'], 'Users'));
        $rules->add($rules->existsIn(['requested_to'], 'Users'));
        return $rules;
    }
    
    public function getFriendIdsByUserId($userId = null, $status = 'Accepted') {
        $status = ucfirst($status);
        if($status == 'Requested') {
            $cond = ['FriendRequest.requested_to'=>$userId];
        } else if($status == 'Blocked') {
            $cond = ['FriendRequest.blocked_by'=>$userId];
        } else {
            $cond = ['OR'=>['FriendRequest.requested_by'=>$userId, 'FriendRequest.requested_to'=>$userId]];
        }
        if(in_array($status, Configure::read('friend_requested_status'))) {
            $cond['requested_status'] = $status;
            $cond['friend_status IS'] = NULL;
        }
        if(in_array($status, Configure::read('friend_status'))) {
            $cond['friend_status'] = $status;
        }
        $friends = $this->find('all', ['fields'=>['FriendRequest.requested_by', 'FriendRequest.requested_to'], 'conditions'=>[$cond]]);
        $friend = [0];
        if($friends->count()) {
            $friendIds = $friends->toArray();
            $friend = array_unique(array_merge(array_column($friendIds,'requested_by'), array_column($friendIds,'requested_to'))); 
        }
        return $friend;
    }
    
    public function getFriendIdsByStatus($userId = null, $status = 'Blocked') {
        $status = ucfirst($status);
        $cond = ['OR'=>['FriendRequest.requested_by'=>$userId, 'FriendRequest.requested_to'=>$userId]];
        if(in_array($status, Configure::read('friend_requested_status'))) {
            $cond['requested_status'] = $status;
            $cond['friend_status IS'] = NULL;
        }
        if(in_array($status, Configure::read('friend_status'))) {
            $cond['friend_status'] = $status;
        }
        $friends = $this->find('all', ['fields'=>['FriendRequest.requested_by', 'FriendRequest.requested_to'], 'conditions'=>[$cond]]);
        $friend = [];
        if($friends->count()) {
            $friendIds = $friends->toArray();
            $friend = array_unique(array_merge(array_column($friendIds,'requested_by'), array_column($friendIds,'requested_to'))); 
        }
        return $friend;
    }
    
    public function getFriendCountByUserId($userId = null) {
        $friends = $this->find('all')
            ->select(['FriendRequest.id'])
            ->Where([['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId]], ['requested_status'=>'Accepted', 'friend_status IS'=>NULL]]);
        return $friends->count();
    }
    
    public function updateRoomId($matrixId = null, $userId = null, $matrixRoomId = null) {
        if(!empty($matrixId)) {
            $user = TableRegistry::get('Users')->findByMatrixUserId($matrixId)->select(['id']);
            if($user->count()) {
                $inviteId = $user->first()->id;
                $friend = $this->find('all')
                ->Where(['OR'=>[['requested_by'=>$userId, 'requested_to'=>$inviteId], ['requested_by'=>$inviteId, 'requested_to'=>$userId]]]);
                $request['matrix_room_id'] = $matrixRoomId;
                if($friend->count()) {
                    $entity = $friend->first();
                } else {
                    $request['requested_by'] = $userId;
                    $request['requested_to'] = $inviteId;
                    $request['requested_status'] = 'Anonymous';
                    $entity = $this->newEntity();
                }
                $items = $this->patchEntity($entity, $request);
                $this->save($items);
            }
        }
    }
}
