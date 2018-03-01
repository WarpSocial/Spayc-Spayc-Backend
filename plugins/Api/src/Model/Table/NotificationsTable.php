<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Notifications Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Notification newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Notification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Notification findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotificationsTable extends Table
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

        $this->setTable('notifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('NotificationTo', [
            'foreignKey' => 'requested_to',
            'className' => 'Api.Users'
        ]);
        $this->belongsTo('NotificationBy', [
            'foreignKey' => 'requested_by',
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('requested_by', 'create')
            ->notEmpty('requested_by');

        $validator
            ->requirePresence('requested_to', 'create')
            ->notEmpty('requested_to');

        $validator
            ->scalar('notification_type')
            ->maxLength('notification_type', 20)
            ->allowEmpty('notification_type');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->allowEmpty('status');

        $validator
            ->scalar('message')
            ->maxLength('message', 200)
            ->allowEmpty('message');

        $validator
            ->dateTime('date_time')
            ->allowEmpty('date_time');

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
        //$rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));

        return $rules;
    }
}
