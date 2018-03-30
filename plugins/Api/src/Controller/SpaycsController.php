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
        $this->loadComponent('Api.Matrix');
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
        $items = $this->Spaycs->patchEntity($entity, $data);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        if($data['type'] == 'Community'){ /* in community no need to keep start or end date*/
            $items->start_date = '';
            $items->end_date = '';            
        }
        if($data['group_type'] == 'Public'){ /* in community no need to keep start or end date*/
            $items->passcode = '';
        }
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
                $this->restException(['status'=>'failed', 'message'=>__('The spayc couldDFS455HER45555dddadf55af444 not be saved. Please, try again.')], 400);
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
        $user = $this->Auth->user();
        $errors = $this->Spaycs->validateSubspace($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $entity = $this->Spaycs->find()->contain('JoinedSpayc',function($q)use($user){
            return $q->where(['user_id'=>$user['id']]);
        });
        if(preg_match("/[a-z]/i", $data['parent_matrix_room_id'])){
            $entity->where(['matrix_room_id'=>$data['parent_matrix_room_id']]);        
        }else{
            $entity->where(['id'=>$data['parent_matrix_room_id']]);
        }
                
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Parent space has not been found.')], 400);
        }
        
        $parentObj = $entity->first();
        if(empty($parentObj->joined_spayc)){
            $this->restException(['status'=>'failed','message'=>__('You don\'t have sufficient right to create subspace.')], 400);
        }
        if(!empty($parentObj->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Not allowd to create subspayc of subspayc.')], 400);
        }
        $data['parent_id'] = $parentObj->id;
        $data['start_date'] = $parentObj->start_date;
        $data['end_date'] = $parentObj->end_date;
        $data['latitude'] = $parentObj->latitude;
        $data['longitude'] = $parentObj->longitude;
        $data['type'] = $parentObj->type;
        $items = $this->Spaycs->newEntity($data,['validate'=>false]);
        
        
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
                $data['id'] = $items->id;
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
     * createChatRoom method for oneandone chat
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
                    return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.distance']);
                },
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                },
                'Comments' => function($q) {
                    return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
                }
            ]);
         if($lat != null && $long != null){
            $distance = str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles));
            $spaycs->select(['distance'=>$distance])
                    //->bind(':lat', $lat, 'float')
                    //->bind(':long', $long, 'float')
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
                 $present= 0;$totalJoined=[];
                if(!empty($row['joined_spayc'])) {
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$loggedUser.'].status');                
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:'';
//                if($userId==$row['user_id']) {
//                    $row['joined_spayc_status'] = 'Joined';
//                }
                $row['is_joined'] = !empty($status[0])?true:false;
                $row['joined_users'] =  !empty($row['joined_spayc'])?count($totalJoined):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                unset($row['comments']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        
        //pr($spaycs->toArray());die;
        //$newQuery = clone $spaycs;
        $data['count'] = $spaycs->count();
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
        $spaycs = TableRegistry::get('Api.Spaycs')->find('all',['fields'=>['id','matrix_room_id']])->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc id.')], 400);
        }
        $spayc = $spaycs->first();
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);
        if(!$entities->isEmpty()){
             $this->restException(['status'=>'failed','message'=>__('User has been already subscribed.')], 400);
        }
        $entity = $scModel->newEntity();
        $entity->user_id = $data['user_id'];
        $entity->spayc_id = $spayc->id;
        //$entity->status = 'Active';
        $entity->modified = new \Cake\I18n\Time();
        $entity->created = new \Cake\I18n\Time();            
                
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
        $spaycs = TableRegistry::get('Api.Spaycs')->find()->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc id.')], 400);
        }
        $spayc = $spaycs->first();
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);        
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('User has not yet subscribed.')], 400);
        }
        $entity = $entities->first();           
