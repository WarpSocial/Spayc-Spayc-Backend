<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

/**
 * Matrix component
 */
class MatrixComponent extends Component {

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
        $Matrixconfig = Configure::read('MATRIX');
        $config = !empty($config)?$config:array();
        $this->_config = array_merge($this->_defaultConfig , $Matrixconfig , $config);        
    }
    
    /**
     * register to register new account to matrix chatserver
     */
    public function register($items){
        if(empty($items)){
            return false;
        }
        $validInput = [
            'auth'=>['type'=>'m.login.dummy'],
            'bind_email'=>false,
            'device_id'=>$items['device_id'],
            'initial_device_display_name'=>$items['user_name'],
            'username'=>$items['user_name'],
            'password'=>$items['password']
        ]; 
        $url = $this->config('url') . DS.'register';
        $http = new Client();
        $httpResponse = $http->post(
                $url, 
                json_encode($validInput), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => false, 
                    'ssl_verify_peer' => false,
                    'ssl_verify_host' => false,
                    'ssl_verify_peer_name' => false
                ]
            );
        $response = json_decode($httpResponse->body);
        //pr($response);die;
        if($httpResponse->isOk()){
            return $response;
        }else{
            return false;
        }
        
    }

}
