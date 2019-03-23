<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserFeedbacks Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UserFeedback get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserFeedback newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserFeedback[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserFeedback|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserFeedback patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserFeedback[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserFeedback findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserFeedbacksTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('user_feedbacks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('ImgUpload', [
            'field' => 'attachment',
            'uploadPath' => 'feedback/',
            'where' => 's3', /* local and s3 */
        ]);
        $this->belongsTo('ParentUserFeedbacks', [
            'className' => 'UserFeedbacks',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('FeedbackReply', [
            'foreignKey' => 'parent_id',
            'joinType' => 'Left',
            'className' => 'UserFeedbacks',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('message', 'create', __('Message key is missing.'))
                ->maxLength('message', 1000, 'Message must not be greater than 500 characters.')
                ->notEmpty('name', __('Message is required.'));
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

}
