<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WebApi Controller
 *
 * @property \Api\Model\Table\WebApiTable $WebApi
 */
class WebApiController extends AppController {

    /**
     * initialize the controller config
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Matrix');
        $this->loadComponent('Api.Push');
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['addCategory', 'apilog', 'addComment', 'notify']);
    }

    public function spamReport() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $srRegistory = TableRegistry::get('Api.SpamReports');
        $errors = $srRegistory->validateInput($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $reportedUser = TableRegistry::get('Api.Users')->findByMatrixUserId($data['reported_to'])->first();
        $spaycs = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($data['matrix_room_id'])->first();
        if($reportedUser->id == $user['id']){
            $this->restException(['status'=>'failed', 'message'=>__('Youd couldn\'t make himself as spam user.')], 400);
        }
        if($srRegistory->exists(['reported_to'=>$reportedUser->id,'reported_by'=>$user['id'],'spayc_id'=>$spaycs->id])){
            $this->restException(['status'=>'failed', 'message'=>__('You have already reported this user as spam user.Admin will take care about this reports.')], 400);
        }
        $srEntity = $srRegistory->newEntity();
        $srEntity->spayc_id = $spaycs->id;
        $srEntity->reported_by = $user['id'];
        $srEntity->reported_to = $reportedUser->id;
        $srEntity->event_id = $data['event_id'];
        if($srRegistory->save($srEntity)){
            $this->restException(['status'=>'success', 'message'=>__('You have reported successfully.')], 200);
        }else{
            $this->restException(['status'=>'failed', 'message'=>__('Failed to make user as spam user.')], 400);
        }
    }

    public function apilog() {
        $del = $this->request->getQuery('clean');
        $logfile = $this->request->getQuery('file', 'api.log');
        $file = new \Cake\Filesystem\File(LOGS . $logfile);
        if (!empty($del) && ($del == 1)) {
            $file->write(null);
        }
        $errorfile = $file->read();
        pr($errorfile);
        die;
        $this->set(print_r($errorfile, false));
    }

    public function notify() {
        $this->loadComponent('Api.Notification');
        $items = $this->request->getData();
        $deviceToken = $this->request->getData('device_token');
        //$this->Push->sendOnIOS($items);
        $this->Notification->iosPush($items, $deviceToken);
    }

}
