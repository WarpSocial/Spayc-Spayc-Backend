<?php

namespace Api\Shell\Task;

use Cake\Console\Shell;
use Queue\Shell\Task\QueueTask;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;
/**
 * QueueNotification shell task.
 */
class QueueNotificationTask extends QueueTask {

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
    public function run(array $data, $jobId) {
        $push = new PushComponent(new ComponentRegistry());
        $push->sendOnIOS($data);
        $this->hr();
        $this->out('Proccessing to send the notification');
        $this->hr();
        $this->out('->Success, Notification has been sent successfully.');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
