<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WarpCategories Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \Api\Model\Table\SpaycCategoriesTable|\Cake\ORM\Association\BelongsTo $SpaycCategories
 *
 * @method \Api\Model\Entity\WarpCategory get($primaryKey, $options = [])
 * @method \Api\Model\Entity\WarpCategory newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\WarpCategory[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\WarpCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\WarpCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\WarpCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\WarpCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WarpCategoriesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('warp_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('SpaycCategories', [
            'foreignKey' => 'spayc_category_id',
            'joinType' => 'INNER',
            'className' => 'Api.SpaycCategories'
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
                ->allowEmpty('id', 'create');

        $validator
                ->boolean('is_primary')
                ->requirePresence('is_primary', 'create')
                ->notEmpty('is_primary');

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
        $rules->add($rules->existsIn(['spayc_category_id'], 'SpaycCategories'));

        return $rules;
    }

}
