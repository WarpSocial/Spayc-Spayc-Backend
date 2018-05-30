<?php
namespace App\Controller\Admin;

use App\Controller\AdminController;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Api\Auth\ApiHasher;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Api\Utils\Utils;


/**
 * Spaycs Controller
 *
 * @property \App\Model\Table\SpaycsTable $Spaycs
 */
class SpaycsController extends AdminController
{

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();        
        $this->loadComponent('Api.Push');
        $this->Users = TableRegistry::get('Users');        
        $this->FRIEND_REQUESTED_STATUS_ARR = unserialize(FRIEND_REQUESTED_STATUS_ARR);
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
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):'';
        $query = $this->Spaycs->getWarpList();
        if(!empty($keyword))
            $query->where(['OR' => [['LOWER(name) LIKE' => "%".$keyword."%"]]]);
        
        $this->paginate['sortWhitelist'] = ['name','start_date','Users.display_name'];
        $spaycs = $this->paginate($query);           
        $this->set(compact('spaycs','keyword'));
        $this->set('_serialize', ['spaycs']);
    }

    public function physicalPresents($spaycId){        

        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $conditions_array = [];
        $ageArr = unserialize(USER_AGE);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):'';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Users->getUsersList($spaycId, PHYSICAL_PRESENT_USERS);
        
        if ($this->request->query('gender') && $this->request->query('gender') !='All') {
            $conditions_array['Users.gender'] = $this->request->query('gender');
        }
        if ($this->request->query('from_date')) {            
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') >="] = date(DATEFORMAT,strtotime($this->request->query('from_date')));
        }
        if ($this->request->query('to_date')) {
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') <="] = date(DATEFORMAT,strtotime($this->request->query('to_date')));
        }
        if ($this->request->query('age_filter')) {
            $getage=$ageArr[$this->request->query('age_filter')];
            $getage = explode("-", $getage );   
            $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) >="] = $getage['0'];           
            if((int)($getage['1'])){                
               $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) <="] = $getage['1'];
            } 
        }         
        if(!empty($keyword)){
            $query->where(['OR' => [['LOWER(Users.display_name) LIKE' => "%".$keyword."%"], ['LOWER(Users.email) LIKE' => "%".$keyword."%"], ['LOWER(Users.address) LIKE' => "%".$keyword."%"],['LOWER(Users.username) LIKE' => "%".$keyword."%"]]]);
        } 
        if (count($conditions_array)) {
            $query->where($conditions_array);
        }         
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);   
        $this->set(compact('users','keyword','spayc'));
        $this->set('_serialize', ['users']);
    }
    
    /*** get list of warp members ***/
    public function spaycMembers($spaycId){

        if(empty($spaycId))
            return $this->redirect(['action' => 'index']);        
        $this->set('title', $this->siteTitleMessage['MANAGE-WARP-MEMBERS']);
        $conditions_array = [];
        $ageArr = unserialize(USER_AGE);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):''; 
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Spaycs->getWarpMembers($spaycId); 
         if ($this->request->query('gender') && $this->request->query('gender') !='All') {
            $conditions_array['Users.gender'] = $this->request->query('gender');
        }
        if ($this->request->query('from_date')) {            
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') >="] = date(DATEFORMAT,strtotime($this->request->query('from_date')));
        }
        if ($this->request->query('to_date')) {
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') <="] = date(DATEFORMAT,strtotime($this->request->query('to_date')));
        }
        if ($this->request->query('age_filter')) {
            $getage=$ageArr[$this->request->query('age_filter')];
            $getage = explode("-", $getage );   
            $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) >="] = $getage['0'];           
            if((int)($getage['1'])){                
               $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) <="] = $getage['1'];
            } 
        }       
        if(!empty($keyword)){
            $query->where(['OR' => [['LOWER(Users.display_name) LIKE' => "%".$keyword."%"], ['LOWER(Users.email) LIKE' => "%".$keyword."%"], ['LOWER(Users.address) LIKE' => "%".$keyword."%"],['LOWER(Users.username) LIKE' => "%".$keyword."%"]]]);
        } 
        if (count($conditions_array)) {
            $query->where($conditions_array);
        } 
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);         
        $this->set(compact('users','keyword','spayc'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id= null, $userId= null, $subspayc=null)
    {   
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        if((empty($id) || !is_numeric($id)) && (empty($userId) || !is_numeric($userId)))
            return $this->redirect(['Controller'=>'Users', 'action' => 'index']);

        $exists = $this->Spaycs->exists(['id' => $id]);       
        if(!$exists) 
            return $this->redirect(['Controller'=>'Users', 'action' => 'index']);
                
        $user = $this->Users->get($userId);
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, $this->FRIEND_REQUESTED_STATUS_ARR['accepted']);
        $spayc = $this->Spaycs->getWarpsViewBySpaycId($id, $userId, $friend);     
        $this->set(compact('spayc','user','subspayc'));
        $this->set('_serialize', ['spayc']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
        $matrixRooms = $this->Spaycs->MatrixRooms->find('list', ['limit' => 200]);
        $parentSpaycs = $this->Spaycs->ParentSpaycs->find('list', ['limit' => 200]);
        $this->set(compact('spayc', 'users', 'matrixRooms', 'parentSpaycs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
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
        $matrixRooms = $this->Spaycs->MatrixRooms->find('list', ['limit' => 200]);
        $parentSpaycs = $this->Spaycs->ParentSpaycs->find('list', ['limit' => 200]);
        $this->set(compact('spayc', 'users', 'matrixRooms', 'parentSpaycs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $spayc = $this->Spaycs->get($id);
        if ($this->Spaycs->delete($spayc)) {
            $this->Flash->success(__('The spayc has been deleted.'));
        } else {
            $this->Flash->error(__('The spayc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*** get list of warp members ***/
    public function subscribedMembers($spaycId){    
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $conditions_array = [];
        $ageArr = unserialize(USER_AGE);
        $keyword=($this->request->query('keyword'))?trim(strtolower($this->request->query('keyword'))):'';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Users->getUsersList($spaycId, SUBSCRIBED_USERS);
        
        if ($this->request->query('gender') && $this->request->query('gender') !='All') {
            $conditions_array['Users.gender'] = $this->request->query('gender');
        }
        if ($this->request->query('from_date')) {            
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') >="] = date(DATEFORMAT,strtotime($this->request->query('from_date')));
        }
        if ($this->request->query('to_date')) {
            $conditions_array["to_date(cast(created as TEXT),'YYYY-MM-DD') <="] = date(DATEFORMAT,strtotime($this->request->query('to_date')));
        }
        if ($this->request->query('age_filter')) {
            $getage=$ageArr[$this->request->query('age_filter')];
            $getage = explode("-", $getage );   
            $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) >="] = $getage['0'];           
            if((int)($getage['1'])){                
               $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) <="] = $getage['1'];
            } 
        }         
        if(!empty($keyword)){
            $query->where(['OR' => [['LOWER(Users.display_name) LIKE' => "%".$keyword."%"], ['LOWER(Users.email) LIKE' => "%".$keyword."%"], ['LOWER(Users.address) LIKE' => "%".$keyword."%"],['LOWER(Users.username) LIKE' => "%".$keyword."%"]]]);
        } 
        if (count($conditions_array)) {
            $query->where($conditions_array);
        }         
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);   
        $this->set(compact('users','keyword','spayc'));
        $this->set('_serialize', ['users']);
    }

    /*** get list of sub wraps by spaycId ***/
    public function subwarps($spaycId) { 
        if((empty($spaycId) || !is_numeric($spaycId)))
            return $this->redirect(['action' => 'index']);
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $spayc = $this->Spaycs->getSubwarpsListBySpaycId($spaycId);
        $this->set(compact('spayc'));
        $this->set('_serialize', ['spayc']);
    }
    
    public function setSpaycStatus($id, $status = 'Blocked') {
        
        $this->viewBuilder()->layout('');
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);  
        }        
        $spayc = $this->Spaycs->get($id);  
        $statusArr = unserialize(STATUS_ARR);
        $pushNotificationAdminSlug = unserialize(PUSH_NOTIFICATION_ADMIN_SLUG);
        $txtMassage = unserialize(TEXT_MASSAGE);               
        if ($this->request->is(['post','put'])) {    
            if(!empty($spayc->status) && ucfirst($spayc->status) == $statusArr['active'] ){
                $spayc->status = $statusArr['inactive'];
            }else{
                $spayc->status = $statusArr['active'];
            }

            if ($this->Spaycs->save($spayc)) {
                $spayc_id=$spayc->id;
//                $spayc =$this->Spaycs->get($spayc->id);
                 $spaycs = $this->Spaycs->find();
        $spaycs->select()            
             ->where(['id'=>$spayc->id])
                ->contain([
                 'JoinedSpayc' => function($q) {
                     return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);
                 }   ]);
            
//                  $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($spayc_id){
//                          return $results->map(function ($row) use($spayc_id) {
//                $row['joined_users'] = TableRegistry::get('JoinedSpayc')->getJoinedUserIds($spayc_id);
//                $present = 0;$totalJoined=[];
//                if(!empty($row['joined_users'])) {
////                    $joinedStatus = \Cake\Utility\Hash::extract($row['joined_users'],'{n}[user_id='.$userId.']');
//                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_users'],'{n}[status=Joined].status');
//                }
//                return $row;
//            });
//                  });
                  // pr($spaycs->toArray());die;
                $displayName = !empty($spayc->name)? ucfirst($spayc->name) :SITE_TITLE;
                if (ucfirst($spayc->status) == $statusArr['active']) {
                    $spayc->statusTxt = $txtMassage['unblock'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['unblocked'];
                    $result_arr = ['result' => true, 'status'=>$statusArr['active'], 'message' => $displayName.' '.$this->errorSuccessMessage['UNBLOCKED-MSG']]; 
                     $this->activeSubSpaycStatus($spayc->id,$statusArr['active']);
                } else {                       
                    $spayc->statusTxt = $txtMassage['block'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['blocked'];
                    $result_arr = ['result' => true, 'status'=>$statusArr['inactive'], 'message' => $displayName.' '.$this->errorSuccessMessage['BLOCKED-MSG']];   
                     $update=$this->inactiveSubSpaycStatus($spayc->id,$statusArr['inactive']);
                }
                if(!empty($spayc->email))
                    $this->getMailer('User')->send('userStatus', [$spayc]);   
                // for push notification
                $push['requested_by'] = $this->Auth->user('id');
                $push['username'] = $this->Auth->user('display_name');
                $push['requested_to'] = $spayc->id;
                $push['slug'] = $pushNotificationAdminSlug;
                $this->Push->sendPushNotification($push);
            } else {                
                $result_arr = ['result' => false, 'status'=>'', 'message' => $this->errorSuccessMessage['SYSTEMERR']];   
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('spayc'));
    }
    
    
    public function deleteSpayc($id) {
        
        $this->viewBuilder()->layout('');
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);  
        }        
        $spayc = $this->Spaycs->get($id);    
        if ($this->request->is(['post','put'])) {    
            if(!empty($spayc)){
            $displayName = !empty($spayc->name)? ucfirst($spayc->name) : SITE_TITLE;
            if ($this->Spaycs->delete($spayc)) {              
              $result_arr = ['result' => true,  'message' => $displayName.' '.$this->errorSuccessMessage['DELETED-MSG']]; 
            } else {                
                $result_arr = ['result' => false, 'status'=>'', 'message' => $this->errorSuccessMessage['SYSTEMERR']];   
            }
            } else {                
                $result_arr = ['result' => false, 'status'=>'', 'message' => $this->errorSuccessMessage['SYSTEMERR']];   
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('spayc'));
    }
    
    
    public function inactiveSubSpaycStatus($parent_id,$status) {
        $conn = ConnectionManager::get('default');
        $sql="UPDATE ".SPAYC_TABLE." set last_status = status where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        
        $sql="UPDATE ".SPAYC_TABLE." set status = '".$status."' where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }
    
    public function activeSubSpaycStatus($parent_id,$status) {
        $conn = ConnectionManager::get('default');
        $sql="UPDATE ".SPAYC_TABLE." set status = last_status where parent_id = $parent_id AND last_status is NOT NULL";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        $sql="UPDATE ".SPAYC_TABLE." set last_status = NULL where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }

}
