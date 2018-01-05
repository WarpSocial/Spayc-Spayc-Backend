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
use Cake\Utility\Text;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;

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
        if (!$request->query('token'))
            return false;
        $table = TableRegistry::get($this->_config['userModel']);
        $user = $table->findByToken($request->query('token'))->first();
        if (!$user)
            return false;
        return $user->toArray();
    }

    public function authenticate(ServerRequest $request, Response $response) {        
        $fields = $this->_config['fields'];
        $username = $request->getData($fields['username']);
        $password = $request->getData($fields['password']);
        $token = $request->getData($fields['token']);
        if(!empty($username) && !empty($password)){ 
            $user = $this->_findUserByFields($username,$password);
        }elseif(!empty($token)){
            $user = $this->_findUserByToken($token);
        }else{
            return false;
        }
        return $user;
    }

    public function authenticate1(Request $request, Response $response) {
        $user = parent::authenticate($request, $response);
        if (!$user) {
            return $user;
        }
        $table = TableRegistry::get($this->_config['userModel']);
        $entity = $table->get($user[$table->primaryKey()]);
        $entity->token = $token = sha1(Text::uuid());
        $entity->token_created = $token_created = Time::now();
        unset($entity->{$this->_config['fields']['password']});
        if (!$table->save($entity)) {
            return false;
        }
        $user['token'] = $token;
        $user['token_created'] = $token_created;
        return $user;
    }

    public function unauthenticated(ServerRequest $request, Response $response) {
        $response->statusCode(403);
        $msgbody = ['status' => 'failed', 'message' => "You're not authorized"];
        $response->body(json_encode($msgbody));
        $response->type('json');
        return $response;
    }
    
    protected function _findUserByFields($username,$password){
        $fields = $this->_config['fields'];
        $userModel = $this->_config['userModel'];
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
        
        if (!(new DefaultPasswordHasher)->check($password, $result[$fields['password']])) {
            return false;
        }
        return $result;
    }

    /**
     * Find a user record.
     *
     * @param string $username The token identifier.
     * @param string $password Unused password.
     * @return Mixed Either false on failure, or an array of user data.
     */
    protected function _findUser($username, $password = null) { //pr($request);die;
        $userModel = $this->_config['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->_config['fields'];
        $conditions = [$model . '.' . $fields['token'] => $username];
        if (!empty($this->_config['scope'])) {
            $conditions = array_merge($conditions, $this->_config['scope']);
        }
        $table = TableRegistry::get($userModel)->find('all');
        if ($this->_config['contain']) {
            $table = $table->contain($this->_config['contain']);
        }
        $result = $table
                ->where($conditions)
                ->hydrate(false)
                ->first();
        if (empty($result)) {
            return false;
        }
        unset($result[$fields['password']]);
        return $result;
    }

}
