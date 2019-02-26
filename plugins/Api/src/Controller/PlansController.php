<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Api\Utils\Utils;
use Cake\Utility\Hash;
/**
 * Plans Controller
 *
 * @property \Api\Model\Table\PlansTable $Plans
 */
class PlansController extends AppController {
    
     /**
     * beforeFilter overwrite the default function
     * 
     * @param object $event 
     */
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['metaData']);
    }
   
    /**
     * index method to show the meta data
     * 
     * @return \Cake\Http\Response|void
     */
    public function metaData(){
        if (!$this->request->is('get')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $items['categories'] = TableRegistry::get('Api.SpaycCategories')->allCategories();
        $plans = TableRegistry::get('Api.Plans')->allPlans();
        foreach($plans as $plan){
            if($plan->type == 'advertisement'){
                $items['plans'][] = $plan;
            }else{
                $items['promotional_plan'][]  = $plan;
            }
            
        }
        $response = ['status'=>'success','Message'=>'List of meta-data details.','data'=>$items];
        $this->set($response);
    }
    
    /**
     * addPromotionalSpayc to add spayc which is promotional
     * @return \Cake\Http\Response|void
     */
    public function addPromotionalSpayc(){
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        
        $data= $this->request->getData();        
        $errors = $this->Plans->validatePromotionalSpayc($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $user = $this->Auth->user();
        $sps = explode(',', $data['spayc_promotional_id']);
        if(in_array($data['spayc_id'],$sps)){
            $this->restException(['status'=>'failed', 'message'=> __('You couldn\'t promote same warp from existing warp.')], 400);
        }
        $data['pspaycs'] = explode(',', $data['spayc_promotional_id'].','.$data['spayc_id']) ;        
        $sRepo = TableRegistry::get('Api.Spaycs');
        $spaycs = $sRepo->find()->contain(['JoinedSpayc'=>function($q)use($user){
            return $q->where(['JoinedSpayc.status'=>JOINED,'JoinedSpayc.user_id'=>$user['id']]);
        }])->where(['id IN'=> $data['pspaycs']]);
        $pspayc = false;$wherePromote = [];
        foreach($spaycs as $spayc){
            //echo $spayc->group_type .'=='. PRIVATETYPE.'<br>';
            if($spayc->group_type == PRIVATETYPE){
                if(empty($spayc->joined_spayc)){
                     $this->restException(['status'=>'failed', 'message'=> __('You have not join with this private warp.')], 400);
                }
            }
            if($spayc->id == $data['spayc_promotional_id']){
                $pspayc = true;
                $promotionalSpaycRole = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
                if(empty($spayc->joined_spayc) || empty($promotionalSpaycRole[0])){
                    $this->restException(['status'=>'failed', 'message'=> __('You have not join with this warp.')], 400);
                }
                if($promotionalSpaycRole[0]['is_admin'] <= 0 ){
                    $this->restException(['status'=>'failed', 'message'=> __('You have not access to promote this warp.')], 400);
                }
            }
            if(in_array($spayc->id, explode(',',$data['spayc_id']))){
                array_push($wherePromote, $spayc->id);
            }            
        }
        if(!$pspayc){
             $this->restException(['status'=>'failed', 'message'=> __('Promotional warp is no longer available.')], 400);
        }
        if(count($wherePromote) != count(explode(',',$data['spayc_id']))){
            $this->restException(['status'=>'failed', 'message'=> __('Some of warp id is no longer available.')], 400);
        }
        
        
        $plan = $this->Plans->find()->where(['OR'=>['id'=>$data['plan_id'],'app_plan_id'=>$data['plan_id']]])->first();
        
        $purchase = [
            'plan_id'=>$data['plan_id'],
            'receipt'=>$data['receipt'],
            'platform'=>$data['platform'],
            'purchase_date'=> Utils::toUtc($data['purchase_date']),
        ];
        $pRepo = TableRegistry::get('Api.Promotions');
//        if($pRepo->exists(['spayc_id'=>$data['spayc_promotional_id']])){
//            $this->restException(['status'=>'failed', 'message'=> __('This warp has been already promoted.')], 400);
//        }
        $promotions = [
            'spayc_id'=>$data['spayc_promotional_id'],
            'user_id'=>$user['id'],
            'views'=>$plan->views,
            'balance'=>$plan->views,
            'amount'=>$plan->amount,
            //'spaycs'=>['_ids'=>explode(',',$data['spayc_id'])],
            'purchase'=>$purchase
        ];
        
        
        $pRepo->getConnection()->begin(); 
        $pEntity = $pRepo->newEntity();
        $items = $pRepo->patchEntity($pEntity,$promotions);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $sppRepo = TableRegistry::get('Api.SpaycPromotionPriority');
        if($pRepo->save($items)){
            foreach(explode(',',$data['spayc_id']) as $key=>$value){
                $spayc = ['spayc_id'=>$value,'promotion_id'=>$items->id];   
                $spEntity = $pRepo->SpaycPromotion->newEntity($spayc);
                $pRepo->SpaycPromotion->save($spEntity);
                
                if(!$sppRepo->exists(['spayc_id'=>$value])){
                    $sppItems = $sppRepo->newEntity(['spayc_id'=>$value,'cycle'=>0,'comment_count'=>0]);
                    $sppRepo->save($sppItems);
                }
                 //Ad Bucket Active & Expire         
             TableRegistry::get('Api.SpaycPromotion')->updatePromotionExpired($value);
             TableRegistry::get('Api.SpaycPromotion')->updatePromotionActive($value);
            }
            $pRepo->getConnection()->commit();
            $this->response->statusCode(201);
            unset($data['pspaycs']);
            $response = ['status'=>'success','message'=>__('Promotion has been created successfully.'),'data'=>$data];
        }else{
            $pRepo->getConnection()->rollback();
            $response = ['status'=>'failed','message'=>__('Failed to create new promotion')];
        }
        
        $this->set($response);
    }
    
    
    //Ad Logic
     public function promotionLogic() {
        if (!$this->request->is('post')) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
         if(!isset($data['spayc_id'])) {
            $this->restException(['status' => 'failed', 'message' => __('Warp ID field required.')], 400);
        }
         if(!isset($data['cycle'])) {
            $this->restException(['status' => 'failed', 'message' => __('Cycle field required.')], 400);
        }
         if(!isset($data['comment_count'])) {
            $this->restException(['status' => 'failed', 'message' => __('Comment Count field required.')], 400);
        }
        $spaycRow = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'spayc_promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'Spaycs.id = spayc_promotion.spayc_id',
                                'promotion_status != 2',
                            ]
                        ]
                )->where(['spayc_id' =>  $data['spayc_id']])
                ->distinct(['Spaycs.id']);;
        
        if($spaycRow->isEmpty()){
//             $this->restException(['status'=>'failed','message'=>'Spayc not Authorized with any Promotion .'], 404);
             $this->restException(['status'=>'failed','message'=>'Promotion could not be found.'], 404);
        }
        
        
        $spayc=$spaycRow->first();
        
         $cycleRow = TableRegistry::get('Api.SpaycPromotionPriority')->find()->where(['spayc_id' =>  $data['spayc_id']])
                 ->order(['id' => 'DESC']);
         
         //Ad Bucket Active & Expire         
             TableRegistry::get('Api.SpaycPromotion')->updatePromotionExpired($data['spayc_id']);
             TableRegistry::get('Api.SpaycPromotion')->updatePromotionActive($data['spayc_id']);
             
        $cycleData=$cycleRow->first();
        $frequency=TableRegistry::get('Api.SpaycPromotion')->adFrequency($data['spayc_id']);
        
        if($data['comment_count']>$frequency) {
            $this->restException(['status' => 'failed', 'message' => __('Comment Count Must be less than from Comment Frequency.')], 400);
        }
       
        if($cycleData){
             $cycle=$cycleData['cycle'];
             $comment_count=$cycleData['comment_count'];
             
            
             if($data['cycle']<=$cycle && $data['comment_count']<=$comment_count){ 
                 // If Cycle Same or Low Count Comment or Low Cycle
//                 $this->restException(['status' => 'failed', 'message' => __('Cycle Already Inserted.')], 400);
             }elseif($data['cycle']==$cycle && $data['comment_count']>=$comment_count){ 
                 // If Cycle Same and Count Comment Greater
                 $update['comment_count']=$data['comment_count'];
                 $condition['spayc_id']=$data['spayc_id'];
                 $condition['cycle']=$data['cycle'];
                 TableRegistry::get('Api.SpaycPromotionPriority')->UpdateAll($update, $condition);
             }elseif($data['cycle']>$cycle || !$cycleData){
                 
                 //Ad Expire,Active,View Balance
                 TableRegistry::get('Api.SpaycPromotion')->updatePromotionStatus($data['spayc_id']);
                 
                 // If Cycle Greater, Update Cycle
                    $update['comment_count']=$data['comment_count'];
                    $update['cycle']=$data['cycle'];
                    $condition['spayc_id']=$data['spayc_id'];
                    TableRegistry::get('Api.SpaycPromotionPriority')->UpdateAll($update, $condition);
                    
                    $priority = TableRegistry::get('Api.SpaycPromotion')
                            ->setPriority($data['spayc_id']);
                    
             }
     }
     
     
        //Getting Distance 
                 $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $pquery = $pquery->first();
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;
        }else{
            $lat = $user['latitude'];
            $long = $user['longitude'];
        }
                    
        if(!empty($lat) && !empty($long)){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,
                    str_replace('Spaycs.','spayc.',TableRegistry::get('Api.Spaycs')->distanceInMiles)
                    ))." AS numeric), 3)";
            $distance_condition=$distance;
        }else{
            $distance_condition=0;
        }
            //Getting Distance 
            
         
        $ad = TableRegistry::get('Api.SpaycPromotion')->find('all',
                ['fields'=>
                    [
                        'promotions.user_id',
                        'priority.cycle',
                        'priority.comment_count',
                        'spayc.id',
                        'spayc.name',
                        'spayc.location',
                        'spayc.description',
                        'spayc.matrix_room_id',
                        'distance'=>$distance_condition,
                        'spayc.image',
                        'spayc.type',
                        'spayc.group_type',
                        'spayc.start_date',
                        'spayc.end_date',
                        'spayc.spayc_category_id',
                        'sc.id',
                        'sc.name',
                        'joined_spayc_status'=>'joined_spayc.status',
                        ]])                
                ->join(
                        [
                            'table' => 'promotions',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotions.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->join(
                        [
                            'table' => 'spayc_promotion_priority',
                            'alias' => 'priority',
                            'type' => 'INNER',
                            'conditions' => [
                                'priority.spayc_id = SpaycPromotion.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'spaycs',
                            'alias' => 'spayc',
                            'type' => 'INNER',
                            'conditions' => [
                                'spayc.id = promotions.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'joined_spayc',
                            'type' => 'LEFT',
                            'conditions' => [
                                'joined_spayc.user_id'=>$user['id'],
                                'spayc.id = joined_spayc.spayc_id',
                                "joined_spayc.status != 'BANNED'",
                            ]
                        ]
                )
                ->join([
                    'table' => 'spayc_categories',
                    'alias' => 'sc',
                    'type' => 'LEFT',
                    'conditions' => [
                        'sc.id = spayc.spayc_category_id',
                    ]
                ])
                ->join([
                    'table' => 'friend_request',
                    'type' => 'LEFT',
                    'conditions' => [
                        'OR' =>[
                            [
                                'friend_request.requested_by = promotions.user_id', 'friend_request.requested_to = '.$user['id']
                            ],
                            [
                                'friend_request.requested_to = promotions.user_id', 'friend_request.requested_by = '.$user['id']
                            ]
                        ]
                    ]
                ])
                
                
                ->where(['SpaycPromotion.spayc_id'=>$data['spayc_id'],"balance > 0","promotion_status"=>1,'promotions.status'=>'Active'])
                ->order(['SpaycPromotion.priority' => 'ASC'])
                ->limit(1)
                ;
        $data=[];
        if($ad->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Promotion not found.'], 404);
        }
        $data=$ad->first();
        if(!empty($data['sc'])){
            $data['spayc']['spayc_category'] = $data['sc'];
            unset($data['sc']);
        }
        if($data->spayc['type']=='Event'){
        $timezone = Configure::read('timezone');
        $sd = new \Cake\I18n\Time($data->spayc['start_date'], 'UTC');
        $data->spayc['start_date'] = $sd->setTimezone(new \DateTimeZone($timezone))->format('Y-m-d H:i:s');
        $ed = new \Cake\I18n\Time($data->spayc['end_date'], 'UTC');
        $data->spayc['end_date'] = $ed->setTimezone(new \DateTimeZone($timezone))->format('Y-m-d H:i:s');
        }else{
            unset($data->spayc['start_date']);
            unset($data->spayc['end_date']);
        }
        $data['frequency']=$frequency;
        $response = ['status' => 'success', 'message' => __('Promotion Find Successfully'), 'data' => $data];
        $this->set($response);
    }
    
    //Ad Logic First Time Enter
     public function promotionLogicStart() {
        if (!$this->request->is('post')) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
         if(!isset($data['spayc_id'])) {
            $this->restException(['status' => 'failed', 'message' => __('Warp ID field required.')], 400);
        }
        
        
        $spaycRow = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'spayc_promotion',
                            'type' => 'INNER',
                            'conditions' => [
                                'Spaycs.id = spayc_promotion.spayc_id',
                                'promotion_status != 2',
                            ]
                        ]
                )->where(['spayc_id' =>  $data['spayc_id']])
                ->distinct(['Spaycs.id']);;
        
        if($spaycRow->isEmpty()){
//             $this->restException(['status'=>'failed','message'=>'Spayc not Authorized with any Promotion .'], 404);
             $this->restException(['status'=>'failed','message'=>'Promotion could not be found.'], 404);
        }
        
        //Ad Bucket Active & Expire
                 TableRegistry::get('Api.SpaycPromotion')->updatePromotionExpired($data['spayc_id']);
                 TableRegistry::get('Api.SpaycPromotion')->updatePromotionActive($data['spayc_id']);
        
        
        //Getting Distance 
                 $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $pquery = $pquery->first();
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;
        }else{
            $lat = $user['latitude'];
            $long = $user['longitude'];
        }
                    
        if(!empty($lat) && !empty($long)){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,
                    str_replace('Spaycs.','spayc.',TableRegistry::get('Api.Spaycs')->distanceInMiles)
                    ))." AS numeric), 3)";
            $distance_condition=$distance;
        }else{
            $distance_condition=0;
        }
            //Getting Distance 
            
        $ad = TableRegistry::get('Api.SpaycPromotion')->find('all',
                ['fields'=>
                    [
                        'promotions.user_id',
                        'priority.cycle',
                        'priority.comment_count',
                        'spayc.id',
                        'spayc.name',
                        'spayc.location',
                        'spayc.description',
                        'spayc.matrix_room_id',
                        'distance'=>$distance_condition,
                        'spayc.image',
                        'spayc.type',
                        'spayc.group_type',
                        'spayc.start_date',
                        'spayc.end_date',
                        'sc.id',
                        'sc.name',
                        'joined_spayc_status'=>'joined_spayc.status',
                        
                        ]])
                ->join(
                        [
                            'table' => 'promotions',
                            'type' => 'INNER',
                            'conditions' => [
                                'promotions.id = SpaycPromotion.promotion_id',
                            ]
                        ]
                )
                ->join(
                        [
                            'table' => 'spayc_promotion_priority',
                            'alias' => 'priority',
                            'type' => 'INNER',
                            'conditions' => [
                                'priority.spayc_id = SpaycPromotion.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'spaycs',
                            'alias' => 'spayc',
                            'type' => 'INNER',
                            'conditions' => [
                                'spayc.id = promotions.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'joined_spayc',
                            'type' => 'LEFT',
                            'conditions' => [
                                'joined_spayc.user_id'=>$user['id'],
                                'spayc.id = joined_spayc.spayc_id',
                                "joined_spayc.status != 'BANNED'",
                            ]
                        ]
                )
                ->join([
                    'table' => 'spayc_categories',
                    'alias' => 'sc',
                    'type' => 'LEFT',
                    'conditions' => [
                        'sc.id = spayc.spayc_category_id',
                    ]
                ])
                ->where(['SpaycPromotion.spayc_id'=>$data['spayc_id'],"balance > 0",'promotions.status'=>'Active'])
                ->order(['SpaycPromotion.priority' => 'ASC'])
                ->limit(1)
                ;
        $frequency=TableRegistry::get('Api.SpaycPromotion')->adFrequency($data['spayc_id']);
        $data=[];
        if($ad->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Promotion not found.'], 404);
        }
        
        $data=$ad->first();
        if(!empty($data['sc'])){
            $data['spayc']['spayc_category'] = $data['sc'];
            unset($data['sc']);
        }
        
        $timezone = Configure::read('timezone');
        $sd = new \Cake\I18n\Time($data->spayc['start_date'], 'UTC');
        $data->spayc['start_date'] = $sd->setTimezone(new \DateTimeZone($timezone))->format('Y-m-d H:i:s');
        if(!empty($data->spayc['end_date'])){
            $ed = new \Cake\I18n\Time($data->spayc['end_date'], 'UTC');
            $ed = $ed->setTimezone(new \DateTimeZone($timezone))->format('Y-m-d H:i:s');
        }else{
            $ed = $data->spayc['end_date'];
        }
        
        $data->spayc['end_date'] = $ed;
        $data['frequency']=$frequency;
        $response = ['status' => 'success', 'message' => __('Promotion Find Successfully'), 'data' => $data];
        $this->set($response);
    }
    
    public function isCurrency($number) {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }
}
