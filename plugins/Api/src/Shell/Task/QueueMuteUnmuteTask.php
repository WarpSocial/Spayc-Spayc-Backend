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
        if (!empty($data['join'])) {
            $matrix->joinRoom(['status' => $data['status'], 'matrix_token' => $data['matrix_token'], 'matrix_room_id' => $data['matrix_room_id']]);
        }
        /* when user subscribe spayc it will automatic subscribed with subspayc */
        if (!empty($data['action_type']) && $data['action_type'] == 'subspayc') {
            if(strtolower($data['rule']) == 'mute'){
                $this->muteSubspayc($data,$matrix);
            }else{
                $this->unMuteSubspayc($data,$matrix);
            }
        } else {
            $matrix->muteUnmute($data['rule'], $data['matrix_token'], $data['matrix_room_id']);
        }

        $this->hr();
        $this->out('Proccessing to Mute|Unmute the room');
        $this->hr();
        $this->out(' ->Success, Mute|Unmute proccess completed');
        $this->out(' ');
        $this->out(' ');
        return true;
    }

    /**
     * mute user from subspayc on matrix and local system when user unsubscribe spayc
     * @param Array $data user_id, spayc_id matix_token and matrix_user_id and matrix_room_id
     * @param Object $matrix matrix component object
     * @return Bool true|false
     */
    public function muteSubspayc($data,$matrix) {
        $subspayc = TableRegistry::get('Api.Spaycs')->find()->where(['parent_id' => $data['spayc_id']])->toArray();
        $scModel = TableRegistry::get('Api.SubscribedUsers');
        if(empty($subspayc)){
            return true;
        }
        foreach ($subspayc as $subItems) {
            $entities = $scModel->find('all', ['field' => ['id', 'user_id', 'spayc_id', 'status']])->where(['spayc_id' => $subItems->id, 'user_id' => $data['user_id']]);
            $entity = $entities->first();
            if(empty($entity)){
                continue;
            }
            if($scModel->delete($entity)){
                if (!(TableRegistry::get('Api.JoinedSpayc')->exists(['user_id' => $data['user_id'], 'spayc_id' => $subItems->id]))) {                    
                $matrix->leaveRoom($subItems->matrix_room_id, $data['matrix_token']);
                $matrix->deleteTag($subItems->matrix_room_id, $data['matrix_token'], $data['matrix_user_id']);                   
                }
            }
            $matrix->muteUnmute($data['rule'], $data['matrix_token'], $subItems->matrix_room_id);
        }
    }

    /**
     * unMute user from subspayc on matrix and local system when user subscribe spayc
     * @param Array $data user_id, spayc_id matix_token and matrix_user_id and matrix_room_id
     * @param Object $matrix matrix component object
     * @return Bool true|false
     */
    public function unMuteSubspayc($data,$matrix) {
        $subspayc = TableRegistry::get('Api.Spaycs')->find()->where(['parent_id' => $data['spayc_id']])->toArray();
        if(empty($subspayc)){
            return true;
        }
        $scModel = TableRegistry::get('Api.SubscribedUsers');        
        foreach ($subspayc as $subItems) {
            $entities = $scModel->find('all', ['field' => ['id', 'user_id', 'spayc_id', 'status']])->where(['spayc_id' => $subItems->id, 'user_id' => $data['user_id']]);
            if ($entities->isEmpty()) {
                $entity = $scModel->newEntity();
            } else {
                $entity = $entities->first();
                if ($entity->status == 'Active') {
                    /* user has been already subscribed */
                    continue;
                }
            }
            $entity->user_id = $data['user_id'];
            $entity->status = 'Active';
            $entity->spayc_id = $subItems->id;
            $entity->modified = $data['datetime'];
            $entity->created = $data['datetime'];
            if ($scModel->save($entity, ['checkRules' => false, 'atomic' => false])) {
                if (!(TableRegistry::get('Api.JoinedSpayc')->exists(['user_id' => $data['user_id'], 'spayc_id' => $subItems->id]))) {                    
                    $matrix->joinRoom([
                        'status' => 'Joined',
                        'matrix_token' => $data['matrix_token'],
                        'matrix_room_id' => $subItems->matrix_room_id
                    ]);
                    $matrix->tagRoom($subItems->matrix_room_id, $data['matrix_token'], $data['matrix_user_id']);                    
                }
            }
            $matrix->muteUnmute($data['rule'], $data['matrix_token'], $subItems->matrix_room_id);
        }
    }

}
