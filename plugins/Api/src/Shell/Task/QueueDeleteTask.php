<?php

namespace Api\Shell\Task;

use Cake\Console\Shell;
use Queue\Shell\Task\QueueTask;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
/**
 * Delete shell task.
 */
class QueueDeleteTask extends QueueTask {

    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 1;

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return bool Success
     */
    use MailerAwareTrait;
    public function run(array $data, $jobId) {        
        $matrix = new MatrixComponent(new ComponentRegistry());
        $push = new PushComponent(new ComponentRegistry());
        if(!empty($data['joined_spayc'])){
            /* For root spayc */
            foreach($data['joined_spayc'] as $joinedUser){
                $matrix->leaveRoom($data['matrix_room_id'],$joinedUser['user']['matrix_access_token']);
                $matrix->muteUnmute('mute',$joinedUser['user']['matrix_access_token'],$data['matrix_room_id']);
                $rPush = [
                    'slug' => 'spayc-deleted',
                    'requested_by' => $data['user_id'],
                    'requested_to' => $joinedUser['user_id'],
                    'spayc_id' => $data['id'],
                    'spayc_name' => $data['name'],
                    'spayc_image' => $data['image'],
                    'matrix_room_id' => $data['matrix_room_id'],
                    'display_name' => $joinedUser['user']['display_name']                
                ];
                if(isset($data['spayc-deleted-by-admin'])){                   
                    $rPush['slug'] = $data['spayc-deleted-by-admin'];
                    $this->getMailer('User')->send('warpDeleted', [$joinedUser['user']]);
                }                
                /* super admin will not recieve any notification */
                if(($data['user_id'] != $joinedUser['user_id']) || isset($data['spayc-deleted-by-admin'])){
                    // \Cake\Log\Log::info(json_encode($rPush,JSON_PRETTY_PRINT));
                    $push->sendPushNotification($rPush);
                }
                
            }
        }
        if(!empty($data['sub_spaycs'])){
            /* For sub spayc */
            foreach($data['sub_spaycs'] as $subspayc){
                if(!empty($subspayc['joined_spayc'])){
                    foreach($subspayc['joined_spayc'] as $joinspayc){
                        $matrix->leaveRoom($subspayc['matrix_room_id'],$joinspayc['user']['matrix_access_token']);
                        $matrix->muteUnmute('mute',$joinspayc['user']['matrix_access_token'],$subspayc['matrix_room_id']);
                        $sPush = [
                            'subpayc' => 'sub-spayc-deleted',
                            'slug' => 'spayc-deleted',
                            'requested_by' => $data['user_id'],
                            'requested_to' => $joinspayc['user_id'],
                            'spayc_id' => $subspayc['id'],
                            'spayc_name' => $subspayc['name'],
                            'spayc_image' => $subspayc['image'],
                            'matrix_room_id' => $subspayc['matrix_room_id'],
                            'display_name' => $joinspayc['user']['display_name']                
                        ];
                        if(isset($data['spayc-deleted-by-admin'])){
                            $rPush['slug'] = $data['spayc-deleted-by-admin'];
                            $this->getMailer('User')->send('warpDeleted', [$joinspayc['user']]);
                        }
                        /* super admin will not recieve any notification */
                        if(($data['user_id'] != $joinspayc['user_id']) || isset($data['spayc-deleted-by-admin'])){
                            // \Cake\Log\Log::info(json_encode($sPush,JSON_PRETTY_PRINT));
                            $push->sendPushNotification($sPush);
                        }
                    }
                }
            }
        }
        $this->hr();
        $this->out('Proccessing to leave the room');
        $this->hr();
        $this->out(' ->Success, All user have been leave the room');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
