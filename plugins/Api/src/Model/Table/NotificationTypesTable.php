<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotificationTypes Model
 *
 * @method \Api\Model\Entity\NotificationType get($primaryKey, $options = [])
 * @method \Api\Model\Entity\NotificationType newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\NotificationType[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\NotificationType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\NotificationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\NotificationType[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\NotificationType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotificationTypesTable extends Table
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

        $this->setTable('notification_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'created']);

        $this->addBehavior('Timestamp');
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
            ->scalar('type')
            ->maxLength('type', 200)
            ->allowEmpty('type');

        $validator
            ->scalar('message')
            ->allowEmpty('message');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 200)
            ->allowEmpty('slug');

        return $validator;
    }
}
