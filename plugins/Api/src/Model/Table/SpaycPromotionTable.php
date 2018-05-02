<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use \Cake\ORM\TableRegistry;
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
        $this->setPrimaryKey(['id', 'spayc_id', 'promotion_id']);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Api.Priority');

        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'joinType' => 'INNER',
            'className' => 'Api.Promotions'
        ]);
        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['promotion_id'], 'Promotions'));
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
        return $rules;
    }
    
      
     public function setPriority($spayc_id){
         
         $pro=TableRegistry::get('Api.SpaycPromotion')->find()
                  ->join(
                [
                    'table' => 'promotion',
                    'type' => 'INNER',
                    'conditions' => [
                        'promotion.id = SpaycPromotion.promotion_id',
                    ]
                ]
            )
                 ->where(['spayc_id'=>$spayc_id,"balance > 0","promotion_status"=>1,'promotion.status'=>'Active']);
 
         if(!$pro->isEmpty()){
             $list=$pro->toArray();
             for($i=0;$i<count($list);$i++){
                 if($i==0){
                    $update['priority']=end($list)['priority'];
                    $condition['id']=$list[$i]['id'];
                    TableRegistry::get('Api.SpaycPromotion')->UpdateAll($update, $condition);
                 }else{
                    $update['priority']=$list[$i-1]['priority'];
                    $condition['id']=$list[$i]['id'];
                    TableRegistry::get('Api.SpaycPromotion')->UpdateAll($update, $condition);
                 }
                 
             }
         }
       return true;
    }
    
     public function updatePromotionStatus($spayc_id){
         
        
          $this->updatePromotionExpired($spayc_id);
         $this->updatePromotionActive($spayc_id);
           $this->calculateView($spayc_id);
        
         
           return true;
    }
    
    public function updatePromotionExpired($spayc_id) {

        // To Do Expired
        $pro = TableRegistry::get('Api.SpaycPromotion')->find()
                ->join(
                        [
                            'table' => 'promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotion.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->where(['spayc_id' => $spayc_id, " (balance < 1 OR status != 'Active') "]);
        $pro_spayc_ids = \Cake\Utility\Hash::extract($pro->toArray(), '{n}.id');
        $proids = \Cake\Utility\Hash::extract($pro->toArray(), '{n}.promotion_id');
        $expired=false;
        if($pro_spayc_ids){
        $update['promotion_status'] = 2;
        $expired=TableRegistry::get('Api.SpaycPromotion')->UpdateAll($update, ["id in (" . implode(",", $pro_spayc_ids) . ")"]);
        }
        if($proids){
        $update_ad['status'] = "Inactive";
        $expired=TableRegistry::get('Api.Promotion')
                ->UpdateAll($update_ad, ["id in (" . implode(",", $proids) . ")"]);
        }
        return $expired;
    }
    public function updatePromotionActive($spayc_id) {

        // To Do Expired
        $pro = TableRegistry::get('Api.SpaycPromotion')->find()
                ->join(
                        [
                            'table' => 'promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotion.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->where(['spayc_id' => $spayc_id, "balance > 0","promotion_status != 2"])
                ->order(['SpaycPromotion.id' => 'ASC'])
                ->limit(10)
                ;
//        print_R($pro->toArray());die;
        $proids = \Cake\Utility\Hash::extract($pro->toArray(), '{n}.id');
        $update['promotion_status'] = 1;
        $success=TableRegistry::get('Api.SpaycPromotion')
                ->UpdateAll($update, ["id in (" . implode(",", $proids) . ")"]);
        return $success;
    }
    
    public function adFrequency($spayc_id) {

          $pro_count = TableRegistry::get('Api.SpaycPromotion')->find()
                  ->join(
                        [
                            'table' => 'promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotion.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->where(['spayc_id'=>$spayc_id,"balance > 0","promotion_status"=>1,'promotion.status'=>'Active'])
                ->count()
                ;
          
        switch ($pro_count) {
            case 1:
                $comments=20;
            break;
            case 2:
                $comments=19;
            break;
            case 3:
                $comments=18;
            break;
            case 4:
                $comments=17;
            break;
            case 5:
                $comments=16;
            break;
            case 6:
                $comments=15;
            break;
            case 7:
                $comments=14;
            break;
            case 8:
                $comments=13;
            break;
            case 9:
                $comments=12;
            break;
            case 10:
                $comments=11;
            break;
            default:
                $comments=20;
            break;
        }
            return $comments; 
    }
    
    
    public function calculateView($spayc_id) {

        
        $pro = TableRegistry::get('Api.SpaycPromotion')->find('all',
                ['fields'=>
                    [
                        'SpaycPromotion.id',
                        'SpaycPromotion.promotion_id',
                        'SpaycPromotion.display_times',
                        'promotion.balance'
                        
                        ]])
                ->join(
                        [
                            'table' => 'promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotion.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->where(['spayc_id'=>$spayc_id,"balance > 0","promotion_status"=>1,'promotion.status'=>'Active'])
                ->order(['SpaycPromotion.priority' => 'ASC'])
                ->limit(1)
                ;
        
        $data=false;
         if(!$pro->isEmpty()){
        $array=$pro->first();
        
        $display_times=$array['display_times']+1;
        $pro_spayc_id=$array['id'];
        $pro_id=$array['promotion_id'];
        $balance=$array['promotion']['balance'];
        $data=TableRegistry::get('Api.SpaycPromotion')
                ->UpdateAll(array('display_times' => $display_times)
                        , ["id"=>$pro_spayc_id]);
                $this->UpdateViewBalance($display_times,$spayc_id,$balance,$pro_id);
        }
        return $data;
    }
    
     
    public function UpdateViewBalance($display_times,$spayc_id,$balance,$pro_id) {
        $joined_users=TableRegistry::get('Api.JoinedSpayc')->getJoinedUserIds($spayc_id);
       
        $views=count($joined_users)*$display_times;
        $final_balance= $balance-$views;
        
        $data=TableRegistry::get('Api.Promotion')
                ->UpdateAll(array('balance' => $final_balance)
                          , ["id"=>$pro_id]);
        return $data;
    }

}
