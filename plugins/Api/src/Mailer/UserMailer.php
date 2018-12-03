<?php

/**
 * Description of UserMailer
 *
 * @author Mr Subhash
 */

namespace Api\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class UserMailer extends Mailer {

    public function signup($items) {
        $this->viewVars(['user' => $items])
            ->setDomain(Configure::read('App.domain'))
            ->to($items['email'])
            ->subject(Configure::read('signup_welcome_msg'))
            ->emailFormat('html')
            ->template('Api.signup'); // By default template with same name as method name is used.                
    }

    public function resetPassword($user) {
        $this
            ->to($user->email)
            ->subject('Reset password')
            ->set(['token' => $user->token]);
    }

    public function forgotPassword($user) {
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('forgotpassword_subject'))
            ->emailFormat('html')
            ->template('Api.forgotpassword');
    }
    
    public function reverification($user) {
        //pr($user['user']);die;
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('reverification_subject'))
            ->emailFormat('html')
            ->template('Api.reverification');
    }

   
    public function eventStartCron($user) {
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('startevent_subject'))
            ->emailFormat('html')
            ->template('Api.starteventcron');
    }
    public function eventEndCron($user) {
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('endevent_subject'))
            ->emailFormat('html')
            ->template('Api.endeventcron');
    }
    
    public function userFeedBack($data) {
        
        
        $this->viewVars(['data' => $data])
            ->to(Configure::read('admin_email'))
            ->subject('Warp Feedback')
            ->emailFormat('html')
            ->template('Api.feedback');
        if(!empty($data['attachment'])){
            $http = new \Cake\Http\Client();
            $response = $http->get($data['attachment']);
            
            $fino = pathinfo($data['attachment']);
            $this->setAttachments([
                $fino['basename'] => [
                    'file' => $data['attachment'],
                    'mimetype' => $response->getHeaderLine('content-type'),
                    'contentId'=>'ksdlf'
                ]
            ]);
        }
        
    }

}
