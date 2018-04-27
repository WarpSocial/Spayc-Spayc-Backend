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
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Api.Priority');

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
                 ->where(['spayc_id'=>$spayc_id,"balance > 0","advertisement_status"=>1,'advertisement.status'=>'Active']);
 
         if(!$ad->isEmpty()){
             $list=$ad->toArray();
             for($i=0;$i<count($list);$i++){
                 if($i==0){
                    $update['priority']=end($list)['priority'];
                    $condition['id']=$list[$i]['id'];
                    TableRegistry::get('Api.SpaycAdvertisement')->UpdateAll($update, $condition);
                 }else{
                    $update['priority']=$list[$i-1]['priority'];
                    $condition['id']=$list[$i]['id'];
                    TableRegistry::get('Api.SpaycAdvertisement')->UpdateAll($update, $condition);
                 }
                 
             }
         }
       return true;
    }
    
     public function updateAdvertisementStatus($spayc_id){
         
         
         $this->updateAdActive($spayc_id);
           $this->calculateView($spayc_id);
         $this->updateAdExpired($spayc_id);
         
           return true;
    }
    
    public function updateAdExpired($spayc_id) {

        // To Do Expired
        $ad = TableRegistry::get('Api.SpaycAdvertisement')->find()
                ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->where(['spayc_id' => $spayc_id, "balance < 1 "]);
        $ad_spayc_ids = \Cake\Utility\Hash::extract($ad->toArray(), '{n}.id');
        $adids = \Cake\Utility\Hash::extract($ad->toArray(), '{n}.advertisement_id');
        $expired=false;
        if($ad_spayc_ids){
        $update['advertisement_status'] = 2;
        $expired=TableRegistry::get('Api.SpaycAdvertisement')->UpdateAll($update, ["id in (" . implode(",", $ad_spayc_ids) . ")"]);
        }
        if($adids){
        $update_ad['status'] = "Inactive";
        $expired=TableRegistry::get('Api.Advertisement')
                ->UpdateAll($update_ad, ["id in (" . implode(",", $adids) . ")"]);
        }
        return $expired;
    }
    public function updateAdActive($spayc_id) {

        // To Do Expired
        $ad = TableRegistry::get('Api.SpaycAdvertisement')->find()
                ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->where(['spayc_id' => $spayc_id, "balance > 0"])
                ->order(['SpaycAdvertisement.id' => 'ASC'])
                ->limit(10)
                ;
        $adids = \Cake\Utility\Hash::extract($ad->toArray(), '{n}.id');
        $update['advertisement_status'] = 1;
        $expired=TableRegistry::get('Api.SpaycAdvertisement')
                ->UpdateAll($update, ["id in (" . implode(",", $adids) . ")"]);
        return $expired;
    }
    
    public function adFrequency($spayc_id) {

          $ad_count = TableRegistry::get('Api.SpaycAdvertisement')->find()
                  ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->where(['spayc_id'=>$spayc_id,"balance > 0","advertisement_status"=>1,'advertisement.status'=>'Active'])
                ->count()
                ;
          
        switch ($ad_count) {
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

        
        $ad = TableRegistry::get('Api.SpaycAdvertisement')->find('all',
                ['fields'=>
                    [
                        'SpaycAdvertisement.id',
                        'SpaycAdvertisement.advertisement_id',
                        'SpaycAdvertisement.display_times',
                        'advertisement.balance'
                        
                        ]])
                ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->where(['spayc_id'=>$spayc_id,"balance > 0","advertisement_status"=>1,'advertisement.status'=>'Active'])
                ->order(['SpaycAdvertisement.priority' => 'ASC'])
                ->limit(1)
                ;
        
        $data=false;
         if(!$ad->isEmpty()){
        $array=$ad->first();
        
        $display_times=$array['display_times']+1;
        $ad_spayc_id=$array['id'];
        $ad_id=$array['advertisement_id'];
        $balance=$array['advertisement']['balance'];
        $data=TableRegistry::get('Api.SpaycAdvertisement')
                ->UpdateAll(array('display_times' => $display_times)
                        , ["id"=>$ad_spayc_id]);
                $this->UpdateViewBalance($display_times,$spayc_id,$balance,$ad_id);
        }
        return $data;
    }
    
     
    public function UpdateViewBalance($display_times,$spayc_id,$balance,$ad_id) {
        $joined_users=TableRegistry::get('Api.JoinedSpayc')->getJoinedUserIds($spayc_id);
       
        $views=count($joined_users)*$display_times;
        $final_balance= $balance-$views;
        
        $data=TableRegistry::get('Api.Advertisement')
                ->UpdateAll(array('balance' => $final_balance)
                          , ["id"=>$ad_id]);
        return $data;
    }
    

}
