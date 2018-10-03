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
        $this->Auth->allow(['addCategory', 'apilog', 'addComment', 'notify','updateComment','scrapper']);
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
    
    public function scrapper(){ 
        //$items = $this->ticketmasterapi();
        $catEntity = \Cake\ORM\TableRegistry::get('Api.SpaycCategories');
        //$catEntity->connection()->query('TRUNCATE TABLE categories')->execute();
        $list = $catEntity->find('treeList');
pr($list->toArray());
// Or you can output it in plain text, for example in a CLI script
foreach ($list as $categoryName) {
    echo $categoryName . "\n";
}
        die("END");
        
        $i = 0;
        foreach($items as $cat=>$subcats){
            $pslug = \Cake\Utility\Inflector::slug(strtolower($cat));
            if($catEntity->exists(['slug'=>$pslug])){
                $pcat = $catEntity->find()->where(['slug'=>$pslug,'parent_id IS NULL'])->first();
            }else{
                $pcat = $catEntity->newEntity([
                'name'=>$cat,
                'slug'=> \Cake\Utility\Inflector::slug(strtolower($cat)),
                'description'=>$cat]
                );
                $catEntity->save($pcat);
            }
            
            $i++;
            if(!empty($subcats)){
                foreach($subcats as $key=>$child){                    
                    $cslug = \Cake\Utility\Inflector::slug(strtolower($child));
                    if($catEntity->exists(['slug'=>$cslug])){
                        continue;
                    }
                    $childCat = $catEntity->newEntity([
                    'parent_id'=>$pcat->id,
                    'name'=>$child,
                    'slug'=> \Cake\Utility\Inflector::slug(strtolower($child)),
                    'description'=>$child]
                    );
                    $catEntity->save($childCat);
                    $i++;
                }
            }
        }
        echo 'TOTAL = '.$i;
        pr($items);
    }
    
    public function ticketmasterapi(){
        $http = (new \Cake\Http\Client())->get('https://app.ticketmaster.com/discovery/v2/classifications.json?apikey=FGCdJbUpn9mAmyE9Rlqdi8CYfdhNQMsa&size=500');
        $result = json_decode($http->body,true);
        $items = [];$allItems = null;       
        //pr($result['_embedded']['classifications']);die;
        foreach ($result['_embedded']['classifications'] as $key => $value){
            if(!isset($value['segment']) && !empty($value['segment'])){
                continue;
            }
            //$items['name'] = trim($value['segment']['name']);
            if(empty($value['segment']['_embedded']['genres'])){
                continue;
            }
            foreach ($value['segment']['_embedded']['genres'] as $gkey => $gvalue) {
                $items[trim($value['segment']['name'])][] = trim($gvalue['name']);
                if(empty($gvalue['_embedded']['subgenres'])){
                    continue;
                }
                foreach ($gvalue['_embedded']['subgenres'] as $skey => $svalue) {
                    $items[trim($value['segment']['name'])][] = trim($svalue['name']);
                }
            }
        }
        return $items;
    }
    
    public function eventbriteapi(){
        $http = (new \Cake\Http\Client())->get('https://www.eventbriteapi.com/v3/subcategories/?token=JRTJ7FHW3TG7F5U535RN&page=5');
        $result = json_decode($http->body,true);
        $items = [];
        foreach($result['subcategories'] as $key => $cat){
            $items[$cat['parent_category']['name']][] = $cat['name'];
        }
        return $items;
    }
    

}
