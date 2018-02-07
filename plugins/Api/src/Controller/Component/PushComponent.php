<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Aws\Sns\SnsClient;


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
    
    public function sendOnIOS($device_token, $message, $eventData = null){
        try{ 
            //require_once APPPATH.'third_party/aws/aws-autoloader.php';
            $config = $this->snsConfig;
            if(isset($eventData) && !empty($eventData)) {
                $updated = true; 
            } else {                
                $updated = false;  
            }
            $this->SnsClient = SnsClient::factory($config);
            /*Start Create EndpointARN*/
            $attr1 = array(
                'PlatformApplicationArn' => $config['ARN_IOS'],
                'Token' => $device_token
            );
            $endpointARN = $this->SnsClient->createPlatformEndpoint($attr1);
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
            $FinalMessage = json_encode(array('default' => $message,'APNS' => json_encode(array(
                    'aps' => array(
                      'alert' => $message,
                      'sound'=>'default'
                       
                    ),
                'updated' => $updated
                       
                  ))
                ));
            $this->SnsClient->publish(
                array(
                'TargetArn' => $device_token,
                'MessageStructure' => 'json',
                'Message' => $FinalMessage
                )
            );
        } catch(Exception $e){
            print($e->getMessage());
        }
    }
    
    public function sendOnAndroid($device_token, $message, $eventData= null) {
             //, $badge, $count, $notification_type = null,$project_id
        //$data = array('message'=>$message,'project_id'=>$project_id);
        $data = array('message'=>$message);
        if(isset($eventData) && !empty($eventData)) {
            $data['updated'] = 'true';            
            $data['Event'] = $eventData;            
        }
        $target = $device_token;

        //FCM api URL
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $CI = & get_instance();
        $server_key = $CI->config->item('ANDROID_PUSH_KEY');
        $fields = array();
        $fields['data'] = $data;        
        $fields['to'] = $target;

        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
          'Authorization:key='.$server_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        //var_dump($result);exit; 
        //return true;
    }
    
}
/**** End Services Controller*******/
