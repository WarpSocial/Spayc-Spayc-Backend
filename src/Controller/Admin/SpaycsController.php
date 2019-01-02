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
class SpaycsController extends AdminController {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
        $this->Users = TableRegistry::get('Users');     
        $this->loadComponent('Api.Matrix');
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
    public function index() {
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';
        $query = $this->Spaycs->getWarpList();
        if (!empty($keyword))
            $query->where(['OR' => [['LOWER(name) LIKE' => "%" . $keyword . "%"]]]);

        $this->paginate['sortWhitelist'] = ['name', 'start_date', 'Users.display_name'];
        $spaycs = $this->paginate($query);
        $this->set(compact('spaycs', 'keyword'));
        $this->set('_serialize', ['spaycs']);
    }

    public function physicalPresents($spaycId) {

        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Users->getUsersList($spaycId, PHYSICAL_PRESENT_USERS);
        $conditions_array = $this->filterData();
        $query = $this->filterNSearchData($query, $keyword, $conditions_array);
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);
        $this->set(compact('users', 'keyword', 'spayc'));
        $this->set('_serialize', ['users']);
    }

    /*     * * get list of warp members ** */

    public function spaycMembers($spaycId) {

        if (empty($spaycId))
            return $this->redirect(['action' => 'index']);
        $this->set('title', $this->siteTitleMessage['MANAGE-WARP-MEMBERS']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Spaycs->getWarpMembers($spaycId);
        $conditions_array = $this->filterData();
        $query = $this->filterNSearchData($query, $keyword, $conditions_array);
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);
        $this->set(compact('users', 'keyword', 'spayc'));
        $this->set('_serialize', ['users']);
    }
    public function reportedUsers($spaycId) {

        if (empty($spaycId))
            return $this->redirect(['action' => 'index']);
        $this->set('title', $this->siteTitleMessage['MANAGE-WARP-MEMBERS']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Spaycs->reportedWarpUsers($spaycId);
        $conditions_array = $this->filterData();
        $query = $this->filterNSearchData($query, $keyword, $conditions_array);
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);
        $this->set(compact('users', 'keyword', 'spayc'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $userId = null, $subspayc = null) {
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        if ((empty($id) || !is_numeric($id)) && (empty($userId) || !is_numeric($userId)))
            return $this->redirect(['Controller' => 'Users', 'action' => 'index']);

        $exists = $this->Spaycs->exists(['id' => $id]);
        if (!$exists)
            return $this->redirect(['action' => 'index']);

        $user = $this->Users->get($userId);
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, $this->FRIEND_REQUESTED_STATUS_ARR['accepted']);
        $spayc = $this->Spaycs->getWarpsViewBySpaycId($id, $userId, $friend);
        $this->set(compact('spayc', 'user', 'subspayc'));
        $this->set('_serialize', ['spayc']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
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
    public function edit($id = null) {
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
    public function delete($id = null) {
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
    public function subscribedMembers($spaycId) {
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $keyword = ($this->request->query('keyword')) ? trim(strtolower($this->request->query('keyword'))) : '';
        $spayc = $this->Spaycs->get($spaycId);
        $query = $this->Users->getUsersList($spaycId, SUBSCRIBED_USERS);
        $conditions_array = $this->filterData();
        $query = $this->filterNSearchData($query, $keyword, $conditions_array);
        $this->paginate = ['order' => ['Users.display_name' => 'ASC']];
        $users = $this->paginate($query);
        $this->set(compact('users', 'keyword', 'spayc'));
        $this->set('_serialize', ['users']);
    }

    /*** get list of sub wraps by spaycId ***/
    public function subwarps($spaycId) {
        if ((empty($spaycId) || !is_numeric($spaycId)))
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
        $pushNotificationAdminSlug = unserialize(PUSH_NOTIFICATION_SPAYC_ADMIN_SLUG);
        $txtMassage = unserialize(TEXT_MASSAGE);
        if ($this->request->is(['post', 'put'])) {
            if (!empty($spayc->status) && ucfirst($spayc->status) == $statusArr['active']) {
                $spayc->status = $statusArr['inactive'];
            } else {
                $spayc->status = $statusArr['active'];
            }

            if ($this->Spaycs->save($spayc)) {
                $spayc_id = $spayc->id;
                $spaycs = $this->Spaycs->find();
                $spaycs->select()
                        ->where(['Spaycs.id' => $spayc->id])
                        ->contain([
                            'Users' => function($q) {
                                return $q->select(['matrix_access_token']);
                            },                                    
                            'JoinedSpayc' => function($q) {
                                return $q->select(['JoinedSpayc.id', 'JoinedSpayc.spayc_id', 'JoinedSpayc.user_id', 'JoinedSpayc.is_admin', 'JoinedSpayc.status', 'JoinedSpayc.distance']);
                            },
                            'JoinedSpayc.Users' => function($q) {
                                return $q->select(['email', 'matrix_user_id','matrix_access_token']);
                            },
                            'SubSpaycs' => function($q){                        
                                $q->select(['SubSpaycs.id','SubSpaycs.name','SubSpaycs.image','SubSpaycs.parent_id','SubSpaycs.matrix_room_id']);
                                return $q;
                            }, 
                            'SubSpaycs.Users' => function($q) {
                                return $q->select(['matrix_access_token']);
                            },        
                            'SubSpaycs.JoinedSpayc.Users' => function($q) {
                                return $q->select(['email', 'matrix_user_id','matrix_access_token']);
                            }        
                ]);
                $spaycs = $spaycs->first()->toArray();
                $spayc = $spaycs;
                $displayName = !empty($spayc['name']) ? ucfirst($spayc['name']) : SITE_TITLE;
                if (ucfirst($spayc['status']) == $statusArr['active']) {
                    $spayc['statusTxt'] = $txtMassage['unblock'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['unblocked'];
                    $result_arr = ['result' => true, 'status' => $statusArr['active'], 'message' => $displayName . ' ' . $this->errorSuccessMessage['UNBLOCKED-MSG']];
                    $this->activeSubSpaycStatus($spayc['id'], $statusArr['active']);
                    $status = UNBANNED;
                } else {
                    $spayc['statusTxt'] = $txtMassage['block'];
                    $pushNotificationAdminSlug = $pushNotificationAdminSlug['blocked'];
                    $result_arr = ['result' => true, 'status' => $statusArr['inactive'], 'message' => $displayName . ' ' . $this->errorSuccessMessage['BLOCKED-MSG']];
                    $update = $this->inactiveSubSpaycStatus($spayc['id'], $statusArr['inactive']);
                    $status = BANNED;
                }
                
                $this->spaycBannedStatus($spayc, $status, $pushNotificationAdminSlug);
                if(!empty($spayc['sub_spaycs'])){
                    foreach($spayc['sub_spaycs'] as $subSpayc){                        
                        $subSpayc['statusTxt'] = $spayc['statusTxt'];
                        $this->spaycBannedStatus($subSpayc, $status, $pushNotificationAdminSlug);
                    }
                }
                //Ban,Mail & Push
            } else {
                $result_arr = ['result' => false, 'status' => '', 'message' => $this->errorSuccessMessage['SYSTEMERR']];
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('spayc'));
    }
    
    public function spaycBannedStatus($spaycs,$status,$notificationSlug) {
        $displayName = !empty($spaycs['name']) ? ucfirst($spaycs['name']) : SITE_TITLE;
        if (!empty($spaycs['joined_spayc'])) {
            foreach ($spaycs['joined_spayc'] as $val) {
                if($val['is_admin'] == 2){
                    continue;
                }
                $email['email'] = $val['user']['email'];
                $email['status'] = $status;
                $email['name'] = $displayName;
                $email['statusTxt'] = $spaycs['statusTxt'];

                // for push notification
                $push['requested_by'] = $this->Auth->user('id');
                $push['username'] = $this->Auth->user('display_name');
                $push['requested_to'] = $val['user_id'];
                $push['slug'] = $notificationSlug;
                $this->Push->sendPushNotification($push);

                //Ban from Matrix
                $jsModel = TableRegistry::get('Api.JoinedSpayc');
                
                if (!empty($spaycs['user'])) {
                    $data['matrix_user_id'] = $val['user']['matrix_user_id'];
                    $data['matrix_token'] = $spaycs['user']['matrix_access_token'];
                    $data['matrix_room_id'] = $spaycs['matrix_room_id'];

                    $data['status'] = $jStatus = $status;
                    $matrix = $this->Matrix->banMember($data);
                    //if (!is_string($matrix)) {
                        if ($status == UNBANNED) {
                            $jStatus = JOINED;
                            $this->Matrix->joinRoom([
                                'status'=>JOINED,
                                'matrix_user_id' => $val['user']['matrix_user_id'],
                                'matrix_token' => $val['user']['matrix_access_token'],
                                'matrix_room_id' => $spaycs['matrix_room_id'],
                            ]);
                        }
                        $this->Matrix->muteUnmute('mute', $val['user']['matrix_access_token'], $spaycs['matrix_room_id']);

                        $update['status'] = $jStatus;
                        $update['updated_by'] = $this->Auth->user('id');
                        $condition['id'] = $val['id'];
                        $success = $jsModel->UpdateAll($update, $condition);
                        if ($success)
                            TableRegistry::get('Api.SubscribedUsers')->removeSubscription($val['user_id'], $val['spayc_id']);
                    //}
                }
                $this->getMailer('User')->send('spaycStatus', [$email]);
            }
        }
    }

    public function deleteSpayc($id) {

        $this->viewBuilder()->layout('');
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);  
        }  
        $admin_slug_arr = unserialize(ADMIN_SLUG_ARR);   
        $spayc= $this->Spaycs->spaycObj($id); 
        if ($this->request->is(['post','put'])) {    
            if(!empty($spayc)){
                $displayName = !empty($spayc->name)? ucfirst($spayc->name) : SITE_TITLE;
                $user= $this->Users->get($spayc->user_id);
                $spayc->set('matrix_access_token',$user->matrix_access_token);
                $spayc->set('spayc-deleted-by-admin',$admin_slug_arr['spayc-deleted']);
                /* To queue the job to process from backend system */
                TableRegistry::get('Queue.QueuedJobs')->createJob('Delete', $spayc->toArray());
                $matrixRoomIds = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.matrix_room_id');
                array_push($matrixRoomIds, $spayc->matrix_room_id);
                $child = \Cake\Utility\Hash::extract($spayc->sub_spaycs, '{n}.id');
                array_push($child, $spayc->id);
                if ($this->Spaycs->delete($spayc)) {
                    $this->Spaycs->deleteAllSpaycObj($child);
                    $result_arr = ['result' => true, 'message' => $displayName . ' ' . $this->errorSuccessMessage['DELETED-MSG']];
                } else {
                    $result_arr = ['result' => false, 'status' => '', 'message' => $this->errorSuccessMessage['SYSTEMERR']];
                }
            } else {
                $result_arr = ['result' => false, 'status' => '', 'message' => $this->errorSuccessMessage['SYSTEMERR']];
            }
            echo json_encode($result_arr);
            die;
        }
        $this->set(compact('spayc'));
    }

    public function inactiveSubSpaycStatus($parent_id, $status) {
        $conn = ConnectionManager::get('default');
        $sql = "UPDATE " . SPAYC_TABLE . " set last_status = status where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');

        $sql = "UPDATE " . SPAYC_TABLE . " set status = '" . $status . "' where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }

    public function activeSubSpaycStatus($parent_id, $status) {
        $conn = ConnectionManager::get('default');
        $sql = "UPDATE " . SPAYC_TABLE . " set status = last_status where parent_id = $parent_id AND last_status is NOT NULL";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        $sql = "UPDATE " . SPAYC_TABLE . " set last_status = NULL where parent_id = $parent_id ";
        $stmt = $conn->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }

    public function filterData($filter = null) {
        $conditions_array = [];
        $ageArr = unserialize(USER_AGE);
        if ($this->request->query('gender') && $this->request->query('gender') != 'All') {
            $conditions_array['Users.gender'] = $this->request->query('gender');
        }
        if ($this->request->query('from_date')) {
            $conditions_array["to_date(cast(Users.created as TEXT),'YYYY-MM-DD') >="] = date(DATEFORMAT, strtotime($this->request->query('from_date')));
        }
        if ($this->request->query('to_date')) {
            $conditions_array["to_date(cast(Users.created as TEXT),'YYYY-MM-DD') <="] = date(DATEFORMAT, strtotime($this->request->query('to_date')));
        }
        if ($this->request->query('age_filter')) {
            $getage = $ageArr[$this->request->query('age_filter')];
            $getage = explode("-", $getage);
            $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) >="] = $getage['0'];
            if ((int) ($getage['1'])) {
                $conditions_array["DATE_PART('year', now()) - DATE_PART('year', dob) <="] = $getage['1'];
            }
        }
        return $conditions_array;
    }

    public function filterNSearchData($query, $keyword, $conditions_array) {
        if (!empty($keyword)) {
            $query->where(['OR' => [['LOWER(Users.display_name) LIKE' => "%" . $keyword . "%"], ['LOWER(Users.email) LIKE' => "%" . $keyword . "%"], ['LOWER(Users.address) LIKE' => "%" . $keyword . "%"], ['LOWER(Users.username) LIKE' => "%" . $keyword . "%"]]]);
        }
        if (count($conditions_array)) {
            $query->where($conditions_array);
        }
        return $query;
    }
    
    /*** get list of comments from matrix for a warp ***/
    public function comments($spaycMatrixRoomId = null) {        
        if (empty($spaycMatrixRoomId)) 
            return $this->redirect(['action' => 'index']);
        $this->set('title', $this->siteTitleMessage['MANAGEWARPS']);
        $chat_msg_type = unserialize(CHAT_MSG_TYPE);
        $eventsRepo = TableRegistry::get('Events');
        $query = $eventsRepo->getComments($spaycMatrixRoomId);  
        $totalComments = $query->count();
        $this->paginate['order'] = ['stream_ordering' => 'Desc'];
        $comments = $this->paginate($query);   
        $this->set(compact('comments','totalComments'));
        $this->set('_serialize', ['comments']);
    }
    /**
     * scrapperEvents get the all events which scrapped on current date
     */
    public function scrapperEvents(){
        $clientTimezone = $this->request->query('timezone',null);
        $items = ['status'=>1,'message'=>'Scrapper events']; 
        if(empty($clientTimezone) || !preg_match('/[(.*)\/(.*)]/', $clientTimezone)){
            $clientTimezone = 'America/New_York';
        }        
        $now = new \Cake\I18n\Time('now',$clientTimezone);
        $endOfDay = clone $now;
        $now->modify('today');
        $endOfDay->modify('tomorrow');  
        $endOfDay->modify('1 second ago'); 
        $beginOfDay = $now->setTimezone('UTC')->format('Y-m-d H:i');
        $endOfDay = $endOfDay->setTimezone('UTC')->format('Y-m-d H:i');
        $scrapped = TableRegistry::get('ScraperLogs')->find()->order(['id'=>'desc'])->first();
        $items['last_scrapped'] = $scrapped->created->setTimezone($clientTimezone)->format('m-d-Y h:i:s a');
        $data = $this->Spaycs->find()->select(['id','website'])->where(function (\Cake\Database\Expression\QueryExpression $exp, \Cake\ORM\Query $q)use($beginOfDay,$endOfDay) {
            $created = "TO_TIMESTAMP(cast(Spaycs.created as text),'YYYY-MM-DD HH24:MI')";
            return $exp->between($created, $beginOfDay, $endOfDay);
        })->orWhere(function (\Cake\Database\Expression\QueryExpression $exp, \Cake\ORM\Query $q)use($beginOfDay,$endOfDay) {
            $modified = "TO_TIMESTAMP(cast(Spaycs.modified as text),'YYYY-MM-DD HH24:MI')"; 
            return $exp->between($modified, $beginOfDay, $endOfDay);
        })->where(['status'=>ACTIVE]);
        $eventBrite = \Cake\Utility\Hash::extract($data->toArray(),'{n}[website='.EVENT_BRITE.']' );
        $ticketMaster = \Cake\Utility\Hash::extract($data->toArray(),'{n}[website='.TICKET_MASTER.']' );
        $items['events'][EVENT_BRITE] =  !empty($eventBrite)?count($eventBrite):0;
        $items['events'][TICKET_MASTER] =  !empty($ticketMaster)?count($ticketMaster):0;
        $items['events']['total'] =  $items['events'][EVENT_BRITE] + $items['events'][TICKET_MASTER];
        $response = $this->response->withType('json')->withStringBody(json_encode($items));
        return $response;
    }
    
}
