<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Collection\CollectionInterface;
use Api\Utils\Utils;
use Cake\ORM\TableRegistry;

/**
 * Plans Model
 *
 * @method \Api\Model\Entity\Plan get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Plan newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Plan[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Plan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Plan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Plan[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Plan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlansTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('plans');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * validatePromotionalSpayc to validate the input request of spayc promotion.
     * 
     * @param array $data input request data
     * @return array List of array
     */
    public function validatePromotionalSpayc($data){
        $validator = new Validator();
        $validator
                ->requirePresence('spayc_id','create', __('Please provide the warp id'))
                ->notEmpty('spayc_id',__('Please provide the warp id'))
                ->add('spayc_id','uniquekey',[
                    'rule'=>function($value,$context){
                        $array = explode(',',$value);
                        return (count($array) == count(array_unique($array)));
                    },
                    'message'=>__('Warp must not be repeated.') 
                ]);                
        $validator
                ->requirePresence('spayc_promotional_id','create', __('Please provide promotional warp.'))
                ->integer('spayc_promotional_id',__('Please provide integer value for promotional warp.'))
                ->notEmpty('spayc_promotional_id',__('Please provide promotional warp.'));
        
        $validator
                ->requirePresence('plan_id','create', __('Please provide the plan.'))
                ->notEmpty('plan_id',__('Please provide the plan.'))
                ->integer('plan_id',__('Please provide integer value for plan.'))
                ->add('plan_id','exist',[
                    'rule'=>function($value,$context){
                        if(!empty($value)){
                            return  TableRegistry::get('Api.Plans')->exists(['id'=>$value]);
                        }else{
                            return false;
                        }
                    },
                    'message'=>__('Plan is not available.')
                ]);
        $validator
                ->requirePresence('receipt','create', __('Please provide the receipt.'))
                ->maxLength('receipt', 500,__('Receipt must be lower than 500 character.'))
                ->allowEmpty('receipt',__('Please provide the receipt.'));
        $validator
                ->requirePresence('purchase_date','create', __('Please provide the purchase date.'))
                ->allowEmpty('purchase_date',__('Please provide the purchase date.'))
                ->dateTime('purchase_date','mdy',__('Purchase date is not valid.'));
        $validator
                ->requirePresence('platform','create', __('Please provide the platform.'))
                ->maxLength('platform', 100,__('Platform must be lower than 100 character.'))
                ->notEmpty('platform',__('Please provide the platform.'));
              
         return $validator->errors($data);
    }

    /**
     * AllPlans to get all the active plans
     * 
     * @return Object Array of object contain plan details
     */
    public function allPlans() {
        $items = $this->find()
                ->select(['id','type', 'name', 'slug', 'amount', 'currency', 'views', 'created', 'modified'])
                ->where(['status' => ACTIVE])
                ->order(['name'=>'ASC'])
                ->map(function($row) {
                    $row->created = Utils::toClient($row->created);
                    $row->modified = Utils::toClient($row->modified);
                    return $row;
                });
        return $items;
    }

}
