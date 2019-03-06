<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TicketmasterEvents Model
 *
 * @property \App\Model\Table\TicketmasterEventsTable|\Cake\ORM\Association\BelongsTo $TicketmasterEvents
 *
 * @method \App\Model\Entity\TicketmasterEvent get($primaryKey, $options = [])
 * @method \App\Model\Entity\TicketmasterEvent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TicketmasterEvent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TicketmasterEvent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TicketmasterEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TicketmasterEvent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TicketmasterEvent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketmasterEventsTable extends Table
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

        $this->setTable('ticketmaster_events');
        $this->setDisplayField('name');
        $this->setPrimaryKey(['id']);
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
        //$rules->add($rules->existsIn(['ticketmaster_event_id'], 'TicketmasterEvents'));
        return $rules;
    }

    public function saveNupdateData($events, $eventIds) {
        /* delete previous record from ticketmaster table */
        $this->deleteAll([['end_date <'=> date('Y-m-d 23:59:59', strtotime(' -1 day'))]]);
        $getIds = $this->find()->select(['ticketmaster_event_id'])->
            where(['ticketmaster_event_id IN' => $eventIds])->extract('ticketmaster_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);       
        if(count($diffIds)){
            $getuniqueevents =[];           
            foreach ($events as $val) {
                if (in_array($val['ticketmaster_event_id'],$diffIds)){
                    $Entity = $this->newEntity($events[$val['ticketmaster_event_id']]);
                    $result = $this->save($Entity);
                } else if(in_array($val['ticketmaster_event_id'],$getIds)) {
                    $query = $this->query();
                    $events[$val['ticketmaster_event_id']]['modified'] = date('Y-m-d H:i:s');
                    $query->update()
                    ->set($events[$val['ticketmaster_event_id']])
                    ->where(['ticketmaster_event_id' => $val['ticketmaster_event_id']])
                    ->execute();
                } else {
                    continue;
                }
            }
        }  else {
            foreach ($getIds as $id) {
                $query = $this->query();
                $events[$id]['modified'] = date('Y-m-d H:i:s');
                $query->update()
                ->set($events[$id])
                ->where(['ticketmaster_event_id' => $id])
                ->execute();
            } 
        } 
    }
}
