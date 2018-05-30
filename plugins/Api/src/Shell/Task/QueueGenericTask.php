<?php

namespace Api\Shell\Task;

use Cake\Console\Shell;
use Queue\Shell\Task\QueueTask;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;
use Cake\Log\Log;

/**
 * QueuePusher shell command.
 */
class QueueGenericTask extends QueueTask {

    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 0;

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return bool Success
     */
    public function run(array $data, $jobId) {
        if(empty($data['job_type'])){
            return true;
        }
        switch ($data['job_type']){
            case "new-spayc":
                $this->newSpayc($data);
                break;
            case "communication_center":
                $this->communicationCenter($data);
                break;
        }
        $this->out('Proccessing to send pusher notification');
        $this->hr();
        $this->out('->Success, Puhser Notification has been sent successfully.');
        $this->out(' ');
        $this->out(' ');
        return true;
    }
    
    /**
     * communicationCenter to keep the like or reply comment notification
     * 
     * @param Array $data list of pushers data
     */
    public function communicationCenter($data){
        $notify = $notificationRepo->addNotification([
            'requested_by'=>$data['items']['requested_by'],
            'requested_to'=>$data['items']['requested_to'],
            'notification_type'=>$data['items']['type'],
            'status'=>'Unread',
            'message'=>$data['items']['message'],
            'spayc_id'=>$data['items']['spayc_id'],
            'date_time'=>$data['created_duration']
        ]);
    }
    
    /**
     * newSpayc method on create new spayc send the notification if spayc has been created withing 25 miles
     * @param Array $data list of new spayc entity including latitude and longitude
     * @return Bool true|false
     */
    public function newSpayc($data){
        $push = new PushComponent(new ComponentRegistry());
        $phylRepo = TableRegistry::get('Api.PhysicalLocation');
        $users = $phylRepo->userNearSpayc($data['latitude'],$data['longitude']);
        $notificationRepo = TableRegistry::get("Api.Notifications");
        $notifyMessage = $notificationRepo->message('new-spayc');
        if(empty($notifyMessage)){
            return true;
        }
        foreach($users as $user){
            $message = str_replace(["<X>","<SpaycName>"], [$user->distance,$data['name']], $notifyMessage->message);
            $notificationItems = [
                'requested_by'=>$data['user_id'],
                'requested_to'=>$user->user_id,
                'notification_type'=>$notifyMessage->type,
                'status'=>'Unread',
                'message'=>$message,
                'spayc_id'=>$data['id'],
                'date_time'=>$data['created_duration']
            ];
            $notify = $notificationRepo->addNotification($notificationItems);
            
            $items = [
                'requested_by'=>$data['user_id'],
                'id'=>$notify->id,
                'device_token'=>$user->_matchingData['UserLogs']->device_token,
                'message'=>$message,
                'matrix_room_id'=>$data['matrix_room_id'],
                'notification_type'=>$notifyMessage->type,
                'spayc_image'=>empty($data['image'])?null:$data['image'],
                'time'=>$data['created_duration']
            ];
            $push->sendOnIOS($items);
            
        }
    }
}
