<?php

namespace Api\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }
    public function beforeRender(Event $event) {
        parent::beforeRender($event);
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
        $this->set('_serialize', true);        
    }
    public function mapErrors($errors) {
        foreach ($errors as $ekey => $row) {
            foreach ($row as $ikey => $ival) {
                return $ekey.":".$ival;
            }
        }
    }
    
}
