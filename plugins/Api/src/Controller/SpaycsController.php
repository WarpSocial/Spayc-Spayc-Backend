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
            $this->restException(['status'=>'failed','message'=>'Invalied method.'],405);
        }
        $data = $this->request->getData();
        $items = $this->Spaycs->patchEntity($entity, $data);
        
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>'Validation errors','error'=>$this->mapErrors($items->errors())]);
        }
        $this->loadComponent('Api.Matrix');
        $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
        $matrix = $this->Matrix->createRoom($data);
        if(!empty($matrix['error'])) {
            $this->restException(['status' => "failed", 'message' =>__($matrix['error'])],401);
        }
        $items->set('matrix_room_id',$matrix['room_id']);
        $items->set('matrix_room_alias',$matrix['room_alias']);
        $items->set('user_id',$this->Auth->user('id'));
        if ($this->Spaycs->save($items)) {
            $response = ['status'=>'success','message'=>__('Your spayc, '.ucfirst($data['name']).', has been created.'),'data'=>$items];
        } else {
            Log::info(['status' => "failed", 'message' =>__('The spayc could not be saved. Please, try again.')]);
            $response = ['status'=>'failed','message'=>__('The spayc could not be saved. Please, try again.')];
        }
        $this->set($response);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $userId = $this->Auth->user("id");
        $limit = 5;
        if(!is_numeric($this->request->query('page'))) {
            $this->restException(['status'=>'failed', 'message'=>'Page number is not valid.'], 405);
        }
        $page = $this->request->query('page');
        $friends = TableRegistry::get('FriendRequest')->find('all', ['fields'=>['FriendRequest.requested_by', 'FriendRequest.requested_to'], 'conditions'=>['OR'=>['requested_by'=>$userId, 'requested_to'=>$userId], 'requested_status'=>'Accepted']]);
        $friend = [];
        if($friends->count()) {
            $friendIds = $friends->toArray();
            $friend = array_unique(array_merge(array_column($friendIds,'requested_by'),array_column($friendIds,'requested_to')));
        }
        $fieldArray = ['user_id'=>$userId];
        $query =  $this->Spaycs->find()->select(['id','user_id','name','start_date','end_date','image', 'type', 'group_type', 'status', 'created', 'modified'])->where(['user_id'=>$fieldArray['user_id']])->contain([
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
        $query->order(['Spaycs.created'=>'ASC'])->limit($limit);
        if($this->request->query('start_date')) {
            $date = new \Cake\I18n\Time($this->request->query('start_date'));
            $startDate = Utils::setUtc($date->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $query->where(["Spaycs.start_date >="=>$startDate]);
        }
        if($this->request->query('end_date')) {
            $date = new \Cake\I18n\Time($this->request->query('start_date'));
            $endDate = Utils::setUtc($date->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $query->where(["Spaycs.end_date <="=>$endDate]);
        }
        if(in_array(ucfirst($this->request->query('spayc_type')), ['Event', 'Community'])) {
            $query->where(["Spaycs.type"=>ucfirst($this->request->query('spayc_type'))]);
        }
        if(in_array(ucfirst($this->request->query('group_type')), ['Public', 'Private'])) {
            $query->where(["Spaycs.group_type"=>ucfirst($this->request->query('group_type'))]);
        }
        if($page < 0){
            $page = $page*-1;
            $query->page($page);
        } else {
            $query->page($page);
        }
        $newQuery = clone $query;
        if($page == 1) {
            $data['previous'] = $newQuery->count();            
        }
        $result = [];
        if(!$query->isEmpty()) {
            $result = $query->toArray();
        }
        $data['spaycs'] = $result;
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
