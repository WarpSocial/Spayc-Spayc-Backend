<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EventbriteEvents Model
 *
 * @property \App\Model\Table\EventbriteEventsTable|\Cake\ORM\Association\BelongsTo $EventbriteEvents
 *
 * @method \App\Model\Entity\EventbriteEvent get($primaryKey, $options = [])
 * @method \App\Model\Entity\EventbriteEvent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EventbriteEvent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EventbriteEvent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EventbriteEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EventbriteEvent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EventbriteEvent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventbriteEventsTable extends Table
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

        $this->setTable('eventbrite_events');
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
    
     /*** common query for union all scraper table ***/
    public function unionCommonQuery(){
        return "select eventbrite_event_id  as event_id,'eventbrite' as type,name,start_date,latitude,longitude,group_id,location,category from eventbrite_events where latitude IS NOT NULL and longitude IS NOT NULL and spayc_id IS NULL         
        UNION 
        select ticketmaster_event_id as event_id,'ticketmaster' as type,name,start_date,latitude,longitude,group_id,location,category from ticketmaster_events where latitude IS NOT NULL and longitude IS NOT NULL and spayc_id IS NULL ";
        /*for stubhub
         * UNION 
        select stubhub_event_id as event_id,'stubhub' as type,name,start_date,latitude,longitude,group_id,location,category from stubhub_events where latitude IS NOT NULL and longitude IS NOT NULL and spayc_id IS NULL 
         */
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
        //$rules->add($rules->existsIn(['eventbrite_event_id'], 'EventbriteEvents'));
        return $rules;
    }

    public function saveNupdateData($events, $eventIds,$page=null) {
        /* delete previous record from eventbrite table */
        $this->deleteAll([['end_date <'=> date('Y-m-d 23:59:59', strtotime(' -1 day'))]]);
        /* pre-existing events in tmp table */
        $getIds = $this->find()->select(['eventbrite_event_id'])->
            where(['eventbrite_event_id IN' => $eventIds])->extract('eventbrite_event_id')->toList();
        /* get which not existing in temp table - new events received */
        $diffIds=array_diff($eventIds,$getIds);
        //echo "@@$page<=>".count($eventIds)."@@";
        if(!empty($diffIds)){
            $getuniqueevents =[];           
            foreach ($events as $val) {
                if (in_array($val['eventbrite_event_id'],$diffIds)){
                    $Entity = $this->newEntity($events[$val['eventbrite_event_id']]);
                    $result = $this->save($Entity);
                    //echo '**'.$val['eventbrite_event_id'].'**';
                } else if(in_array($val['eventbrite_event_id'],$getIds)) {
                    $query = $this->query();
                    $events[$val['eventbrite_event_id']]['modified'] = date('Y-m-d H:i:s');
                    $query->update()
                    ->set($events[$val['eventbrite_event_id']])
                    ->where(['eventbrite_event_id' => $val['eventbrite_event_id']])
                    ->execute();
                    //echo '++'.$val['eventbrite_event_id'].'++';
                }else{
                   // echo '!!!'.$val['eventbrite_event_id'].'!!!';
                    continue;
                }
            }
        }  else {
            foreach ($getIds as $id) {
                $query = $this->query();
                $events[$id]['modified'] = date('Y-m-d H:i:s');
                $query->update()
                ->set($events[$id])
                ->where(['eventbrite_event_id' => $id])
                ->execute();
                //echo '=='.$val['eventbrite_event_id'].'==';
            } 
        } 
    }
    
    public function saveNupdateData_new($events, $eventIds,$page=null) {
        /* delete previous record from eventbrite table */
        $this->deleteAll([['end_date <'=> date('Y-m-d 23:59:59', strtotime(' -1 day'))]]);
        /* pre-existing events in tmp table */
        $getIds = $this->find()->select(['eventbrite_event_id'])->where(['eventbrite_event_id IN' => $eventIds])->extract('eventbrite_event_id')->toList();
        /* newly created event id on scrapper */
        $diffIds=array_diff($eventIds,$getIds); 
        $connection = \Cake\Datasource\ConnectionManager::get('default');
        if(!empty($events)){
            /*update existing events */
            if(!empty($getIds)){
            foreach($getIds as $uEbId){
                $events[$uEbId]['modified'] = date('Y-m-d H:i:s');
                $connection->update($this->getTable(), $events[$uEbId], ['eventbrite_event_id' => $uEbId]);
                
            }
            }
            $newObj = [];
            /* create new events */
            if(!empty($diffIds)){
                foreach($diffIds as $nEbId){
                    if(!empty($events[$nEbId])){
                        $events[$nEbId]['created'] = date('Y-m-d H:i:s');
                        $events[$nEbId]['modified'] = date('Y-m-d H:i:s');                
                        $connection->insert($this->getTable(), $events[$nEbId]);
                        //$newObj[] = $events[$uEbId];
                    }
                } 
            }
            //$connection->insert($this->getTable(), $events[$nEbId]);
        }
    }
}
