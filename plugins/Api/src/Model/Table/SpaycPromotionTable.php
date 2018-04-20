<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpaycPromotion Model
 *
 * @property \Api\Model\Table\PromotionsTable|\Cake\ORM\Association\BelongsTo $Promotions
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\SpaycPromotion get($primaryKey, $options = [])
 * @method \Api\Model\Entity\SpaycPromotion newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\SpaycPromotion[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycPromotion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\SpaycPromotion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycPromotion[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycPromotion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycPromotionTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('spayc_promotion');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'created']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'className' => 'Api.Promotions'
        ]);
        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
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
                ->integer('priority')
                ->allowEmpty('priority');

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
        $rules->add($rules->existsIn(['promotion_id'], 'Promotions'));
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));

        return $rules;
    }

}
