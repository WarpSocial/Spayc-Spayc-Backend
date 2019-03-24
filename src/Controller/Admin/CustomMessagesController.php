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
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class CustomMessagesController extends AdminController {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
        $this->loadComponent('Scraper');
        $this->Users = TableRegistry::get('Users');
        $this->CustomMessages = TableRegistry::get('CustomMessages');
        $this->Spaycs = TableRegistry::get('Spaycs');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout', 'forgotPassword', 'resetPassword', 'getUserObj', 'success', 'scraperCall', 'runScrapper']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($userId = null) {
        $this->set('title', $this->siteTitleMessage['MANAGEUSER']);
        $currUser = '';
        if (!empty($userId))
            $currUser = $this->Users->get($userId);
        $query = $this->CustomMessages->find('all');
        $this->paginate = ['order' => ['id' => 'DESC']];
        $messages = $this->paginate($query);
        $this->set(compact('messages', 'keyword', 'currUser'));
        $this->set('_serialize', ['messages']);
    }

    /*     * * get list of Advertisement created by user** */

    public function getCustomMessage() {
        $this->viewBuilder()->layout('');

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $custom = $this->CustomMessages->newEntity();
            if(!empty($data['users'])){
            $custom->user_id = implode(",", $data['users']);
            $custom->message = $data['message'];
            if ($this->CustomMessages->save($custom)) {
                $data['id']=$this->Auth->user('id');
                $data['display_name']=$this->Auth->user('display_name');
                TableRegistry::get('Queue.QueuedJobs')->createJob('CustomMessageNotifications',$data);
              
                $result_arr = ['result' => true, 'message' => $this->errorSuccessMessage['SEND-CUTSOM-MSG']];
            } else {
                $result_arr = ['result' => false, 'message' => $this->errorSuccessMessage['SYSTEMERR']];
            }
            }else{
                $result_arr = ['result' => false, 'message' => $this->errorSuccessMessage['INVALIDUSER']];
            }
            echo json_encode($result_arr);
            die;
        }
        //return $this->render('custom_message');
    }

    public function sendCustomMessages($id) {
        $this->viewBuilder()->layout('');
        $this->autoRender = false;
        if (empty($id)) {
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id);
        $statusArr = unserialize(STATUS_ARR);
        $pushNotificationAdminSlug = unserialize(PUSH_NOTIFICATION_ADMIN_SLUG);
        $txtMassage = unserialize(TEXT_MASSAGE);
        $this->set(compact('user'));
    }
    
    public function userList() {
        $this->viewBuilder()->layout('');
        $this->autoRender = false;
        $data = $this->request->getData();
        $obj = TableRegistry::get('Users')->find()->select(['Users.id','Users.display_name','email'])
                ->contain([
                    'UserImages'=>function($q) {
                        return $q->select(['UserImages.id','UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
                    },  
                ])
                ->order(['Users.display_name'=>'ASC'])
                ->where(['Users.role_id IS NULL','Users.email !='=>SCRAPER_EMAIL]);
                    
        if(!empty($data['q']['term'])){
            $obj->orWhere(['OR' => [
                'LOWER(Users.display_name) LIKE' => "%". strtolower($data['q'])."%",
                'LOWER(Users.email) LIKE' => '%'.strtolower($data['q']).'%',
                'LOWER(Users.full_name) LIKE' => '%'.strtolower($data['q']).'%',
                ]]);
        }
        
        $users = $obj->map(function($row){
            return [
                'id'=>$row->id,
                'text'=> ucwords($row->display_name),
                'avatar_url' => !empty($row->user_images)?$row->user_images[0]->image_url:''
                ];
            });
        
        echo json_encode($users);die;
        
    }

}
