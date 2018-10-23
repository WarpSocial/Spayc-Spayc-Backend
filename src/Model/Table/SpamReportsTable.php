<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * SpamReports Model
 *
 * @property \App\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \App\Model\Table\EventsTable|\Cake\ORM\Association\BelongsTo $Events
 *
 * @method \App\Model\Entity\SpamReport get($primaryKey, $options = [])
 * @method \App\Model\Entity\SpamReport newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SpamReport[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SpamReport|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SpamReport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SpamReport[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SpamReport findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpamReportsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('spam_reports');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Reportedby', [
            'foreignKey' => 'reported_by',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Reportedto', [
            'foreignKey' => 'reported_to',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'reported_by',
            'targetForeignKey' => 'reported_to',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('reported_by', 'create')
            ->notEmpty('reported_by');

        $validator
            ->requirePresence('reported_to', 'create')
            ->notEmpty('reported_to');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
//        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
//        $rules->add($rules->existsIn(['event_id'], 'Events'));
          return $rules;
    }
    
    public function getspamReportObj($keyword){
        $query = $this->find();
        $query->select(['SpamReports.event_id','SpamReports.spayc_id','SpamReports.reported_to','Spaycs.id','Spaycs.matrix_room_id','Spaycs.name','total_user_reported_by' => $query->func()->count('event_id')])
                ->contain(['Spaycs' => function($q)use($keyword) {
                        $qq= $q->select(['Spaycs.id','Spaycs.matrix_room_id','Spaycs.name']);
                        if(!empty($keyword))
                          $qq->where(['LOWER(Spaycs.name) LIKE' => "%" . $keyword . "%"]);

                        return $qq;
                         }
                    ])
                    ->group(['SpamReports.event_id,SpamReports.spayc_id,SpamReports.reported_to,Spaycs.id, Spaycs.name,Spaycs.matrix_room_id']);
       return $query;
    }
}
