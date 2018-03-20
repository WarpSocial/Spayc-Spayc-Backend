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
            'user'=>$items['username'],
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
            'initial_device_display_name'=>$items['display_name'],
            'username'=>$items['username'],
            'password'=>$items['password'],
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
        if($httpResponse->isOk()){            
            $response['status'] = 'success';
            $this->displayName($items['display_name'],$response['user_id'],$response['access_token']);
        }else{
            $response['status'] = 'failed';
            $response['message'] = $this->errorMsg($response['errcode']);
        }
        return $response;
    }
    
    /*update display name*/
    public function displayName($name=null,$matrixUserId=null,$matrixToken=null){
        if(empty($matrixUserId) || empty($matrixToken) || empty($name)){
            return false;
        }
        $http = new Client();
        $profileId = urlencode($matrixUserId);
        $url = $this->config('url') .DS.$this->config('client').DS.'profile'. DS.$profileId.DS.'displayname?access_token='.$matrixToken;
        $httpResponse = $http->put(
            $url, 
            json_encode(['displayname'=>$name]), 
            [
                'type'=>'json',
                'ssl_verify_host' => $this->config('sslverify'), 
                'ssl_verify_peer' => $this->config('sslverify'),
                'ssl_verify_host' => $this->config('sslverify'),
                'ssl_verify_peer_name' => $this->config('sslverify')
            ]
        ); 
        
        $response = json_decode($httpResponse->body,true);
        if(!empty($response['errcode'])){
            return $response;
        }else{
            return true;
        }
    }
    /**
     * createRoom method to create room on matrix server
     * 
     * @param Array $items array contain required field of matrix fields
     * @return false|$data return data if created or false
     */
    public function createRoom($items=[]) {
        if(empty($items)) {
            return false;
        }
        if(empty($items['visibility'])){
            $items['visibility'] = strtolower($items['group_type']);
        }
        if(empty($items['is_direct'])){
            $items['visibility'] = 'public';
            $items['group_type'] = 'public';
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
            'room_alias_name'=> \Cake\Utility\Inflector::slug($items['name'].'_'.microtime(true)),
            'visibility'=> strtolower(Utils::getVar('visibility',$items)),            
            'topic'=> Utils::getVar('description', $items),
            //'join_rule'=>'public',
            'invite' => !empty($items['invite'])?explode(',',$items['invite']):""
        ];
        if(!empty($items['is_direct'])){
            $validInput['is_direct'] = $items['is_direct'];
            unset($validInput['room_alias_name']);
        }
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
        if(empty($items['is_direct']) && !empty($response['room_id']) && !empty($items['invite'])){
            $joinees = explode(',',$items['invite']);
            foreach($joinees as $ke => $mid){
                $joinData = [
                    'status'=>'Joined',
                    'matrix_room_id'=>$response['room_id'],
                    'matrix_token'=>$items['matrix_token']
                ];
                $this->joinRoom($joinData);
            }
        }
//        if(empty($items['is_direct']) && ($items['visibility'] == 'private') && empty($response['error'])){
//            /** Join Rules in case of private room */
//            $joinRulesInput = ['matrix_token'=>$items['matrix_token'],'join_rule'=>'public'];
//            $this->updateRoom($response['room_id'],$joinRulesInput);
//        }
        return $response;
    }
    
    /**
     * 
     */
    /**
     * updateRoom method to update room on matrix server
     * 
     * @param Array $items array contain required field of matrix fields
     * @return false|$data return data if created or false
     */
    public function updateRoom($matrix_room_id = null,$items=[]) {
        if(empty($items) || $matrix_room_id == null) {
            return false;
        }
        
        $http = new Client();
        $url = $this->config('url') .DS.$this->config('client').'/rooms'. DS.$matrix_room_id.DS.'state';
        if(!empty($items['name'])){ 
            $httpResponse['name'] =   $http->put(
                $url.'/m.room.name?access_token='.$items['matrix_token'], 
                json_encode(['name'=>$items['name']]), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
            //pr($httpResponse['name']->body());die;
        }
        if(!empty($items['description'])){
            $httpResponse['topic'] =  $http->put(
                $url.'/m.room.topic?access_token='.$items['matrix_token'], 
                json_encode(['topic'=>$items['description']]), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            );
        }
        if(!empty($items['group_type'])){
            $preset = strtolower($items['group_type']).'_chat';
            $httpResponse['preset'] = $http->put(
                $url.'/m.room.preset?access_token='.$items['matrix_token'], 
                    json_encode(['preset'=>$preset]), 
                    [
                        'type'=>'json',
                        'ssl_verify_host' => $this->config('sslverify'), 
                        'ssl_verify_peer' => $this->config('sslverify'),
                        'ssl_verify_host' => $this->config('sslverify'),
                        'ssl_verify_peer_name' => $this->config('sslverify')
                    ]
                );
            
            $httpResponse['visibility'] = $http->put(
                    $url.'/m.room.visibility?access_token='.$items['matrix_token'], 
                    json_encode(['visibility'=> strtolower($items['group_type'])]), 
                    [
                        'type'=>'json',
                        'ssl_verify_host' => $this->config('sslverify'), 
                        'ssl_verify_peer' => $this->config('sslverify'),
                        'ssl_verify_host' => $this->config('sslverify'),
                        'ssl_verify_peer_name' => $this->config('sslverify')
                    ]
                ); 
        }
        if(!empty($items['join_rule'])){
            $httpResponse['join_rule'] = $http->put(
                $url.'/m.room.join_rules?access_token='.$items['matrix_token'], 
                json_encode(['join_rule'=>'public']), 
                [
                    'type'=>'json',
                    'ssl_verify_host' => $this->config('sslverify'), 
                    'ssl_verify_peer' => $this->config('sslverify'),
                    'ssl_verify_host' => $this->config('sslverify'),
                    'ssl_verify_peer_name' => $this->config('sslverify')
                ]
            ); 
            
        }
        $response = [];
        foreach ($httpResponse as $opt=>$res){
            $response[$opt] = json_decode($res->body,true);
            if(!empty($response[$opt]['errcode'])){
                return false;
            }            
        }
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
        if(empty($data['matrix_token'])){
            $data['matrix_token'] = $this->Auth->user('UserLogs.matrix_access_token');
            //pr($data['token']);die;
        }
        //echo $rawfile.'<br>'.$filename.'<br>'.$contentType;pr($data);die;
        //$body = fopen($data['image_url']['tmp_name'], 'r');        
        $url = $this->config('url') .DS.$this->config('media'). DS.'upload?access_token='.$data['matrix_token'].'&filename='.urldecode($filename);
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
            $this->setAvatarUrl($response['content_uri'],$data);
        }
        return $response;
    }
    
    public function setAvatarUrl($matrixuri = null,$options){        
        if(empty($options['matrix_token'])){
            return;
        }
        if(!empty($options['matrix_room_id'])){
            $options['body'] = ['url'=>$matrixuri];
            $options['url'] = $this->config('url') .DS.$this->config('client'). DS.'rooms'.DS.$options['matrix_room_id'].DS.'state/m.room.avatar/?access_token='.$options['matrix_token'];
        }elseif(!empty($options['matrix_user_id'])){
            $options['body'] = ['avatar_url'=>$matrixuri];
            $options['url'] = $this->config('url') .DS.$this->config('client'). DS.'profile'.DS. urlencode($options['matrix_user_id']).DS.'avatar_url?access_token='.$options['matrix_token'];
        }else{
            return;
        }
        
        $http = new Client();
        $httpResponse = $http->put(
                $options['url'], 
                json_encode($options['body']),
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
            'auth'=>[
                'type'=>'m.login.password', 
                'user'=>$items['matrix_user_id'], 
                'password'=>$items['old_password']
            ],
            'new_password'=>$items['new_password']
        ]; 
        $url = $this->config('url').DS.$this->config('client') . DS.'account'.DS.'password?access_token='.$items['matrix_access_token'];
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
    
    public function leaveRoom($matrix_room_id = null,$matrix_token = null){
        if(empty($matrix_room_id) || empty($matrix_token)){
            return false;
        }
        $roomId  = $this->validRoomId($matrix_room_id);
        $http = new Client();
        $url = $this->config('url') .DS.$this->config('client').DS.'rooms'. DS.$roomId.DS.'leave?access_token='.$matrix_token;
       
        $httpResponse = $http->post(
            $url, 
            json_encode([]), 
            [
                'type'=>'json',
                'ssl_verify_host' => $this->config('sslverify'), 
                'ssl_verify_peer' => $this->config('sslverify'),
                'ssl_verify_host' => $this->config('sslverify'),
                'ssl_verify_peer_name' => $this->config('sslverify')
            ]
        ); 
        
        $response = json_decode($httpResponse->body,true);
        if(!empty($response['errcode'])){
            return $response;
        }else{
            return true;
        }
    }
    public function joinRoom($data = []){
        if(empty($data['status']) || empty($data['matrix_token']) || empty($data['matrix_room_id'])){
            return false;
        }
        if($data['status'] == 'Pending'){
            return true;
        }
        $postData = [];
        $roomId  = $this->validRoomId($data['matrix_room_id']);
        $http = new Client();
        if($data['status'] == 'Joined'){ 
            $url = $this->config('url') .DS.$this->config('client').DS.'join'. DS.$roomId.'?access_token='.$data['matrix_token'];
        }elseif($data['status'] == 'Invite'){
            return true;
            $url = $this->config('url') .DS.$this->config('client').DS.'rooms'. DS.$roomId.DS.'invite?access_token='.$data['matrix_token'];
            $postData = ['user_id'=>$data['matrix_user_id']];
        }else{
            return true;
            $url = $this->config('url') .DS.$this->config('client').DS.'rooms'. DS.$roomId.DS.'leave?access_token='.$data['matrix_token'];
        }
        $httpResponse = $http->post(
            $url, 
            json_encode($postData), 
            [
                'type'=>'json',
                'ssl_verify_host' => $this->config('sslverify'), 
                'ssl_verify_peer' => $this->config('sslverify'),
                'ssl_verify_host' => $this->config('sslverify'),
                'ssl_verify_peer_name' => $this->config('sslverify')
            ]
        ); 
        
        $response = json_decode($httpResponse->body,true);
        if(!empty($response['errcode'])){
            return $this->errorMsg($response['errcode']);
        }elseif(!empty($response['room_id'])){
            return true;
        }else{
            return false;
        }
    }
    
    public function validRoomId($roomid=null){
        if($roomid == null){
            return false;
        }
        return '!'.urlencode(substr($roomid,1));
    }
    
    public function errorMsg($errorCode){
        $messages = [
            'M_FORBIDDEN'=>__('You are not invited to this room'),
            'M_UNRECOGNIZED'=>__('Invalid request')
        ];
        if(array_key_exists($errorCode, $messages)){
            return $messages[$errorCode];
        }else{
            return __('Invalid request.');
        }
        
    }

}
