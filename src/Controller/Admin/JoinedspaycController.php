<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Joinedspayc Controller
 *
 * @property \App\Model\Table\JoinedspaycTable $Joinedspayc
 */
class JoinedspaycController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $joinedspayc = $this->paginate($this->Joinedspayc);

        $this->set(compact('joinedspayc'));
    }

    /**
     * View method
     *
     * @param string|null $id Joinedspayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $joinedspayc = $this->Joinedspayc->get($id, [
            'contain' => []
        ]);

        $this->set('joinedspayc', $joinedspayc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $joinedspayc = $this->Joinedspayc->newEntity();
        if ($this->request->is('post')) {
            $joinedspayc = $this->Joinedspayc->patchEntity($joinedspayc, $this->request->getData());
            if ($this->Joinedspayc->save($joinedspayc)) {
                $this->Flash->success(__('The joinedspayc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The joinedspayc could not be saved. Please, try again.'));
        }
        $this->set(compact('joinedspayc'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Joinedspayc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $joinedspayc = $this->Joinedspayc->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $joinedspayc = $this->Joinedspayc->patchEntity($joinedspayc, $this->request->getData());
            if ($this->Joinedspayc->save($joinedspayc)) {
                $this->Flash->success(__('The joinedspayc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The joinedspayc could not be saved. Please, try again.'));
        }
        $this->set(compact('joinedspayc'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Joinedspayc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $joinedspayc = $this->Joinedspayc->get($id);
        if ($this->Joinedspayc->delete($joinedspayc)) {
            $this->Flash->success(__('The joinedspayc has been deleted.'));
        } else {
            $this->Flash->error(__('The joinedspayc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
