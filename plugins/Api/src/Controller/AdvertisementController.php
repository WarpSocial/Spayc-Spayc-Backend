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
        if (!$this->request->is(['put', 'patch', 'post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $data['name'] = !empty($data['name']) ? ucfirst($data['name']) : '';
        if (empty($data['id'])) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement id is required.'], 400);
        }
        $entities = $this->Advertisement->find()->where(['id' => $data['id']]);

        if ($entities->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => __('Invalid Advertisement id.')], 400);
        }

        $entity = $entities->first();
        if($user['id'] != $entity->user_id){
            $this->restException(['status'=>'failed','message'=>__('Insufficient privileges to edit this Advertisement.')], 400);
        }        
        unset($data['id']);        
        
        
        // Check IF Exist (Public || Private)
           $exist = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                [
                    'table' => 'joined_spayc',
                    'alias' => 'JoinedSpayc',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Spaycs.id = JoinedSpayc.spayc_id',
                    ]
                ]
            )->where(['OR'=>
                    [
                        ['Spaycs.id IN ('.$data['spayc_id'].')', 'JoinedSpayc.user_id'=>$user['id'], 'JoinedSpayc.status'=>'Joined','Spaycs.group_type'=>'Private'],
                    ['Spaycs.id IN ('.$data['spayc_id'].')','Spaycs.group_type'=>'Public']]])
                ->distinct(['Spaycs.id']);
        $spayc_id=explode(",",$data['spayc_id']);
//        print_R($exist->toArray());die;
        if(count($exist->toArray()) != count($spayc_id)){
              $this->restException(['status'=>'failed', 'message'=> __('Not Authorized to Create Ad in listed Spaycs.')], 400);
        }
        // Check IF Exist 
        $items = $this->Advertisement->patchEntity($entity, $data);       
       
        if(!empty($items->errors())) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        unset($data['id']);

        $items = $this->Advertisement->patchEntity($entity, $data);

        if (!empty($items->errors())) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($items->errors())], 400);
        }

        if (!$this->isCurrency($data['price'])) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid Price.')], 400);
        }
        if (isset($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $this->restException(['status'=>'failed', 'message'=> __('Enter Valid URL.')], 400);
        } 
        
        $items->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");   
        $items->expired = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");   
        
        
        
        if($success=$this->Advertisement->save($items)){  
            $success->created= Utils::toClient($success->created);
             TableRegistry::get('Api.SpaycAdvertisement')->deleteAll(['advertisement_id' => $success->id]);
            // Saving Ad into Spayc_Ad 
            $ad_spayc=array();
            $spayc_id=explode(",",$data['spayc_id']);
            foreach($spayc_id as $k=>$v){
            $advModel = TableRegistry::get('Api.SpaycAdvertisement');
            $entity = $advModel->newEntity();
            $entity->advertisement_id = $success->id;
            $entity->spayc_id = $v;
            $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");   
            $created=$advModel->save($entity);
            $ad_spayc[]=$v;
        }
            // Saving Ad into Spayc_Ad 
        
         if(!count($ad_spayc)){
            $this->restException(['status'=>'failed', 'message'=>__('Advertisement could not be saved. Please, try again.')], 400);
        }
        $success['created_spayc']= implode(",",$ad_spayc);
        
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
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }
        if ($id == null) {
            $id = $this->request->query('id');
        }
        $user = $this->Auth->user();
        $entity = $this->Advertisement->find()
                ->where(['id' => $id, 'user_id' => $user['id']]);
        if ($entity->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Record not found.'], 404);
        }
        $ad = $entity->first();
        $id = $ad->id;
//        print_R($ad);die;
        if ($this->Advertisement->delete($ad)) {
            TableRegistry::get('Api.SpaycAdvertisement')->deleteAll(['advertisement_id' => $id]);
            $response = ['status' => 'success', 'message' => __('Advertisement has been deleted.')];
        } else {
            $response = ['status' => 'failed', 'message' => __('Advertisement could not be deleted.')];
        }
        $this->set(compact('response'));
    }

    /**
     * publicSpayc method to get the public and joined spayces
     * End point map-spaycs for Advertisement
     */
    public function viewAdvertisement() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }

        if (empty($this->request->query('id'))) {
            $this->restException(['status' => 'failed', 'message' => __('Advertisement id is required field.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.Advertisement')->findById($this->request->getQuery('id',null))
                ->select(['id','name','user_id','image','price','description','url','status','expired']);
        
        if($pquery->toArray()){
         
        $data=$pquery->toArray();
         if($data[0]->user_id != $user['id']) {
            $this->restException(['status'=>'failed', 'message'=>__('Not Authorized to view that Advertisement.')], 400);
        }
        unset($data[0]->user_id);
        
        $entity = TableRegistry::get('Api.Spaycs')->find('all',['fields'=>[
//                 'distance' => $distanceField,
                            'Spaycs.name', 'Spaycs.id', 'Spaycs.type', 'Spaycs.image']])->join(
                    [
                        'table' => 'spayc_advertisement',
                        'type' => 'INNER',
                        'conditions' => [
                            'Spaycs.id = spayc_advertisement.spayc_id',
                            'spayc_advertisement.advertisement_id' => $data[0]->id
                        ]
                    ]
            );
            $spayc = $entity->toArray();
            $array['advertisement'] = $data[0];
            if ($spayc)
                $array['spaycs'] = $spayc;
            $response = ['status' => 'success', 'message' => 'Advertisement Details', 'data' => $array];
        }else {
            $response = ['status' => 'failed', 'message' => __('No Advertisement found')];
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
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();

        $user = $this->Auth->user();

        $entity = TableRegistry::get('Api.Spaycs')->find()->contain('JoinedSpayc', function($q)use($user) {
            return $q->where(['user_id' => $user['id']]);
        });

        $advModel = TableRegistry::get('Api.Advertisement');

        $entity = $advModel->newEntity();
        //pr($this->request->getData());
//        echo $data['spayc_id'];die;
        $exist = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'joined_spayc',
                            'alias' => 'JoinedSpayc',
                            'type' => 'LEFT',
                            'conditions' => [
                                'Spaycs.id = JoinedSpayc.spayc_id',
                            ]
                        ]
                )->where(['OR' =>
                    [
                        ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'JoinedSpayc.user_id' => $user['id'], 'JoinedSpayc.status' => 'Joined', 'Spaycs.group_type' => 'Private'],
                        ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'Spaycs.group_type' => 'Public']]])
                ->distinct(['Spaycs.id']);
        $spayc_id = explode(",", $data['spayc_id']);
