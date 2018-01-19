<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
        $this->belongsTo('RequestedBy', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        $this->belongsTo('RequestedTo', [
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
            ->requirePresence('requested_to', 'create')
            ->notEmpty('requested_to');

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
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));

        return $rules;
    }
}
