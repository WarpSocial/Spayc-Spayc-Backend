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
        if(strtolower($data['action_type']) == $this->signupType){
            $this->getMailer('Api.User')->send($this->signupType, [$data]);
        }
        $this->hr();
        $this->out('Proccessing to send mail.');
        return true;
    }
}
