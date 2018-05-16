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
    
    public function spaycActivities($spaycId,$data){
        $comment = $this->findBySpaycId($spaycId)->first();
        if(empty($comment)){
            $comment = $this->newEntity();
            $comment->status = ACTIVE;
            $comment->spayc_id = $spaycId;
            $comment->comment = 1;
            $comment->event_id = $data['event_id'];
        }else{
            if( ($comment->event_id == $data['event_id']) ){
                return;
            }
            $comment->comment = $comment->comment+1;
            $comment->event_id = $data['event_id'];
        }
        if(!$this->save($comment)){
            \Cake\Log\Log::info(['message'=>'Record not saved','data'=>$data]);
        }
        return;
    }

}
