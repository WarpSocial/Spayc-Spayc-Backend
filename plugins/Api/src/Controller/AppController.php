<?php

namespace Api\Controller;

use Api\Controller\Component\UtilityComponent;
use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Log\Log;
use Api\Auth\ApiHasher;


class AppController extends BaseController {
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->loadComponent('Api.Utility');
         $this->loadComponent('Auth', [
            'authenticate'=>[
                'Api.Api'=>[
                    'token'=>'HTTP_TOKEN',
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'userModel' => 'Users',
                    'scope' => ['Users.status' => 'Active'],
                ],
               
            ],
            'unauthorizedRedirect'=>false,
            'storage' => 'Memory'
         ]);
         $timezone =  $this->request->env('HTTP_TIMEZONE');
         if(!empty($timezone)){
             Configure::write('timezone', $timezone);
         }else{
             $this->request->env('HTTP_TIMEZONE','UTC');
             Configure::write('timezone', 'UTC');
         }
         $user = $this->Auth->identify();
         if(!empty($user['id'])) {
             $user['id'] = ApiHasher::decrypt($user['id']);
         }
         \Cake\Core\Configure::write('auth',$user);
         $this->Auth->setUser($user);
        Configure::write('timezone', 'UTC');
        if($this->request->header('timezone')) {
            Configure::write('timezone', $this->request->header('timezone'));
        }        
    }
    public function beforeRender(Event $event) {
        parent::beforeRender($event);
        if($this->request->is('json')){
            $this->RequestHandler->renderAs($this, 'json');
            $this->response->type('application/json');
        }
        $this->set('_serialize', true);        
    }
    public function mapErrors($errors) {
        foreach ($errors as $ekey => $row) {
            foreach ($row as $ikey => $ival) {
                return $ival;
            }
        }
    }
    /**
     * restException to deal the custom exception (To avoid much more nesting)
     * $data
     */
    public function restException($data=[], $code=200){        
        Log::info($data);        
        $this->response->type('json');
        $this->response->statusCode($code);
        $this->response->body(json_encode($data)); 
        $this->response->send();
        $this->response->stop();
    }
    /**
     * getPaging method to set the pagination variable
     */
    public function getPaging($subject=null){
        if(is_null($subject)){
            return null;
        }
        $pageKey = $this->request->getParam('paging')[$subject];
        return [
            'page_count'=>$pageKey['pageCount'],
            'next_page'=>$pageKey['nextPage'],
            'all_records'=>$pageKey['count'],
            'prev_page'=>$pageKey['prevPage'],
            'current_page_size'=>$pageKey['current'],
            'per_page'=>$pageKey['perPage'],
            'page'=>$pageKey['page'],
        ];
    }
    

}
