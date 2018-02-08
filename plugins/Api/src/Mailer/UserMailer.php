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
            ->to($items->email)
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

    public function contactUs($user) {
        $this->viewVars(['user' => $user])
            ->to(Configure::read('Settings.adminEmail'))
            ->subject(sprintf('A user try to contact you from Rehab network.'))
            ->emailFormat('html')
            ->template('contactus'); // By default template with same name as method name is used. 
    }

}