//        $entity->status = 'Inactive';
//        $entity->modified = new \Cake\I18n\Time();
//        $entity->updated_by = $this->Auth->user('id');
        if($scModel->delete($entity)){
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
            $this->restException(['status'=>'failed', 'message'=>__('This spayc is no longer exist.')], 400);
        }
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        
        $spayc = $this->Spaycs->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.parent_id','Spaycs.created','Spaycs.modified'])
                ->where(['status'=>'Active', 'OR'=>['matrix_room_id'=>$id,'id'=>$id]])
                ->contain([
                    'SubSpaycs' => function($q) {
                    $exp = $q->newExpr()->addCase($q->newExpr()->add(['location IS NULL']),"");
                        return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'location'=>$exp, 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id']);
                    },
                    'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
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
                $row->created = Utils::toClient($row->created);
                $row->modified = Utils::toClient($row->modified);
                $spaycId = ApiHasher::decrypt($row->id);
                $row['friends'] = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $present = 0;$totalJoined=[];
                if(!empty($row['joined_spayc'])) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.']');
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }
                if(!empty($row['sub_spaycs'])) {
                    foreach($row['sub_spaycs'] as $key=>$subSpayc) {
                        if(!empty($subSpayc->start_date)) {
                            $sd = new Time($subSpayc->start_date,'UTC');
                            $row['sub_spaycs'][$key]['start_date'] = $sd->setTimezone(Configure::read('timezone'))->format('m-d-Y H:i:s');              }
                        if(!empty($subSpayc->end_date)) {
                            $sd = new Time($subSpayc->end_date,'UTC');
                            $row['sub_spaycs'][$key]['end_date'] = $sd->setTimezone(Configure::read('timezone'))->format('m-d-Y H:i:s');                }
                    }
                }
                if(!empty($joinedStatus[0])){
                    $row['joined_spayc_status'] = $joinedStatus[0]['status'];
                    $row['is_admin'] = $joinedStatus[0]['is_admin'];
                }else{
                    $row['joined_spayc_status'] = '';
                    $row['is_admin'] = '';
                }
                $row['joined_users'] =!empty($row['joined_spayc'])?count($totalJoined):0;
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                unset($row['comments'],$row['joined_spayc']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        $data = [];        
        if(!$spayc->isEmpty()) {
            $data = $spayc->first();                        
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
        $user = $this->Auth->user();
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
        if($user['id'] != $entity->user_id){
            $this->restException(['status'=>'failed','message'=>__('Insufficient privileges to edit this space.')], 400);
        }        
        unset($data['spayc_id']);        
        $items = $this->Spaycs->patchEntity($entity, $data);       
        if($data['type'] == 'Community'){ /* in community no need to keep start or end date*/
            $items->start_date = '';
            $items->end_date = '';
        }
        if($data['group_type'] == 'Public'){ /* in community no need to keep start or end date*/
            $items->passcode = '';
        }
        if(!empty($items->errors())) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrix = $this->Matrix->updateRoom($entity->matrix_room_id,$data);
        if(!$matrix) {
            $this->restException(['status' => "failed", 'message' =>__('Third party updation failed.')], 400);
        }
        
        if($items['description'] != $entity->description) {
            TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
        }
        if($this->Spaycs->save($items)){  
            $items = $items->toArray();
            $items['start_date']=  Utils::toClient($items['start_date']);
            $items['end_date'] = Utils::toClient($items['end_date']);
            $response = ['status'=>'success','message'=>__('The spayc has been updated successfully.'),'data'=>$items];
            /*Event to bind to update the set upload room image */
            $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                'options' => [
                    'matrix_token'=>$data['matrix_token'],
                    'image'=> $items['image'],
                    'matrix_room_id'=> $items['matrix_room_id'],
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
        if (!$this->request->is(['post','delete'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        if($id == null){
            $id = $this->request->query('id');
        } 
        $user = $this->Auth->user();
        $entity = $this->Spaycs->find()
                ->where(['OR'=>['id'=>$id,'matrix_room_id'=>$id],'user_id'=>$user['id']])
                ->contain('SubSpaycs');
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $spayc = $entity->first();
        
        $matrixRoomIds = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.matrix_room_id');
        array_push($matrixRoomIds, $spayc->matrix_room_id);
        $child = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.id');        
        array_push($child,$spayc->id);  
        $this->Matrix->deleteRoom($matrixRoomIds);
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
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
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
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
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
                $this->restException(['status'=>'failed','message'=>'This subspayc is no longer exist.'], 400);
            }
            $subspayc = $parentSpayc->id;
            $parentMatrixId = $parentSpayc->matrix_room_id;
        }else{ 
            $parentSpayc = $this->Spaycs->get($subspayc);
            if(empty($parentSpayc)){
                $this->restException(['status'=>'failed','message'=>'This subspayc is no longer exist.'], 400);
            }
            $parentMatrixId = $parentSpayc->matrix_room_id;
        }
        
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        $query = $this->Spaycs->find()
                ->select(['Spaycs.id', 'Spaycs.name', 'Spaycs.location','Spaycs.description', 'Spaycs.matrix_room_id', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.type', 'Spaycs.group_type', 'Spaycs.passcode','Spaycs.user_id','Spaycs.parent_id'])
                ->where(['status'=>'Active','parent_id'=>$subspayc])                
                ->contain([
                    'JoinedSpayc' => function($q) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
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
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$userId.']');
                    $totalJoined = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[status=Joined].status');
                }
                $row->is_joined = false;
                if(!empty($joinedStatus[0])){
                    $row->joined_spayc_status = $joinedStatus[0]['status'];
                    if($row->joined_spayc_status == 'Joined'){
                        $row->is_joined = true;
                    }
                    $row->is_admin = $joinedStatus[0]['is_admin'];
                }else{
                    $row->joined_spayc_status = '';
                    $row->is_admin = '';
                }                
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
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
    
    /**
     * nearAboutSpayces method to get the spayces which is within 1 miles
     */
    
    public function nearAboutSpayces(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $pquery = $pquery->first();
            $userLat = $pquery->current_latitude;
            $userLong = $pquery->current_longitude;
        }else{
            $userLat = $user['latitude'];
            $userLong = $user['longitude'];
        }
                
        
        $lat = $this->request->getQuery('latitude',$userLat);
        $long = $this->request->getQuery('longitude',$userLong);
        $errors = TableRegistry::get('Api.Users')->validateLatLong(['latitude'=>$lat,'longitude'=>$long]); 
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>__('Latitude and Longitude is not updated.Either update the user current status or provide the latitude and longitude.')], 400);
        }
        $page = 1;
        $limit = Configure::read('pagelimit');
        
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
        $distance = Configure::read('miles');
        $joinedSpayces = TableRegistry::get('Api.JoinedSpayc')->find()->where(['JoinedSpayc.user_id'=>(int)$user['id'],'distance <='=>$distance,'JoinedSpayc.status'=>'Joined']);
        if($joinedSpayces->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $ids = \Cake\Utility\Hash::extract($joinedSpayces->toArray(), '{n}.spayc_id');
        $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id'])
            ->where(['status'=>'Active','parent_id IS'=>null,'Spaycs.group_type !='=>'trusted_private','Spaycs.id IN'=>$ids,'start_date >'=>$date])
            ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);                        
                    }
                ]);
      
        if(!empty($lat) && !empty($long)){
            $distance = $this->Spaycs->distanceInMiles;
            $spaycs->select(['distance'=>$distance])
                    ->bind(':lat', $userLat, 'float')
                    ->bind(':long', $userLong, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spaycs->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        }
        $spaycs->limit($limit)->page($page);
        $result = $spaycs->map(function ($row)use($friend,$user) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$user['id'].']');
                    $totalJoined = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[status=Joined].status');
                }
                $row->is_joined = false;
                if(!empty($joinedStatus[0])){
                    $row->joined_spayc_status = $joinedStatus[0]['status'];
                    if($row->joined_spayc_status == 'Joined'){
                        $row->is_joined = true;
                    }
                    $row->is_admin = $joinedStatus[0]['is_admin'];
                }else{
                    $row->joined_spayc_status = '';
                    $row->is_admin = '';
                } 
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$user['id'].']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['total_comment'])?$row->comments[0]['total_comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }
    
    /**
     * publicSpayc method to get the public and joined spayces
     * End point map-spaycs for Advertisement
     */
    
    public function mapSpayc(){
         if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;
        }else{
            $lat = $user['latitude'];
            $long = $user['longitude'];
        }
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',Configure::read('pagelimit'));
        $spayc=TableRegistry::get('Api.Spaycs')->getNearBySpaycsOnMap($this->request->getQuery(),$user['id']);
        $friends = TableRegistry::get('Api.FriendRequest')->getNearByFriendsOnMap($this->request->getQuery(), $user['id']);
        print_R($friends);die;
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
        $distance = Configure::read('miles');
        $array = \Cake\Utility\Hash::extract($data['records'], '{n}.spayc_hashtags');
        $temp =[];
        if(!$data['count']){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        foreach ($array as $key => $value) {
           foreach ($value as $key_1 => $value_1) {
              array_push($temp, $value_1['spayc_id']);
           }
        }
        $ids=array_unique($temp);
        if(!$ids){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id'])
            ->where(['status'=>'Active','parent_id IS'=>null,'Spaycs.group_type ='=>'Public','Spaycs.id IN'=>$ids])
            ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);                        
                    }
                ]);
      
        if(!empty($lat) && !empty($long)){
            $distance = $this->Spaycs->distanceInMiles;
            $spaycs->select(['distance'=>$distance])
                    ->bind(':lat', $lat, 'float')
                    ->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spaycs->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        }
        $spaycs->limit($limit)->page($page);
        $result = $spaycs->map(function ($row)use($friend,$user) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                     $totalJoined = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[status=Joined].status');
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$user['id'].']');
                }
                $row->is_joined = false;
                if(!empty($joinedStatus[0])){
                    $row->joined_spayc_status = $joinedStatus[0]['status'];
                    if($row->joined_spayc_status == 'Joined'){
                        $row->is_joined = true;
                    }
                    $row->is_admin = $joinedStatus[0]['is_admin'];
                }else{
                    $row->joined_spayc_status = '';
                    $row->is_admin = '';
                } 
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$user['id'].']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['total_comment'])?$row->comments[0]['total_comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }
    
    /**
     * publicSpayc method to get the public and joined spayces
     * End point public-spaycs for Advertisement
     */
    
    public function publicSpayc(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',Configure::read('pagelimit'));
        
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
        $distance = Configure::read('miles');
        $joinedSpayces = TableRegistry::get('Api.JoinedSpayc')->find()->where(['JoinedSpayc.user_id'=>(int)$user['id'],'JoinedSpayc.status'=>'Joined']);
        if($joinedSpayces->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $ids = \Cake\Utility\Hash::extract($joinedSpayces->toArray(), '{n}.spayc_id');
         $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','distance'=>0])
            ->where(['status'=>'Active','parent_id IS'=>null,'Spaycs.group_type ='=>'Public','Spaycs.id IN'=>$ids,'start_date >'=>$date])
            ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);                        
                    }
                ]);
        $spaycs->order(['created'=>'DESC']);
        
        $spaycs->limit($limit)->page($page);
        $result = $spaycs->map(function ($row)use($friend,$user) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                    $totalJoined = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[status=Joined].status');
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$user['id'].']');
                }
                $row->is_joined = false;
                if(!empty($joinedStatus[0])){
                    $row->joined_spayc_status = $joinedStatus[0]['status'];
                    if($row->joined_spayc_status == 'Joined'){
                        $row->is_joined = true;
                    }
                    $row->is_admin = $joinedStatus[0]['is_admin'];
                }else{
                    $row->joined_spayc_status = '';
                    $row->is_admin = '';
                } 
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$user['id'].']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['total_comment'])?$row->comments[0]['total_comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }
    /**
     * hashTagSpayc method to get the public and joined spayces
     * End point hastag-spaycs
     */
    
    public function hashTagSpayc(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;
        }else{
            $lat = $user['latitude'];
            $long = $user['longitude'];
        }
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',Configure::read('pagelimit'));
        $data=TableRegistry::get('Api.Hashtags')->spaceHashtags($this->request->getQuery());
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
        $distance = Configure::read('miles');
        $array = \Cake\Utility\Hash::extract($data['records'], '{n}.spayc_hashtags');
        $temp =[];
        if(!$data['count']){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        foreach ($array as $key => $value) {
           foreach ($value as $key_1 => $value_1) {
              array_push($temp, $value_1['spayc_id']);
           }
        }
        $ids=array_unique($temp);
        if(!$ids){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id'])
            ->where(['status'=>'Active','parent_id IS'=>null,'Spaycs.group_type ='=>'Public','Spaycs.id IN'=>$ids])
            ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);                        
                    }
                ]);
      
        if(!empty($lat) && !empty($long)){
            $distance = $this->Spaycs->distanceInMiles;
            $spaycs->select(['distance'=>$distance])
                    ->bind(':lat', $lat, 'float')
                    ->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spaycs->select(['distance'=>0])
                    ->order(['created'=>'DESC']);
        }
        $spaycs->limit($limit)->page($page);
        $result = $spaycs->map(function ($row)use($friend,$user) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                     $totalJoined = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[status=Joined].status');
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$user['id'].']');
                }
                $row->is_joined = false;
                if(!empty($joinedStatus[0])){
                    $row->joined_spayc_status = $joinedStatus[0]['status'];
                    if($row->joined_spayc_status == 'Joined'){
                        $row->is_joined = true;
                    }
                    $row->is_admin = $joinedStatus[0]['is_admin'];
                }else{
                    $row->joined_spayc_status = '';
                    $row->is_admin = '';
                } 
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$user['id'].']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['total_comment'])?$row->comments[0]['total_comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }

}
