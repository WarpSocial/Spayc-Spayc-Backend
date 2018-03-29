<?php

/**
 * Description of WapApiController
 *
 * @author kiwitech
 */

namespace Api\Controller;

use Api\Controller\AppController;

class ApiDocController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow('apiList');
    }
    
    public function apiList(){
       $this->render('api_list',false);
    }

}
