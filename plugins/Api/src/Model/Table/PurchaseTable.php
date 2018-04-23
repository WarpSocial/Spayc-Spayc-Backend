<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Purchase Model
 *
 * @property \Api\Model\Table\PlansTable|\Cake\ORM\Association\BelongsTo $Plans
 * @property \Api\Model\Table\PromotionsTable|\Cake\ORM\Association\BelongsTo $Promotions
 * @property \Api\Model\Table\AdvertisementsTable|\Cake\ORM\Association\BelongsTo $Advertisements
 *
 * @method \Api\Model\Entity\Purchase get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Purchase newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Purchase[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Purchase|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Purchase patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Purchase[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Purchase findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PurchaseTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('purchase');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'created']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Plans', [
            'foreignKey' => 'plan_id',
            'className' => 'Api.Plans'
        ]);
        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'className' => 'Api.Promotions'
        ]);
        $this->belongsTo('Advertisements', [
            'foreignKey' => 'advertisement_id',
            'className' => 'Api.Advertisements'
        ]);
    }
}
