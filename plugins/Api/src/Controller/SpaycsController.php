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
        $spayc = $this->Spaycs->newEntity();
        if ($this->request->is('post')) {
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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $spaycs = $this->paginate($this->Spaycs);

        $this->set(compact('spaycs'));
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
