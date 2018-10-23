<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
/**
 * PhysicalLocation Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\PhysicalLocation get($primaryKey, $options = [])
 * @method \Api\Model\Entity\PhysicalLocation newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\PhysicalLocation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\PhysicalLocation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PhysicalLocationTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('physical_location');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
    }
    
    public function updateLocation($user,$lat,$long){
        $distance = "ROUND( CAST({$this->Users->Spaycs->distanceInMiles} AS numeric), 3)";       
        $jsModel = TableRegistry::get('Api.JoinedSpayc');
        $jsquery = $jsModel->find()
                ->select(['JoinedSpayc.id','JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.distance'])
                ->contain(['Spaycs'=>function($q)use($distance){
                    $miles= Configure::read('miles');
                    return $q->select(['distance'=>$distance]);
                            
                }])
                ->bind(':lat', $lat, 'float')
                ->bind(':long', $long, 'float')
                ->where(['JoinedSpayc.user_id'=>$user['id']]);
                //pj($query->toArray());die;
        if(!$jsquery->isEmpty()){
            $result = $jsquery->toArray();
             foreach($result as $row){
                 $jsModel->query()
                          ->update()
                          ->set(['distance' => $row->distance])
                          ->where(['user_id' => $row->user_id,'spayc_id'=>$row->spayc_id])
                          ->execute();
             }
         }
         $ple = $this->findByUserId($user['id']);
         if($ple->isEmpty()){
             $pl = $this->newEntity();
             $pl->set('user_id',$user['id']);
         }else{
             $pl = $ple->first();             
         }
         $pl->set('current_latitude',$lat);
         $pl->set('current_longitude',$long);
         $pl->set('timezone',Configure::read('timezone'));
        if($this->save($pl,['validate'=>false,'checkRules'=>false,'atomic'=>false])){
            return true;
        }else{
            return false;
        }
    }
    
    public function physicalLocation($userId=null){
        $user = $this->findByUserId($userId);
        if($user->isEmpty()){
           return false; 
        }else{
            return $user->first()->timezone;
        }
    }
    
    public function userNearSpayc($latitude,$longitude){
        //$distance = "ROUND( CAST({$this->Users->Spaycs->distanceInMiles} AS numeric), 3)";    
        $equation = TableRegistry::get('Api.Spaycs')->distanceInMiles;
        $dckey = [':lat',':long','Spaycs.latitude','Spaycs.longitude'];
        $rckey = [$latitude,$longitude,'PhysicalLocation.current_latitude','PhysicalLocation.current_longitude'];
        $distance = "ROUND(CAST(".str_replace($dckey,$rckey,$equation)." AS numeric), 5)";
        $milesDistance = Configure::read('newSpaycDistance');
        $query = $this->find()
                ->select(['PhysicalLocation.id','PhysicalLocation.user_id','Users.id','distance'=>$distance])
                ->innerJoinWith('Users.UserLogs',function($q){
                    return $q->select(['UserLogs.id','UserLogs.user_id','UserLogs.device_token']);
                })
                ->where([$distance.' <='=>$milesDistance]);
       # pj($query);die;
        return $query;
    }

}
