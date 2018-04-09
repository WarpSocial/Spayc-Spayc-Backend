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
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        //$this->Auth->allow(['']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Users', 'MatrixRooms', 'ParentSpaycs']
        // ];
        // $spaycs = $this->paginate($this->Spaycs);

        // $this->set(compact('spaycs'));
    }

    /**
     * View method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id= null, $userId= null)
    {
        $this->set('title', 'Warp Detail');
        if((empty($id) || !is_numeric($id)) && (empty($userId) || !is_numeric($userId)))
            return $this->redirect(['Controller'=>'Users', 'action' => 'index']);

        $exists = $this->Spaycs->exists(['id' => $id]);       
        if(!$exists) 
            return $this->redirect(['Controller'=>'Users', 'action' => 'index']);       
       
        $this->Users = TableRegistry::get('Users');        
        $user = $this->Users->get($userId);

        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, 'Accepted');
        $spayc = $this->Spaycs->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.parent_id','Spaycs.created','Spaycs.modified'])
                ->where(['id'=>$id, 'Spaycs.group_type !=' =>'trusted_private'])
                ->contain([
                    'SubSpaycs' => function($q) {
                    $exp = $q->newExpr()->addCase($q->newExpr()->add(['location IS NULL']),"");
                        return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'location'=>$exp, 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id']);
                    },
                    'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin','JoinedSpayc.distance']);//joinded
                    },
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'total_comment' => $q->func()->count('Comments.id')])->group(['Comments.spayc_id']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    }
                ]);
        $spayc->order(['created'=>'DESC']); 
        $spayc->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend, $userId) {
            return $results->map(function ($row) use($friend, $userId) {                
                $row['friends'] = TableRegistry::get('JoinedSpayc')->getTotalJoinedFriends($row->id, $friend);
                $present = 0;$totalJoined=[];
                if(!empty($row['joined_spayc'])) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.']');
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }
                
                if(!empty($joinedStatus[0])){
                    $row['joined_spayc_status'] = $joinedStatus[0]['status'];
                    $row['is_admin'] = $joinedStatus[0]['is_admin'];
                }else{
                    $row['joined_spayc_status'] = '';
                    $row['is_admin'] = '';
                }
                $row['joined_users'] =!empty($row['joined_spayc'])?count($totalJoined):0;
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['total_comment'])?$row['comments'][0]['total_comment']:0;
                unset($row['joined_spayc']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        $spayc = $spayc->first();
        $this->set(compact('spayc','user'));
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

    
}
