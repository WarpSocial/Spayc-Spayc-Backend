<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Aws\Sns\SnsClient;
use Cake\I18n\Time;


class PushComponent extends Component {

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
        // \Cake\Log\Log::info(json_encode($data,JSON_PRETTY_PRINT));
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
                      'date_time'=>!empty($data['time'])?$data['time']:null
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
           // pj($resp);exit;
            return true;
        } catch(Exception $e) {
            //print($e->getMessage());exit;
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
            $deviceId = TableRegistry::get("Api.UserLogs")->findByUserId($data['requested_to'])->select(['id', 'user_id', 'device_id']);
            if($deviceId->isEmpty()) {
                return false;
            }
            $deviceId = $deviceId->first();
            
            if($notificationType->slug == 'friend-request') {
                $notificationType->message = str_replace("<USERNAME>", ucwords($data['display_name']), $notificationType->message);
            }
            if($notificationType->slug == 'new-spayc') {
                $notificationType->message = str_replace("<X>", $data['distance'], $notificationType->message);
                $notificationType->message = str_replace("<SpaycName>", $data['spayc_name'], $notificationType->message);
            }
            if($notificationType->slug == 'friend-join-spayc') {
                $notificationType->message = str_replace("<SpaycName>", $data['spayc_name'], $notificationType->message);
            }
            if($notificationType->slug == 'user-joined-your-spayc') {
                $notificationType->message = str_replace("<USERNAME>", ucwords($data['display_name']), $notificationType->message);
                $notificationType->message = str_replace("<SpaycName>", $data['spayc_name'], $notificationType->message);
            }
            if(($notificationType->slug == 'user-subscribed-to-your-spayc') || ( $notificationType->slug == 'friend-subscribed-to-your-spayc' )) {
                $notificationType->message = str_replace("<USERNAME>", ucwords($data['display_name']), $notificationType->message);
                $notificationType->message = str_replace("<SpaycName>", $data['spayc_name'], $notificationType->message);
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
            $data['device_token'] = $deviceId->device_id;
            $data['notification_type'] = $notificationType->type;
            //pr($data);die;
            /* Save the record in db*/
             $data['date_time'] = (new Time($userInputTime, $timezone))->setTimezone('UTC')->format("Y-m-d H:i:s");
            $data['message'] = $notificationType->message;
            $data['status'] = 'Unread';
            $data['created'] = date("Y-m-d H:i:s"); //pr($data);exit;
            $items = TableRegistry::get("Api.Notifications")->addNotification($data);
            /* end of saving  */
            /* Send notification */
            if(!empty($data['device_token'])) {
                if(strlen($deviceId->device_id)<64) {
                    return false;
                }
                TableRegistry::get('Queue.QueuedJobs')->createJob('Notification',$data);
                //$sent = $this->sendOnIOS($data);
            }            
        }
    }
}
/**** End Services Controller*******/
