<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;


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
        $this->Auth->allow(['addCategory', 'apilog', 'addComment', 'notify','updateComment']);
    }
    
    public function eventsImage(){
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $matrixRoomId = $this->request->query('events');
        if(empty($matrixRoomId)){
            $this->restException(['status' => 'failed', 'message' => __('Events key is required.')], 405);
        }
        $images = TableRegistry::get("Api.Spaycs")->find('list', [
            'keyField' => 'matrix_room_id',
            'valueField' => 'image'])->where(['matrix_room_id IN'=>explode(',',$matrixRoomId),'image !='=>'']);
        
        $this->restException([
            'status'=>'success',
            'message'=>__('List of events image.'),
            'data'=>$images
        ]);
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
        $joinedCheck = TableRegistry::get('Api.JoinedSpayc')->find()->where(['spayc_id'=>$spaycs->id,'user_id IN'=>[$reportedUser->id,$user['id']]])->toArray();
        $loggedUserStatus = Hash::extract($joinedCheck, '{n}[user_id='.$user['id'].']');
        $reportedUserStatus = Hash::extract($joinedCheck, '{n}[user_id='.$reportedUser->id.']');
        if(empty($loggedUserStatus)){
            $this->restException(['status'=>'failed', 'message'=>__('Your are not joined with this warp.')], 400);
        }
        if(empty($reportedUserStatus)){
            $this->restException(['status'=>'failed', 'message'=>__('Reported user has not been joined with this warp.')], 400);
        }
        if($srRegistory->exists(['reported_to'=>$reportedUser->id,'reported_by'=>$user['id'],'event_id'=>$data['event_id']])){
            $this->restException(['status'=>'failed', 'message'=>__('You have already reported this user as spam user.Admin will take care about this reports.')], 400);
        }
        $srEntity = $srRegistory->newEntity();
        $srEntity->spayc_id = $spaycs->id;
        $srEntity->reported_by = $user['id'];
        $srEntity->reported_to = $reportedUser->id;
        $srEntity->event_id = $data['event_id'];
        if($srRegistory->save($srEntity)){
            $this->restException(['status'=>'success', 'message'=>__('You have reported successfully.'),'data'=>[]], 200);
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
    /**
     * updateComment method to update the comment
     * 
     * @param String $matrixRoomId existing matrix room id
     * @return Object json object containing status and message.
     */
    public function updateComment($matrixRoomId = null){
        if (!$this->request->is(['put'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        if(is_null($matrixRoomId)){
            $this->restException(['status'=>'success', 'message'=>__('Matrix room id is required')], 200);
        }
        $spayc = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($matrixRoomId,['fields'=>['id']])->first();        
        if(empty($spayc)){
            $this->restException(['status'=>'success', 'message'=>__('Matrix room id is not valid.')], 200);
        }
        $data['spayc_id'] = $spayc['id'];
        TableRegistry::get('Api.Comments')->spaycActivities($matrixRoomId,$data);
        $this->restException(['status'=>'success', 'message'=>__('Request proccess successfully.')], 200);
    }

}
