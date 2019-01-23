<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\RedisComponent;
use Cake\Collection\CollectionInterface;

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
class FriendRequestTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
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
            'targetForeignKey' => 'requested_to',
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
                ->integer('requested_by')
                ->requirePresence('requested_by', 'create')
                ->notEmpty('requested_by');

        $validator
                ->integer('requested_to')
                ->notEmpty('requested_to', __('Requested user id is required field.'))
                ->requirePresence('requested_to', 'create');

        $validator
                ->scalar('requested_status')
                ->allowEmpty('requested_status');


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
        $rules->add($rules->existsIn(['requested_by'], 'Users'));
        $rules->add($rules->existsIn(['requested_to'], 'Users'));
        return $rules;
    }

    public function getFriendIdsByUserId($userId = null, $status = 'Accepted') {
        $status = ucfirst($status);
        if ($status == 'Pending') {
            $cond = ['FriendRequest.requested_to' => $userId];
        } else if ($status == 'Blocked') {
            $cond = ['FriendRequest.action_by' => $userId];
        } else {
            $cond = ['OR' => ['FriendRequest.requested_by' => $userId, 'FriendRequest.requested_to' => $userId]];
        }
        if (in_array($status, Configure::read('friend_requested_status'))) {
            $cond['requested_status'] = $status;
            //$cond['friend_status IS'] = NULL;
        }
        /* if(in_array($status, Configure::read('friend_status'))) {
          $cond['friend_status'] = $status;
          } */

        $friends = $this->find('all', ['fields' => ['FriendRequest.requested_by', 'FriendRequest.requested_to'], 'conditions' => [$cond]]);
        if ($friends->isEmpty()) {
            return false;
        }

        $ids = [];
        foreach ($friends as $frnd) {
            if ($frnd->requested_by != $userId) {
                array_push($ids, $frnd->requested_by);
            }
            if ($frnd->requested_to != $userId) {
                array_push($ids, $frnd->requested_to);
            }
        }
        return $ids;
    }

    public function getFriendIdsRoomIdByUserId($userId = null, $status = 'Accepted') {
        $status = ucfirst($status);
        if ($status == 'Pending') {
            $cond = ['FriendRequest.requested_to' => $userId];
        } else if ($status == 'Blocked') {
            $cond = ['FriendRequest.action_by' => $userId];
        } else {
            $cond = ['OR' => ['FriendRequest.requested_by' => $userId, 'FriendRequest.requested_to' => $userId]];
        }
        if (in_array($status, Configure::read('friend_requested_status'))) {
            $cond['requested_status'] = $status;
            //$cond['friend_status IS'] = NULL;
        }
        /* if(in_array($status, Configure::read('friend_status'))) {
          $cond['friend_status'] = $status;
          } */

        $friends = $this->find('all', ['fields' => ['FriendRequest.requested_by', 'FriendRequest.requested_to', 'FriendRequest.matrix_room_id'], 'conditions' => [$cond]]);
        if ($friends->isEmpty()) {
            return false;
        }

        $ids = [];
        $room_ids = [];
        foreach ($friends as $frnd) {
            if ($frnd->requested_by != $userId) {
                array_push($ids, $frnd->requested_by);
                $room_ids[$frnd->requested_by] = $frnd->matrix_room_id;
            }
            if ($frnd->requested_to != $userId) {
                array_push($ids, $frnd->requested_to);
                $room_ids[$frnd->requested_to] = $frnd->matrix_room_id;
            }
        }
        $data['ids'] = $ids;
        $data['room_ids'] = $room_ids;
        return $data;
    }

    public function getFriendIdsByStatus($userId = null, $status = 'Blocked') {
        $status = ucfirst($status);
        $cond = ['OR' => ['FriendRequest.requested_by' => $userId, 'FriendRequest.requested_to' => $userId]];
        if (in_array($status, Configure::read('friend_requested_status'))) {
            $cond['requested_status'] = $status;
        }
        /* if(in_array($status, Configure::read('friend_status'))) {
          $cond['friend_status'] = $status;
          } */
        $friends = $this->find('all', ['fields' => ['FriendRequest.requested_by', 'FriendRequest.requested_to'], 'conditions' => [$cond]]);
        $friend = [];
        if ($friends->count()) {
            $friendIds = $friends->toArray();
            $friend = array_unique(array_merge(array_column($friendIds, 'requested_by'), array_column($friendIds, 'requested_to')));
        }
        return $friend;
    }

    public function getFriendCountByUserId($userId = null) {
        $friends = $this->find('all')
                ->select(['FriendRequest.id'])
                ->Where([
                ['OR' => ['requested_by' => $userId, 'requested_to' => $userId]],
                ['requested_status' => 'Accepted']]);
        return $friends->count();
    }

    public function updateRoomId($matrixId = null, $userId = null, $matrixRoomId = null) {
        if (!empty($matrixId)) {
            $user = TableRegistry::get('Api.Users')->findByMatrixUserId($matrixId)->select(['id']);
            if ($user->count()) {
                $inviteId = $user->first()->id;
                $friend = $this->find('all')
                        ->Where(['OR' => [['requested_by' => $userId, 'requested_to' => $inviteId], ['requested_by' => $inviteId, 'requested_to' => $userId]]]);
                $request['matrix_room_id'] = $matrixRoomId;
                if ($friend->count()) {
                    $entity = $friend->first();
                } else {
                    $request['requested_by'] = $userId;
                    $request['requested_to'] = $inviteId;
                    $request['requested_status'] = 'is_direct';
                    $entity = $this->newEntity();
                }
                $items = $this->patchEntity($entity, $request);
                $this->save($items);
            }
        }
    }

    public function myFriend($selfId, $frndId) {
        $friend = $this->find()
                ->select(['id', 'requested_by', 'requested_status', 'requested_to', 'matrix_room_id', 'action_by'])
                ->Where(['OR' => [
                    ['requested_by' => $selfId, 'requested_to' => $frndId],
                    ['requested_by' => $frndId, 'requested_to' => $selfId]
        ]]);
        if ($friend->isEmpty()) {
            return [];
        } else {
            return $friend->first();
        }
    }
    
    public function userFriend($selfId,$frndId){
        $friend = $this->find()
                ->select(['id','requested_by', 'requested_status', 'requested_to','matrix_room_id','action_by'])
                ->Where(['OR'=>[
                    ['requested_by' => $selfId,'requested_to'=>$frndId],
                    ['requested_by' => $frndId,'requested_to'=>$selfId]
                ],'requested_status'=>'Accepted']);
        if($friend->isEmpty()){
            return [];
        }else{
            return $friend->first();
        }
    }
    
    public function getNearByFriendsOnMap($request = [], $userId = null) {
        //Friend ID List     
        $all_id = $this->getFriendIdsRoomIdByUserId($userId);
        $friendIds = $all_id['ids'];
        $room_id = $all_id['room_ids'];
        if(empty($friendIds)){
            return ['count'=>0,'records'=>[]];
        }
        if (empty($request['radius'])) {
            $radius = $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']);
        } else {
            $radius = $request['radius'];
        }
        $redis = new RedisComponent(new ComponentRegistry());
        $nearUsers = $redis->getGeoLocation('Users',$request['center_latitude'], $request['center_longitude'], $radius);
        if(empty($nearUsers)){
            return ['count'=>0,'records'=>[]];
        }
        $friendIds = array_intersect($friendIds,array_column($nearUsers,'id'));
         if(empty($friendIds)){
            return ['count'=>0,'records'=>[]];
        }
        $friends = TableRegistry::get('Api.Users')->find()
                ->select(['Users.id', 'Users.display_name','Users.full_name', 'Users.email', 'Users.address', 'Users.modified'])
                ->contain([
                    'UserImages' => function($q) {
                        return $q->select(['UserImages.user_id', 'UserImages.image_url'])->where(['UserImages.is_profile' => 'Yes']);
                    }
                ])
                ->where(['Users.status'=>ACTIVE,'Users.ghost_mode_map'=>GHOST_MODE_OFF,'Users.id IN' =>$friendIds]);

        // Getting User image
        $friends->contain([
            'UserImages' => function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url'])->where(['UserImages.is_profile' => 'Yes']);
            }
        ]);
        $count = $friends->count();
        $friends->formatResults(function (CollectionInterface $results)use($nearUsers,$room_id) {
            return $results->map(function ($row)use($nearUsers,$room_id) {
                $row['image_url'] = !empty($row['user_images'][0]['image_url']) ? $row['user_images'][0]['image_url'] : '';
                $row->distance = $nearUsers[$row->id]['distance'];
                $row->latitude = $nearUsers[$row->id]['latitude'];
                $row->longitude = $nearUsers[$row->id]['longitude'];
                $row->matrix_room_id = $room_id[$row->id];
                unset($row['user_images']);
                return $row;
            });
        });
        return ['count'=>$count,'records'=>$friends];
    }

    public function distance($lat1, $lon1, $lat2, $lon2) {

        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 3959; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        //echo '<br/>'.$km;
        return $km;
    }
    
    /**
     * friendSubquery method to return the query of friend
     * 
     * @param Integer $userId
     * @return sql query
     */
    public function friendSubquery($userId){
        if(empty($userId)){
            return false;
        }
        $requestedTo = $this->find()->select('requested_to')->where(['requested_by'=>$userId,'requested_status'=>ACCEPTED]);
        $requestedBy = $this->find()->select('requested_by')->where(['requested_to'=>$userId,'requested_status'=>ACCEPTED]);
        $query = $requestedBy->union($requestedTo);
        return $query;
    }
    /**
     * friendStatus method to return the query of friend
     * 
     * @param Integer $userId
     * @return sql query
     */
    public function friendStatus($userId,$status = 'Accepted'){
        if(empty($userId)){
            return false;
        }
        return $this->exists(['requested_to' => $userId,'requested_status'=>$status]);
    }
    
    public function checkFriendRequestExist($loggedInUserId, $friendId) {
        $res = false;
        if(!empty($loggedInUserId) && $friendId) {
            $requestedFrnd = $this->find()->Where(['OR'=>[
                ['requested_by' => $loggedInUserId,'requested_to'=>$friendId],
                ['requested_by' => $friendId,'requested_to'=>$loggedInUserId]
                ]]);            
            if($requestedFrnd->count())
                $res = false;
            else 
                $res = true;
        }
        return $res;
    }
    
    public function addFbFirends($data) {
        if(!empty($data)){
            $friendRequest = $this->newEntity();
            $friendRequest->requested_by = $data['id'];
            $friendRequest->requested_to = $data['friendId'];
            $friendRequest->requested_status = SUGGESTED;
            $friendRequest->friend_status = SUGGESTED;
            $friendRequest->action_by = $data['id'];
            $this->save($friendRequest);
        }
    }

}
