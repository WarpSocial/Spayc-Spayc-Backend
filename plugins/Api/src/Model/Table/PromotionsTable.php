<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Promotions Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\Promotion get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Promotion newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Promotion[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Promotion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Promotion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Promotion[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Promotion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PromotionsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('promotions');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');
        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Api.Users'
        ]);
        $this->hasOne('Purchase', [
            'foreignKey' => 'promotion_id',
            'className' => 'Api.Purchase'
        ]);
        $this->hasMany('SpaycPromotion', [
            'foreignKey' => 'promotion_id',
            'className' => 'Api.SpaycPromotion'
        ]);
        $this->belongsToMany('Spaycs', [
            'foreignKey' => 'promotion_id',
            'targetForeignKey' => 'spayc_id',
            'joinTable' => 'spayc_promotion',
            'className' => 'Api.Spaycs'
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
                ->decimal('views')
                ->allowEmpty('views');

        $validator
                ->decimal('balanced_views')
                ->allowEmpty('balanced_views');

        
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
//    public function buildRules(RulesChecker $rules) {
//        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
//
//        return $rules;
//    }

}
