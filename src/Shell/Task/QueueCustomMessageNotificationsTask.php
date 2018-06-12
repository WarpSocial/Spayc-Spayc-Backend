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
        
        
          foreach ($data['users'] as $val) {
                    $user = TableRegistry::get("Api.Users")->get($val);
                    $email['email'] = $user['email'];
                    $email['message'] = $data['message'];
                    $email['name'] = $user['display_name'];
                    $this->getMailer('User')->send('customMessages', [$email]);
                            $push['requested_by'] = $data['id'];
                            $push['username'] = $data['display_name'];
                            $push['requested_to'] = $user['id'];
                            $push['slug'] = CUSTOM_MESSAGES_SLUG;
                            $pushNotification->sendPushNotification($push);
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
