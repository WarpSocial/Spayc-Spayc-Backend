<?php

/**
 * Description of EplannerPasswordHasher
 *
 * @author kiwitech
 */

namespace Api\Auth;

use Cake\Auth\AbstractPasswordHasher;
use Cake\Utility\Security;

class ApiPasswordHasher extends AbstractPasswordHasher {
    private $hashkey = 'wt1U5MACWJFTXGenB8BB6FDF9E7B3A827A';

    public function hash($password) {
        $encrypt = base64_encode(Security::encrypt($password, $this->hashkey));
        return $encrypt;
    }

    public function check($password, $hashedPassword) {        
        $originalPassword = $this->dehash($hashedPassword);
        if ($password == $originalPassword) {
            return true;
        } else {
            return false;
        }
    }
    
    public function dehash($hashedPassword) {
        $hashedPassword = base64_decode($hashedPassword);
        $originalPassword = Security::decrypt($hashedPassword,$this->hashkey);
        return $originalPassword;
    }

    

}
