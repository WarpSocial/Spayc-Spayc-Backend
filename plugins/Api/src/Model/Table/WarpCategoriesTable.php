<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

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
        $this->setPrimaryKey('id');

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
    
    public function getWarpCategories($object){
        $primary = null;$other=[];
        if(empty($object->warp_categories)){
            return ['primary'=>'','other'=> ''];
        } 
        foreach($object->warp_categories as $cat){
            if($cat->is_primary){  
                $primary = $cat->spayc_category_id;
            }else{
                $other[] = $cat->spayc_category_id;
            }
        }
        return ['primary'=>$primary,'other'=> implode(',', $other)];
    }
    
    public function SaveCategories($request, $spaycEntity){
        $warpCat = TableRegistry::get('Api.WarpCategories');
        /* when edit subwarp return existing category, no need to save the reocrd again in case of edit the subwarp but will save new subwarp category*/
//        if(!is_null($spaycEntity->parent_id) && !$spaycEntity->isNew()){
//            return $spaycEntity->warp_categories;
//        }
        $warpCat->deleteAll(['spayc_id' => $spaycEntity->id]);
        $data[] = [
            'spayc_id'=>$spaycEntity->id,
            'spayc_category_id'=>$request['primary_category'],
            'is_primary'=>true,
            ];
        if(!empty($request['other_category'])){
            $otherCategory = explode(',',$request['other_category']);
            foreach($otherCategory as $cat){
                $data[] = [
                    'spayc_id'=>$spaycEntity->id,
                    'spayc_category_id'=>$cat,
                    'is_primary'=>false,
                ];
            }            
        }
        return $warpCat->saveMany($warpCat->newEntities($data));
    }

}
