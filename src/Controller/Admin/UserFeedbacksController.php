<?php

namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;

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
        $inputQuery = $keyword = $this->request->getQuery('keyword',null);
        $query = $this->UserFeedbacks->find()->contain(['Users'=>function($q)use($inputQuery){
            if(!empty($inputQuery)){
                $inputQuery = strtolower($inputQuery);
                $q->where(["OR"=>[
                ['Lower(display_name) LIKE' => '%'.$inputQuery.'%'],
                ['Lower(full_name) LIKE' => '%'.$inputQuery.'%'],
                ['Lower(email) LIKE' => '%'.$inputQuery.'%']]]);
            }
            return $q;
        }, 'FeedbackReply'])->where('UserFeedbacks.parent_id IS NULL');

        $userFeedbacks = $this->paginate($query);
        $this->set('title', __('User Feedbacks'));
        $this->set(compact('userFeedbacks'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function reply($id = null) {

        if (!$this->request->is('post')) {
            $this->ajaxResponse(['status' => false, 'message' => 'Invalid method type']);
        }
        $entity = $this->UserFeedbacks->newEntity();
        $userFeedback = $this->UserFeedbacks->get($id, ['contain' => ['Users']]);
        $items = $this->UserFeedbacks->patchEntity($entity, $this->request->getData());
        if ($items->errors()) {
            $this->ajaxResponse(['status' => false, 'message' => $this->mapErrors($items->errors())]);
        }
        $items['parent_id'] = $id;
        $items['user_id'] = $this->Auth->user('id');
        try {
            if ($this->UserFeedbacks->save($items)) {

                TableRegistry::get('Queue.QueuedJobs')->createJob('Mailer', [[
                'email' => $userFeedback->user->email,
                'display_name' => $userFeedback->user->display_name,
                'feedback_reply' => $this->request->getData('message'),
                'action_type' => 'feedbackReply'
                ]]);
                $this->ajaxResponse(['status' => true, 'message' => __('Mail has been sent successfull.')]);
            }
            $this->ajaxResponse(['status' => true, 'message' => __('Fail to send feedback because of system problem.')]);
        } catch (\Exception $e) {
            $this->ajaxResponse(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /*
     * Edit method
     *
     * @ param string|null $id User Feedback id.
     * @ return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @ throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function edit($id = null) {
        $userFeedback = $this->UserFeedbacks->get($id, [
            'contain' => [],
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

    /*
     * Download method to download the attached file
     * @ param Integer $userFeedBackId User feedback id
     * @ reuturn object
     */

    public function download($userFeedBackId = null) {
        $feedback = $this->UserFeedbacks->get($userFeedBackId);
        if (empty($feedback->attachment)) {
            return;
        }
        $fileInfo = pathinfo($feedback->attachment);
        $response = $this->response;

        $response = $response->withStringBody(file_get_contents($feedback->attachment))
                ->withType($fileInfo['extension'])
                ->withDownload($fileInfo['basename']);
        return $response;
    }

}
