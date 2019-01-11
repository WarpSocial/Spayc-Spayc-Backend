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
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;

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
        $this->loadComponent('Api.Redis');
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
        //$this->Matrix->uploadMediaImage($data);die(" #END#");
        $data['type'] = !empty($data['type'])?ucfirst($data['type']):'';
        $data['group_type'] = !empty($data['group_type'])?ucfirst($data['group_type']):'';        
        $data['status'] = ACTIVE;
        
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
                $this->Redis->addSpayc($items);
                $items->job_type = 'new-spayc';
                $items->created_duration = Utils::toClient($items->created);
                TableRegistry::get('Queue.QueuedJobs')->createJob('Generic',$items->toArray());
                //Joined the invite to the room//
                $this->Spaycs->joinedInvite($items,$items->id,$this->Auth->user('id'));
                if(!empty($items['description'])) {
                    TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
                }
                $items->created = Utils::toClient($items->created);
                $items->modified = Utils::toClient($items->modified);
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('Your warp '.ucfirst($data['name']).', has been created.'),'data'=>$items];
                /*Event to bind to update the set upload room image */
                /*$event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'image'=> $items->image,
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);
                 * 
                 */
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('The warp could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('The warp could not be saved. Please, try again.')], 400);
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
            return $q->where(['user_id'=>$user['id'],'status'=>'Joined']);
        });
        $entity->where($this->Spaycs->spaycPk($data['parent_matrix_room_id']));
        $entity->where(['group_type !='=>'trusted_private']);        
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Parent warp is no longer available.')], 400);
        }
        
        $parentObj = $entity->first();
        if(!empty($parentObj->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Warp inside subwarp is not allowed.')], 400);
        }
        if(empty($parentObj->joined_spayc)){
            $this->restException(['status'=>'failed','message'=>__('You don\'t have sufficient right to create subwarp.')], 400);
        }
       
        $data['parent_id'] = $parentObj->id;
        $data['start_date'] = $parentObj->start_date;
        $data['end_date'] = $parentObj->end_date;
        $data['latitude'] = $parentObj->latitude;
        $data['longitude'] = $parentObj->longitude;
        $data['type'] = $parentObj->type;
        $data['location'] = $parentObj->location;
        $data['spayc_category_id'] = $parentObj->spayc_category_id;
        $items = $this->Spaycs->newEntity($data,['validate'=>false]);
        
        if($data['group_type'] == 'Public'){ /* in community no need to keep start or end date*/
            $data['passcode'] = '';
            $items->set('passcode', '');
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
            if($this->Spaycs->save($items)){
                $this->Redis->addSpayc($items);
                $data['image'] = $items->get('image');
                $data['matrix_room_id'] = $items->get('matrix_room_id');
                //Joined the invite to the room//
                $this->Spaycs->joinedInvite($items,$items->id,$this->Auth->user('id'));
                 if(!empty($items['description'])) {
                    TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
                }
                $this->response->statusCode(201);
                $data['id'] = $items->id;
                $response = ['status'=>'success','message'=>__('Subwarp Created Successfully'),'data'=>$data];
                /*Event to bind to update the set upload room image */
               /* $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'image'=> $items->get('image'),
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);
                * 
                */
            }else{
                $this->restException(['status'=>'failed', 'message'=>__('Subwarp could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('Subwarp could not be saved. Please, try again.')], 400);
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
        $nameSwaped = $this->Auth->user('UserLogs.matrix_user_id').'-'.$data['invite'];
        if($this->Spaycs->exists(['OR'=>[['name'=>$data['name']],['name'=>$nameSwaped]]])){
            $this->restException(['status'=>'failed','message'=>__('One & One chat already initiated between you.')], 400);
        }
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
                $this->Matrix->joinRoom(['status'=>JOINED,'matrix_token'=>$data['matrix_token'],'matrix_room_id'=>$matrix['room_id']]);
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
                $this->restException(['status'=>'failed', 'message'=>__('The warp could not be saved. Please, try again.')], 400);
            }
        } else {
            $this->restException(['status'=>'failed', 'message'=>__('The warp could not be saved. Please, try again.')], 400);
        }
        $this->set($response);
    }

    /**
     * Index method to list the spayc and filter based on some keyword
     * 
     * @endpoint spaycs.json?page=:page&limit=5&latitude=28.4594965&longitude=77.0266383
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
        $spaycs = $this->Spaycs->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.spayc_category_id','distance'=>0])
            ->where(['Spaycs.status'=>'Active','Spaycs.parent_id IS'=>null,'Spaycs.group_type !='=>'trusted_private'])
            ->contain([                    
                'JoinedSpayc' => function($q) {
                    return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.distance'])->where(['JoinedSpayc.status !='=>'Banned']);
                //return $q->select(['JoinedSpayc.spayc_id','total_joined'=>$q->func()->count('JoinedSpayc.id')])->group('JoinedSpayc.spayc_id');
                },
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                },
                'Comments' => function($q) {
                    return $q->select(['Comments.spayc_id', 'Comments.comment']);
                },
                'SpaycCategories' => function($q) {
                    return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
                }
            ]);
        $bannedSpayc = $this->Spaycs->bannedSpayc($loggedUser);    
        if(!empty($bannedSpayc)){
            $spaycs->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                return $exp->notIn('Spaycs.id', $bannedSpayc);
             });
        }
         if($lat != null && $long != null){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles))." AS numeric), 3)";
            $spaycs->select(['distance'=>$distance]);
            if(!empty($this->request->getQuery('radius'))){
                $radius = $this->request->getQuery('radius');
                $spaycs->where(function (QueryExpression $exp) use ($distance,$radius) {
                    return $exp->lte($distance,$radius);
                });
            }
            $spaycs->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else if(!empty($this->request->query('hot'))) {
            
        }else{
            $spaycs->order(['Spaycs.created'=>'DESC']);
        } 
        #pr($spaycs->toArray());die;
        $spaycs->limit($limit);
        if($this->request->query('list_by')=='created') {
            $spaycs->where(['Spaycs.user_id'=>$userId]);
        } else if($this->request->query('list_by')=='joined') {
            $ids = TableRegistry::get("Api.JoinedSpayc")->getJoinedSpaycIds($userId);
            $spaycs->where(['Spaycs.id IN'=>$ids]);
        }
        $startDate = "TO_TIMESTAMP(cast(Spaycs.start_date as text),'YYYY-MM-DD HH24:MI')"; 
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD HH24:MI')"; 
        if(!empty($this->request->query('date'))) {
            if(!Utils::validTimestamp($this->request->query('date'))){
                 $this->restException(['status'=>'failed','message'=>__('Date format is not valid.')], 400);
            }
 
            $user_date = Time::createFromTimestamp($this->request->query('date'), Configure::read('timezone'));
            $endObj = clone $user_date;            
            $endObj->modify('+1 days');
            $endObj->modify('1 second ago'); 
            $dayStart = $user_date->setTimezone('UTC')->format("Y-m-d H:i");
            $endDay = $endObj->setTimezone('UTC')->format("Y-m-d H:i");  
            $spaycs->where([
                'OR'=>[[$startDate.' >='=>$dayStart],[$endDate.' >= '=>$dayStart]]
                ]);
            $spaycs->where([
                'OR'=>[[$startDate.' <='=>$endDay],[$endDate.' <= '=>$endDay]]
                ]);
        }
        
        if(in_array(ucfirst($this->request->query('spayc_type')), ['Event', 'Community'])) {
            $spaycs->where(["Spaycs.type"=>ucfirst($this->request->query('spayc_type'))]);
        }
        
        if(!empty($this->request->query('payment_type'))) {
           if(strtolower($this->request->query('payment_type')) == strtolower(FREE)){
                $spaycs->where(["LOWER(Spaycs.payment_type)"=> strtolower($this->request->query('payment_type'))]);
            }
        }
        
        if(in_array(ucfirst($this->request->query('group_type')), ['Public', 'Private'])) {
            $spaycs->where(["Spaycs.group_type"=>ucfirst($this->request->query('group_type'))]);
        }
        if(!empty($this->request->query('categories'))) {
            $cats = explode(',',$this->request->query('categories'));
            $spaycs->where(["Spaycs.spayc_category_id IN"=>$cats],['spayc_category_id' => 'integer[]']);
        }
        if(!empty($this->request->query('friends')) && $this->request->query('friends') == 'yes') {
            $subQuery = $this->Spaycs->spaycWithFriends($loggedUser);
            $spaycs->where(["Spaycs.id IN"=>$subQuery]);
        }
        if(!empty($this->request->query('hot')) && (strtolower($this->request->query('hot')) == 'yes')) {
           $spaycs->select(['joined_user'=>$spaycs->func()->count('JoinedSpayc.spayc_id')]);
           $spaycs->leftJoinWith('JoinedSpayc',function($q){
               return $q->where(['JoinedSpayc.status'=>JOINED]);
           });
           $spaycs->group(['Spaycs.id, Spaycs.name,Spaycs.user_id, Spaycs.location, Spaycs.image, Spaycs.group_type, Spaycs.type,Spaycs.start_date,
Spaycs.end_date,Spaycs.passcode,Spaycs.matrix_room_id,Spaycs.spayc_category_id,SpaycCategories.id,SpaycCategories.name,Spaycs.created']);
           $spaycs->order(['joined_user'=>'DESC','distance'=>'ASC','Spaycs.created'=>'DESC'],Query::OVERWRITE);
        }
        if($page < 0){
            $page = $page*-1;
            $spaycs->page($page);
        } else {
            $spaycs->page($page);
        }
        //pj($spaycs->toArray());die;
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
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:'Not_Joined';
//                if($userId==$row['user_id']) {
//                    $row['joined_spayc_status'] = 'Joined';
//                }
                $row['is_joined'] = !empty($status[0])?true:false;
                $row['joined_users'] =  !empty($row['joined_spayc'])?count($totalJoined):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$loggedUser.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['comment'])?$row['comments'][0]['comment']:0;
                unset($row['comments']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        
        #pr($spaycs->toArray());die;
        //$newQuery = clone $spaycs;
        $data['count'] = $spaycs->count();
        $data['spaycs'] = [];
        if(!$spaycs->isEmpty()) {
            $data['spaycs'] = $spaycs->toArray();
            $response = ['status'=>'success','message'=>__('Warp lists.'), 'data'=>$data];
        } else {
            $this->response->statusCode(404);
            $response = ['status'=>'failed','message'=>__('Record not found.')];
        }
        
        $this->set($response);
    }
    
    /**
     * subscribeSpayc method to subscribe the user from the spayc
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
            $this->restException(['status'=>'failed','message'=>__('Warp id is required fields.')], 400);
        }
        $data['spayc_id'] = ApiHasher::decrypt($data['spayc_id']);
        $spaycs = TableRegistry::get('Api.Spaycs')->find('all',['fields'=>['id','name','image','matrix_room_id','user_id','parent_id']])->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('This warp is no longer exist.')], 400);
        }
        $spayc = $spaycs->first();
        $friend = TableRegistry::get('Api.FriendRequest')->userFriend($user['id'],$spayc->user_id);
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);
        if($entities->isEmpty()){
            $entity = $scModel->newEntity();
        }else{
            $entity = $entities->first();
            if($entity->status == 'Active'){
                $this->restException(['status'=>'failed','message'=>__('User has been already subscribed.')], 400);
           }
        }
        $nowTime = Utils::toUtc('05-31-2018 8:13:00');
        $entity->user_id = $data['user_id'];
        $entity->status = 'Active';
        $entity->spayc_id = $spayc->id;
        $entity->modified = $nowTime;
        $entity->created = $nowTime;
        if($scModel->save($entity,['checkRules' => false, 'atomic' => false])){
            $this->Matrix->muteUnmute('Unmute',$user['UserLogs']['matrix_access_token'], $spayc->matrix_room_id);
            /* If user not joined and want to subscribed the spayc so only joined will be done on matrix*/
            if(!(TableRegistry::get('Api.JoinedSpayc')->exists(['user_id'=>$data['user_id'],'spayc_id'=>$spayc->id]))){
                $this->Matrix->joinRoom([
                    'status'=>'Joined',
                    'matrix_token'=>$user['UserLogs']['matrix_access_token'],
                    'matrix_room_id' => $spayc->matrix_room_id
                ]);
                $this->Matrix->tagRoom($spayc->matrix_room_id,$user['UserLogs']['matrix_access_token'],$user['matrix_user_id']);
            }
            /* for subspayc user will be subscribe automatically */
            $data = $data+[
                'matrix_token' => $user['UserLogs']['matrix_access_token'],
                'matrix_user_id' => $user['matrix_user_id'],
                'datetime' => $nowTime,
                'action_type' => 'subspayc',
                'rule' => 'Unmute'
            ];
            $data['spayc_id'] = $spayc->id;
            TableRegistry::get('Queue.QueuedJobs')->createJob('MuteUnmute',$data);
            
            $push = [
                'slug' => 'user-subscribed-to-your-spayc',
                'requested_by' => $user['id'],
                'requested_to' => $spayc->user_id,
                'spayc_id' => $spayc->id,
                'spayc_name' => $spayc->name,
                'spayc_image' => $spayc->image,
                'matrix_room_id' => $spayc->matrix_room_id,
                'display_name' => $user['display_name']                
            ];
            if(!empty($friend)){
                $push['slug'] = 'friend-subscribed-to-your-spayc';
            }
            /* spayc owner will not get notification*/
            if($spayc->user_id != $user['id']){
                $this->Push->sendPushNotification($push);
            }
             
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
            $this->restException(['status'=>'failed','message'=>__('Warp id is required fields.')], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->find()->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid warp id.')], 400);
        }
        $spayc = $spaycs->first();
        $entities = $scModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['spayc_id'=>$spayc->id,'user_id'=>$data['user_id']]);      
        if($entities->isEmpty()){
             $this->restException(['status'=>'failed','message'=>__('User has not yet subscribed.')], 400);
        }
        $entity = $entities->first();
        if($entity->status == 'Inactive'){
            $this->restException(['status'=>'failed','message'=>__('User has been already un-subscribed.')], 400);
       }
        
        if($scModel->delete($entity)){
            $this->Matrix->muteUnmute('mute',$user['UserLogs']['matrix_access_token'], $spayc->matrix_room_id);
            /*for subscribed user only who not joined the room but virtually joined the room*/
            if(!(TableRegistry::get('Api.JoinedSpayc')->exists(['user_id'=>$data['user_id'],'spayc_id'=>$spayc->id]))){
                $this->Matrix->leaveRoom($spayc->matrix_room_id,$user['UserLogs']['matrix_access_token']);
                $this->Matrix->deleteTag($spayc->matrix_room_id,$user['UserLogs']['matrix_access_token'],$user['matrix_user_id']);
            }
            /* for subspayc user will be unsubscribe automatically */
            $data = $data+[
                'matrix_token' => $user['UserLogs']['matrix_access_token'],
                'matrix_user_id' => $user['matrix_user_id'],
                'datetime' => Utils::toUtc('05-31-2018 8:13:00'),
                'action_type' => 'subspayc',
                'rule' => 'mute'
            ];
            $data['spayc_id'] = $spayc->id;
            TableRegistry::get('Queue.QueuedJobs')->createJob('MuteUnmute',$data);
            $response = ['status'=>'success','message'=>__('User has been unsubcribed successfully.')];
        }else{
            $response = ['status'=>'failed','message'=>__('System failed to unsubscribe the user.')];
        }
        $this->set($response);
    }
    
    /**
     * View method
     * 
     * @endpoint spayc-details.json?id=:id
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
            $this->restException(['status'=>'failed', 'message'=>__('Warp id is required field.')], 400);
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
            $this->restException(['status'=>'failed', 'message'=>__('This warp is no longer exist.')], 400);
        }
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        
        $bannedSpayc = $this->Spaycs->bannedSpayc($userId);
        $spayc = $this->Spaycs->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.parent_id','Spaycs.created','Spaycs.modified','Spaycs.latitude','Spaycs.longitude','Spaycs.spayc_category_id','Spaycs.payment_type','Spaycs.ticket_url'])
                ->where(['Spaycs.status'=>'Active', 'OR'=>['matrix_room_id'=>$id,'Spaycs.id'=>$id]])
                ->contain([
                    'SubSpaycs' => function($q)use($bannedSpayc) {
                        $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'SubSpaycs.location', 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id','SubSpaycs.latitude','SubSpaycs.longitude']);
                        if(!empty($bannedSpayc)){
                            $q->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                                return $exp->notIn('SubSpaycs.id', $bannedSpayc);
                             });
                        }
                        return $q;
                    },
                    'SubSpaycs.SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
                    },
                    'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin','JoinedSpayc.distance']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'Comments.comment']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
                    }
                ]);
        if($lat != null && $long != null){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles))." AS numeric), 3)";
            $spayc->select(['distance'=>$distance])
                    //->bind(':lat', $lat, 'float')
                    //->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $spayc->select(['distance'=>0])
                    ->order(['Spaycs.created'=>'DESC']);
        }        
        #pr($spayc->toArray());die;
        $spayc->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend, $userId) {
            return $results->map(function ($row) use($friend, $userId) {  
                $row->created = Utils::toClient($row->created);
                $row->modified = Utils::toClient($row->modified);
                if(!empty($row->ticket_url)){
                    $row->ticket_url = explode(',',$row->ticket_url);
                }
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
                if(!empty($joinedStatus[0])){
                    $row['joined_spayc_status'] = $joinedStatus[0]['status'];
                    $row['is_admin'] = $joinedStatus[0]['is_admin'];
                }else{
                    $row['joined_spayc_status'] = 'Not_Joined';
                    $row['is_admin'] = '';
                }
                $row['joined_users'] =!empty($row['joined_spayc'])?count($totalJoined):0;
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['comment'])?$row['comments'][0]['comment']:0;
                unset($row['comments'],$row['joined_spayc']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        $data = [];        
        if(!$spayc->isEmpty()) {
            $data = $spayc->first();
            if($data['joined_spayc_status'] == 'Banned'){
                $this->restException(['status'=>'failed','message'=>__('You have banned with this warp')],400);
            }
        } else {
            $this->response->statusCode(404);
        }
        $response = ['status'=>'success', 'message'=>__('Warp Details.'), 'data'=>$data];
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
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $data['group_type'] = !empty($data['group_type'])?ucfirst($data['group_type']):'';
        $data['type'] = !empty($data['type'])?ucfirst($data['type']):'';
        if(empty($data['spayc_id'])) {
            $this->restException(['status'=>'failed','message'=>'Spayc id is required.'], 400);
        }
        $entities = $this->Spaycs->find();
        if(!empty($data['latitude']) || !empty($data['longitude'])){
            $entities->contain('JoinedSpayc',function($q)use($data){
                    $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id','pl.current_latitude','pl.current_longitude']);
                    $dckey = [':lat',':long','Spaycs.latitude','Spaycs.longitude'];
                    $rckey = [$data['latitude'],$data['longitude'],'pl.current_latitude','pl.current_longitude'];
                    $distance = "ROUND(CAST(".str_replace($dckey,$rckey,$this->Spaycs->distanceInMiles)." AS numeric), 5)";
                    $q->select(['distance'=>$distance]);
                    $q->join([
                        'pl'=>[
                            'table' => 'physical_location',
                            'type' => 'INNER',
                            'conditions' => 'pl.user_id = JoinedSpayc.user_id'
                        ]
                    ]);
                    return $q;
            });
        }else{
            $entities->contain('JoinedSpayc',function($q){
                    $q->select(['distance'=>'NULL','JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id']);
                    return $q;
            });
        }
                
        // If User Update Spayc once Scraper will not update
        if(isset($data['is_admin_update'])){
            $entities->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']],['is_admin_update'=>0]]);
            unset($data['is_admin_update']);
        }else{        
        $entities->where(['OR'=>['id'=>$data['spayc_id'],'matrix_room_id'=>$data['spayc_id']]]);
        }
        if($entities->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Invalid warp id.')], 400);
        }
        
        $entity = $entities->first();
        $eventType = $entity->type;
        if($user['id'] != $entity->user_id){
            $this->restException(['status'=>'failed','message'=>__('Insufficient privileges to edit this space.')], 400);
        }        
        unset($data['spayc_id']);   
        if(is_null($entity->parent_id)){
            $items = $this->Spaycs->patchEntity($entity, $data,['associated'=>['JoinedSpayc']]);
            if(!empty($items->errors())) {
                $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
            }
        }else{
            $data['parent_matrix_room_id'] = $entity->parent_id;
            $errors = $this->Spaycs->validateSubspace($data);
            if(!empty($errors)) {
                $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
            }
            unset($data['parent_matrix_room_id']);
            $items = $this->Spaycs->patchEntity($entity, $data,['validate'=>false,'associated'=>['JoinedSpayc']]);
        }
        $items->type = $eventType;
        if($data['type'] == 'Community'){ /* in community no need to keep start or end date*/
            $items->start_date = '';
            $items->end_date = '';
        }
        if($data['group_type'] == 'Public'){ /* in community no need to keep start or end date*/
            $items->passcode = '';
        }
        
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrix = $this->Matrix->updateRoom($entity->matrix_room_id,$data);
        if(!$matrix) {
            $this->restException(['status' => "failed", 'message' =>__('Third party updation failed.')], 400);
        }
        
        $prevLocation = $entity->getOriginal('location');
        $prevDescription = $entity->getOriginal('description');
        if($this->Spaycs->save($items)){
            if($prevDescription != $entity->get('description')) {
                TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
            }
            if($prevLocation != $entity->get('location')){
                $this->Spaycs->updateDistance($items);                
                $this->Redis->addSpayc($items);
            }
            if(!empty($entity['joined_spayc'])){
                unset($items->joined_spayc);
            }
            $items = $items->toArray();
            $items['ticket_url']= !empty($items['ticket_url'])?explode(',', $items['ticket_url']):null;
            $items['created']=  Utils::toClient($items['created']);
            $items['modified'] = Utils::toClient($items['modified']);
            $items['start_date']=  Utils::toClient($items['start_date']);
            $items['end_date'] = Utils::toClient($items['end_date']);
            $response = ['status'=>'success','message'=>__('The warp has been updated successfully.'),'data'=>$items];
            /*Event to bind to update the set upload room image */
            /*$event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                'options' => [
                    'matrix_token'=>$data['matrix_token'],
                    'image'=> $items['image'],
                    'matrix_room_id'=> $items['matrix_room_id'],
                    ]
            ]);
            EventManager::instance()->dispatch($event);
             * 
             */
        }else{
            $this->restException(['status'=>'failed', 'message'=>__('The warp could not be updated. Please, try again.')], 400);
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
        if (!$this->request->is(['delete'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        if($id == null){
            $id = $this->request->query('id');
            if(empty($id)){
                $this->restException(['status'=>'failed','message'=>'Spayc id is required.'], 400);
            }
        } 
        $user = $this->Auth->user();
        $entity = $this->Spaycs->find()
                ->where(['OR'=>['id'=>$id,'matrix_room_id'=>$id],'user_id'=>$user['id']])
                ->contain([
                    'SubSpaycs'=>function($q){
                        return $q->select(['id','name','image','matrix_room_id','parent_id']);
                    },
                    'SubSpaycs.JoinedSpayc'=>function($q){
                        return $q->select(['id','spayc_id','user_id']);
                    },'SubSpaycs.JoinedSpayc.Users'=>function($q){
                        return $q->select(['id','display_name','matrix_access_token','matrix_user_id']);
                    },   
                    'JoinedSpayc'=>function($q){
                        return $q->select(['id','spayc_id','user_id']);
                    },
                    'JoinedSpayc.Users'=>function($q){
                        return $q->select(['id','display_name','matrix_access_token','matrix_user_id']);
                    },   
                ]);
        if($entity->isEmpty()){
            $this->restException(['status'=>'failed','message'=>'This spayc is no longer exist.'], 404);
        }

        $spayc = $entity->first();
        $spaycId = $spayc->id;
        $spayc->set('matrix_access_token',$user['matrix_access_token']);
        /* To queue the job to process from backend system */
        TableRegistry::get('Queue.QueuedJobs')->createJob('Delete',$spayc->toArray());
        
        $matrixRoomIds = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.matrix_room_id');
        array_push($matrixRoomIds, $spayc->matrix_room_id);
        $child = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.id');        
        array_push($child,$spayc->id); 
       
//        $this->Matrix->deleteRoom($matrixRoomIds);
        if ($this->Spaycs->delete($spayc)) {
            $this->Redis->deleteSpayc($spaycId);
            TableRegistry::get('Api.JoinedSpayc')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SubscribedUsers')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SpaycHashtags')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SpaycAdvertisement')->deleteAll(['spayc_id IN' => $child]);
            TableRegistry::get('Api.Notifications')->deleteAll(['spayc_id IN' => $child]);
             $ids = TableRegistry::get('Api.Promotions')->find()
                     ->select(['id'])
                     ->where(['spayc_id IN' => $child]);
            TableRegistry::get('Api.SpaycPromotion')->deleteAll(['promotion_id IN' => $ids]);
            TableRegistry::get('Api.Promotions')->deleteAll(['spayc_id IN' => $child]);
            $response = ['status'=>'success','message'=>__('The warp has been deleted.')];
        } else {
            $response = ['status'=>'failed','message'=>__('Warp could not be deleted.')];
        }
         $this->set($response);
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
        $user = $this->Auth->user();
        if($this->Spaycs->JoinedSpayc->exists(['user_id'=>$user['id'],'status'=>BANNED,'spayc_id'=>$spaycId])){
            $this->restException(['status'=>'failed','message'=>__('Your status with this warp has been banned.')], 400);
        }
        $query = $this->Spaycs->spaycMember($spaycId,$status,$page,$limit);        
        if(empty($query)){
//            $this->response->statusCode(204);
            $response = ['status'=>'success', 'message'=>__('List of warp member.'), 'data'=>[]];
        }else{
            $response = ['status'=>'success', 'message'=>__('List of warp member.'), 'data'=>$query];
        }        
        $this->set($response);
    }
    /**
     * viewSubSpaycs method to lit the subspaycs of spayc
     * 
     * @endpoint subspaycs.json?spayc_id=:id
     * @param String $spayc_id Parent spayc id
     * @return Object Json object with spayc details.
     */
    public function viewSubSpaycs(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $subspayc = $this->request->getQuery('spayc_id',null);
        $user = $this->Auth->user();
        $loggedUser = $user['id'];
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
                ->select(['Spaycs.id', 'Spaycs.name', 'Spaycs.location','Spaycs.description', 'Spaycs.matrix_room_id', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.type', 'Spaycs.group_type', 'Spaycs.passcode','Spaycs.user_id','Spaycs.parent_id','Spaycs.spayc_category_id','Spaycs.payment_type','Spaycs.ticket_url'])
                ->where(['Spaycs.status'=>ACTIVE,'Spaycs.parent_id'=>$subspayc])                
                ->contain([
                    'JoinedSpayc' => function($q) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin', 'JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>'Joined']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                      return $q->select(['Comments.spayc_id', 'Comments.comment']);                     
                    },
                    'SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
                    }
                ]);
        $bannedSpayc = $this->Spaycs->bannedSpayc($user['id']);    
        if(!empty($bannedSpayc)){
            $query->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                return $exp->notIn('Spaycs.id', $bannedSpayc);
             });
        }        
        if($lat != null && $long != null){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles))." AS numeric), 3)";
            $query->select(['distance'=>$distance])
                    //->bind(':lat', $lat, 'float')
                    //->bind(':long', $long, 'float')
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $query->select(['distance'=>0])
                    ->order(['Spaycs.created'=>'DESC']);
        }
        $query->limit($limit)->page($page);
        #pr($query->toArray());die;
        $result = $query->map(function ($row)use($friend,$userId,$loggedUser) {
                $spaycId = ApiHasher::decrypt($row->id);
                $row->friends = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                $totalJoined = [];
                if(!empty($row->joined_spayc)) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row->joined_spayc,'{n}[user_id='.$loggedUser.']');
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
                    $row->joined_spayc_status = 'Not_Joined';
                    $row->is_admin = '';
                }                
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$loggedUser.']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['comment'])?$row->comments[0]['comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of subspayc.','parent_spayc_id'=>$parentMatrixId,'data'=>$result];
        $this->set($response);
    }
    
    /**
     * physicalyPresentSpaycs method to get the spayces which is within 1 miles
     * End Point physical-present-spaycs.json
     */
    
    public function physicalyPresentSpaycs(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $lat = $tmpLat = $this->request->getQuery('latitude');
        $long = $tmpLong = $this->request->getQuery('longitude');
        if(empty($lat) && empty( $long)){
            $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
            if($pquery->isEmpty()){
                $this->restException(['status'=>'failed','message'=>__('Latitude and Longitude is not updated.Either update the user current status or provide the latitude and longitude.')], 400);
            }
            $pquery = $pquery->first();
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;            
        }else{
            TableRegistry::get('Api.PhysicalLocation')->updateLocation($user,$lat,$long);
             /* update user current status on redis too */
            $this->Redis->addUser([
                'id'=>$user['id'],
                'latitude'=>$lat,
                'longitude'=>$long,
            ]);
        }
       
        $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $errors = TableRegistry::get('Api.Users')->validateLatLong(['latitude'=>$lat,'longitude'=>$long]); 
        if(!empty($errors)) {
           // $this->restException(['status'=>'failed','message'=>__('Latitude and Longitude is not updated.Either update the user current status or provide the latitude and longitude.')], 400);
        }
        $page = 1;
        $limit = Configure::read('pagelimit');
        
        $radius =  Configure::read('miles');
        $query = $this->Spaycs->find();
        $query->select(['Spaycs.id', 'Spaycs.name','Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.matrix_room_id','Spaycs.spayc_category_id']);
        $query->where(['Spaycs.status'=>'Active','Spaycs.parent_id IS'=>null,'Spaycs.group_type !='=>'trusted_private','OR'=>[['Spaycs.end_date >='=>$date],['Spaycs.end_date IS'=>null]]]);
        $bannedSpayc = $this->Spaycs->bannedSpayc($user['id']);    
        if(!empty($bannedSpayc)){
            $query->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                return $exp->notIn('Spaycs.id', $bannedSpayc);
             });
        } 
        $query->contain([
            'SubscribedUsers' => function($q)use($user) {
                return $q->select(['SubscribedUsers.id','SubscribedUsers.spayc_id', 'SubscribedUsers.user_id'])->where(['SubscribedUsers.status'=>'Active','SubscribedUsers.user_id'=>$user['id']]);
            },
            'SpaycCategories' => function($q) {
                return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
            }        
            ]);
        $query->innerJoinWith('JoinedSpayc',function($q)use($user,$radius,$lat,$long) {
                $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.user_id'=>$user['id'],'JoinedSpayc.status'=>'Joined']);
                $q->where(['JoinedSpayc.distance <='=>$radius]);
                return $q;
        });
        $query->order(['JoinedSpayc.distance'=>'ASC','Spaycs.created'=>'DESC']);
        $query->limit($limit)->page($page);
       // pr($query->toArray());die;
        if($query->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        $result = $query->map(function ($row)use($lat,$long) {
            $row->distance = $row->_matchingData['JoinedSpayc']->distance;
            $row->is_subscribed = !empty($row->subscribed_users)?true:false;
            $row->joined_status = 'Joined';
            unset($row->_matchingData,$row->subscribed_users);
            return $row;
         });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }
    
    /**
     * mapSpayc method to get the public and joined spayces
     * End point map-spaycs for Advertisement
     */
    
    public function mapSpayc(){
         if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $limit = (int)$this->request->getQuery('limit',100);
         if(empty($this->request->getData('center_latitude'))
                 || empty($this->request->getData('center_longitude'))
                 || empty($this->request->getData('endpoint_latitude'))
                 || empty($this->request->getData('endpoint_longitude'))
                 ) {
            $this->restException(['status'=>'failed', 'message'=> __('Parameter Invalid.')], 400);
         }
         $currentDate = $this->request->getData('current_date');
         if(!empty($currentDate) && !Utils::validTimestamp($currentDate)){
              $this->restException(['status'=>'failed', 'message'=> __('Current date must be valid timestamp.')], 400);
         }
         if($this->request->getData('hashtag_id') && $this->request->getData('hashtag_id')) {
            $hashtag=explode(",", $this->request->getData('hashtag_id'));
            if(count($hashtag)>MAX_HASHTAG){
                 $this->restException(['status'=>'failed', 'message'=> __('Maximum '.MAX_HASHTAG.' Hashtag Allowed.')], 400);
            }
         }
        $user = $this->Auth->user();
        $spayc=TableRegistry::get('Api.Spaycs')->getNearBySpaycsOnMap($this->request->getData(),$user['id']);
        
        $friends = TableRegistry::get('Api.FriendRequest')->getNearByFriendsOnMap($this->request->getData(), $user['id']);
        if(!$friends['count'] && !$spayc['count']){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }
        //$this->loadComponent('Api.ApiPagination');
        
        //$spayc['records'] = $this->paginate($spayc['records'],['limit'=>$limit]);        
        //$result['pagination'] = $this->getPaging('Spaycs');
        //$spayc['count'] = $result['pagination']['all_records'];
        //$result['a_count']=count($spayc['records']->toArray());
        $result['spaycs']=$spayc;
        $result['friends']=$friends;
        $response = ['status'=>'success','message'=>'List of Data.','data'=>$result];
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
        
        $keyword = $this->request->getQuery('keyword',null);
        $page = (int)$this->request->getQuery('page',1);        
        $limit = (int)$this->request->getQuery('limit',Configure::read('pagelimit'));
        if(!$page || !$limit){
            $this->restException(__('Page and limit value must be integer.'),400);
        }
        $date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
        $pquery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($user['id']);
        if(!$pquery->isEmpty()){
            $pquery = $pquery->first();
            $lat = $pquery->current_latitude;
            $long = $pquery->current_longitude;
        }else{
            $lat = null;
            $long = null;
                    
        }
        $subQuery = TableRegistry::get('Api.JoinedSpayc')->joinedSpaycQuery($user['id']);
        $query = $this->Spaycs->find();
        $query->select(['Spaycs.id', 'Spaycs.name','Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.matrix_room_id','Spaycs.spayc_category_id']);
        $query->where(['Spaycs.status'=>'Active','Spaycs.parent_id IS'=>null,'OR'=>[['Spaycs.id IN'=>$subQuery],['Spaycs.group_type'=>'Public']]]);
        $query->contain([
            'SpaycCategories' => function($q) {
                return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
            }        
            ]);
        $bannedSpayc = $this->Spaycs->bannedSpayc($user['id']);    
        if(!empty($bannedSpayc)){
            $query->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                return $exp->notIn('Spaycs.id', $bannedSpayc);
             });
        } 
        if(!empty($keyword)){
            $search = Utils::clean(strtolower($keyword));
            $keyString = explode(' ', $search);
            $keywords = array_diff($keyString, array(''));
            foreach ($keywords as $key) {
                $keyQuery[] = [
                    "LOWER(Spaycs.name) LIKE" => "%".trim($key)."%"
                ];
            }
            $query->where(['OR'=>$keyQuery]);
        }
        if(!empty($lat) && !empty($long)){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles))." AS numeric), 3)";
            $query->select(['distance'=>$distance])                    
                    ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
        }else{
            $query->select(['distance'=>0])
                    ->order(['Spaycs.created'=>'DESC']);
        }
       
        $query->limit($limit)->page($page);
        if($query->isEmpty()){
             $this->restException(['status'=>'failed','message'=>'Record not found.'], 404);
        }        
        $result = $query->map(function ($row)use($subQuery) {
            $joinedId = \Cake\Utility\Hash::extract($subQuery->toArray(),'{n}[spayc_id='.$row->id.']');
            if(!empty($joinedId)){
                $row->joined_status = 'Joined';
            }else{
                $row->joined_status = 'Not_Joined';
            };
            unset($row->_matchingData);
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
            $pquery = $pquery->first();
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
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>'Joined']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'Comments.comment']);
                    }
                ]);
        if(!empty($lat) && !empty($long)){
            $distance = "ROUND( CAST(".str_replace(':long',$long,str_replace(':lat',$lat,$this->Spaycs->distanceInMiles))." AS numeric), 3)";
            $spaycs->select(['distance'=>$distance])
                    //->bind(':lat', $lat, 'float')
                    //->bind(':long', $long, 'float')
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
                    $row->joined_spayc_status = 'Not_Joined';
                    $row->is_admin = '';
                } 
                $row->joined_users =  !empty($row->joined_spayc)?count($totalJoined):0;
                if(!empty($row->subscribed_users)) {
                    $subUserId = \Cake\Utility\Hash::extract($row->subscribed_users,'{n}[user_id='.$user['id'].']');
                }
                $row->subscribed_users = !empty($row->subscribed_users)?count($row->subscribed_users):0;
                $row->is_subscribed = !empty($subUserId[0])?true:false;
                $row->total_comments = !empty($row->comments[0]['comment'])?$row->comments[0]['comment']:0;
                unset($row->joined_spayc,$row->comments);
                return $row;
            });
        $response = ['status'=>'success','message'=>'List of spaycs.','data'=>$result];
        $this->set($response);
    }
    /**
     * userSubscribedSpaycs to get the list spaycs to which user has been subscribed
     */
    public function userSubscribedSpaycs(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 400);
        }
        $status = $this->request->getQuery('status',ACTIVE);
        $page = $this->request->getQuery('page',1);
        $limit = $this->request->getQuery('limit',100);
        $user = $this->Auth->user();
        $spaycs = TableRegistry::get('Api.SubscribedUsers')->subscribedSpayc($user['id'],$status,$page,$limit);
        if(!$spaycs->isEmpty()){
//            $this->response->statusCode(204);
            $response = ['status'=>'success', 'message'=>__('List of subscribed warp.'), 'data'=>$spaycs];
        }else{
            $response = ['status'=>'success', 'message'=>__('User has not been subscribed to any warp.'), 'data'=>[]];
        }        
        $this->set($response);
    }
    
}
