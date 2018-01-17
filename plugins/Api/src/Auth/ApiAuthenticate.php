<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api\Auth;

/**
 * Description of ApiAuthenticate
 *
 * @author kiwitech
 */
use Cake\Auth\BaseAuthenticate;
use Cake\Controller\ComponentRegistry;
use Cake\Http\ServerRequest;
Use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Api\Auth\ApiPasswordHasher;

class ApiAuthenticate extends BaseAuthenticate {

    /**
     * Constructor.
     *
     * Settings for this object.
     *
     * - `parameter` The url parameter name of the token.     
     * - `userModel` The model name of the User, defaults to Users.
     * - `fields` The fields to use to identify a user by. Make sure `'token'` has
     *    been added to the array
     * - `scope` Additional conditions to use when looking up and authenticating users,
     *    i.e. `['Users.is_active' => 1].`
     * - `contain` Extra models to contain.
     *
     * @param \Cake\Controller\ComponentRegistry $registry The Component registry
     *   used on this request.
     * @param array $config Array of config to use.
     * @throws Cake\Error\Exception If header is not present.
     */
    public function __construct(ComponentRegistry $registry, $config) {
        $this->_registry = $registry;
        $this->config([
            'parameter' => '_token',
            'header' => 'X-ApiToken',
            'fields' => ['token' => 'HTTP_TOKEN','username'=>'username', 'password' => 'password'],
            
        ]);
        $this->config($config);
        if (empty($this->_config['parameter']) &&
                empty($this->_config['header'])
        ) {
            throw new Exception(__d(
                    'authenticate', 'You need to specify token parameter and/or header'
            ));
        }
    }

    public function getUser(ServerRequest $request) { 
        $token = env('HTTP_TOKEN');        
        if (empty($token)) {
            return false;
        }        
        $table = TableRegistry::get('Api.'.$this->_config['userModel']);
        $user = $table->find()->matching('UserLogs',function($q)use($token){
            return $q
                    ->select(['id','user_id','plain_token','token','matrix_access_token','device_id','matrix_user_id','login_status','last_login'])
                    ->where(['plain_token'=>$token]);
            
        })->where(['Users.status'=>'Active']);
        if($user->isEmpty()){
            return false;
        }
        $user = $user->first();
        $user['UserLogs'] = $user->_matchingData['UserLogs']->toArray();
        if (!$user){
            return false;
        } 
        return $user->toArray();
    }

    public function authenticate(ServerRequest $request, Response $response) {
        $fields = $this->_config['fields'];
        $username = $request->getData($fields['username']);
        $password = $request->getData($fields['password']);
        /* in case of facebook */
        $fbId = $request->getData('fb_id');
        $token = $request->env('HTTP_TOKEN');
        if(!empty($username) && !empty($password)){
            $user = $this->_findByFields($username,$password);
        }elseif(!empty($token)){
            $user = $this->getUser($request);
        }elseif(!empty($fbId)){
            $userModel = 'Api.'.$this->_config['userModel'];
            $query = TableRegistry::get($userModel)->findByFbIdAndStatus($fbId, 'Active');
            if($query->isEmpty()){
                return false;
            }
            $user = $query->first()->toArray();
        }else{
            $user = false;
        }
        return $user;
    }    
    public function unauthenticated(ServerRequest $request, Response $response) {
        $response->statusCode(403);
        $msgbody = ['status' => 'failed', 'message' => "You're not authorized"];
        $response->body(json_encode($msgbody));
        $response->type('json');
        return $response;
    }
    
    protected function _findByFields($username,$password){
        $fields = $this->_config['fields'];
        $userModel = 'Api.'.$this->_config['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->_config['fields'];
        $conditions = [$fields['username']=>$username];
        if (!empty($this->_config['scope'])) {
            $conditions = array_merge($conditions, $this->_config['scope']);
        }
        $table = TableRegistry::get($userModel)->find();
        if ($this->_config['contain']) {
            $table = $table->contain($this->_config['contain']);
        }
        $entity = $table
                ->where($conditions)
                ->hydrate(false);
        if($entity->isEmpty()){
            return false;
        }
        $result = $entity->first();
        if (!(new ApiPasswordHasher())->check($password, $result[$fields['password']])) {
            return false;
        }
        return $result;
    }
}
