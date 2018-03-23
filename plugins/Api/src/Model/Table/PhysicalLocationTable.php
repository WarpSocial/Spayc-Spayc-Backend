<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PhysicalLocation Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\PhysicalLocation get($primaryKey, $options = [])
 * @method \Api\Model\Entity\PhysicalLocation newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\PhysicalLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PhysicalLocationTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('physical_location');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'user_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
    }

}
