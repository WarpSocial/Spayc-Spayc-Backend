<?php

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * ReportedWarps Controller
 *
 * @property \App\Model\Table\ReportedWarpsTable $ReportedWarps
 */
class ReportedWarpsController extends AppController {
    public function initialize() {
        parent::initialize();        
        $this->loadComponent('Api.Matrix');
        $this->loadComponent('Api.Push');
        $this->Users = TableRegistry::get('Users');
    }

   
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $items = $this->paginate($this->ReportedWarps);

        $this->set(compact('items'));
    }

    /**
     * View method
     *
     * @param string|null $id Reported Warp id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $reportedWarp = $this->ReportedWarps->get($id, [
            'contain' => []
        ]);

        $this->set('reportedWarp', $reportedWarp);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $reportedWarp = $this->ReportedWarps->newEntity();
        if ($this->request->is('post')) {
            $reportedWarp = $this->ReportedWarps->patchEntity($reportedWarp, $this->request->getData());
            if ($this->ReportedWarps->save($reportedWarp)) {
                $this->Flash->success(__('The reported warp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reported warp could not be saved. Please, try again.'));
        }
        $this->set(compact('reportedWarp'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reported Warp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $reportedWarp = $this->ReportedWarps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reportedWarp = $this->ReportedWarps->patchEntity($reportedWarp, $this->request->getData());
            if ($this->ReportedWarps->save($reportedWarp)) {
                $this->Flash->success(__('The reported warp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reported warp could not be saved. Please, try again.'));
        }
        $this->set(compact('reportedWarp'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reported Warp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $reportedWarp = $this->ReportedWarps->get($id);
        if ($this->ReportedWarps->delete($reportedWarp)) {
            $this->Flash->success(__('The reported warp has been deleted.'));
        } else {
            $this->Flash->error(__('The reported warp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
