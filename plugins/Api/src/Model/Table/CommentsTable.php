<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comments Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\Comment get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Comment newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Comment[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Comment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Comment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Comment[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Comment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommentsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.Spaycs'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Api.Users'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    
    public function matrixComment($matrixRoomId){
        $conn = \Cake\Datasource\ConnectionManager::get('matrix');
        $sql = sprintf("SELECT count(room_id) AS all_comments FROM events WHERE (content LIKE '%%m.text%%' OR content LIKE '%%m.image%%') AND type='m.room.message' AND room_id='%s' GROUP BY room_id",$matrixRoomId);
        $results = $conn->execute($sql)->fetch('assoc');
        return empty($results['all_comments'])?0:$results['all_comments'];
    }
    
    public function spaycActivities($matrixRoomId,$data){        
        if(empty($data['spayc_id']) || empty($matrixRoomId)){
            return;
        }
        $comments = $this->findBySpaycId($data['spayc_id']);
        if($comments->isEmpty()){
            $comment = $this->newEntity();
            $comment->status = ACTIVE;
            $comment->spayc_id = $data['spayc_id'];
            $comment->comment = $this->matrixComment($matrixRoomId);
            $comment->event_id = \Api\Utils\Utils::getVar('event_id', $data);
        }else{
            $comment = $comments->first();
            $comment->comment = $this->matrixComment($matrixRoomId);
            $comment->event_id = \Api\Utils\Utils::getVar('event_id', $data);
        }
        $this->save($comment);
        return;
    }

}
