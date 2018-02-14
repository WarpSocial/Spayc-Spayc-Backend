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
    //private static $floatKey = 52532525.07;
    private static $secret_iv = 'eaiYYkYTysia2lnHiw0N0';
    private static $encrypt_method = "AES-256-CBC";
    
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
        $output = (string)$sData;
        /*$key = hash('sha256', self::$hashkey);
        $initialization_vector = substr(hash('sha256', self::$secret_iv), 0, 16);
        if(!empty($sData)) {
          $output = openssl_encrypt($sData, self::$encrypt_method, $key, 0, $initialization_vector);
          $output = base64_encode($output);
        }*/
        return $output;
    }

    public static function decrypt($sData) {
        $output = $sData;
        /*$key = hash('sha256', self::$hashkey);
        $initialization_vector = substr(hash('sha256', self::$secret_iv), 0, 16);
        if(!empty($sData)) {
            $output = openssl_decrypt(base64_decode($sData), self::$encrypt_method, $key, 0, $initialization_vector);
        }*/
        return $output;
    }
}
