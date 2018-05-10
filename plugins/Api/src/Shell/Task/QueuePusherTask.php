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
class QueuePusherTask extends QueueTask {

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
        $msgType = $data['notification']['content']['msgtype'];
        if($msgType == 'm.likeMessage'){
           
        }elseif($msgType == 'm.replyText'){
           
        }
        TableRegistry::get('Api.Comments')->spaycActivities($data['items']['spayc_id'],$data['items']);
        $this->hr();
        $this->out('Proccessing to send pusher notification');
        $this->hr();
        $this->out('->Success, Puhser Notification has been sent successfully.');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
