<?php

namespace Api\Controller;

use Api\Controller\AppController;

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
        }else{
            $response = ['status'=>'success','message'=>__('The spayc could not be saved. Please, try again.')];
        }
        $this->set($response);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() { die("dkls");
        
        $this->paginate = [
            'contain' => ['Users']
        ];
        $spaycs = $this->paginate($this->Spaycs);

        $this->set(compact('spaycs'));
        $id = $this->Auth->user("id");
       // $user = $this->Users->get($id, ['fields'=>['username','email','gender','phone','dob','status','website_url','address','bio_data','created','modified']]);
        $response = ['status' => "success", 'message' => 'Profile details', 'data' => $spaycs];
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
