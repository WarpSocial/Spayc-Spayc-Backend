<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use Queue\Shell\Task\QueueTask;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\MailerAwareTrait;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;
/**
 * QueueNotification shell task.
 */
class QueueCustomMessageNotificationsTask extends QueueTask {

    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 1;

    use MailerAwareTrait;
    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return bool Success
     */
    public function run(array $data, $jobId) {
        $pushNotification = new PushComponent(new ComponentRegistry());
        
        if(!empty($data['users'])){
        $obj = TableRegistry::get("Api.Users")->find('all',
                ['fields' =>['email','display_name','id']])
                ->where(['id IN ' => $data['users']])->toArray();
        
            foreach ($obj as $val) {
                $email['email'] = $val['email'];
                $email['message'] = $data['message'];
                $email['name'] = $val['display_name'];
                $this->getMailer('User')->send('customMessages', [$email]);                
               
                $pushNotification->sendPushNotification([
                    'slug' => CUSTOM_MESSAGES_SLUG,
                    'message' => $data['message'],
                    'requested_by' => $data['id'],
                    'requested_to' =>$val['id'],
                    'spayc_id' => '',
                    'spayc_name' => '',
                    'spayc_image' => '',
                    'matrix_room_id' => '',
                    'display_name' => ADMIN_DISPLAY_NAME  
                ]);
            }
        }
        
        $this->hr();
        $this->out('Proccessing to send the notification');
        $this->hr();
        $this->out('->Success, Notification has been sent successfully.');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
