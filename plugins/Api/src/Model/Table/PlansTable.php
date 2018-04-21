<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Collection\CollectionInterface;
use Api\Utils\Utils;
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
class PlansTable extends Table
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

        $this->setTable('plans');
        $this->setDisplayField('name');
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 200)
            ->allowEmpty('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 200)
            ->allowEmpty('slug');

        $validator
            ->decimal('amount')
            ->allowEmpty('amount');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 20)
            ->allowEmpty('currency');

        $validator
            ->integer('views')
            ->allowEmpty('views');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
    
    /**
     * AllPlans to get all the active plans
     * 
     * @return Object Array of object contain plan details
     */
    public function allPlans(){
        $items = $this->find()
                ->select(['id','name','slug','amount','currency','views','created','modified'])
                ->where(['status'=>ACTIVE])
                ->map(function($row){
                    $row->created = Utils::toClient($row->created);
                    $row->modified = Utils::toClient($row->modified);
                    return $row;
                });
        return $items;
    }
}
