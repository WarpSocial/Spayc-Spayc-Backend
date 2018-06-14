<?php

/**
 * Description of UserMailer
 *
 * @author Mr Ankur
 */

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Mailer\Email;

class UserMailer extends Mailer {

    public function signup($items) {
        $this->viewVars(['user' => $items])
            ->to($items->email)
            ->subject(Configure::read('signup_welcome_msg'))
            ->emailFormat('html')
            ->template('signup'); // By default template with same name as method name is used.                
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
            ->template('forgotpassword');
    }
    
    public function reverification($user) {
        //pr($user['user']);die;
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('reverification_subject'))
            ->emailFormat('html')
            ->template('reverification');
    }

    public function contactUs($user) {
        $this->viewVars(['user' => $user])
            ->to(Configure::read('Settings.adminEmail'))
            ->subject(sprintf('A user try to contact you from Rehab network.'))
            ->emailFormat('html')
            ->template('contactus'); // By default template with same name as method name is used. 
    }

    public function userStatus($user) {        
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject($user->statusTxt)
            ->emailFormat('html')
            ->template('userstatus');
    }
    public function spaycStatus($spayc) {        
        $this->viewVars(['spayc' => $spayc])
            ->to($spayc['email'])
            ->subject($spayc['statusTxt'])
            ->emailFormat('html')
            ->template('spaycstatus');
    }
    public function customMessages($user) {        
        $this->viewVars(['user' => $user])
            ->to($user['email'])
            ->subject(Configure::read('custom_messages_subject'))
            ->emailFormat('html')
            ->template('custommessages');
    }
    public function advertisementDelete($user) {        
        $this->viewVars(['user' => $user])
            ->to($user->email)
            ->subject(Configure::read('advertisement_deleted_by_admin'))
            ->emailFormat('html')
            ->template('advertisementdelete');
    }
    
    public function warpDeleted($user) {        
        $this->viewVars(['user' => $user])
            ->to($user['email'])
            ->subject(Configure::read('spayc_deleted_by_admin'))
            ->emailFormat('html')
            ->template('warpdelete');
    }

}
