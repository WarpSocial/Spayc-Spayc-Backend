<?php

/**
 * Description of EplannerPasswordHasher
 *
 * @author kiwitech
 */

namespace Api\Auth;

use Cake\Utility\Security;

class ApiHasher {
    private static $hashkey = 'wt1U5MACWJFTXGenB8BB6FDF9E7B3A827A';
    private static $floatKey = 52532525.07;

    public static function hash($password) {
        $encrypt = base64_encode(Security::encrypt($password, self::$hashkey));
        return $encrypt;
    }

    public static function check($password, $hashedPassword) {    
        $originalPassword = self::dehash($hashedPassword);
        if ($password == $originalPassword) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function dehash($hashedPassword) {
        $hashedPassword = base64_decode($hashedPassword);
        $originalPassword = Security::decrypt($hashedPassword,  self::$hashkey);
        return $originalPassword;
    }
    
    public static function encrypt($sData) {
        $id=(double)$sData*self::$floatKey;
        return base64_encode($id);
    }

    public static function decrypt($sData) {
        $url_id=base64_decode($sData);
        $id=(double)$url_id/self::$floatKey;
        return (int)$id;
    }
}
