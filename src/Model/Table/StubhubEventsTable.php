<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StubhubEvents Model
 *
 * @property \App\Model\Table\StubhubEventsTable|\Cake\ORM\Association\BelongsTo $StubhubEvents
 *
 * @method \App\Model\Entity\StubhubEvent get($primaryKey, $options = [])
 * @method \App\Model\Entity\StubhubEvent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StubhubEvent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StubhubEvent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StubhubEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StubhubEvent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StubhubEvent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StubhubEventsTable extends Table
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

        $this->setTable('stubhub_events');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmpty('location');

        $validator
            ->numeric('latitude')
            ->allowEmpty('latitude');

        $validator
            ->numeric('longitude')
            ->allowEmpty('longitude');

        $validator
            ->dateTime('start_date')
            ->allowEmpty('start_date');

        $validator
            ->dateTime('end_date')
            ->allowEmpty('end_date');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmpty('image');

        $validator
            ->scalar('category')
            ->maxLength('category', 255)
            ->allowEmpty('category');

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
        // $rules->add($rules->existsIn(['stubhub_event_id'], 'StubhubEvents'));
         return $rules;
    }

    public function saveNupdateData($events, $eventIds) {
        $getIds = $this->find()->select(['stubhub_event_id'])->
            where(['stubhub_event_id IN' => $eventIds])->extract('stubhub_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);       
        if(count($diffIds)){
            $getuniqueevents =[];           
            foreach ($events as $val) {
                if (in_array($val['stubhub_event_id'],$diffIds)){
                    $Entity = $this->newEntity($events[$val['stubhub_event_id']]);
                    $result = $this->save($Entity);
                } else if(in_array($val['stubhub_event_id'],$getIds)) {
                    $query = $this->query();
                    $query->update()
                    ->set($events[$val['stubhub_event_id']])
                    ->where(['stubhub_event_id' => $val['stubhub_event_id']])
                    ->execute();
                } else {
                    continue;
                }
            }
        }  else {
            foreach ($getIds as $id) {
                $query = $this->query();
                $query->update()
                ->set($events[$id])
                ->where(['stubhub_event_id' => $id])
                ->execute();
            } 
        } 
    }

}
