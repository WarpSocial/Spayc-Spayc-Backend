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
 * Spaycs Controller
 *
 * @property \Api\Model\Table\SpaycsTable $Spaycs
 *
 * @method \Api\Model\Entity\Spayc[] paginate($object = null, array $settings = [])
 */
class SpaycsController extends AppController {
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
    }
    
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow('matrixApplicationService');
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $data['type'] = !empty($data['type'])?ucfirst($data['type']):'';
        $data['group_type'] = !empty($data['group_type'])?ucfirst($data['group_type']):'';        
        $data['status'] = 'Active';
        
        $entity = $this->Spaycs->newEntity();
        $items = $this->Spaycs->patchEntity($entity, $data,['associated' => ['JoinedSpayc']]);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        
        $matrix = $this->Matrix->createRoom($data);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
        }
        $items->set('matrix_room_id',$matrix['room_id']);
        $items->set('matrix_room_alias',$matrix['room_alias']);
        $items->set('user_id', $this->Auth->user('id'));
        if (!$items->errors()) {
            if($this->Spaycs->save($items)) {
                //Joined the invite to the room//
                $this->Spaycs->joinedInvite($items,$items->id,$this->Auth->user('id'));
                if(!empty($items['description'])) {
                    TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
                }
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('Your spayc '.ucfirst($data['name']).', has been created.'),'data'=>$items];
                /*Event to bind to update the set upload room image */
                $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'image'=> $items->image,
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('The spayc could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('The spayc could not be saved. Please, try again.')], 400);
        }
        $this->set($response);
    }
    /**
     * createSubSpace method to create subspace
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function createSubSpace() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $data['group_type'] = !empty($data['group_type'])?ucfirst($data['group_type']):'';
        $data['status'] = 'Active';
        $errors = $this->Spaycs->validateSubspace($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $entity = $this->Spaycs->find()->where(['matrix_room_id'=>$data['parent_matrix_room_id']]);
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Parent space has not been found.')], 400);
        }
        $parentObj = $entity->first();
        $data['parent_id'] = $parentObj->id;
        $data['start_date'] = $parentObj->start_date;
        $data['end_date'] = $parentObj->end_date;
        $data['latitude'] = $parentObj->latitude;
        $data['longitude'] = $parentObj->longitude;
        $data['type'] = $parentObj->type;
        $items = $this->Spaycs->newEntity($data,['validate'=>false]);
        
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        
        $matrix = $this->Matrix->createRoom($data);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
        }
        $items->set('matrix_room_id',$matrix['room_id']);
        $items->set('matrix_room_alias',$matrix['room_alias']);
        $items->set('user_id', $this->Auth->user('id'));
        if (!$items->errors()) {
            if($this->Spaycs->save($items)){
              $data['image'] = $items->get('image');
              $data['matrix_room_id'] = $items->get('matrix_room_id');
              //Joined the invite to the room//
                $this->Spaycs->joinedInvite($items,$items->id,$this->Auth->user('id'));
                 if(!empty($items['description'])) {
                    TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
                }
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('SubSpayc Created Successfully'),'data'=>$data];
                /*Event to bind to update the set upload room image */
                $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'image'=> $items->get('image'),
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('Subspace could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('Subspace could not be saved. Please, try again.')], 400);
        }
        $this->set($response);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function createChatRoom() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['invite'])) {
            $this->restException(['status'=>'failed', 'message'=>'Invite is required field.'], 400);
        }
        $data['name'] = $data['invite'].'-'.$this->Auth->user('UserLogs.matrix_user_id');
        $data['group_type'] = 'trusted_private';
        $entity = $this->Spaycs->newEntity();
        $items = $this->Spaycs->patchEntity($entity, $data, ['validate'=>false]);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrixData = $data;
        $matrixData['name'] = '';
        $matrixData['visibility'] = 'private';
        $matrixData['is_direct'] = true;
        $matrix = $this->Matrix->createRoom($matrixData);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
        }
        $items->set('matrix_room_id', $matrix['room_id']);
        $items->set('matrix_room_alias', Utils::getVar('room_alias', $matrix));
        $items->set('user_id', $this->Auth->user('id'));
        $items->set('status', 'Active');
        if (!$items->errors()) {
            if($this->Spaycs->save($items)) {
                
                TableRegistry::get('Api.FriendRequest')->updateRoomId($items['invite'], $this->Auth->user('id'), $matrix['room_id']);
                $items['is_direct'] = true;
                $this->Spaycs->joinedInvite($items,$items->id,$this->Auth->user('id'));
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('Your room, '.ucfirst($data['name']).', has been created.'), 'data'=>$items];
                /*Event to bind to update the set upload room image */
                /*$event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);*/
            } else {
                $this->restException(['status'=>'failed', 'message'=>__('The spayc could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('The spayc could not be saved. Please, try again.')], 400);
        }
        $this->set($response);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        if(!$this->request->is('get')) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $userId = !empty($this->request->query('user_id'))?$this->request->query('user_id'):$this->Auth->user("id");
        $loggedUser = $this->Auth->user('id');
        
        $limit = (!empty($this->request->query('limit')) and is_numeric($this->request->query('limit')))?$this->request->query('limit'):5;
        $page = (!empty($this->request->query('page')) and is_numeric($this->request->query('page')))?$this->request->query('page'):1;
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        $lat = $this->request->getQuery('latitude',null);
        $long = $this->request->getQuery('longitude',null);
        
        if((empty($this->request->query('list_by')) || !in_array($this->request->query('list_by'), ['created', 'joined'])) || (!empty($lat) && !empty($long))) {
            if(!Utils::isValidLatitude($lat)) {
                $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
            }
            if(!Utils::isValidLongitude($long)) {
                $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
            }
        }
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id'])
            ->where(['status'=>'Active','parent_id IS'=>null,'Spaycs.group_type !='=>'trusted_private'])
            ->contain([                    
                'JoinedSpayc' => function($q) {
                    return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
                },
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                },
                'Comments' => function($q) {
                    return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
                }
            ]);
         if($lat != null && $long != null){
            $distance = $this->Spaycs->distanceInMiles;
            $spaycs->select(['distance'=>$distance])
                    ->bind(':lat', $lat, 'float')
                    ->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spaycs->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        } 
        
        $spaycs->limit($limit);
        if($this->request->query('list_by')=='created') {
            $spaycs->where(['Spaycs.user_id'=>$userId]);
        } else if($this->request->query('list_by')=='joined') {
            $ids = TableRegistry::get("Api.JoinedSpayc")->getJoinedSpaycIds($userId);
            $spaycs->where(['Spaycs.id IN'=>$ids]);
        }
        
        if($this->request->query('start_date')) {
            $date = new \Cake\I18n\Time($this->request->query('start_date'));
            $startDate = Utils::setUtc($date->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $spaycs->where(["Spaycs.start_date >="=>$startDate]);
        }
        
        if($this->request->query('end_date')) {
            $date = new \Cake\I18n\Time($this->request->query('start_date'));
            $endDate = Utils::setUtc($date->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $spaycs->where(["Spaycs.end_date <="=>$endDate]);
        }
        
        if(in_array(ucfirst($this->request->query('spayc_type')), ['Event', 'Community'])) {
            $spaycs->where(["Spaycs.type"=>ucfirst($this->request->query('spayc_type'))]);
        }
        
        if(in_array(ucfirst($this->request->query('group_type')), ['Public', 'Private'])) {
            $spaycs->where(["Spaycs.group_type"=>ucfirst($this->request->query('group_type'))]);
        }
        
        if($page < 0){
            $page = $page*-1;
            $spaycs->page($page);
        } else {
            $spaycs->page($page);
        }
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend,$userId,$loggedUser){
            return $results->map(function ($row) use($friend,$userId,$loggedUser) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row['friends'] = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                if(!empty($row['joined_spayc'])) {
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$loggedUser.'].status');
                }
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:null;
//                if($userId==$row['user_id']) {
//                    $row['joined_spayc_status'] = 'Joined';
//                }
                $row['is_joined'] = !empty($status[0])?true:false;
                $row['joined_users'] =  !empty($row['joined_spayc'])?count($row['joined_spayc']):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                unset($row['comments']);
                $row['total_presents'] = 0;
                return $row;
            });
        });
        
        //pr($spaycs->toArray());die;
        $newQuery = clone $spaycs;
        $data['count'] = $newQuery->all()->count();
        $data['spaycs'] = [];
        if(!$spaycs->isEmpty()) {
            $data['spaycs'] = $spaycs->toArray();
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success','message'=>__('Spayc lists.'), 'data'=>$data];
        $this->set($response);
    }

    /**
     * unSubscribeSpayc method to unsubscribe the user from the spayc
     * 
     * @param String|Number $spayc_id Either spayc id or matrix room id
     * @return Object Json object
     */
    public function subscribeSpayc() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $scModel = TableRegistry::get('Api.SubscribedUsers');
        $user = $this->Auth->user();
        $data['user_id'] = $user['id'];
        if(empty($data['spayc_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Spayc id is required fields.')], 400);
        }
        $data['spayc_id'] = ApiHasher::decrypt($data['spayc_id']);
        $spaycs = TableRegistry::get('Spaycs')->find('all',['fields'=>['id','matrix_room_id']])->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc id.')], 400);
        }
        $spayc = $spaycs->first();
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);
        if($entities->isEmpty()){
            $entity = $scModel->newEntity();
            $entity->user_id = $data['user_id'];
            $entity->spayc_id = $spayc->id;
            $entity->status = 'Active';
            $entity->modified = new \Cake\I18n\Time();
            $entity->created = new \Cake\I18n\Time();            
        }else{
            $entity = $entities->first();
            if($entity->status == 'Active'){
                $this->restException(['status'=>'failed','message'=>__('User has been already subscribed.')], 400);
            }
            $entity->status = 'Active';
            $entity->modified = new \Cake\I18n\Time();
        }        
        if($scModel->save($entity,['checkRules' => false, 'atomic' => false])){
            $response = ['status'=>'success','message'=>__('User has been subcribed successfully.')];
        }else{
            $response = ['status'=>'failed','message'=>__('System failed to subscribe the user.')];
        }
        $this->set($response);
    }
    
    /**
     * unSubscribeSpayc method to unsubscribe the user from the spayc
     * 
     * @param String|Number $spayc_id Either spayc id or matrix room id
     * @return Object Json object
     */
    public function unSubscribeSpayc(){
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $scModel = TableRegistry::get('Api.SubscribedUsers');
        $user = $this->Auth->user();
        $data['user_id'] = $user['id'];
        
        if(empty($data['spayc_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Spayc id is required fields.')], 400);
        }
        $spaycs = TableRegistry::get('Spaycs')->find()->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc id.')], 400);
        }
        $spayc = $spaycs->first();
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);        
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('User has not yet subscribed.')], 400);
        }
        $entity = $entities->first();           
        $entity->status = 'Inactive';
        $entity->modified = new \Cake\I18n\Time();
        $entity->updated_by = $this->Auth->user('id');
        if($scModel->save($entity,['checkRules' => false, 'atomic' => false])){
            $response = ['status'=>'success','message'=>__('User has been unsubcribed successfully.')];
        }else{
            $response = ['status'=>'failed','message'=>__('System failed to unsubscribe the user.')];
        }
        $this->set($response);
    }
    
    /**
     * View method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view() { 
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        if(empty($this->request->query('id'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Spayc id is required field.')], 400);
        }
        $lat = $this->request->getQuery('latitude',null);
        $long = $this->request->getQuery('longitude',null);
        //$id = ApiHasher::decrypt($this->request->query('id'));
        $id = $this->request->query('id');
        if($lat != null && !Utils::isValidLatitude($lat)) {
            $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
        }
        if($long != null && !Utils::isValidLongitude($long)) {
            $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
        }
        
        $exists = $this->Spaycs->exists(['OR'=>['matrix_room_id'=>$id,'id'=>$id]]);
        if(!$exists) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid spayc id.')], 400);
        }
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        
        $spayc = $this->Spaycs->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id'])
                ->where(['status'=>'Active', 'OR'=>['matrix_room_id'=>$id,'id'=>$id]])
                ->contain([
                    'SubSpaycs' => function($q) {
                        return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'SubSpaycs.location', 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id']);
                    },
                    'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    }
                ]);
        if($lat != null && $long != null){
            $distance = $this->Spaycs->distanceInMiles;
            $spayc->select(['distance'=>$distance])
                    ->bind(':lat', $lat, 'float')
                    ->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spayc->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        }        
        
        $spayc->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend, $userId) {
            return $results->map(function ($row) use($friend, $userId) {                
                $spaycId = ApiHasher::decrypt($row->id);
                $row['friends'] = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                //pj($row['joined_spayc']);die;
                if(!empty($row['joined_spayc'])) {
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.'].status');
                }
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:null;
//                if($userId==$row['user_id']) {
//                    $row['joined_spayc_status'] = 'Joined';
//                }
                $row['joined_users'] =!empty($row['joined_spayc'])?count($row['joined_spayc']):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                unset($row['comments']);
                $row['total_presents'] = 0;
                return $row;
            });
        });
        $data = [];
        if($spayc->count()) {
            $data = $spayc->first();            
            if($data->user_id == $userId){
                $data->is_admin = 1;
            }
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success', 'message'=>__('Spayc Details.'), 'data'=>$data];
        $this->set($response);
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
        $data = $this->request->getData();
        $data['group_type'] = !empty($data['group_type'])?ucfirst($data['group_type']):'';
        $data['type'] = !empty($data['type'])?ucfirst($data['type']):'';
        if(empty($data['spayc_id'])) {
            $this->restException(['status'=>'failed','message'=>'Spayc id is required.'], 400);
        }
        $entities = $this->Spaycs->find()->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc id.')], 400);
        }
        
        $entity = $entities->first();
        unset($data['spayc_id']);        
        $items = $this->Spaycs->patchEntity($entity, $data);        
        
        if(!empty($items->errors())) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrix = $this->Matrix->updateRoom($entity->matrix_room_id,$data);
        if(!$matrix) {
            $this->restException(['status' => "failed", 'message' =>__('Third party updation failed.')], 400);
        }
        
        if($items['description'] != $entity->description) {
            TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
        }
        
        if($this->Spaycs->save($items)){             
            $response = ['status'=>'success','message'=>__('The spayc has been updated successfully.'),'data'=>$items];
            /*Event to bind to update the set upload room image */
            $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                'options' => [
                    'matrix_token'=>$data['matrix_token'],
                    'image'=> $items->image,
                    'matrix_room_id'=> $items->matrix_room_id,
                    ]
            ]);
            EventManager::instance()->dispatch($event);
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
        if($id == null){
            $id = $this->request->query('id');
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Auth->user();
        $entity = $this->Spaycs->find()
                ->where(['OR'=>['id'=>$id,'matrix_room_id'=>$id],'user_id'=>$user['id']])
                ->contain('SubSpaycs');
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>'Record not found.'], 201);
        }
        $spayc = $entity->first();
        $this->loadComponent('Api.Matrix');
        
        $matrix = $this->Matrix->leaveRoom($spayc->matrix_room_id,$user['UserLogs']['matrix_access_token']);
