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
    
    public function sendOnIOS($device_token, $message){
        try {
            $config = $this->snsConfig;
            
            
            $this->SnsClient = SnsClient::factory([
                'version' => $config['version'],
                'region'  => $config['region'],
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'], 
                ]
            ]); //pr($this->SnsClient);exit;
            /*Start Create EndpointARN*/
            $attr1 = array(
                'PlatformApplicationArn' => $config['ARN_IOS'],
                'Token' => $device_token
            );
            $endpointARN = $this->SnsClient->createPlatformEndpoint($attr1); pr($endpointARN);exit;
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
        } catch(Exception $e){
            print($e->getMessage());
        }
    }
}
/**** End Services Controller*******/
