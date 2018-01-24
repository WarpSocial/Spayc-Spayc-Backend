<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;
use \Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Api\Utils\Utils;
use Cake\Core\Configure;

/**
 * Spaycs Controller
 *
 * @property \Api\Model\Table\SpaycsTable $Spaycs
 *
 * @method \Api\Model\Entity\Spayc[] paginate($object = null, array $settings = [])
 */
class SpaycsController extends AppController {
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $entity = $this->Spaycs->newEntity();
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $items = $this->Spaycs->patchEntity($entity, $data);
        
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
        $items->set('user_id',$this->Auth->user('id'));
        if ($this->Spaycs->save($items)) {
            $response = ['status'=>'success','message'=>__('Your spayc, '.ucfirst($data['name']).', has been created.'),'data'=>$items];
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
        if(!Utils::isValidLatitude($this->request->query('latitude'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Latitude is not valid.')], 400);
        }
        if(!Utils::isValidLongitude($this->request->query('longitude'))) {
            $this->restException(['status'=>'failed', 'message'=>__('Longitude is not valid.')], 400);
        }
        $page = (!empty($this->request->query('page')) and is_numeric($this->request->query('page')))?$this->request->query('page'):1;
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Approved');
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
                'distance' => $distanceField, 'id', 'user_id', 'name', 'address'=>'location', 'start_date', 'end_date', 'image', 'type', 'group_type', 'status', 'latitude', 'longitude', 'created', 'modified'
            ])
            ->where(["$distanceField <" => $distance])
            ->bind(':latitude', $this->request->query('latitude'), 'float')
            ->bind(':longitude', $this->request->query('longitude'), 'float');
        $spaycs->contain([
            'JoinedSpayc' => function($q) use($friend) {
                $row =  $q->select(['JoinedSpayc.spayc_id', 'joined_users' => $q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.spayc_id']);
                $joinedUsers = 0;
                if($row->count()) { $joinedUsers = $row->first()->toArray()['joined_users']; }
                return  $q->select(['joined_users'=>$joinedUsers, 'JoinedSpayc.spayc_id', 'joined_friends'=>$q->func()->count('JoinedSpayc.id')])->group(['JoinedSpayc.spayc_id'])->where(['JoinedSpayc.user_id IN'=>$friend]);
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
        $newQuery = clone $spaycs;
        $data['count'] = $newQuery->count();
        $data['spaycs'] = [];
        if($spaycs->count()) {
            $data['spaycs'] = $spaycs->toArray();
        }
        $response = ['status'=>'success','message'=>__('Spayc lists.'), 'data'=>$data];
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
        $spayc = $this->Spaycs->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('spayc', $spayc);
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

}
