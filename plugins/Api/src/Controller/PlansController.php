<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Api\Utils;
use Cake\Utility\Hash;
/**
 * Plans Controller
 *
 * @property \Api\Model\Table\PlansTable $Plans
 */
class PlansController extends AppController {
   
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
        $spaycs = $sRepo->find('list')->where(['id IN'=> $data['pspaycs']])->toArray();
        $spaycIds = array_keys($spaycs);
        if(!in_array($data['spayc_id'],$spaycIds)){
            $this->restException(['status'=>'failed', 'message'=> __('Spayc is no longer available.')], 400);
        }
        if(!empty(array_diff($data['pspaycs'],$spaycIds))){
            $this->restException(['status'=>'failed', 'message'=> __('Some of promotional spayc is no longer available.')], 400);
        }
        $plan = $this->Plans->get($data['plan_id']);
        $data['views'] = $data['balanced_views'] = $plan->views;
        $data['amount'] = $plan->amount;
        $data['user'] = $user['id'];
        $data['plan_id'] = $plan->id;
        $pRepo = TableRegistry::get('Api.Promotions');
        $pRepo->getConnection()->begin();
        $promotion = $pRepo->newEntity($data);
        $data->save($promotion);
        $pRepo->getConnection()->commit();
        $pRepo->getConnection()->rollback();
        $promo = $pRepo->find()->contain(['Purchase','SpaycPromotion','SpaycPromotionPriority']);
        pj($promo);die;
        $this->set($response);
    }
}
