<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Api\Utils;
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
        $errors = $this->Spaycs->validateSubspace($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $entity = $this->Spaycs->find()->contain('JoinedSpayc',function($q)use($user){
            return $q->where(['user_id'=>$user['id'],'status'=>'Joined']);
        });
        $entity->where($this->Spaycs->spaycPk($data['parent_matrix_room_id']));
        $entity->where(['group_type !='=>'trusted_private']);        
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Parent spayc is no longer available.')], 400);
        }
        $this->set($response);
    }
}
