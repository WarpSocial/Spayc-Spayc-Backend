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
            $this->restException(['status'=>'failed','message'=>__('Warp is no longer available..')], 400);
        }
        $spayc = $spaycs->first();
        if(!empty($spayc->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Not allowed to join sub warp.')], 400);
        }
        
        if(($spayc->group_type == 'Public') && ($data['status'] == 'Pending')){
            $this->restException(['status'=>'failed','message'=>__('Invalid status for public warp.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        if(!empty($currentUserStatus[0])){
            $currentUserStatus = $currentUserStatus[0];
            if($currentUserStatus->is_admin > 0){
                $this->restException(['status'=>'failed','message'=>__('Admin could\'t change their own role.')], 400);
            }
            if(($currentUserStatus->status == 'Joined') && ($data['status'] == 'Pending')){
                $this->restException(['status'=>'failed','message'=>__('You are already part of this warp.')], 400);
            }
            if($currentUserStatus->status == $data['status']){
                if($data['status'] == 'Joined'){
                    $message = __('You have already joined with this warp');
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
                if($spayc->group_type == "Public"){
                    if(!TableRegistry::get('Api.SubscribedUsers')->isSubscribed($user['id'],ACTIVE)){
                        $this->Matrix->muteUnmute('mute',$data['matrix_token'], $spayc->matrix_room_id);
                    }
                }
                $jsModel->getConnection()->commit();
                $friends = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
                //$userIds = $jsModel->getJoinedUserIds($data['spayc_id']);
                if($data['status'] = 'Joined'){
                    if($friends && in_array($spayc->user_id, $friends)) {
                        $push['slug'] = 'friend-join-spayc';
                    } else {
                        $push['slug'] = 'user-joined-your-spayc';
                    }
                }else{
                    $push['slug'] = 'join-request';
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
                    if(($spayc->group_type == 'Private') && empty($data['passcode'])){
                        $msg = __('Your request has been sent successfully.');
                    }else{
                        $msg = __('Your status has been changed successfully.');
                    }
                    
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
            $this->restException(['status'=>'failed','message'=>__('Warp is not exist.')], 400);
        }
        $spayc = $spaycs->first();
        if(empty($spayc->parent_id)){
            $this->restException(['status'=>'failed','message'=>__('Only subwarp is allowed.')], 400);
        }
        if(($spayc->group_type == 'Public') && ($data['status'] == 'Pending')){
            $this->restException(['status'=>'failed','message'=>__('Invalid status for public sub-warp.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        if(!empty($currentUserStatus[0])){
            $currentUserStatus = $currentUserStatus[0];
            if($currentUserStatus->is_admin > 0){
                $this->restException(['status'=>'failed','message'=>__('Admin could\'t change their own status')], 400);
            }
            if(($currentUserStatus->status == 'Joined') && ($data['status'] == 'Pending')){
                $this->restException(['status'=>'failed','message'=>__('Request is not valid because of you have joined this sub warp.')], 400);
            }
            if($currentUserStatus->status == $data['status']){
                if($data['status'] == 'Joined'){
                    $message = __('You have already joined with this warp');
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
                if($spayc->group_type == "Public"){
                    if(!TableRegistry::get('Api.SubscribedUsers')->isSubscribed($user['id'],ACTIVE)){
                        $this->Matrix->muteUnmute('mute',$data['matrix_token'], $spayc->matrix_room_id);
                    }
                }
                $jsModel->getConnection()->commit();
                $friends = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($user['id'], 'Accepted');
                //$userIds = $jsModel->getJoinedUserIds($data['spayc_id']);
                if($data['status'] = 'Joined'){
                    if($friends && in_array($spayc->user_id, $friends)) {
                        $push['slug'] = 'friend-join-spayc';
                    } else {
                        $push['slug'] = 'user-joined-your-spayc';
                    }
                }else{
                    $push['slug'] = 'join-request';
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
    /**
     * banSpaycMember to ban or unban the uesr from spayc
     */
    
    public function banSpaycMember() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $errors = $jsModel->ValidateStatus($data,['Banned','Unbanned']);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        
        $data['matrix_token'] = $user['UserLogs']['matrix_access_token'];        
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->select(['Spaycs.id','Spaycs.name','Spaycs.image','Spaycs.matrix_room_id','Spaycs.parent_id'])
                ->contain([
                    'JoinedSpayc' => function($q)use($data,$user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id IN'=>[$data['user_id'],$user['id']]]);
                    },
                    'JoinedSpayc.Users'=>function($q){
                        return $q->select(['Users.id','Users.matrix_access_token','Users.matrix_user_id','Users.display_name']);                    
                    },            
                    'SubSpaycs' => function($q)use($data){                        
                        $q->select(['SubSpaycs.id','SubSpaycs.name','SubSpaycs.image','SubSpaycs.parent_id','SubSpaycs.matrix_room_id']);
                        $q->innerJoinWith('JoinedSpayc',function($qq)use($data) {
                            $qq->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.user_id'=>$data['user_id'],'JoinedSpayc.status'=>'Joined']);
                            return $qq;
                        });
                        return $q;
                    },
                   'Users'=>function($q){
                        return $q->select(['Users.id','Users.matrix_access_token','Users.matrix_user_id','Users.display_name']);
                   }
                ])
                ->where(['Spaycs.id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()) {
            $this->restException(['status'=>'failed','message'=>__('Sarp is no longer available.')], 400);
        }
        $spayc = $spaycs->first();
        #pj($spayc);die;
        if(empty($spayc->joined_spayc)){
             $this->restException(['status'=>'failed','message'=>__('User is not member of this warp.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        $BannedUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$data['user_id'].']');
        if(empty($currentUserStatus[0]) || empty($BannedUserStatus[0])){
            $this->restException(['status'=>'failed','message'=>__('User is not member of this warp.')], 400);
        }
        $currentUserStatus = $currentUserStatus[0];
        if($currentUserStatus['is_admin'] != 2){
            $data['matrix_token'] = $spayc->user->matrix_access_token;
        }
        $BannedUserStatus = $BannedUserStatus[0];
        if($currentUserStatus['is_admin'] < 1){
            $this->restException(['status'=>'failed','message'=>__('You have no permission to ban a user.')], 400);
        }
        if($currentUserStatus['is_admin'] <= $BannedUserStatus['is_admin']){
            $this->restException(['status'=>'failed','message'=>__('You have no rights to ban a user which has same level of access.')], 400);
        }
        if($currentUserStatus['status'] != JOINED){
            $this->restException(['status'=>'failed','message'=>__('Only joined member who has admin rights can ban or unban any user.')], 400);
        }
        if($BannedUserStatus['status'] == $data['status']){
            $this->restException(['status'=>'failed','message'=>__('User has already '. strtolower($data['status']).' with this warp.')], 400);
        }
        if(($BannedUserStatus['status'] == JOINED) && ($data['status'] == UNBANNED)){
            $this->restException(['status'=>'failed','message'=>__('Cannot unban user who was not banned.')], 400);
        }       
        
        if(!in_array($BannedUserStatus['status'],['Joined',BANNED])){
            $this->restException(['status'=>'failed','message'=>__('User is not joined with this warp.')], 400);
        }
        $data['matrix_user_id'] = $BannedUserStatus->user->matrix_user_id;
        $data['matrix_room_id'] = $spayc->matrix_room_id;
        
        $BannedUserStatus->status = ($data['status'] == UNBANNED)?JOINED:$data['status'];
        $BannedUserStatus->modified = new \Cake\I18n\Time();
        $BannedUserStatus->updated_by = $user['id'];
        $matrix = $this->Matrix->banMember($data);
        if(is_string($matrix)) {
            $this->restException(['status'=>'failed','message'=>__($matrix)],400);
        }
        if($data['status'] == UNBANNED){
            $mjoin['matrix_user_id'] = $BannedUserStatus->user->matrix_user_id;
            $mjoin['matrix_token'] = $BannedUserStatus->user->matrix_access_token;
            $mjoin['matrix_room_id'] = $spayc->matrix_room_id;
            $mjoin['status'] = 'Joined';
            //pr($mjoin);die;
            $this->Matrix->joinRoom($mjoin);
        }
        $this->Matrix->muteUnmute('mute',$BannedUserStatus->user->matrix_access_token, $spayc->matrix_room_id);
        if($jsModel->save($BannedUserStatus)){                        
            if($data['status'] == 'Banned'){
                TableRegistry::get('Api.SubscribedUsers')->removeSubscription($data['user_id'],$spayc->id);                
            }
            $response = ['status'=>'success','message'=>__('User has been '.$data['status'].' successfully.')];
        }else{
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('Failed to ban a user.')];
        }
        $this->set($response);
    }
    /**
     * remove user from spayc
     * @param $user_id
     * @param $spayc_id 
     * @return Json object
     */
    public function removeFromSpayc() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        if(empty($data['spayc_id']) || empty($data['user_id'])){
             $this->restException(['status'=>'failed','message'=>['Spayc id and user id are required fields.']], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->contain([
                    'Users',
                    'SubSpaycs.JoinedSpayc'=>function($q)use($data){
                        return $q->select(['id','spayc_id','user_id'])->where(['JoinedSpayc.user_id'=>$data['user_id']]);
                    }, 
                    'JoinedSpayc' => function($q)use($data,$user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id IN'=>[$data['user_id'],$user['id']]]);
                    },
                    'JoinedSpayc.Users'=>function($q){
                        return $q->select(['Users.id','Users.matrix_access_token','Users.matrix_user_id','Users.display_name']);                    
                    },           
                   'Users'
                ])
                ->where(['Spaycs.id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()) {
            $this->restException(['status'=>'failed','message'=>__('Warp is no longer available.')], 400);
        }
        $spayc = $spaycs->first();        
        if(empty($spayc->joined_spayc)){
             $this->restException(['status'=>'failed','message'=>__('User is not member of this warp.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        $removeUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$data['user_id'].']');
        if(empty($currentUserStatus[0]) || empty($removeUserStatus[0])){
            $this->restException(['status'=>'failed','message'=>__('User is not member of this warp.')], 400);
        }
        $currentUserStatus = $currentUserStatus[0];
        $removeUserStatus = $removeUserStatus[0];
        if($currentUserStatus['is_admin'] < 1){
            $this->restException(['status'=>'failed','message'=>__('You have no permission to remove a user.')], 400);
        }
        if($currentUserStatus['is_admin'] <= $removeUserStatus['is_admin']){
            $this->restException(['status'=>'failed','message'=>__('You have no rights to remove a user which has same level of access.')], 400);
        }
        if($currentUserStatus['status'] != 'Joined'){
            $this->restException(['status'=>'failed','message'=>__('Only joined member who has admin rights can remove any user.')], 400);
        }
        if($removeUserStatus['status'] != 'Joined'){
            $this->restException(['status'=>'failed','message'=>__('Only joined user will be removed.')], 400);
        }
        $removeMatrixUser = TableRegistry::get('Api.Users')->get($removeUserStatus['user_id'],['fields'=>['matrix_user_id']]);
        $data['matrix_user_id'] = $removeMatrixUser->matrix_user_id;
        $data['matrix_room_id'] = $spayc->matrix_room_id;
        $data['matrix_token'] = $spayc['user']->matrix_access_token; 
        //$matrix = $this->Matrix->removeMember($data);      
        $matrix = $this->Matrix->leaveRoom($data['matrix_room_id'],$removeUserStatus->user->matrix_access_token);
        if(is_string($matrix)) {
            $this->restException(['status'=>'failed','message'=>__($matrix)],400);
        }
        $this->Matrix->muteUnmute('mute',$removeUserStatus->user->matrix_access_token, $spayc->matrix_room_id);
        
        if($jsModel->delete($removeUserStatus)){
            $this->removeFromSubspayc($spayc->sub_spaycs, $removeUserStatus->user->matrix_access_token);
            //TableRegistry::get('Api.JoinedSpayc')->deleteAll(['spayc_id IN' => $child]);
            $push = [
                'slug' => 'kick-from-spayc',
                'requested_by' => $user['id'],
                'requested_to' => $data['user_id'],
                'spayc_id' => $spayc->id,
                'spayc_name' => $spayc->name,
                'spayc_image' => $spayc->image,
                'matrix_room_id' => $spayc->matrix_room_id,
                'display_name' => $user['display_name']                
            ];
            $this->Push->sendPushNotification($push);
            $response = ['status'=>'success','message'=>__('User has been removed successfully.')];
        }else{
            $this->response->statusCode(400);
            $response = ['status'=>'failed','message'=>__('Failed to remove a user.')];
        }
        $this->set($response);
    }
    
    
    /**
     * acceptJoinedRequest to accept the request of join member
     * accept-join-request endpoint
     */
    public function acceptJoinedRequest() {
        if (!$this->request->is('post')) {
            $this->restException(['status'=>'failed', 'message'=> __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $user = $this->Auth->user();
        $errors = $jsModel->ValidateStatus($data,['Accepted','Declined']);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->contain([
                    'JoinedSpayc' => function($q)use($data,$user) {
                        return $q
                                ->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.is_admin'])
                                ->where(['JoinedSpayc.user_id IN'=>[$data['user_id'],$user['id']]]);
                    },
                ])
                ->where(['Spaycs.id'=>$data['spayc_id']]);
        if($spaycs->isEmpty()){
            $this->restException(['status'=>'failed','message'=>__('Warp is no longer available.')], 400);
        }
        $spayc = $spaycs->first();       
        
        if(($spayc->group_type == 'Public')){
            $this->restException(['status'=>'failed','message'=>__('Warp must be private only.')], 400);
        }
        $currentUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$user['id'].']');
        $requestedUserStatus = Hash::extract($spayc->joined_spayc, '{n}[user_id='.$data['user_id'].']');
        if(empty($currentUserStatus[0])){
            $this->restException(['status'=>'failed','message'=>__('You are not member of this warp.')], 400);
        }elseif(empty($requestedUserStatus[0])){
            $this->restException(['status'=>'failed','message'=>__('User is not member of this warp.')], 400);
        }
        $currentUserStatus = $currentUserStatus[0];
        $requestedUserStatus = $requestedUserStatus[0];
        if(($currentUserStatus['status'] != 'Joined') || ($currentUserStatus['is_admin'] < 1)){
            $this->restException(['status'=>'failed','message'=>__('Joined member and admin can accept or decline of any user request.')], 400);
        }
        if($currentUserStatus['is_admin'] <= $requestedUserStatus['is_admin']){
            $this->restException(['status'=>'failed','message'=>__('You have no rights to accept or decline a user which has same level of access.')], 400);
        }
        if(($requestedUserStatus['status'] == 'Joined')){
            $this->restException(['status'=>'failed','message'=>__('User already joined with this warp.')], 400);
        }       
        if(($requestedUserStatus['status'] != 'Pending')){
            $this->restException(['status'=>'failed','message'=>__('Only pending user will be accepted.')], 400);
        }       
        if($requestedUserStatus['status'] == $data['status']){
            $this->restException(['status'=>'failed','message'=>__('User has alreadyd '. strtolower($data['status']).' with this warp.')], 400);
        }
      
        $requestedMatrixUser = TableRegistry::get('Api.Users')->get($requestedUserStatus['user_id'],['fields'=>['matrix_user_id','matrix_access_token']]);
        $data['matrix_user_id'] = $requestedMatrixUser->matrix_user_id;
        $data['matrix_token'] = $requestedMatrixUser->matrix_access_token;
        $data['matrix_room_id'] = $spayc->matrix_room_id;
       
        
        $requestedUserStatus->status = ($data['status'] == 'Accepted')?'Joined':'Declined';
        $requestedUserStatus->modified = new \Cake\I18n\Time();
        $requestedUserStatus->updated_by = $user['id'];
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $jsModel->getConnection()->begin();
        if($data['status'] == 'Accepted'){
            $dbStatus = $jsModel->save($requestedUserStatus, ['checkRules' => false, 'atomic' => false]);
        }else{
            $dbStatus = $jsModel->delete($requestedUserStatus);
        }
        if ($dbStatus) {
            if ($data['status'] == 'Accepted') {
                $matrixData = ['status'=>'Joined']+$data;
                if ($this->Matrix->joinRoom($matrixData)) {
                    $this->Matrix->muteUnmute('mute',$data['matrix_token'], $spayc->matrix_room_id);
                    $jsModel->getConnection()->commit();
                    $this->Push->sendPushNotification([
                        'slug' => 'accept-join-request',
                        'requested_by' => $user['id'],
                        'requested_to' => $data['user_id'],
                        'spayc_id' => $spayc->id,
                        'spayc_name' => $spayc->name,
                        'spayc_image' => $spayc->image,
                        'matrix_room_id' => $spayc->matrix_room_id,
                        'display_name' => $user['display_name']                
                    ]);
                    $response = ['status' => 'success', 'message' => __('Request has been '. strtolower($data['status']).' successfully.')];
                } else {
                    $jsModel->getConnection()->rollback();
                    $this->response->statusCode(400);
                    $response = ['status' => 'failed', 'message' => __('System failed to process the request.')];
                }
            }else{
                $jsModel->getConnection()->commit();
                $response = ['status' => 'success', 'message' => __('Request has been '. strtolower($data['status']).' successfully.')];
            }
        } else {
            $jsModel->getConnection()->rollback();
            $this->response->statusCode(400);
            $response = ['status' => 'failed', 'message' => __('System failed to process the request.')];
        }
        $this->set($response);
    }
    
    public function removeFromSubspayc($subspaycs, $accessToken=null) {
        if (empty($subspaycs) || is_null($accessToken)) {
            return;
        }        
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        foreach ($subspaycs as $subspayc) {
            if (!empty($subspayc['joined_spayc'])) {
                foreach ($subspayc['joined_spayc'] as $joinspayc) {
                    if($jsModel->delete($joinspayc)){
                        $this->Matrix->leaveRoom($subspayc['matrix_room_id'], $accessToken);
                        $this->Matrix->muteUnmute('mute', $accessToken,$subspayc['matrix_room_id']);
                    }                    
                }
            }
        }
    }

}
