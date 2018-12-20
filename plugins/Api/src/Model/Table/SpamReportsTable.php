<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * SpamReports Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \Api\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \Api\Model\Entity\SpamReport get($primaryKey, $options = [])
 * @method \Api\Model\Entity\SpamReport newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\SpamReport[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\SpamReport|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\SpamReport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\SpamReport[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\SpamReport findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpamReportsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('spam_reports');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.Spaycs'
        ]);
        
        $this->belongsTo('Reportedby', [
            'foreignKey' => 'reported_by',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        $this->belongsTo('Reportedto', [
            'foreignKey' => 'reported_to',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'reported_by',
            'targetForeignKey' => 'reported_to',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
       
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validateInput($data) {
        $validator = new Validator();
        $validator
                ->requirePresence('matrix_room_id', 'create',__('Matrix room id key is missing.'))
                ->notEmpty('matrix_room_id',__('Matrix room id is required field.'))
                ->add('matrix_room_id','isexist' ,[
                        'rule'=> function($value,$context){
                            return TableRegistry::get('Api.Spaycs')->exists(['matrix_room_id'=>$value]);
                        },
                        'message'=>__('Matrix room id is not valid.')
                ]);
        $validator
                ->requirePresence('reported_to', 'create',__('Reported to key is missing.'))
                ->notEmpty('reported_to',__('Reported to is required field.'))
                ->add('reported_to','isexist' ,[
                        'rule'=> function($value,$context){
                            return TableRegistry::get('Api.Users')->exists(['matrix_user_id'=>$value]);
                        },
                        'message'=>__('Reported to id is not valid.')
                ]);
        $validator
                ->requirePresence('event_id', 'create',__('Event key is missing.'))
                ->notEmpty('event_id',__('Event is required field.'));
                
        return $validator->errors($data);
    }

   

}