//        print_R($exist->toArray());die;
        if (count($exist->toArray()) != count($spayc_id)) {
            $this->restException(['status' => 'failed', 'message' => __('Not Authorized to Create Ad in listed Spaycs.')], 400);
        }
        $data['spaycs'] = ['_ids' => [1]];
        $items = $advModel->patchEntity($entity, $data);

        if (!empty($items->errors())) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($items->errors())], 400);
        }

        if (!$this->isCurrency($data['price'])) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid Price.')], 400);
        }
        if (isset($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $this->restException(['status'=>'failed', 'message'=> __('Enter Valid URL.')], 400);
        } 
        

        //Fetcing Plan 
        $pquery = TableRegistry::get('Api.Plans')->findById($data['plan_id']);
         
        if($pquery->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Plan not found.'], 404);
        }
        $plan=$pquery->first();
        $items->user_id = $user['id'];
        $items->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
        $items->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");   
//        print_R($plan);die;
        $items->views = $plan['views'];
        $items->balance = $plan['views'];
        $items->status = 'Active';
        $success=$advModel->save($items);
//        pr($success);die;




        $ad_spayc = array();
        $spayc_id = explode(",", $data['spayc_id']);
        foreach ($spayc_id as $k => $v) {
            $advModel = TableRegistry::get('Api.SpaycAdvertisement');
            $entity = $advModel->newEntity();
            $entity->advertisement_id = $success->id;
            $entity->spayc_id = $v;
            $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $created = $advModel->save($entity);
            $ad_spayc[] = $v;
        }
        
        //Saving into the Purchase
        if($success->id){
            $purchaseModel = TableRegistry::get('Api.Purchase');
        $entity = $purchaseModel->newEntity();
        $entity->advertisement_id = $success->id;
        $entity->plan_id = $data['plan_id'];
        $entity->receipt = $data['receipt'];
        $entity->amount = $plan['amount'];
        $entity->platform = $data['platform'];
        if(isset($data['purchase_date']) && $data['purchase_date'])
        $entity->purchase_date = $data['purchase_date'];
        $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
        $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");   
//        print_r($entity);die;
        $purchase=$purchaseModel->save($entity);
        }
         
        if(!count($ad_spayc)){
            $this->restException(['status'=>'failed', 'message'=>__('Advertisement could not be saved. Please, try again.')], 400);
        }
        $success['created_spayc'] = implode(",", $ad_spayc);
        $response = ['status' => 'success', 'message' => __('Advertisement Created Successfully'), 'data' => $success];
        $this->set($response);
    }

    public function userAdvertisement() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }

        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.Advertisement')->findByUserId($user['id'])
                ->select(['id','name','image','price','description','url','status','expired']);
         
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',Configure::read('pagelimit'));
        $pquery->limit($limit)->page($page);
        $pquery->order(['created' => 'DESC']);

        if ($pquery->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Record not found.'], 404);
        }
        if ($pquery->toArray()) {
            $data = $pquery->toArray();
            $response = ['status' => 'success', 'message' => 'List of Advertisement.', 'data' => $data];
        } else {
            $response = ['status' => 'failed', 'message' => __('No Advertisement found')];
        }



        $this->set($response);
    }

    public function isCurrency($number) {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }
    

}
