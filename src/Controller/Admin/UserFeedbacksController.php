<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;

/**
 * UserFeedbacks Controller
 *
 * @property \App\Model\Table\UserFeedbacksTable $UserFeedbacks
 */
class UserFeedbacksController extends AdminController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $userFeedbacks = $this->paginate($this->UserFeedbacks);

        $this->set(compact('userFeedbacks'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $userFeedback = $this->UserFeedbacks->newEntity();
        if ($this->request->is('post')) {
            $userFeedback = $this->UserFeedbacks->patchEntity($userFeedback, $this->request->getData());
            if ($this->UserFeedbacks->save($userFeedback)) {
                $this->Flash->success(__('The user feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user feedback could not be saved. Please, try again.'));
        }
        $users = $this->UserFeedbacks->Users->find('list', ['limit' => 200]);
        $this->set(compact('userFeedback', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Feedback id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $userFeedback = $this->UserFeedbacks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userFeedback = $this->UserFeedbacks->patchEntity($userFeedback, $this->request->getData());
            if ($this->UserFeedbacks->save($userFeedback)) {
                $this->Flash->success(__('The user feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user feedback could not be saved. Please, try again.'));
        }
        $users = $this->UserFeedbacks->Users->find('list', ['limit' => 200]);
        $this->set(compact('userFeedback', 'users'));
    }

}
