<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
/**
 * ScraperCategories Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $ScraperCategories
 * @property |\Cake\ORM\Association\BelongsTo $SpaycCategories
 * @property |\Cake\ORM\Association\HasMany $ScraperCategories
 *
 * @method \App\Model\Entity\ScraperCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScraperCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScraperCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScraperCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScraperCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScraperCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScraperCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ScraperCategoriesTable extends Table
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

        $this->setTable('scraper_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->maxLength('name', 250)
            ->allowEmpty('name');

        $validator
            ->integer('website')
            ->allowEmpty('website');

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
        // $rules->add($rules->existsIn(['scraper_category_id'], 'ScraperCategories'));
        // $rules->add($rules->existsIn(['spayc_category_id'], 'SpaycCategories'));

        return $rules;
    }

    public function updateScraperCategories($value, $eventIds, $website) {
        if(!empty($value)){
            $getIds = $this->find()->select(['scraper_category_id'])->where(['scraper_category_id IN' => $eventIds, 'website' => $website])->extract('scraper_category_id')->toList();
            $diffIds=array_diff($eventIds,$getIds); 
            if(count($diffIds)){
                $getuniqueevents =[];           
                foreach ($value as $val) {
                    if (in_array($val['scraper_category_id'],$diffIds)){
                        $entities = $this->newEntity($val);
                        $result = $this->save($entities);
                    }                    
                } 
            }
        }
    }
    
    
     public function isCatExist($category,$website) {
        $data=false;
        if($category){
         $ids=explode(',',$category);
        $obj = $this->find('all',
                ['fields' =>['spayc_category_id','spayc_categories.name']])
               ->join([
                            'table' => 'spayc_categories',
                            'type' => 'INNER',
                            'conditions' => [
                                'spayc_category_id = spayc_categories.id',
                            ]])
                ->where([
                    'scraper_category_id IN '=>$ids,
                    'website'=>$website,
                    'spayc_category_id IS NOT NULL'
                    ])->toArray();
        if(!empty($obj[0]))
            $data=[$obj,$obj[0]->spayc_category_id,$obj[0]->name];
        
        }else{
            $obj = $this->find('all',
                ['fields' =>['spayc_category_id',]])
                ->where([
                     "name LIKE" => "%".OTHER_CAT_NAME."%",
                     'website'=>$website,
                     'spayc_category_id IS NOT NULL'])
               ->first();
            if(!empty($obj))
            $data=[0,$obj->spayc_category_id,0];
        }
        
         if(!empty($data)){
            return $data;
        }else{
            return false;
        }
        
    }
}
