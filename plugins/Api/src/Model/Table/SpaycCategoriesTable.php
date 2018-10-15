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
        $this->addBehavior('Tree');

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
        if(!empty(\Cake\Routing\Router::getRequest()->getQuery('clear'))){
            \Cake\Cache\Cache::delete('spayc_categories', 'long'); 
        }
        if (($categories = \Cake\Cache\Cache::read('spayc_categories','long')) === false) {
            $spaycCategory = $this->find('threaded')        
                ->select(['SpaycCategories.id','SpaycCategories.parent_id','SpaycCategories.name','SpaycCategories.slug','SpaycCategories.code','SpaycCategories.description','SpaycCategories.created','SpaycCategories.modified'])
                ->where(['SpaycCategories.status'=>ACTIVE])
                ->order(['SpaycCategories.name'=>'ASC'])        
                ->map(function($row){
                    //$row->created = $row->created);
                    //$row->modified = Utils::toClient($row->modified);
                    if(!empty($row->children)){
                        foreach($row->children as $skey => $subrow){
                            //$row->children[$skey]->created = Utils::toClient($subrow->created);
                            //$row->children[$skey]->modified = Utils::toClient($subrow->modified);
                            unset($row->children[$skey]->children);
                        };
                    }
                    $row->sub_categories = $row->children;
                    unset($row->children);
                    return $row;
                });
            $categories = $spaycCategory->toArray();    
            \Cake\Cache\Cache::write('spayc_categories', $categories,'long');    
        }
        return $categories;        
    }

}
