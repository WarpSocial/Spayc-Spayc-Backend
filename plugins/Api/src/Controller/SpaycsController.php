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
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        
        //$data['image_url']='https://spayc-qa.s3.amazonaws.com/room/screenshot_from_2017_10_09_16_53_55_20180214070522.png';
        //$matrix = $this->Matrix->uploadMediaImage($data);die();
        
        $matrix = $this->Matrix->createRoom($data);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
        }
        $items->set('matrix_room_id',$matrix['room_id']);
        $items->set('matrix_room_alias',$matrix['room_alias']);
        $items->set('user_id', $this->Auth->user('id'));
        if (!$items->errors()) {
            if($this->Spaycs->save($items)){
                 if(!empty($items['description'])) {
                    TableRegistry::get('Api.Hashtags')->saveHashTags($items['description'], $items['id']);
                }
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('Your spayc, '.ucfirst($data['name']).', has been created.'),'data'=>$items];
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
        $data['group_type'] = 'Private';
        $entity = $this->Spaycs->newEntity();
        $items = $this->Spaycs->patchEntity($entity, $data, ['validate'=>false]);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrix = $this->Matrix->createRoom($data);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])], 400);
        }
        $items->set('matrix_room_id', $matrix['room_id']);
        $items->set('matrix_room_alias', $matrix['room_alias']);
        $items->set('user_id', $this->Auth->user('id'));
        $items->set('status', 'Active');
        if (!$items->errors()) {
            if($this->Spaycs->save($items)) {
                TableRegistry::get('Api.FriendRequest')->updateRoomId($items['invite'], $this->Auth->user('id'), $matrix['room_id']);
                $this->response->statusCode(201);
                $response = ['status'=>'success','message'=>__('Your room, '.ucfirst($data['name']).', has been created.'), 'data'=>$items];
                /*Event to bind to update the set upload room image */
                $event = new Event('Controller.Spayc.matrixMedia', $this->Controller, [
                    'options' => [
                        'matrix_token'=>$data['matrix_token'],
                        'matrix_room_id'=> $items->matrix_room_id,
                        ]
                ]);
                EventManager::instance()->dispatch($event);
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
        $userId = $this->Auth->user("id");
        $limit = (!empty($this->request->query('limit')) and is_numeric($this->request->query('limit')))?$this->request->query('limit'):5;
        if(!Utils::isValidLatitude($this->request->query('latitude')) || empty($this->request->query('latitude'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
        }
        if(!Utils::isValidLongitude($this->request->query('longitude')) || empty($this->request->query('longitude'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
        }
        $page = (!empty($this->request->query('page')) and is_numeric($this->request->query('page')))?$this->request->query('page'):1;
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        //To search by kilometers instead of miles, replace 3959 with 6371.
        $distanceField = '(3959 * acos (cos ( radians(:latitude) )
            * cos( radians( Spaycs.latitude ) )
            * cos( radians( Spaycs.longitude )
            - radians(:longitude) )
            + sin ( radians(:latitude) )
            * sin( radians( Spaycs.latitude ) )))';
        $distance = 25;
        $spaycs = $this->Spaycs->find()
            ->select([
                'distance' => $distanceField, 'id', 'user_id', 'name', 'address'=>'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'status', 'latitude', 'longitude', 'created', 'modified'
            ])
            ->where(["$distanceField <" => $distance, 'status'=>'Active'])
            ->bind(':latitude', $this->request->query('latitude'), 'float')
            ->bind(':longitude', $this->request->query('longitude'), 'float');
        $spaycs->contain([
            'JoinedSpayc' => function($q) {
                return $q->select(['JoinedSpayc.spayc_id', 'joined_users' => $q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.spayc_id']);
            },
            'SubscribedUsers' => function($q) {
                return $q->select(['SubscribedUsers.spayc_id', 'subscribed_users' => $q->func()->count('SubscribedUsers.id')])->group(['SubscribedUsers.spayc_id']);
            },
            'Comments' => function($q) {
                return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
            }
        ]);
        $spaycs->order(['distance'=>'ASC'])->limit($limit);
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
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend){
            return $results->map(function ($row) use($friend) {
                if(!empty($row['joined_spayc'])) {
                    $spaycId = ApiHasher::decrypt($row->id);
                    $row['joined_spayc'][0]['joined_friends'] = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                }
                return $row;
            });
        });
        
        $newQuery = clone $spaycs;
        $data['count'] = $newQuery->count();
        $data['spaycs'] = [];
        if($spaycs->count()) {
            $data['spaycs'] = $spaycs->toArray();
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success','message'=>__('Spayc lists.'), 'data'=>$data];
        $this->set($response);
    }

    public function subscribeSpayc() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status'=>'failed','message'=>__('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        if(empty($data['spayc_id'])) {
            $this->restException(['status'=>'failed','message'=>__('Spayc id is required fields.')], 400);
        }
        $data['spayc_id'] = ApiHasher::decrypt($data['spayc_id']);
        $isExist = $this->Spaycs->exists(['id'=>$data['spayc_id']]);
        if(!$isExist) {
            $this->restException(['status'=>'failed','message'=>__('Invalid spayc Id.')], 400);
        }
        $subscribers = TableRegistry::get("Api.SubscribedUsers");
        $exists = $subscribers->exists(['spayc_id'=>$data['spayc_id'], 'user_id'=>$this->Auth->user('id')]);
        if($exists) {
            $this->restException(['status'=>'failed', 'message'=>__('User already subscribed.')], 400);
        }
        $subscribe['user_id'] = $this->Auth->user('id');
        $subscribe['spayc_id'] = $data['spayc_id'];
        $subscribe['status'] = 'Active';
        $entity = $subscribers->newEntity();
        $items = $subscribers->patchEntity($entity, $subscribe);
        if($items->errors()) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
        $subscribers->save($items);
        $this->response->statusCode(201);
        $response = ['status'=>'success','message'=>__('User Subscribed successfully.')];
        $this->set($response);
    }
    
    /**
     * View method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        if(!$this->request->is(['get'])) {
            $this->restException(['status'=>'failed', 'message'=>__('Method not allowed.')], 405);
        }
        if(empty($id)) {
            $this->restException(['status'=>'failed', 'message'=>__('Spayc id is required fields.')], 400);
        }
        $id = ApiHasher::decrypt($id);
        $exists = $this->Spaycs->exists(['id'=>$id]);
        if(!$exists) {
            $this->restException(['status'=>'failed', 'message'=>__('Invalid spayc id.')], 400);
        }
        $userId = $this->Auth->user('id');
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        $spayc = $this->Spaycs->find('all', ['fields' => ['Spaycs.id', 'Spaycs.name', 'address'=>'Spaycs.location', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.matrix_room_id', 'Spaycs.group_type', 'Spaycs.type']])->where(['id'=>$id, 'status'=>'Active']);
        $spayc->contain([
            'JoinedSpayc' => function($q) {
                return  $q->select(['JoinedSpayc.spayc_id', 'joined_users' => $q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.spayc_id']);
            },
            'SubscribedUsers' => function($q) {
                return $q->select(['SubscribedUsers.spayc_id', 'subscribed_users' => $q->func()->count('SubscribedUsers.id')])->group(['SubscribedUsers.spayc_id']);
            },
            'Comments' => function($q) {
                return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
            }
        ]);
        $spayc->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend) {
            return $results->map(function ($row) use($friend) {
                if(!empty($row['joined_spayc'])) {
                    $spaycId = ApiHasher::decrypt($row->id);
                    $row['joined_spayc'][0]['joined_friends'] = TableRegistry::get('Api.JoinedSpayc')->getTotalJoinedFriends($spaycId, $friend);
                    $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                    $row['total_subscribed_users'] = !empty($row['subscribed_users'][0]['subscribed_users'])?$row['subscribed_users'][0]['subscribed_users']:0;
                    $row['total_joined_users'] = !empty($row['joined_spayc'][0]['joined_users'])?$row['joined_spayc'][0]['joined_users']:0;
                    $row['total_joined_friends'] = !empty($row['joined_spayc'][0]['joined_friends'])?$row['joined_spayc'][0]['joined_friends']:0;
                    unset($row['subscribed_users']);
                    unset($row['joined_spayc']);
                    unset($row['comments']);
                }
                return $row;
            });
        });
        $data = [];
        if($spayc->count()) {
            $data = $spayc->first();
        } else {
            $this->response->statusCode(204);
        }
        $response = ['status'=>'success','message'=>__('Spayc Details.'), 'data'=>$data];
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
        $spayc = $this->Spaycs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spayc = $this->Spaycs->patchEntity($spayc, $this->request->getData());
            if ($this->Spaycs->save($spayc)) {
                $this->Flash->success(__('The spayc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spayc could not be saved. Please, try again.'));
        }
        $users = $this->Spaycs->Users->find('list', ['limit' => 200]);
        $this->set(compact('spayc', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $spayc = $this->Spaycs->get($id);
        if ($this->Spaycs->delete($spayc)) {
            $this->Flash->success(__('The spayc has been deleted.'));
        } else {
            $this->Flash->error(__('The spayc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function matrixApplicationService($id = null){
        $this->autoRender = false;
       // pr($this->request);
       Log::info(json_encode($this->request->data(),JSON_PRETTY_PRINT));
    }

}
