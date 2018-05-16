<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;
use \Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Api\Utils\Utils;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Advertisement Controller
 *
 * @property \Api\Model\Table\SpaycsTable $Spaycs
 *
 * @method \Api\Model\Entity\Spayc[] paginate($object = null, array $settings = [])
 */
class AdminController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
        $this->loadComponent('Api.Matrix');
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Edit method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function index($id = null) {
        if (!$this->request->is(['post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        
//        $data = [
//            'image'=>'https://static.pexels.com/photos/248797/pexels-photo-248797.jpeg',
//            'name'=>'Xyz',
//            'location'=>'Xyz',
//            'type'=>'Community',
//            'user_id'=>'65',
//        ];
        $spayc=TableRegistry::get('Api.Spaycs');
        $item=$spayc->newEntity($data,['validate'=>false]);
        $spayc->save($item);
        
        print_R($item);die;
        if(1){
            
        }else {
            $this->restException(['status' => 'failed', 'message' => __('The spayc could not be updated. Please, try again.')], 400);
        }
        $this->set($response);
    }
    
    public function grab_image($url,$saveto){
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}

}
