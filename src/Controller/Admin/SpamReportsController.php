<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * SpamReports Controller
 *
 * @property \App\Model\Table\SpamReportsTable $SpamReports
 */
class SpamReportsController extends AdminController
{

    public function initialize() {
        parent::initialize();        
        $this->loadComponent('Api.Matrix');
        $this->loadComponent('Api.Push');
        $this->Users = TableRegistry::get('Users');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('title', $this->siteTitleMessage['MANAGE-SPAM-REPORT']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';;
        $query = $this->SpamReports->getspamReportObj($keyword);
        $this->paginate = ['order' => ['SpamReports.reported_to' => 'DESC']];
        $spamReports = $this->paginate($query);
        $this->set(compact('spamReports'));
    }
    
    public function banSpaycMember($spaycId, $userId, $status=BANNED) {
        
        $this->viewBuilder()->layout('');
        $spayc = TableRegistry::get('Spaycs')->get($spaycId);   
        $jsModel = TableRegistry::get('JoinedSpayc');
        $BannedUserStatus = $jsModel->getJoinedSpaycObj($spaycId, $userId);
        if ($this->request->is(['post','put'])) {
           $spamUserObj = $this->Users->get($userId);
           $data['matrix_room_id']=$spayc->matrix_room_id;
           $data['matrix_user_id']=$spamUserObj->matrix_user_id;
           $data['matrix_token'] = $this->Users->get($spayc->user_id)->matrix_access_token;
           $data['status'] = $status;
           $matrix = $this->Matrix->banMember($data);
            if($status == UNBANNED){
                $data['status'] = JOINED;
                $BannedUserStatus->status = JOINED;
                $this->Matrix->joinRoom($data);
            } else {                
                $BannedUserStatus->status = $status;
            }
            $this->Matrix->muteUnmute('mute',$spamUserObj->matrix_access_token, $spayc->matrix_room_id);
            if($jsModel->save($BannedUserStatus)){                        
                if($status == BANNED){
                    TableRegistry::get('Api.SubscribedUsers')->removeSubscription($userId,$spayc->id);                
                }
                $response = ['result' => true, 'status'=>$status,'res'=>$spaycId.'-'.$userId, 'message'=> 'User has been '.strtolower($status).' successfully.'];
            }
            echo json_encode($response);
            die;
        }
        $this->set(compact('spayc', 'BannedUserStatus'));
        $this->set('_serialize', ['spayc']);
    }

    /**
     * View method
     *
     * @param string|null $id Spam Report id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $spamReport = $this->SpamReports->get($id, [
            'contain' => []
        ]);

        $this->set('spamReport', $spamReport);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $spamReport = $this->SpamReports->newEntity();
        if ($this->request->is('post')) {
            $spamReport = $this->SpamReports->patchEntity($spamReport, $this->request->getData());
            if ($this->SpamReports->save($spamReport)) {
                $this->Flash->success(__('The spam report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spam report could not be saved. Please, try again.'));
        }
        $this->set(compact('spamReport'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spam Report id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $spamReport = $this->SpamReports->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $spamReport = $this->SpamReports->patchEntity($spamReport, $this->request->getData());
            if ($this->SpamReports->save($spamReport)) {
                $this->Flash->success(__('The spam report has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The spam report could not be saved. Please, try again.'));
        }
        $this->set(compact('spamReport'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spam Report id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spamReport = $this->SpamReports->get($id);
        if ($this->SpamReports->delete($spamReport)) {
            $this->Flash->success(__('The spam report has been deleted.'));
        } else {
            $this->Flash->error(__('The spam report could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
