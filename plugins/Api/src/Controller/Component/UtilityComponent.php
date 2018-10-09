<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Utility component
 */
class UtilityComponent extends Component {
    public $components = ['Auth','Api.Matrix'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function logout($token = null,$matrixAccessToken = null){
        if(is_null($token)){
            return false;
        }
        \Cake\ORM\TableRegistry::get('Api.UserLogs')->query()
                        ->delete()
                        //->set(['loginstatus' => 0])
                        ->where(['plain_token' =>  $token])
                        ->execute();
         /* delete cache data if existing before creating new one */
        \Cake\Cache\Cache::delete($token,'redis');
        $this->Matrix->logout($matrixAccessToken);
        
        return true;
    }

}
