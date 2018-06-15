<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * JoinedSpayc Model
 *
 * @property \App\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\JoinedSpayc get($primaryKey, $options = [])
 * @method \App\Model\Entity\JoinedSpayc newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JoinedSpayc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JoinedSpayc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JoinedSpayc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JoinedSpayc[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JoinedSpayc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JoinedSpaycTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('joined_spayc');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Spaycs'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Users'
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

        return $rules;
    }

    public function getPhysicalPresentUsersIdBySpaycId($spaycId = null) {       

        $physicalPresentUsersIds = $this->find("all", ['fields' => ['id', 'user_id','distance'], 'conditions' => ['spayc_id' => $spaycId,'status'=>JOINED, 'distance <=' => Configure::read('miles')]]);
        if ($physicalPresentUsersIds->isEmpty()) {
            return false;
        }
        $ids = [];
        foreach ($physicalPresentUsersIds as $physicalPresentUsersId) {
            array_push($ids, $physicalPresentUsersId->user_id);
        }
        return $ids;
    }

    public function getTotalJoinedFriends($spaycId = null, $userIds = []) {
        return $this->find("all", ['fields' => ['id'], 'conditions' => ['spayc_id' => $spaycId, 'user_id IN' => $userIds,'status'=>JOINED]])->count();
    }

    public function getJoinedSpaycIds($userId = null) {
        $spaycId = $this->find("all", ['fields' => ['id', 'spayc_id'], 'conditions' => ['user_id' => $userId,'status'=>JOINED]]);
        $ids = [0];
        if ($spaycId->count()) {
            $spaycIds = $spaycId->toArray();
            $ids = \Cake\Utility\Hash::extract($spaycIds, '{n}.spayc_id');
        }
        return $ids;
    }
    
    public function getJoinedUserIds($spaycId = null) {
        $userId = $this->find("all", ['fields' => ['id', 'user_id'], 'conditions' => ['spayc_id' => $spaycId,'status'=>'Joined']]);
        $ids = [0];
        if ($userId->count()) {
            $userIds = $userId->toArray();
            $ids = \Cake\Utility\Hash::extract($userIds, '{n}.user_id');
        }
        return $ids;
    }
    public function getJoinedSpaycObj($spaycId = null, $userId = null) {
     $jsObj =$this->find()->where(['spayc_id'=>$spaycId, 'user_id'=>$userId])->first();
     return $jsObj;
    }
}
