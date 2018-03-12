<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;
use \Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Api\Utils\Utils;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;
/**
 * JoinSpaycs Controller
 *
 *
 * @method \Api\Model\Entity\JoinSpayc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JoinSpaycsController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Matrix');
    }
    
    public function joinSpayc(){
         if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $user = $this->Auth->user();
        $data['user_id'] = $user['id'];
        $data['matrix_token'] = $user['UserLogs']['matrix_access_token'];        
        $data['matrix_user_id'] = $user['UserLogs']['matrix_user_id'];        
        $errors = $jsModel->ValidateJoinSpayc($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $spaycs = TableRegistry::get('Spaycs')->find()->where(['id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Spayc is not exist.')], 400);
        }
        $spayc = $spaycs->first();
        $data['matrix_room_id'] = $spayc->matrix_room_id;
        if(($spayc->group_type == 'Private') && empty($data['passcode'])){
            $data['status'] = 'Pending';
        }elseif(($spayc->group_type == 'Private') && ($spayc->passcode != $data['passcode'])){
            $this->restException(['status'=>'failed','message'=>__('Passcode is not valid.')], 400);
        }
        
        $entities = $jsModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['JoinedSpayc.spayc_id'=>$data['spayc_id'],'JoinedSpayc.user_id'=>$data['user_id']]);        
        if($entities->isEmpty()){
            $entity = $jsModel->newEntity();
            $entity->user_id = $data['user_id'];
            $entity->spayc_id = $data['spayc_id'];
            $entity->status = $data['status'];
            $entity->modified = new \Cake\I18n\Time();
            $entity->updated_by = $this->Auth->user('id');
        }else{
            $entity = $entities->first();           
            $entity->status = $data['status'];
            $entity->modified = new \Cake\I18n\Time();
            $entity->updated_by = $this->Auth->user('id');
        }
        $jsModel->getConnection()->begin();
        if($jsModel->save($entity,['checkRules' => false, 'atomic' => false])){
            if(!empty($data['passcode'])){                
                $data['status'] = 'Joined';
            }
            if($this->Matrix->joinRoom($data)){
//                $push = [
//                    'requested_by'=>$user['id'],
//                    'requested_to'=>$user['id'],
//                ];
//                $push['requested_by'] = $adminUser;
//                $push['requested_to'] =  $data['user_id'];
//                $push['slug'] = 'user-joined-your-spayc';
//                $push['spayc_id'] =  $data['spayc_id'];
//                $push['spayc_name'] = $items['name'];
//                $push['spayc_image'] = $items['image'];
//                $push['matrix_room_id'] = $items['matrix_room_id'];
//                $push['distance'] = $this->getSpaycDistanceFromUser($items['latitude'], $items['longitude'], $push['requested_to']);
//                $pushNotification->sendPushNotification($push);
                $jsModel->getConnection()->commit();
                $response = ['status'=>'success','message'=>__('User has been '.$data['status'].' successfully.')];
            }else{
                $jsModel->getConnection()->rollback();
                $this->response->statusCode(400);
                $response = ['status'=>'failed','message'=>__('System failed to '.$data['status'].'.')];
            }            
        }else{
            $jsModel->getConnection()->rollback();
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('System failed to '.$data['status'].'.')];
        }
        $this->set($response);
    }
}
