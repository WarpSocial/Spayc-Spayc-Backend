<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Collection\CollectionInterface;
use Api\Utils\Utils;
/**
 * SpaycCategories Model
 *
 * @property \Api\Model\Table\SpaycCategoriesTable|\Cake\ORM\Association\BelongsTo $ParentSpaycCategories
 * @property \Api\Model\Table\SpaycCategoriesTable|\Cake\ORM\Association\HasMany $ChildSpaycCategories
 * @property |\Cake\ORM\Association\HasMany $Spaycs
 *
 * @method \Api\Model\Entity\SpaycCategory get($primaryKey, $options = [])
 * @method \Api\Model\Entity\SpaycCategory newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\SpaycCategory[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\SpaycCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\SpaycCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycCategoriesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('spayc_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentSpaycCategories', [
            'className' => 'Api.SpaycCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('subCategories', [
            'className' => 'Api.SpaycCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Spaycs', [
            'foreignKey' => 'spayc_category_id',
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
                ->integer('right')
                ->allowEmpty('right');

        $validator
                ->scalar('name')
                ->maxLength('name', 100)
                ->allowEmpty('name');

        $validator
                ->scalar('slug')
                ->maxLength('slug', 100)
                ->allowEmpty('slug');

        $validator
                ->scalar('description')
                ->maxLength('description', 200)
                ->allowEmpty('description');

        $validator
                ->scalar('status')
                ->requirePresence('status', 'create')
                ->notEmpty('status');

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentSpaycCategories'));

        return $rules;
    }
    
    /*
     * allCategories method to returnt he active categoris with sub-categories
     * 
     * @return array of all categegories and subcategories or false
     * 
     */
    public function allCategories(){
        $categories = $this->find()
                ->select(['id','parent_id','name','slug','description','created','modified'])
                ->contain(['subCategories'=>function($q){
                    return $q->select(['id','parent_id','name','slug','description','created','modified'])->where(['subCategories.status'=>ACTIVE]);                    
                }])->where(['SpaycCategories.status'=>ACTIVE])
                ->map(function($row){
                    $row->created = Utils::toClient($row->created);
                    $row->modified = Utils::toClient($row->modified);
                    if(!empty($row->sub_categories)){
                        foreach($row->sub_categories as $skey => $subrow){
                            $row->sub_categories[$skey]->created = Utils::toClient($subrow->created);
                            $row->sub_categories[$skey]->modified = Utils::toClient($subrow->modified);
                        };
                    }
                    return $row;
                });
        return $categories;        
    }

}
