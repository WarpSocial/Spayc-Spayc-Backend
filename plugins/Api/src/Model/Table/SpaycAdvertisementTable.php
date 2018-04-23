<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use \Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * SpaycAdvertisement Model
 *
 * @property \Api\Model\Table\AdvertisementsTable|\Cake\ORM\Association\BelongsTo $Advertisements
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\SpaycAdvertisement get($primaryKey, $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycAdvertisement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycAdvertisementTable extends Table
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

        $this->setTable('spayc_advertisement');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'created']);

        $this->addBehavior('Timestamp');

//        $this->belongsTo('Advertisements', [
//            'foreignKey' => 'advertisement_id',
//            'joinType' => 'INNER',
//            'className' => 'Api.Advertisements'
//        ]);
//        $this->belongsTo('Spaycs', [
//            'foreignKey' => 'spayc_id',
//            'joinType' => 'INNER',
//            'className' => 'Api.Spaycs'
//        ]);
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
//        $rules->add($rules->existsIn(['advertisement_id'], 'Advertisements'));
//        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));

        return $rules;
    }
    
     public function setPriority($spayc_id){
         
         $ad=TableRegistry::get('Api.SpaycAdvertisement')->find()
                  ->join(
                [
                    'table' => 'advertisement',
                    'type' => 'INNER',
                    'conditions' => [
                        'advertisement.id = SpaycAdvertisement.advertisement_id',
                    ]
                ]
            )
                 ->where(['spayc_id'=>$spayc_id,"balance > 0"]);
         print_R(count($ad->toArray()));die;
        $joinedSpayc = TableRegistry::get('Api.JoinedSpayc')->find()
                ->contain('Spaycs')
                ->where(['JoinedSpayc.status'=>'Joined','JoinedSpayc.user_id'=>$userid,'Spaycs.parent_id IS'=>null]);
        if($joinedSpayc->isEmpty()){
            return [];
        }else{
            return $joinedSpayc->toArray();
        }
    }
}
