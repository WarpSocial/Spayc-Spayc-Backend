<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;

/**
 * SpaycCategories Controller
 *
 * @property \App\Model\Table\SpaycCategoriesTable $SpaycCategories
 */
class CategoriesController extends AdminController {
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('SpaycCategories');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->set('title', __('Manage categories'));
        $query = $this->SpaycCategories->find()->contain(['ParentSpaycCategories']);//->where('SpaycCategories.parent_id IS NOT NULL');
        
        $keyword = $this->request->getQuery('keyword',null);
        if(!empty($keyword)){
          $query->where(['Lower(SpaycCategories.name) LIKE' => '%'.strtolower($keyword).'%']);
        }
        $spaycCategories = $this->paginate($query);

        $this->set(compact('spaycCategories'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->set('title', __('Create new categories.'));
        $spaycCategory = $this->SpaycCategories->newEntity();
        if ($this->request->is('post')) {
            $spaycCategory = $this->SpaycCategories->patchEntity($spaycCategory, $this->request->getData());
            if ($this->SpaycCategories->save($spaycCategory)) {
                \Cake\Cache\Cache::delete('spayc_categories', 'long'); 
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $parentSpaycCategories = $this->SpaycCategories->ParentSpaycCategories->find('list')->where('parent_id IS NULL');
        $this->set(compact('spaycCategory', 'parentSpaycCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spayc Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $this->set('title', __('Edit categories.'));
        $spaycCategory = $this->SpaycCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spaycCategory = $this->SpaycCategories->patchEntity($spaycCategory, $this->request->getData());
            if ($this->SpaycCategories->save($spaycCategory)) {
                \Cake\Cache\Cache::delete('spayc_categories', 'long'); 
                $this->Flash->success(__('The spayc category has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spayc category could not be saved. Please, try again.'));
        }
         $parentSpaycCategories = $this->SpaycCategories->ParentSpaycCategories->find('list')->where('parent_id IS NULL');
         //pj($spaycCategory);pj($parentSpaycCategories);die;
        $this->set(compact('spaycCategory', 'parentSpaycCategories'));
    }
}
