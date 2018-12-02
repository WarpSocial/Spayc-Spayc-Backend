<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * ReportedWarps Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \Api\Model\Table\MatrixRoomsTable|\Cake\ORM\Association\BelongsTo $MatrixRooms
 *
 * @method \Api\Model\Entity\ReportedWarp get($primaryKey, $options = [])
 * @method \Api\Model\Entity\ReportedWarp newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\ReportedWarp[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\ReportedWarp|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\ReportedWarp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\ReportedWarp[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\ReportedWarp findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'Api.Spaycs'
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

        return $validator->errors($data);
    }
    
}
