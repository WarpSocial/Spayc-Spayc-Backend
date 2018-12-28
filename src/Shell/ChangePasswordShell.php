<?php

namespace App\Shell;

use Cake\Console\Shell;

/**
 * ChangePassword shell command.
 */
class ChangePasswordShell extends Shell {

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main() {
        $this->passwordChange();
        //$this->out($this->OptionParser->help());
        
    }
    public function passwordChange(){
        if(!function_exists('exec')) {
            echo "exec function is disabled";die;
        }
        $sConn = \Cake\Datasource\ConnectionManager::get('default');
        $mConn = \Cake\Datasource\ConnectionManager::get('matrix');
        
        $apiUsers = $sConn->execute('SELECT id,username,matrix_user_id,matrix_access_token,matrix_password FROM users where role_id is null')->fetchAll('assoc');
        
        $p = [];
        $lastId = $mConn->execute('SELECT id FROM access_tokens order by id desc limit 1')->fetchAll('assoc');
        $lastId = $lastId[0]['id'];
        foreach($apiUsers as $user){ 
            $matrixPassword = md5($user['username']);
            /*update matrix password for all users in api users table */
            if(empty($user['matrix_password'])){                
                if($sConn->execute('UPDATE users SET matrix_password = ? WHERE id = ?',[$matrixPassword,$user['id']])){
                    $p['apiupdate'][] = $user['id'];
                    /*Create matrix hashed value and update matrix password in matrix users table */
                    $command = '/usr/bin/python '.ROOT.'/hash_password.py -p '.$matrixPassword;
                    $hashPasswrod = exec($command,$optionss);
                    //echo exec('whoami');
                    //pr($optionss);
                    //echo $hashPasswrod;die(" = hashvalue");
                    
                    if($mConn->execute('UPDATE users SET password_hash = ? WHERE name = ?',[$hashPasswrod,$user['matrix_user_id']])){
                        $p['matrixupdate'][] = $user['id'];
                    }else{
                        $p['matrixfailed'][] = $user['id'];
                    }
                }else{
                    $p['apiupdatefailed'][] = $user['id'];
                }
            }
            $preToken = $mConn->execute('SELECT 1 FROM access_tokens where token = ?',[$user['matrix_access_token']])->fetchAll('assoc');
            if(empty($preToken)){
                $lastId++;
                $p['insert'][] = $user['id'];
                $mConn->insert('access_tokens', ['id'=>$lastId,'user_id' => $user['matrix_user_id'],'device_id' => \Cake\Utility\Text::uuid(),'token'=>$user['matrix_access_token']]);
            }
        }
        pr($p);
    }

}