//        pr($matrix);die;
//        if(!$matrix || !empty($matrix['error'])) {
//            if(empty($matrix['error'])){
//                $this->restException(['status' => "failed", 'message' =>__('Room not found.')], 400);
//            }else{
//                $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
//            }
//            
//        }
        $child = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.id');
        array_push($child,$spayc->id);     
        if ($this->Spaycs->delete($spayc)) {
            TableRegistry::get('Api.JoinedSpayc')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SubscribedUsers')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SpaycHashtags')->deleteAll(['spayc_id IN' => $child]);
            $response = ['status'=>'success','message'=>__('The spayc has been deleted.')];
        } else {
            $response = ['status'=>'failed','message'=>__('Spayc could not be deleted.')];
        }
         $this->set(compact('response'));
    }
    
    public function matrixApplicationService($id = null){
        $this->autoRender = false;
       // pr($this->request);
       Log::info(json_encode($this->request->data(),JSON_PRETTY_PRINT));
    }
    
    public function spaycMembers(){
        $spaycId = $this->request->getQuery('room_id');
        $status = $this->request->getQuery('status');
        $page = $this->request->getQuery('page');
        $limit = $this->request->getQuery('limit');
        if(empty($spaycId)){
             $this->restException(['status'=>'failed','message'=>'Invalid requested data.'], 400);
        }
        if(empty($limit)){
            $limit = Configure::read('pagelimit');
        }
        if(empty($page)){
            $page = 1;
        }
        $query = $this->Spaycs->spaycMember($spaycId,$status,$page,$limit);
        
        if(!$query){
            $this->response->statusCode(204);
            $response = ['status'=>'success', 'message'=>__('List of spayc member.'), 'data'=>[]];
        }else{
            $response = ['status'=>'success', 'message'=>__('List of spayc member.'), 'data'=>$query];
        }
        
        $this->set($response);
    }
    
    public function viewSubSpaycs(){
        $subspayc = $this->request->getQuery('spayc_id',null);
        $user = $this->Auth->user();
        if(empty($subspayc)){
             $this->restException(['status'=>'failed','message'=>'Sub-spayc is required.'], 400);
        }
        $lat = $this->request->getQuery('latitude',null);
        $long = $this->request->getQuery('longitude',null);
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',Configure::read('pagelimit'));
        $userId = $this->request->getQuery('user_id',$user['id']);
        $parentMatrixId = null;
        if(strstr($subspayc,':')){
            $parentSpayc = $this->Spaycs->findByMatrixRoomId($subspayc)->first();
            if(empty($parentSpayc)){
                $this->restException(['status'=>'failed','message'=>'Invalid subspayc id.'], 400);
            }
            $subspayc = $parentSpayc->id;
            $parentMatrixId = $parentSpayc->matrix_room_id;
        }else{ 
            $parentSpayc = $this->Spaycs->get($subspayc);
            if(empty($parentSpayc)){
                $this->restException(['status'=>'failed','message'=>'Invalid subspayc id.'], 400);
            }
            $parentMatrixId = $parentSpayc->matrix_room_id;
        }
        
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        $query = $this->Spaycs->find()
                ->select(['Spaycs.id', 'Spaycs.name', 'Spaycs.location', 'Spaycs.matrix_room_id', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.type', 'Spaycs.group_type', 'Spaycs.passcode','Spaycs.user_id'])
                ->where(['status'=>'Active','parent_id'=>$subspayc])                
                ->contain([
                    'JoinedSpayc' => function($q) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);                        
                    }
                ]);
        if($lat != null && $long != null){
            $distance = $this->Spaycs->distanceInMiles;
            $query->select(['distance'=>$distance])
                    ->bind(':lat', $lat, 'float')
                    ->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $query->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        }
        $query->limit($limit)->page($page);
        
        $result = $query->map(function ($row)use($friend,$userId) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                if(!empty($row->joined_spayc)) {
                    $status = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$userId.'].status');
                }
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:null;
//                if($userId==$row->user_id) {
//                    $row->joined_spayc_status = 'Approved';
//                }
                $row->is_joined = !empty($status[0])?true:false;
                $row->joined_users =  !empty($row->joined_spayc)?count($row->joined_spayc):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$userId.']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['total_comment'])?$row->comments[0]['total_comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of subspayc.','parent_spayc_id'=>$parentMatrixId,'data'=>$result];
        $this->set($response);
    }

}
