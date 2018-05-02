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
        
         
        $this->sendNotification('inactive');


    }
    public function sendNotification($type) {
        
      
          if($type=='active'){
              $now = (new \Cake\I18n\Time('now','UTC'))->format('Y-m-d H:i');
              $where = ["TO_CHAR(start_date, 'YYYY-MM-DD HH:MI') = '".$now."'"];
              $notification_type='spayc-start-event';
          }elseif ($type=='inactive') {
            $where = [" date(end_date) = date(current_date) - interval '2' day"];
            $notification_type='spayc-end-event';
        }else{
            $this->restException(['status'=>'failed', 'message'=>__('Type not Match.')], 400);
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
            if(count($ids)){
                foreach($ids as $val){
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
                    $success[]=$this->Push->sendPushNotificationSpaycEvent($push);
//                    var_dump($success);die;
                }
            }
        }
        }
        $data = $success;
        print_R($success);die;
       
            $response = ['status'=>'success','message'=>__(count($data). ' Process Run Successfully'),'data'=>$data];
        
        $this->set($response);
    

    }
}
