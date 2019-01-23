<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use App\Controller\AppController;

/**
 * Settings Controller
 *
 * @property \App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AdminController {
    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $settings = $this->paginate($this->Settings);

        $this->set(compact('settings'));
    }

    /**
     * View method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $setting = $this->Settings->get($id, [
            'contain' => []
        ]);

        $this->set('setting', $setting);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $setting = $this->Settings->newEntity();
        if ($this->request->is('post')) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $setting = $this->Settings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $setting = $this->Settings->patchEntity($setting, $this->request->getData());
            if ($this->Settings->save($setting)) {
                $this->Flash->success(__('The setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The setting could not be saved. Please, try again.'));
        }
        $this->set(compact('setting'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $setting = $this->Settings->get($id);
        if ($this->Settings->delete($setting)) {
            $this->Flash->success(__('The setting has been deleted.'));
        } else {
            $this->Flash->error(__('The setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function categories(){
        
        $cat = \Cake\ORM\TableRegistry::get('Api.SpaycCategories');
        
        $spaycCategories = $cat->find()->contain(['ParentSpaycCategories'])->all();
       
        $this->set(compact('spaycCategories'));
    }

}
