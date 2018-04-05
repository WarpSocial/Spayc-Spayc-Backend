<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;
use \Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Api\Utils\Utils;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Advertisement Controller
 *
 * @property \Api\Model\Table\SpaycsTable $Spaycs
 *
 * @method \Api\Model\Entity\Spayc[] paginate($object = null, array $settings = [])
 */
class AdvertisementController extends AppController {
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
        $this->loadComponent('Api.Matrix');
    }
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }
    
   
   
    /**
     * Edit method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
     public function edit($id = null) {         
        if (!$this->request->is(['put','patch','post'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $data['name'] = !empty($data['name'])?ucfirst($data['name']):'';
        if(empty($data['id'])) {
            $this->restException(['status'=>'failed','message'=>'Advertisement id is required.'], 400);
        }
        $entities = $this->Advertisement->find()->where(['id'=>$data['id']]);
        
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid Advertisement id.')], 400);
        }
        
        $entity = $entities->first();
        if($user['id'] != $entity->user_id){
            $this->restException(['status'=>'failed','message'=>__('Insufficient privileges to edit this Advertisement.')], 400);
        }        
        unset($data['id']);        
        unset($data['price']);        
        
        $items = $this->Advertisement->patchEntity($entity, $data);       
       
        if(!empty($items->errors())) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        
        
        
        if($success=$this->Advertisement->save($items)){  
             $response = ['status'=>'success','message'=>__('Advertisement Updated Successfully'),'data'=>$success];
        }else{
            $this->restException(['status'=>'failed', 'message'=>__('The spayc could not be updated. Please, try again.')], 400);
        }
        $this->set($response);        
    }

    /**
     * Delete method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {  
        if (!$this->request->is(['post','delete'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        if($id == null){
            $id = $this->request->query('id');
        } 
        $user = $this->Auth->user();
        $entity = $this->Advertisement->find()
                ->where(['id'=>$id,'user_id'=>$user['id']]);
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $ad = $entity->first();
        $id=$ad->id;
//        print_R($ad);die;
        if ($this->Advertisement->delete($ad)) {
            TableRegistry::get('Api.SpaycAdvertisement')->deleteAll(['advertisement_id' => $id]);
            $response = ['status'=>'success','message'=>__('Advertisement has been deleted.')];
        } else {
            $response = ['status'=>'failed','message'=>__('Advertisement could not be deleted.')];
        }
         $this->set(compact('response'));
    }
   
    
    /**
     * publicSpayc method to get the public and joined spayces
     * End point map-spaycs for Advertisement
     */
    
    public function viewAdvertisement(){
         if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        
         if(empty($this->request->query('id'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Advertisement id is required field.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.Advertisement')->findById($this->request->getQuery('id',null))
                ->select(['id','name','image','price','description','url']);
        if($pquery->toArray()){
        $data=$pquery->toArray();
        $response = ['status'=>'success','message'=>'Advertisement Details','data'=>$data[0]];
        }else{
                $response = ['status'=>'failed','message'=>__('No Advertisement found')];
        }
        $this->set($response);
    }
    
    /**
      /**
     * createAdvertisement method to create subspace
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function createAdvertisement() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();

        $user = $this->Auth->user();
      
        $entity = TableRegistry::get('Api.Spaycs')->find()->contain('JoinedSpayc',function($q)use($user){
            return $q->where(['user_id'=>$user['id']]);
        });
         
        $advModel = TableRegistry::get('Api.Advertisement');
        
        $entity = $advModel->newEntity();
        //pr($this->request->getData());
        
        
        $data['spaycs'] = ['_ids' => [1]];
        $items = $advModel->patchEntity($entity,$data);
        
        if(!empty($items->errors())) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $items->user_id = $user['id'];
        $success=$advModel->save($items);
//        pr($success);die;
        
        
        
        
        $ad_spayc=array();
        $spayc_id=explode(",",$data['spayc_id']);
        foreach($spayc_id as $k=>$v){
        $advModel = TableRegistry::get('Api.SpaycAdvertisement');
        $entity = $advModel->newEntity();
        $entity->advertisement_id = $success->id;
        $entity->spayc_id = $v;
        $entity->modified = new \Cake\I18n\Time();
        $entity->created = new \Cake\I18n\Time();   
        $ad_spayc[]=$advModel->save($entity);
        }
         
        if(!count($ad_spayc)){
            $this->restException(['status'=>'failed', 'message'=>__('Advertisement could not be saved. Please, try again.')], 400);
        }
        $response = ['status'=>'success','message'=>__('Advertisement Created Successfully'),'data'=>$success];
        $this->set($response);
    }

}
