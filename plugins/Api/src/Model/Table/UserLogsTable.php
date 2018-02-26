<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserLogs Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Api\Model\Table\DevicesTable|\Cake\ORM\Association\BelongsTo $Devices
 * @property \Api\Model\Table\MatrixUsersTable|\Cake\ORM\Association\BelongsTo $MatrixUsers
 *
 * @method \Api\Model\Entity\UserLog get($primaryKey, $options = [])
 * @method \Api\Model\Entity\UserLog newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\UserLog[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\UserLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\UserLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\UserLog[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\UserLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserLogsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('user_logs');
        $this->setDisplayField('id');
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
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->scalar('token')
                ->maxLength('token', 255)
                ->requirePresence('token', 'create')
                ->notEmpty('token');

        $validator
                ->scalar('plain_token')
                ->maxLength('plain_token', 255)
                ->requirePresence('plain_token', 'create')
                ->notEmpty('plain_token');

        $validator
                ->scalar('matrix_access_token')
                ->maxLength('matrix_access_token', 1000)
                ->requirePresence('matrix_access_token', 'create')
                ->notEmpty('matrix_access_token');

        $validator
                ->integer('login_status')
                ->requirePresence('login_status', 'create')
                ->notEmpty('login_status');

        $validator
                ->dateTime('last_login')
                ->requirePresence('last_login', 'create')
                ->notEmpty('last_login');

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
        $rules->add($rules->existsIn(['device_id'], 'Devices'));
        $rules->add($rules->existsIn(['matrix_user_id'], 'MatrixUsers'));

        return $rules;
    }

}
