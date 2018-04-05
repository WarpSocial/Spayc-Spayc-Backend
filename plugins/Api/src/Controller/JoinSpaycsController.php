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
use Cake\Utility\Hash;
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
        $this->loadComponent('Api.Push');
    }
    
    public function joinSpayc() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $user = $this->Auth->user();
        $data['user_id'] = $user['id'];
        $data['matrix_token'] = $user['UserLogs']['matrix_access_token'];        
        $data['matrix_user_id'] = $user['UserLogs']['matrix_user_id'];        
        $errors = $jsModel->ValidateStatus($data,['Pending','Joined']);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id'=>$user['id']]);
                    },
                ])
                ->where(['id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Spayc is not exist.')], 400);
        }
        $spayc = $spaycs->first();
        if(!empty($spayc->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Not allowed to join sub spayc.')], 400);
        }
        
        if(($spayc->group_type == 'Public') && ($data['status'] == 'Pending')){
            $this->restException(['status'=>'failed','message'=>__('Invalid status for public spayc.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        if(!empty($currentUserStatus[0])){
            $currentUserStatus = $currentUserStatus[0];
            if($currentUserStatus->is_admin > 0){
                $this->restException(['status'=>'failed','message'=>__('Admin could\'t change their own status')], 400);
            }
            if(($currentUserStatus->status == 'Joined') && ($data['status'] == 'Pending')){
                $this->restException(['status'=>'failed','message'=>__('You are already part of this spayc.')], 400);
            }
            if($currentUserStatus->status == $data['status']){
                if($data['status'] == 'Joined'){
                    $message = __('You have already joined with this spayc');
                }else{
                    $message = __('Your could\'t join with same status.');
                }
                $this->restException(['status'=>'failed','message'=>$message], 400);
            }
        }
        $data['matrix_room_id'] = $spayc->matrix_room_id;
        if(($spayc->group_type == 'Private') && empty($data['passcode'])){
            $data['status'] = 'Pending';
        }elseif(($spayc->group_type == 'Private') && ($spayc->passcode != $data['passcode'])){
            $this->restException(['status'=>'failed','message'=>__('Passcode is not valid.')], 400);
        }
        
        $entities = $jsModel->find('all',['field'=>['id','user_id','spayc_id','status']])->where(['JoinedSpayc.spayc_id'=>$data['spayc_id'],'JoinedSpayc.user_id'=>$data['user_id']]);  
        $plQuery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($data['user_id'])->first();
        if($entities->isEmpty()){
            $entity = $jsModel->newEntity();
            $entity->user_id = $data['user_id'];
            $entity->spayc_id = $data['spayc_id'];
            $entity->status = $data['status'];
            $entity->modified = new \Cake\I18n\Time();
            $entity->updated_by = $user['id'];
        }else{
            $entity = $entities->first();
            if(strtolower($entity->status) == strtolower($data['status'])){
                $this->restException(['status'=>'failed','message'=>__('User has been already '.strtolower($data['status']).'.')], 400);
            }
            $entity->status = $data['status'];
            $entity->modified = new \Cake\I18n\Time();
            $entity->updated_by = $user['id'];
        }
        if(!empty($plQuery)){
            $entity->distance = Utils::distance($plQuery->current_latitude, $plQuery->current_longitude, $spayc->latitude,$spayc->longitude);
        }
        $jsModel->getConnection()->begin();
        if($jsModel->save($entity,['checkRules' => false, 'atomic' => false])){
            if(!empty($data['passcode'])){                
                $data['status'] = 'Joined';
            }
            if($this->Matrix->joinRoom($data)) {
                $jsModel->getConnection()->commit();
                $friends = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
                //$userIds = $jsModel->getJoinedUserIds($data['spayc_id']);
                if($friends && in_array($spayc->user_id, $friends)) {
                    $push['slug'] = 'friend-join-spayc';
                } else {
                    $push['slug'] = 'user-joined-your-spayc';
                }
                $push['requested_by'] = $user['id'];
                $push['requested_to'] =  $spayc->user_id;
                $push['spayc_id'] =  $spayc->id;
                $push['spayc_name'] = $spayc->name;
                $push['spayc_image'] = $spayc->image;
                $push['matrix_room_id'] = $spayc->matrix_room_id;
                $push['display_name'] = $user['display_name'];
                $this->Push->sendPushNotification($push);
                if($data['status'] == 'Joined'){
                    $msg = __('User has been joined successfully.');
                }else{
                    $msg = __('Your status has been changed successfully');
                }
                $response = ['status'=>'success','message'=>$msg];
            } else {
                $jsModel->getConnection()->rollback();
                $this->response->statusCode(400);
                $response = ['status'=>'failed','message'=>__('System failed to process the request.')];
            }            
        }else{
            $jsModel->getConnection()->rollback();
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('System failed to process the request.')];
        }
        $this->set($response);
    }
    
    public function joinSubSpayc() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $user = $this->Auth->user();
        $data['user_id'] = $user['id'];
        $data['matrix_token'] = $user['UserLogs']['matrix_access_token'];        
        $data['matrix_user_id'] = $user['UserLogs']['matrix_user_id'];        
        $errors = $jsModel->ValidateStatus($data, ['Pending','Joined']);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->contain([
                    'JoinedSpayc' => function($q)use($user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id'=>$user['id']]);
                    },
                ])
                ->where(['id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Spayc is not exist.')], 400);
        }
        $spayc = $spaycs->first();
        if(empty($spayc->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Only subspayc is allowed.')], 400);
        }
        if(($spayc->group_type == 'Public') && ($data['status'] == 'Pending')){
            $this->restException(['status'=>'failed','message'=>__('Invalid status for public sub-spayc.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        if(!empty($currentUserStatus[0])){
            $currentUserStatus = $currentUserStatus[0];
            if($currentUserStatus->is_admin > 0){
                $this->restException(['status'=>'failed','message'=>__('Admin could\'t change their own status')], 400);
            }
            if(($currentUserStatus->status == 'Joined') && ($data['status'] == 'Pending')){
                $this->restException(['status'=>'failed','message'=>__('Request is not valid because of you have joined this sub spayc.')], 400);
            }
            if($currentUserStatus->status == $data['status']){
                if($data['status'] == 'Joined'){
                    $message = __('You have already joined with this spayc');
                }else{
                    $message = __('Your could\'t join with same status.');
                }
                $this->restException(['status'=>'failed','message'=>$message], 400);
            }
        }       
        
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
            $entity->updated_by = $user['id'];
        }else{
            $entity = $entities->first();
            if(strtolower($entity->status) == strtolower($data['status'])){
                $this->restException(['status'=>'failed','message'=>__('User has been already '.strtolower($data['status']).'.')], 400);
            }
            $entity->status = $data['status'];
            $entity->modified = new \Cake\I18n\Time();
            $entity->updated_by = $user['id'];
        }
        
        $plQuery = TableRegistry::get('Api.PhysicalLocation')->findByUserId($data['user_id'])->first();
         if(!empty($plQuery)){
            $entity->distance = Utils::distance($plQuery->current_latitude, $plQuery->current_longitude, $spayc->latitude,$spayc->longitude);
        }
        
        $jsModel->getConnection()->begin();
        if($jsModel->save($entity,['checkRules' => false, 'atomic' => false])){
            if(!empty($data['passcode'])){                
                $data['status'] = 'Joined';
            }
            if($this->Matrix->joinRoom($data)) {
                $jsModel->getConnection()->commit();
                $friends = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
                //$userIds = $jsModel->getJoinedUserIds($data['spayc_id']);
                if($friends && in_array($spayc->user_id, $friends)) {
                    $push['slug'] = 'friend-join-spayc';
                } else {
                    $push['slug'] = 'user-joined-your-spayc';
                }
                $push['requested_by'] = $user['id'];
                $push['requested_to'] =  $spayc->user_id;
                $push['spayc_id'] =  $spayc->id;
                $push['spayc_name'] = $spayc->name;
                $push['spayc_image'] = $spayc->image;
                $push['matrix_room_id'] = $spayc->matrix_room_id;
                $push['display_name'] = $user['display_name'];
                $this->Push->sendPushNotification($push);
                if($data['status'] == 'Joined'){
                    $msg = __('User has been joined successfully.');
                }else{
                    $msg = __('Your status has been changed successfully');
                }
                $response = ['status'=>'success','message'=>$msg];
            } else {
                $jsModel->getConnection()->rollback();
                $this->response->statusCode(400);
                $response = ['status'=>'failed','message'=>__('System failed to process the request.')];
            }            
        }else{
            $jsModel->getConnection()->rollback();
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('System failed to process the request.')];
        }
        $this->set($response);
    }
    
    public function banSpaycMember() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $errors = $jsModel->ValidateStatus($data,['Banned']);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        
        $data['matrix_token'] = $user['UserLogs']['matrix_access_token'];        
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->contain([
                    'JoinedSpayc' => function($q)use($data,$user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id IN'=>[$data['user_id'],$user['id']]]);
                    },
                ])
                ->where(['id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()) {
            $this->restException(['status'=>'failed','message'=>__('Spayc is no longer available.')], 400);
        }
        $spayc = $spaycs->first();
        if(empty($spayc->joined_spayc)){
             $this->restException(['status'=>'failed','message'=>__('User is not member of this spayc.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        $BannedUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$data['user_id'].']');
        if(empty($currentUserStatus[0]) || empty($BannedUserStatus[0])){
            $this->restException(['status'=>'failed','message'=>__('User is not member of this spayc.')], 400);
        }
        $currentUserStatus = $currentUserStatus[0];
        $BannedUserStatus = $BannedUserStatus[0];
        if($currentUserStatus['is_admin'] < 1){
            $this->restException(['status'=>'failed','message'=>__('You have not permission to ban a user.')], 400);
        }
        if($currentUserStatus['is_admin'] <= $BannedUserStatus['is_admin']){
            $this->restException(['status'=>'failed','message'=>__('You have no rights to ban a user which has same level of access.')], 400);
        }
        if($BannedUserStatus['status'] == 'Banned'){
            $this->restException(['status'=>'failed','message'=>__('User already banned with this spayc.')], 400);
        }
        if($BannedUserStatus['status'] != 'Joined'){
            $this->restException(['status'=>'failed','message'=>__('User is not joined with this spayc.')], 400);
        }
        $bannedMatrixUser = TableRegistry::get('Api.Users')->get($BannedUserStatus['user_id'],['fields'=>['matrix_user_id']]);
        $data['matrix_user_id'] = $bannedMatrixUser->matrix_user_id;
        $data['matrix_room_id'] = $spayc->matrix_room_id;
        
        $BannedUserStatus->status = $data['status'];
        $BannedUserStatus->modified = new \Cake\I18n\Time();
        $BannedUserStatus->updated_by = $user['id'];
        $matrix = $this->Matrix->banMember($data);
        if(!empty($matrix)) {
            $this->restException(['status'=>'failed','message'=>__('Failed to ban a user.')],400);
        }
        if($jsModel->save($BannedUserStatus)){
            $response = ['status'=>'success','message'=>__('User has been '.$data['status'].' successfully.')];
        }else{
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('Failed to ban a user.')];
        }
        $this->set($response);
    }
}
