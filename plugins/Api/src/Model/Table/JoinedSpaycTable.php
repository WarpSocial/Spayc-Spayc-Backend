<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JoinedSpayc Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\JoinedSpayc get($primaryKey, $options = [])
 * @method \Api\Model\Entity\JoinedSpayc newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\JoinedSpayc[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\JoinedSpayc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\JoinedSpayc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\JoinedSpayc[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\JoinedSpayc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JoinedSpaycTable extends Table {

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

    public function getTotalJoinedFriends($spaycId = null, $userIds = []) {
        return $this->find("all", ['fields' => ['id'], 'conditions' => ['spayc_id' => $spaycId, 'user_id IN' => $userIds]])->count();
    }

    public function getJoinedSpaycIds($userId = null) {
        $spaycId = $this->find("all", ['fields' => ['id', 'spayc_id'], 'conditions' => ['user_id' => $userId]]);
        $ids = [0];
        if ($spaycId->count()) {
            $spaycIds = $spaycId->toArray();
            $ids = \Cake\Utility\Hash::extract($spaycIds, '{n}.spayc_id');
        }
        return $ids;
    }
    
    public function ValidateJoinSpayc($data){
        $validator = new Validator();
        $validator->requirePresence('spayc_id', true,__('Spayc id key is missing.'))
                ->notEmpty('spayc_id', __('Please enter Spayc id.'));
        $validator->requirePresence('user_id', true,__('User id key is missing.'))
                ->notEmpty('user_id', __('Please enter User id.'));
        $validator->requirePresence('user_id', true,__('User id key is missing.'))
                ->notEmpty('user_id', __('Please enter User id.'));
        $validator->requirePresence('status', true,__('status key is missing.'))
                ->notEmpty('status', __('Please enter role.'))
                ->inList('status', ['Joined',"Banned"],__('Role must be either Joined or Banned.'));
        return $validator->errors($data);
    }

}
