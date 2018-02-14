<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;
use Api\Utils\Utils;

/**
 * Matrix component
 */
class MatrixComponent extends Component {
    
    public $components = ['Auth'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'client'=> 'client/r0',
        'media'=> 'media/v1'
    ];
    
     /**
     * Controller
     *
     * @var Controller
     */
    protected $Controller = null;
    
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
        $this->Controller = $this->_registry->getController();
    }
    
    /**
     * login to get login to matrix server
     * 
     * @param string $username 
     * @param string $password 
     * @param String $device_id 
     * 
     * @return array [access_token,home_server,user_id,device_id]
     */
    
    public function login($items= []){
        if(empty($items)){
            return false;
        }
        $validInput = [
            'type'=>'m.login.password',
            'user'=>preg_replace('/[\s\.\-\@\#]/','_',$items['username']),
            'password'=>$items['password'],
            'device_id'=>$items['device_id']
        ]; 
        $url = $this->config('url') .DS.$this->config('client'). DS.'login';
        $http = new Client();
        $httpResponse = $http->post(
                $url, 
                json_encode($validInput), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        if($httpResponse->isOk()){
            return $response;
        }else{
            return false;
        }
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
            'initial_device_display_name'=>$items['username'],
            'username'=>preg_replace('/[\s\.\-\@\#]/','_',$items['username']),
            'password'=>$items['password']
        ]; 
        $url = $this->config('url') .DS.$this->config('client'). DS.'register';
        $http = new Client();
        $httpResponse = $http->post(
                $url, 
                json_encode($validInput), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        #pr($response);die;
        if($httpResponse->isOk()){
            return $response;
        }else{
            return false;
        }        
    }
    /**
     * createRoom method to create room on matrix server
     * 
     * @param Array $items array contain required field of matrix fields
     * @return false|$data return data if created or false
     */
    public function createRoom($items=[]){
        if(empty($items)){
            return false;
        }
        $validInput = [
            'creation_content'=>[
                'm.federate'=>false,
                'location'=> Utils::getVar('location', $items),
                'type'=>Utils::getVar('type', $items),
                'group_type'=>Utils::getVar('group_type', $items),
                'start_date'=> Utils::getVar('start_date', $items),
                'end_date'=> Utils::getVar('end_date', $items),
                'passcode'=> Utils::getVar('passcode', $items),
                'latitude'=> Utils::getVar('latitude', $items),
                'longitude'=> Utils::getVar('longitude', $items)
                ],
            'name'=>Utils::getVar('name', $items),
            'preset'=> strtolower($items['group_type']).'_chat',
            'room_alias_name'=> \Cake\Utility\Inflector::slug($items['name']),
            'topic'=> Utils::getVar('description', $items),
            'invite' => !empty($items['invite'])?explode(',',$items['invite']):""
        ];
        #pr($validInput);die;
        $url = $this->config('url') .DS.$this->config('client'). DS.'createRoom';
        $http = new Client(['headers' => ['Authorization' => 'Bearer ' . $items['matrix_token']]]);
        $httpResponse = $http->post(
                $url, 
                json_encode($validInput), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        #pr($response);die;
        return $response;
    }
    
    /**
     * uploadRoomImage to upload room image
     */
    
    public function uploadMediaImage($data){
        if(empty($data['image_url'])){
            return;
        }        
        if(strstr($data['image_url'],'http') !== false){
            $fileInfo = pathinfo($data['image_url']);
            $filename = $fileInfo['basename'];
            $contentType = 'image/'.$fileInfo['extension'];
            $rawfile = $data['image_url'];
        }else{
            $filename = $data['image_url']['name'];
            $contentType = $data['image_url']['type'];
            $rawfile = $data['image_url']['tmp_name'];
        }
        if(empty($data['token'])){
            $data['token'] = $this->Auth->user('UserLogs.matrix_access_token');
            //pr($data['token']);die;
        }
        
        //$body = fopen($data['image_url']['tmp_name'], 'r');        
        $url = $this->config('url') .DS.$this->config('media'). DS.'upload?access_token='.$data['token'].'&filename='.$filename;
        $http = new Client(['headers' => ['Content-Type' =>$contentType]]);
        $httpResponse = $http->post(
                $url, 
                file_get_contents($rawfile),
                [
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        if(!empty($response['content_uri'])){
            $this->setRoomAvatar($response['content_uri'],$data['room_id'],$data['token']);
        }
        return $response;
    }
    
    public function setRoomAvatar($matrixuri = null,$roomid = null,$token = null){
        if($matrixuri == null || $roomid == null || $token == null){
            return;
        }
        $url = $this->config('url') .DS.$this->config('client'). DS.'rooms'.DS.$roomid.DS.'state/m.room.avatar/?access_token='.$token;
        //echo $url;
        $http = new Client();
        $httpResponse = $http->put(
                $url, 
                json_encode(['url'=>$matrixuri]),
                [
                    'type' => 'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        return;
    }
    
    /**
     * change password to matrix chatserver
     */
    public function changePassword($items){
        if(empty($items)){
            return false;
        }
        $validInput = [
            'auth'=>['type'=>'m.login.password', 'user'=>$items['matrix_user_id'], 'password'=>$items['old_password']],
            'new_password'=>$items['new_password']
        ]; 
        $url = $this->config('url') . DS.'account'.DS.'password?access_token='.$items['matrix_access_token'];
        $http = new Client();
        $httpResponse = $http->post(
                $url, 
                json_encode($validInput), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        $response = json_decode($httpResponse->body,true);
        #pr($response);die;
        if($httpResponse->isOk()){
            return $response;
        }else{
            return false;
        }        
    }

}
