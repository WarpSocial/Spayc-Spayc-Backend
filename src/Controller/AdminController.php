<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AdminController extends AppController
{    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
    */
    public function initialize()
    {
        parent::initialize();        
        $this->viewBuilder()->layout('admin'); 
        $this->loadComponent('Flash');        
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
        
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }
    public function beforeFilter(Event $event)
    {
        $this->base_url = Router::url('/', true);
        $this->base_url_admin = Router::url('/', true).'admin';
        $this->errorSuccessMessage = Configure::read('ERRORANDSUCCESSMSG');
        $this->siteTitleMessage = Configure::read('SITETITLEMESSAGE');        
        $this->set('error_success_message', json_encode($this->errorSuccessMessage));
        $this->set('base_url', $this->base_url);
        $this->set('base_url_admin', $this->base_url_admin); 
        $authUser='';        
        if($this->Auth->user()){               
            $authUser=$this->Auth->user();                
        }  
        $this->set(['authUser'=>$authUser]);
    }  
    
    public $paginate = [
        'limit' => PAGINATION_LIMIT,
        'order' => [
            'created' => 'desc'
        ]
    ];
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
    public function ajaxResponse($data=[],$type='json'){        
        $this->response->type($type);
        $this->response->statusCode(200);
        $this->response->body(json_encode($data)); 
        $this->response->send();
        $this->response->stop();
    }
    
}
