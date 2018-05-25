<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * WebApi Controller
 *
 * @property \Api\Model\Table\WebApiTable $WebApi
 */
class WebApiController extends AppController {

    /**
     * initialize the controller config
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Matrix');
        $this->loadComponent('Api.Push');
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['addCategory', 'apilog', 'addComment', 'notify']);
    }

    public function spamReport() {
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $srRegistory = TableRegistry::get('Api.SpamReports');
        $errors = $srRegistory->validateInput($data);
        if(!empty($errors)) {
            $this->restException(['status'=>'failed','message'=>$this->mapErrors($errors)], 400);
        }
        
        
        
        $items = $srEntity->patchEntity($entity, $data,['associated'=>['PhysicalLocation']]);
        if($items->errors()) {
            $this->restException(['status'=>'failed', 'message'=>$this->mapErrors($items->errors())], 400);
        }
    }

    public function apilog() {
        $del = $this->request->getQuery('clean');
        $logfile = $this->request->getQuery('file', 'api.log');
        $file = new \Cake\Filesystem\File(LOGS . $logfile);
        if (!empty($del) && ($del == 1)) {
            $file->write(null);
        }
        $errorfile = $file->read();
        pr($errorfile);
        die;
        $this->set(print_r($errorfile, false));
    }

    public function notify() {
        $this->loadComponent('Api.Notification');
        $items = $this->request->getData();
        $deviceToken = $this->request->getData('device_token');
        //$this->Push->sendOnIOS($items);
        $this->Notification->iosPush($items, $deviceToken);
    }

}
