<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
/**
 * WebApi Controller
 *
 * @property \Api\Model\Table\WebApiTable $WebApi
 */
class WebApiController extends AppController {
      use MailerAwareTrait;

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
        $this->Auth->allow(['passwordChange','addCategory', 'apilog', 'addComment', 'notify', 'updateComment', 'scrapper','appVersion']);
    }
    
    public function appVersion(){        
        $response = [
            'status'=>'success',
            'Message'=>'App current version',
            'data'=>['app_version'=>Configure::read('app_version')]];
        $this->set($response);
    }
    
    /* matrixpasswordchange*/
    public function passwordChange(){
        if(!function_exists('exec')) {
            echo "exec function is disabled";die;
        }
        $sConn = \Cake\Datasource\ConnectionManager::get('default');
        $mConn = \Cake\Datasource\ConnectionManager::get('matrix');
        
        $apiUsers = $sConn->execute('SELECT id,username,matrix_user_id,matrix_access_token,matrix_password FROM users where role_id is null')->fetchAll('assoc');
        
        $p = [];
        $lastId = $mConn->execute('SELECT id FROM access_tokens order by id desc limit 1')->fetchAll('assoc');
        $lastId = $lastId[0]['id'];
        foreach($apiUsers as $user){ 
            $matrixPassword = md5($user['username']);
            /*update matrix password for all users in api users table */
            if(empty($user['matrix_password'])){                
                if($sConn->execute('UPDATE users SET matrix_password = ? WHERE id = ?',[$matrixPassword,$user['id']])){
                    $p['apiupdate'][] = $user['id'];
                    /*Create matrix hashed value and update matrix password in matrix users table */
                    $command = '/usr/bin/python '.ROOT.'/hash_password.py -p '.$matrixPassword;
                    $hashPasswrod = exec($command);
                    echo $hashPasswrod;die(" = hashvalue");
                    
                    if($mConn->execute('UPDATE users SET password_hash = ? WHERE name = ?',[$hashPasswrod,$user['matrix_user_id']])){
                        $p['matrixupdate'][] = $user['id'];
                    }else{
                        $p['matrixfailed'][] = $user['id'];
                    }
                }else{
                    $p['apiupdatefailed'][] = $user['id'];
                }
            }
            $preToken = $mConn->execute('SELECT 1 FROM access_tokens where token = ?',[$user['matrix_access_token']])->fetchAll('assoc');
            if(empty($preToken)){
                $lastId++;
                $p['insert'][] = $user['id'];
                $mConn->insert('access_tokens', ['id'=>$lastId,'user_id' => $user['matrix_user_id'],'device_id' => \Cake\Utility\Text::uuid(),'token'=>$user['matrix_access_token']]);
            }
        }
        pr($p);
    }
    public function eventsImage() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $matrixRoomId = $this->request->query('events');
        if (empty($matrixRoomId)) {
            $this->restException(['status' => 'failed', 'message' => __('Events key is required.')], 405);
        }
        $images = TableRegistry::get("Api.Spaycs")->find('list', [
                    'keyField' => 'matrix_room_id',
                    'valueField' => 'image'])->where(['matrix_room_id IN' => explode(',', $matrixRoomId), 'image !=' => '']);

        $this->restException([
            'status' => 'success',
            'message' => __('List of events image.'),
            'data' => $images
        ]);
    }
    /**
     * @userFeedBack to send the feedback message to the admin
     */
    public function userFeedBack(){
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $srRegistory = TableRegistry::get('Api.UserFeedbacks');
        $entity = $srRegistory->newEntity();
        $items = $srRegistory->patchEntity($entity, $data);
        if($items->errors()) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($items->errors())], 400);
        }
        $items->user_id = $user['id'];
        if($srRegistory->save($items)) {
            $items->action_type = 'userFeedBack';
            $items->User = $this->Auth->user(); /* user mailer of user data*/            
            TableRegistry::get('Queue.QueuedJobs')->createJob('Mailer',$items->toArray());
            $this->restException(['status' => 'success', 'message' => __('Your feed has been sent successfully.'), 'data' => []], 200);
        } else {
            $this->restException(['status' => 'failed', 'message' => __('Failed to send feedback message.')], 400);
        }
    }
    /**
     * spamReport method to report user as spam user
     */
    public function spamReport() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $srRegistory = TableRegistry::get('Api.SpamReports');
        $errors = $srRegistory->validateInput($data);
        if (!empty($errors)) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($errors)], 400);
        }

        $reportedUser = TableRegistry::get('Api.Users')->findByMatrixUserId($data['reported_to'])->first();
        $spaycs = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($data['matrix_room_id'])->first();
        if ($reportedUser->id == $user['id']) {
            $this->restException(['status' => 'failed', 'message' => __('Youd couldn\'t make himself as spam user.')], 400);
        }
        $joinedCheck = TableRegistry::get('Api.JoinedSpayc')->find()->where(['spayc_id' => $spaycs->id, 'user_id IN' => [$reportedUser->id, $user['id']]])->toArray();
        $loggedUserStatus = Hash::extract($joinedCheck, '{n}[user_id=' . $user['id'] . ']');
        $reportedUserStatus = Hash::extract($joinedCheck, '{n}[user_id=' . $reportedUser->id . ']');
        if (empty($loggedUserStatus)) {
            $this->restException(['status' => 'failed', 'message' => __('Your are not joined with this warp.')], 400);
        }
        if (empty($reportedUserStatus)) {
            $this->restException(['status' => 'failed', 'message' => __('Reported user has not been joined with this warp.')], 400);
        }
        if ($srRegistory->exists(['reported_to' => $reportedUser->id, 'reported_by' => $user['id'], 'event_id' => $data['event_id']])) {
            $this->restException(['status' => 'failed', 'message' => __('You have already reported this user as spam user.Admin will take care about this reports.')], 400);
        }
        $srEntity = $srRegistory->newEntity();
        $srEntity->spayc_id = $spaycs->id;
        $srEntity->reported_by = $user['id'];
        $srEntity->reported_to = $reportedUser->id;
        $srEntity->event_id = $data['event_id'];
        if ($srRegistory->save($srEntity)) {
            $this->restException(['status' => 'success', 'message' => __('You have reported successfully.'), 'data' => []], 200);
        } else {
            $this->restException(['status' => 'failed', 'message' => __('Failed to make user as spam user.')], 400);
        }
    }
    
    /**
     * reportedWarp method to report warp if he/she is not interested
     */
    public function reportedWarp() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $srRegistory = TableRegistry::get('Api.ReportedWarps');
        $errors = $srRegistory->validateInput($data);
        if (!empty($errors)) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($errors)], 400);
        }
        $spaycs = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($data['matrix_room_id'])->first();
        
        $joinedCheck = TableRegistry::get('Api.JoinedSpayc')->find()->where(['spayc_id' => $spaycs->id, 'user_id' => $user['id']])->toArray();
        $loggedUserStatus = Hash::extract($joinedCheck, '{n}[user_id=' . $user['id'] . ']');
        if (empty($loggedUserStatus)) {
            $this->restException(['status' => 'failed', 'message' => __('Your are not joined with this warp.')], 400);
        }
        
        if ($srRegistory->exists(['reported_by' => $user['id'], 'matrix_room_id' => $data['matrix_room_id']])) {
            $this->restException(['status' => 'failed', 'message' => __('You have already reported about this warp.Admin will take care about this reports.')], 400);
        }
        $srEntity = $srRegistory->newEntity();
        $srEntity->spayc_id = $spaycs->id;
        $srEntity->matrix_room_id = $spaycs->matrix_room_id;
        $srEntity->reported_by = $user['id'];
        $srEntity->message = !empty($data['message'])?$data['message']:null;
        if ($srRegistory->save($srEntity)) {
            $this->restException(['status' => 'success', 'message' => __('You have reported successfully.'), 'data' => $data], 200);
        } else {
            $this->restException(['status' => 'failed', 'message' => __('Failed to send your message.')], 400);
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
    public function updateComment($matrixRoomId = null) {
        if (!$this->request->is(['put'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        if (is_null($matrixRoomId)) {
            $this->restException(['status' => 'success', 'message' => __('Matrix room id is required')], 200);
        }
        $spayc = TableRegistry::get('Api.Spaycs')->findByMatrixRoomId($matrixRoomId, ['fields' => ['id']])->first();
        if (empty($spayc)) {
            $this->restException(['status' => 'success', 'message' => __('Matrix room id is not valid.')], 200);
        }
        $data['spayc_id'] = $spayc['id'];
        TableRegistry::get('Api.Comments')->spaycActivities($matrixRoomId, $data);
        $this->restException(['status' => 'success', 'message' => __('Request proccess successfully.')], 200);
    }
    
    /* Dummy code to test */
    public function scrapper() {
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
        foreach ($items as $cat => $subcats) {
            $pslug = \Cake\Utility\Inflector::slug(strtolower($cat));
            if ($catEntity->exists(['slug' => $pslug])) {
                $pcat = $catEntity->find()->where(['slug' => $pslug, 'parent_id IS NULL'])->first();
            } else {
                $pcat = $catEntity->newEntity([
                    'name' => $cat,
                    'slug' => \Cake\Utility\Inflector::slug(strtolower($cat)),
                    'description' => $cat]
                );
                $catEntity->save($pcat);
            }

            $i++;
            if (!empty($subcats)) {
                foreach ($subcats as $key => $child) {
                    $cslug = \Cake\Utility\Inflector::slug(strtolower($child));
                    if ($catEntity->exists(['slug' => $cslug])) {
                        continue;
                    }
                    $childCat = $catEntity->newEntity([
                        'parent_id' => $pcat->id,
                        'name' => $child,
                        'slug' => \Cake\Utility\Inflector::slug(strtolower($child)),
                        'description' => $child]
                    );
                    $catEntity->save($childCat);
                    $i++;
                }
            }
        }
        echo 'TOTAL = ' . $i;
        pr($items);
    }
    /* Dummy code to test */
    public function ticketmasterapi() {
        $http = (new \Cake\Http\Client())->get('https://app.ticketmaster.com/discovery/v2/classifications.json?apikey=FGCdJbUpn9mAmyE9Rlqdi8CYfdhNQMsa&size=500');
        $result = json_decode($http->body, true);
        $items = [];
        $allItems = null;
        //pr($result['_embedded']['classifications']);die;
        foreach ($result['_embedded']['classifications'] as $key => $value) {
            if (!isset($value['segment']) && !empty($value['segment'])) {
                continue;
            }
            //$items['name'] = trim($value['segment']['name']);
            if (empty($value['segment']['_embedded']['genres'])) {
                continue;
            }
            foreach ($value['segment']['_embedded']['genres'] as $gkey => $gvalue) {
                $items[trim($value['segment']['name'])][] = trim($gvalue['name']);
                if (empty($gvalue['_embedded']['subgenres'])) {
                    continue;
                }
                foreach ($gvalue['_embedded']['subgenres'] as $skey => $svalue) {
                    $items[trim($value['segment']['name'])][] = trim($svalue['name']);
                }
            }
        }
        return $items;
    }
    /* Dummy code to test */
    public function eventbriteapi() {
        $http = (new \Cake\Http\Client())->get('https://www.eventbriteapi.com/v3/subcategories/?token=JRTJ7FHW3TG7F5U535RN&page=5');
        $result = json_decode($http->body, true);
        $items = [];
        foreach ($result['subcategories'] as $key => $cat) {
            $items[$cat['parent_category']['name']][] = $cat['name'];
        }
        return $items;
    }

}
