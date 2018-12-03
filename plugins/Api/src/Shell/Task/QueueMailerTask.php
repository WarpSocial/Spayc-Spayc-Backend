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
class QueueMailerTask extends QueueTask {
    
    public $signupType = 'signup';

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
        if(empty($data['action_type'])){
            return true;
        }
        switch (strtolower($data['action_type'])){
            case 'signup':
                $this->getMailer('Api.User')->send($data['action_type'], [$data]);
                break;
            case 'userfeedback':
                $this->getMailer('Api.User')->send($data['action_type'], [$data]);
                break;
        }
        
        $this->hr();
        $this->out('Proccessing to send mail.');
        return true;
    }
}
