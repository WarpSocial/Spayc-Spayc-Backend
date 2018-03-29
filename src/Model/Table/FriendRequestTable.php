<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;


/**
 * FriendRequest Model
 *
 * @property \App\Model\Table\MatrixRoomsTable|\Cake\ORM\Association\BelongsTo $MatrixRooms
 *
 * @method \App\Model\Entity\FriendRequest get($primaryKey, $options = [])
 * @method \App\Model\Entity\FriendRequest newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FriendRequest[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FriendRequest|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FriendRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FriendRequest[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FriendRequest findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'Spaycs'
        ]);
        $this->belongsTo('Requestedby', [
            'foreignKey' => 'requested_by',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        $this->belongsTo('Requestedto', [
            'foreignKey' => 'requested_to',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'requested_by',
            'targetForeignKey'=>'requested_to',
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

        /*$validator
            ->scalar('friend_status')
            ->allowEmpty('friend_status');*/

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
}
