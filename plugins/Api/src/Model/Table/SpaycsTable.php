<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Spaycs Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\Spayc get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Spayc newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Spayc[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Spayc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('spaycs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
                ->requirePresence('name', __('create','Name key is missing.'))
                ->notEmpty('name',__('Spayc name is required.'));

        $validator
                ->maxLength('location', 255,__('Location test to too long.'))
                ->requirePresence('location', 'create',__('Location key is missing.'))
                ->notEmpty('location',__('Location is required field.'));

        $validator
                ->scalar('type')
                ->allowEmpty('type');

        $validator
                ->scalar('group_type')
                ->allowEmpty('group_type');

        $validator
                ->dateTime('start_date')
                ->requirePresence('start_date', 'create')
                ->notEmpty('start_date');

        $validator
                ->dateTime('end_date')
                ->requirePresence('end_date', 'create')
                ->notEmpty('end_date');

        $validator
                ->scalar('passcode')
                ->maxLength('passcode', 30)
                ->requirePresence('passcode', 'create')
                ->notEmpty('passcode');

        $validator
                ->scalar('description')
                ->maxLength('description', 250)
                ->allowEmpty('description');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

}
