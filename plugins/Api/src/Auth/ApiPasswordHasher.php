<?php

/**
 * Description of EplannerPasswordHasher
 *
 * @author kiwitech
 */

namespace Api\Auth;

use Cake\Auth\AbstractPasswordHasher;
use Cake\Utility\Security;
use Cake\Utility\Crypto;

class ApiPasswordHasher extends AbstractPasswordHasher {

    public function hash($password) {
        return static::epEncrypt($password);
    }

    public function check($password, $hashedPassword) {
        if (static::epEncrypt($password) == $hashedPassword) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function dehash($password) {
        return static::epDecrypt($password);
    }

    public static function epEncrypt($plaintext) {
        $salt = substr(Security::salt(), 1, 31);
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $salt, $iv);
        $encrypted_data = mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encoded_64 = base64_encode($encrypted_data);
        return trim($encoded_64);
    }

    public static function epDecrypt($crypttext) {
        $salt = substr(Security::salt(), 1, 31);
        $decoded_64 = base64_decode($crypttext);
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $salt, $iv);
        $decrypted_data = mdecrypt_generic($td, $decoded_64);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim($decrypted_data);
    }

}
