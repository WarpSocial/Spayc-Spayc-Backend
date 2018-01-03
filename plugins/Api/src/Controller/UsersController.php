<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
/**
 * Users Controller
 *
 *
 * @method \Api\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    use MailerAwareTrait;
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $entity = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
            $items = $this->Users->patchEntity($entity, $data);
            if ($this->Users->save($items)) {                
                 $this->getMailer('Api.User')->send('signup', [$items]);
                $response = ['status' => "success", 'message' => 'Saved successfully.', 'data' => ['ones', $this->request->data]];
            } else {
                $response = ['status' => "failed", 'message' => 'Failed to saved data.', 'data' => $this->request->data,'errors'=>$this->mapErrors($items->errors())];
            }
        }
        $this->set($response);
    }
    
    /**
     * facebook signup
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
    */
    public function facebookSignup() {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $alreadyExist = $this->Users->getAlreadyExistsUser($data);
            if(!empty($alreadyExist['id'])) {
                $data['id'] = $alreadyExist['id'];
                $data['fb_id'] = !empty($alreadyExist['fb_id'])?$alreadyExist['fb_id']:$data['fb_id'];
                //$data['user_name'] = !empty($alreadyExist['user_name'])?$alreadyExist['user_name']:$data['user_name'];
                $data['email'] = !empty($alreadyExist['email'])?$alreadyExist['email']:$data['email'];
                $entity = $this->Users->get($data['id']);
            } else {
                $data['token_verification'] = Security::hash($data['email'], 'sha1', true);
                $entity = $this->Users->newEntity($data, ['validate' => 'FacebookSignup']);
            }
            $items = $this->Users->patchEntity($entity, $data, ['validate' => 'FacebookSignup']);
            if ($this->Users->save($items)) {      
                //$this->getMailer('Api.User')->send('signup', [$items]);
                $response = ['status' => "success", 'message' => 'Saved successfully.', 'data' => ['ones', $this->request->data]];
            } else {
                $response = ['status' => "failed", 'message' => 'Failed to saved data.', 'data' => $this->request->data,'errors'=>$this->mapErrors($items->errors())];
            }
        }
        $this->set($response);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
