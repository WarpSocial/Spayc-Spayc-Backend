<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Api\Utils\Utils;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;

/**
 * Advertisement Controller
 *
 * @property \App\Model\Table\AdvertisementTable $Advertisement
 */
class AdvertisementController extends AdminController
{

   
    use MailerAwareTrait;
    public function initialize() {
        parent::initialize();        
        $this->loadComponent('Api.Push');
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }
    
     /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('title', $this->siteTitleMessage['MANAGE-ADVERTISEMENTS']);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):'';
        $query = $this->Advertisement->find('all')->where(["status !=" => ADVERTISEMENTSTATUS]);
        if(!empty($keyword)){
            $query->where(['OR' => [['LOWER(Advertisement.name) LIKE' => "%".$keyword."%"]]]);
        }
        $advertisements = $this->paginate($query);
        $this->set(compact('advertisements'));
    }

    /**
     * View method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $advertisement = $this->Advertisement->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('advertisement', $advertisement);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $advertisement = $this->Advertisement->newEntity();
        if ($this->request->is('post')) {
            $advertisement = $this->Advertisement->patchEntity($advertisement, $this->request->getData());
            if ($this->Advertisement->save($advertisement)) {
                $this->Flash->success(__('The advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
        }
        $users = $this->Advertisement->Users->find('list', ['limit' => 200]);
        $this->set(compact('advertisement', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $advertisement = $this->Advertisement->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $advertisement = $this->Advertisement->patchEntity($advertisement, $this->request->getData());
            if ($this->Advertisement->save($advertisement)) {
                $this->Flash->success(__('The advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
        }
        $users = $this->Advertisement->Users->find('list', ['limit' => 200]);
        $this->set(compact('advertisement', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Advertisement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {        
        $this->viewBuilder()->layout('');       
        if (empty($id)) 
            return $this->redirect(['action' => 'index']);          
        $advertisement = $this->Advertisement->find('all')->where(['id'=>$id])->first();
        $pushNotificationAdminSlug = unserialize(PUSH_NOTIFICATION_ADMIN_SLUG);
        if ($this->request->is(['post','put'])) { 
            $update['status'] = ADVERTISEMENTSTATUS;
            $condition['id'] = $id;
            $this->Advertisement->UpdateAll($update, $condition);
            $advertisement =$this->Advertisement->get($advertisement->id);
            $user = TableRegistry::get('Users')->get($advertisement->user_id);
            $this->getMailer('User')->send('advertisementDelete', [$user]);   
            // for push notification
            $push['requested_by'] = $this->Auth->user('id');
            $push['username'] = $this->Auth->user('display_name');
            $push['requested_to'] = $user->id;
            $push['slug'] = $pushNotificationAdminSlug['advertisement-deleted'];            
            $this->Push->sendPushNotification($push);
            $result_arr = ['result' => true, 'status'=>$advertisement->status, 'id'=>$advertisement->id, 'message' => ucwords($advertisement->name).' '.$this->errorSuccessMessage['DELETED-MSG']];  
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('advertisement'));
    }
}
