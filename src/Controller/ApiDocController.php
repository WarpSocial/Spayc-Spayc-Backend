<?php

/**
 * Description of WapApiController
 *
 * @author kiwitech
 */

namespace App\Controller;

use App\Controller\AppController;

class ApiDocController extends AppController {

   
    
    public function apiList(){
       $this->render('api_list',false);
    }

}
