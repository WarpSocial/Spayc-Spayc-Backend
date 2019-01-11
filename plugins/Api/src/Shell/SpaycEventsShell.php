<?php

namespace Api\Shell;


use Cake\Console\Shell;

use Api\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;
use Cake\Utility\Security;
use \Cake\ORM\TableRegistry;
use Api\Utils\Utils;
use Cake\Log\Log;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Api\Model\Entity\UserImage;
use Cake\Utility\Text;
use Cake\Utility\Hash;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\PushComponent;
use Api\Controller\Component\RedisComponent;
use Cake\I18n\Time;
/**
 * SpaycEvents shell command.
 */
class SpaycEventsShell extends Shell {

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main() {        
        $this->out($this->OptionParser->help());
        $this->out("here i m ");
        
        $this->Push=new PushComponent(new ComponentRegistry());
        $now = (new \Cake\I18n\Time('now','UTC'))->format('H:i:s');
        $data['inactive']=$now;
        if($now=='00:00:00'){
            $data['inactive']=$this->sendNotification('inactive');
        }
        
        $data['active']=$this->sendNotification('active');
        
        /* delete past events(spayc) from redis storage */
        $this->cleanPastEvents();
        return true;
//        \Cake\Log\Log::info(json_encode($data,JSON_PRETTY_PRINT));
//        Log::write('info', "test", ['scope' => 'queue']);
        //$pushData['post_value'] = json_encode($data);
        //$pushData['created'] = date("Y-m-d H:i:s");
        //Log::info(json_encode($pushData,JSON_PRETTY_PRINT));
        //$pusher = TableRegistry::get("Api.PusherData");
        //$push = $pusher->newEntity();
        //$entity = $pusher->patchEntity($push, $pushData,['validate'=>false]);
        //$pusher->save($entity);

    }
    public function sendNotification($type) {      
          if($type=='active'){
              $now = (new \Cake\I18n\Time('now','UTC'))->format('Y-m-d H');
              $where = ["TO_CHAR(start_date, 'YYYY-MM-DD HH') = '".$now."'"];
              $notification_type='spayc-start-event';
          }elseif ($type=='inactive') {
            $where = [" date(end_date) = date(current_date) - interval '2' day"];
            $notification_type='spayc-end-event';
        }else{
            return false;
            //$this->restException(['status'=>'failed', 'message'=>__('Type not Match.')], 400);
        }      
        $events = TableRegistry::get('Api.Spaycs')->find()
                ->where($where)
         ->contain([  
                'JoinedSpayc' => function($q) {
                    return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.distance'])->where(['status'=>'Joined']);
                },
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.id','SubscribedUsers.spayc_id','SubscribedUsers.user_id', 'SubscribedUsers.status'])->where(['status'=>'Active']);
                },
                'Users' => function($q) {
                    return $q->select(['Users.username','Users.display_name']);
                }
            ]);
            #debug($events);die;
                $success=[];
        if($events){
        foreach($events->toArray() as $k=>$v){
            $ids=array();
            $joined_ids=array();
            $subscribed_ids=array();
            
            if(count($v['joined_spayc'])){
                $joined_ids = \Cake\Utility\Hash::extract($v['joined_spayc'], '{n}.user_id');
            }
           
            if(count($v['subscribed_users'])){
                $subscribed_ids = \Cake\Utility\Hash::extract($v['subscribed_users'], '{n}.user_id');
            }
            
            $ids=array_unique(array_merge($joined_ids,$subscribed_ids));            
            if(!empty($ids)){
                $userCategories = TableRegistry::get('Api.UserCategory')->listCategories($ids);
                foreach($ids as $val){
                    if(!empty($userCategories[$val]) && in_array($v['id'],$userCategories[$val])){
                        $push['requested_by'] = $v['user_id'];
                        $push['username'] = $v['user']['username'];
                        $push['display_name'] = $v['user']['display_name'];
                        $push['start_date'] = $v['start_date'];
                        $push['end_date'] = $v['end_date'];
                        $push['requested_to'] = $val;
                        $push['spayc_id'] = $v['id']; //provide spayc id if push related to spayc
                        $push['spayc_name'] = $v['name'];
                        $push['spayc_image'] = $v['image'];
                        $push['matrix_room_id'] = $v['matrix_room_id'];
                        $push['slug'] = $notification_type;

                        $success[]=$this->Push->sendPushNotification($push);
                    }
                }
            }
        }
        }
      return $success;
    }
    public function cleanPastEvents(){
        $daysAgo = new Time('3 days ago','America/New_York');
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD')";  
        $spaycs = TableRegistry::get('Api.Spaycs')->find()->select('id')->where([$endDate.' <= '=>$daysAgo->setTimezone('UTC')->format("Y-m-d")])->extract('id')->toArray();
        if(!empty($spaycs)){
            $this->redis=new RedisComponent(new ComponentRegistry());
            $this->redis->deleteSpayc($spaycs);
        }
        
    }
}
