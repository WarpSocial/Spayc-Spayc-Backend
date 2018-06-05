<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\MailerAwareTrait;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Aws\Sns\SnsClient;
use Cake\I18n\Time;


class PushComponent extends Component {
    use MailerAwareTrait;

    public $SnsClient;
    public $snsConfig;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    /**
     * initialize function to initialize the current component config with new more config param
     * 
     * @param array $config config related to the current component
     * @return void nothing
     */
    public function initialize(array $config) {
        parent::initialize($config);
        $this->snsConfig = Configure::read('SNS');       
    }
    
    public function sendOnIOS($data){        
        #\Cake\Log\Log::info(json_encode($data,JSON_PRETTY_PRINT));
        $message = $data['message'];
        try {
            $config = $this->snsConfig;
            $this->SnsClient = SnsClient::factory([
                'version' => $config['version'],
                'region'  => $config['region'],
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'], 
                ]
            ]);
            $device_token = $data['device_token'];
            /*Start Create EndpointARN*/
            $attr1 = array(
                'PlatformApplicationArn' => $config['ARN_IOS'],
                'Token' => $device_token
            );
            //echo $config['ARN_IOS'];die;
            $endpointARN = $this->SnsClient->createPlatformEndpoint($attr1); //pj($endpointARN);exit;
            $end_point_arn1 =$endpointARN['EndpointArn'];
            /*End Create EndpointARN*/
            //print_r($endpointARN);exit;

            /*Start Delete EndpointARN*/
            if (isset($end_point_arn1) && $end_point_arn1 != "") {
                $this->SnsClient->deleteEndpoint(array('EndpointArn' => $end_point_arn1, ));
            }
            /*End Delete EndpointARN*/


            /*Start ReCreate EndpointARN*/
            $attr = array(
                'PlatformApplicationArn' => $config['ARN_IOS'],
                'Token' => $device_token
            );
            
            $endpointARN = $this->SnsClient->createPlatformEndpoint($attr);
            
            $device_token =$endpointARN['EndpointArn'];
            /*End ReCreate EndpointARN*/
            $par["action-loc-key"]="PLAY";
            $par["body"]=$message;
            
            $FinalMessage = json_encode(array('default' => $message, $config['apns'] => json_encode(array(
                    'aps' => array(
                      'alert' => $message,
                      'sound'=>'default',
                      'badge'=>1,
                      'user_id'=>!empty($data['requested_by'])?$data['requested_by']:null,
                      'matrix_room_id'=>!empty($data['matrix_room_id'])?$data['matrix_room_id']:null,
                      'notification_type'=>!empty($data['notification_type'])?$data['notification_type']:null,
                      'user_image'=>!empty($data['user_image'])?$data['user_image']:null,
                      'spayc_image'=>!empty($data['spayc_image'])?$data['spayc_image']:null,
                      'date_time'=>!empty($data['time'])?$data['time']:null,
                      'id'=>!empty($data['id'])?$data['id']:null
                    )
                    ))
                ));
            $this->SnsClient->publish(
                array(
                'TargetArn' => $device_token,
                'MessageStructure' => 'json',
                'Message' => $FinalMessage
                )
            );
           
            return true;
        } catch(\Exception $e) {
             \Cake\Log\Log::info($e->getMessage());
            return false;
        }
    }
    
    public function sendPushNotification($data) {
        //\Cake\Log\Log::info(json_encode($data,JSON_PRETTY_PRINT));
        if(!empty($data['slug'])) { 
            $notificationType = TableRegistry::get("Api.NotificationTypes")->findBySlug($data['slug']);
            if($notificationType->isEmpty()) {
                return false;
            }
           
            $notificationType = $notificationType->first();
            $deviceId = TableRegistry::get("Api.UserLogs")->findByUserId($data['requested_to'])->select(['id', 'user_id', 'device_id','device_token']);
            if($deviceId->isEmpty()) {
                //return false;
                $deviceToken = '';
            }else{
                $deviceToken= $deviceId->first()->device_token;
            }
            switch($notificationType->slug){
                case "friend-request":
                case "join-request":
                    $notificationType->message = str_replace("<USERNAME>", ucwords($data['display_name']), $notificationType->message);
                    break;
                case "new-spayc":                    
                    $notificationType->message = str_replace(["<X>","<SpaycName>"], [$data['distance'],$data['spayc_name']], $notificationType->message);
                
                    break;
                case "friend-join-spayc":
                case "accept-join-request":
                   $notificationType->message = str_replace("<SpaycName>", $data['spayc_name'], $notificationType->message);
                    break;
                case "user-joined-your-spayc":
                    $notificationType->message = str_replace(["<USERNAME>","<SpaycName>"], [ucwords($data['display_name']),$data['spayc_name']], $notificationType->message);
                    break;
                case "user-subscribed-to-your-spayc":
                case "friend-subscribed-to-your-spayc":
                     $notificationType->message = str_replace(["<USERNAME>","<SpaycName>"], [ucwords($data['display_name']),$data['spayc_name']], $notificationType->message);
                    break;
                
            }
            $userImages = TableRegistry::get("Api.UserImages")->findByUserIdAndIsProfile($data['requested_by'], 'Yes');
            if(!$userImages->isEmpty()) {
                $data['user_image'] = $userImages->first()->image_url;
            }
            $timezone = Configure::read('timezone');
            $userInputTime = new Time('now',$timezone);
            //$userInputTime = new \DateTime("now", new \DateTimeZone('America/New_York') );
            //echo $userInputTime->format('Y-m-d H:i:s');
            $data['time'] =  $userInputTime->format("m-d-Y H:i:s");
            $data['device_token'] = $deviceToken;
            $data['notification_type'] = $notificationType->type;
            //pr($data);die;
            /* Save the record in db*/
             $data['date_time'] = (new Time($userInputTime, $timezone))->setTimezone('UTC')->format("Y-m-d H:i:s");
            $data['message'] = $notificationType->message;
            $data['status'] = 'Unread';
            $data['created'] = date("Y-m-d H:i:s"); //pr($data);exit;
            $saveNotification = TableRegistry::get("Api.Notifications")->addNotification($data);
            $data['id'] = $saveNotification->id;
            /* end of saving  */
            /* create a job in queue */
            TableRegistry::get('Queue.QueuedJobs')->createJob('Notification',$data);
        }
    }
    
     
    public function sendPushNotificationSpaycEvent($data) {
        if(!empty($data['slug'])) { 
            $notificationType = TableRegistry::get("Api.NotificationTypes")->findBySlug($data['slug']);
            if($notificationType->isEmpty()) {
                return false;
            }
           
            $notificationType = $notificationType->first();
            $deviceId = TableRegistry::get("Api.UserLogs")->findByUserId($data['requested_to'])
                    ->find('all',
                ['fields'=>
                    [
                        'UserLogs.user_id',
                        'UserLogs.device_id',
                        'UserLogs.device_token',
                        'users.email',                        
                        'users.display_name',                        
                        ]])
                    ->select(['id', 'user_id', 'device_id','device_token'])
                    ->join(
                [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => [
                        'UserLogs.user_id = users.id',
                    ]
                ]);
//            print_R($deviceId->first());die;
            if($deviceId->isEmpty()) {
                return ['status'=>'failed','message'=>"Device ID Not Found"];
            }
           
            $deviceId = $deviceId->first();
            if($deviceId['users']['email']) {
//                print_R($deviceId['users']['email']);die;
            $mail = (object)[];
            $mail->email=$deviceId['users']['email'];
            $mail->display_name=$deviceId['users']['display_name'];
            $mail->spayc_name=$data['spayc_name'];
            //Send Email
            if($notificationType->slug == 'spayc-start-event'){
            $success =    $this->getMailer('Api.User')->send('eventStartCron', [$mail]);
            }elseif ($notificationType->slug == 'spayc-end-event') {
                    $success =    $this->getMailer('Api.User')->send('eventEndCron', [$mail]);
            }
            //Send Email
            }
            
//            if(strlen($deviceId->device_token)<64) {
//                return ['status'=>'failed','message'=>"Device ID Characters not Valid"];
//            }
            if($notificationType->slug == 'spayc-start-event' || $notificationType->slug == 'spayc-end-event') {
                $notificationType->message = str_replace("<WarpName>", ucwords($data['spayc_name']), $notificationType->message);
            }
            $timezone = Configure::read('timezone');
            $userInputTime = new Time('now',$timezone);
            //$userInputTime = new \DateTime("now", new \DateTimeZone('America/New_York') );
            //echo $userInputTime->format('Y-m-d H:i:s');
            $data['time'] =  $userInputTime->format("m-d-Y H:i:s");
            $data['device_token'] = $deviceId->device_token;
            $data['notification_type'] = $notificationType->type;
            $data['message'] = $notificationType->message;
//            pr($data);die;
            $sent = false;
            if(!empty($data['device_token'])) {
                $sent = $this->sendOnIOS($data);
            }
            return $sent;
        }
    }
}
/**** End Services Controller*******/
