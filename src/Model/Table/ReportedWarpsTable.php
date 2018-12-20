<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReportedWarps Model
 *
 * @property \App\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \App\Model\Table\MatrixRoomsTable|\Cake\ORM\Association\BelongsTo $MatrixRooms
 *
 * @method \App\Model\Entity\ReportedWarp get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReportedWarp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReportedWarp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReportedWarp|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReportedWarp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReportedWarp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReportedWarp findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReportedWarpsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('reported_warps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Spaycs'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'reported_by',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
    }
    
    public function getWarps(){
        $query = TableRegistry::get('Spaycs')->find();
        $query->matching('ReportedWarps',function($q){
                    return $q;
                });
        return $query;        
    }
    
    public function reportedWarpUsers($spaycId){ 
        $query = TableRegistry::get('Users')->find();
        $query->innerJoinWith('JoinedSpayc',function($q) {
            $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);     
            $q->innerJoinWith('Spaycs',function($qq) {
                $qq->select(['Spaycs.user_id','Spaycs.id','Spaycs.parent_id'])->where(['Spaycs.group_type !=' =>'trusted_private','Spaycs.parent_id IS'=>null]); 
                return $qq;                        
            });      
            return $q;
        });
        $query->where(['JoinedSpayc.spayc_id'=> $spaycId]);
        $query->contain([                                       
            'JoinedSpayc'=>function($q) {
                $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);                  
                $q->innerJoinWith('Spaycs',function($qq) {
                    $qq->select(['Spaycs.user_id','Spaycs.id','Spaycs.parent_id'])->where(['Spaycs.group_type !=' =>'trusted_private','Spaycs.parent_id IS'=>null]); 
                    return $qq;                        
                });
                return $q;
            },
            'Requestedby' => function($q) {
               return $q->select(['Requestedby.requested_by','count' => $q->func()->count('Requestedby.id')])->group(['Requestedby.requested_by'])->Where(['Requestedby.requested_status'=>FRIEND_REQUESTED_STATUS]);
            },
            'Requestedto' => function($q) {
               return $q->select(['Requestedto.requested_to','count' => $q->func()->count('Requestedto.id')])->group(['Requestedto.requested_to'])->Where(['Requestedto.requested_status'=>FRIEND_REQUESTED_STATUS]);
            }              
        ]); 
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {                
                $present = 0;$totalJoined=[];
                 if(isset($row['joined_spayc']) && !empty($row['joined_spayc'])) {
                $joinedSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined]');
                $createdSpayc = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[is_admin=2,status=Joined]');
                $row->joinedSpayc=count($joinedSpayc);
                $row->createdSpayc=count($createdSpayc);
                unset($row['joined_spayc']);
                }              
                $row->friend = !empty($row['requestedto'][0]['count'])? $row['requestedto'][0]['count'] : BLANK_COUNT;
                $row->friend += !empty($row['requestedby'][0]['count'])? $row['requestedby'][0]['count'] : BLANK_COUNT;
                unset($row['requestedby']);
                unset($row['requestedto']);
                return $row;
            });
        });
        return $query;
    }

}
