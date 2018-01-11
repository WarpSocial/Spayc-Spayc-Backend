<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;

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
        $data['matrix_token'] = $this->Auth->user('matrix_token');
        $matrix = $this->Matrix->createRoom($data);
        if(!$matrix) {       
            $this->restException(['status' => "failed", 'message' =>__('Matrix failed to create room.')],401);
        }
        $items->set('matrix_room_id',$matrix['room_id']);
        $items->set('matrix_room_alias',$matrix['room_alias']);
        $items->set('user_id',$this->Auth->user('id'));
        if ($this->Spaycs->save($items)) {
            $response = ['status'=>'success','message'=>__('The spayc has been created.'),'data'=>$items];
        }else{
            $response = ['status'=>'success','message'=>__('The spayc could not be saved. Please, try again.')];
        }
        $this->set(compact('response'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $userId = $this->Auth->user("id");
        $limit = 2;
        if(!is_numeric($this->request->query('page'))) {
            $this->restException(['status'=>'failed', 'message'=>'Page number is not valid.'], 405);
        }
        $page = $this->request->query('page');
        //?page=1&start_date=2018-01-10&end_date=2018-01-12&spayc_type=event&group_type=public&with_friends=true&timezome=5.5
        $fieldArray = ['user_id'=>$userId];
        $query =  $this->Spaycs->find()->select(['id','user_id','name','start_date','end_date','image', 'type', 'group_type', 'status', 'created', 'modified'])->where(['user_id'=>$fieldArray['user_id']]);
        $query->order(['Spaycs.created'=>'ASC'])->limit($limit);
        if($this->request->query('start_date')) {
            $startDate = (new \DateTime($this->request->query('start_date')))->format('Y-m-d'); 
            $query->where(["Spaycs.start_date >="=>$startDate]);
        }
        if($this->request->query('end_date')) {
            $endDate = (new \DateTime($this->request->query('end_date')))->format('Y-m-d');
            $query->where(["Spaycs.end_date <="=>$endDate]);
        }
        if($this->request->query('spayc_type') && in_array($this->request->query('spayc_type'), ['Event'])) {
            $query->where(["Spaycs.type"=>ucfirst($this->request->query('spayc_type'))]);
        }
        if($this->request->query('group_type')) {
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
        if($query->isEmpty()) {
            $result = [];
        } else {
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
