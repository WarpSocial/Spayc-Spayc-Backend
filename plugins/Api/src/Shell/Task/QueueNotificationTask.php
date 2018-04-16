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
class QueueNotificationTask extends Shell {

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
        $matrix = new MatrixComponent(new ComponentRegistry());
        $push = new PushComponent(new ComponentRegistry());

        $this->hr();
        $this->out('Proccessing to leave the room');
        $this->hr();
        $this->out(' ->Success, All user have been leave the room');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
