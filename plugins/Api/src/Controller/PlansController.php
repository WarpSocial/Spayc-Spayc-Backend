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
        $items['plans'] = TableRegistry::get('Api.Plans')->allPlans();
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
             $this->restException(['status'=>'failed', 'message'=> __('Promotional Spayc is no longer available.')], 400);
        }
        if(count($wherePromote) != count(explode(',',$data['spayc_id']))){
            $this->restException(['status'=>'failed', 'message'=> __('Some of spayc id is no longer available.')], 400);
        }
        
        
        $plan = $this->Plans->get($data['plan_id']);
        
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
            'balanced_views'=>$plan->views,
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
                    $sppItems = $sppRepo->newEntity(['spayc_id'=>$value,'priority'=>0,'comment_count'=>0]);
                    $sppRepo->save($sppItems);
                }
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
}
