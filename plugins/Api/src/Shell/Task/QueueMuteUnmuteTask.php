<?php

namespace Api\Shell\Task;

use Cake\Console\Shell;
use Queue\Shell\Task\QueueTask;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;
/**
 * QueueMuteUnmute shell task.
 */
class QueueMuteUnmuteTask extends QueueTask {

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
         //\Cake\Log\Log::info(json_encode($data,JSON_PRETTY_PRINT));
        if($data['join']){
           $matrix->joinRoom(['status'=>$data['status'],'matrix_token'=>$data['matrix_token'],'matrix_room_id'=>$data['matrix_room_id']]);
        }
        $matrix->muteUnmute($data['rule'],$data['matrix_token'],$data['matrix_room_id']);
        $this->hr();
        $this->out('Proccessing to Mute|Unmute the room');
        $this->hr();
        $this->out(' ->Success, Mute|Unmute proccess completed');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

}
