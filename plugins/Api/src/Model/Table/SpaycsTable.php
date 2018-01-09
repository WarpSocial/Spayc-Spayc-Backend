<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Spaycs Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\Spayc get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Spayc newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Spayc[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Spayc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Spayc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('spaycs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('name','create', __('Name key is missing.'))
                ->maxLength('name', 255,'Name text is too long.')
                ->notEmpty('name',__('Spayc name is required.'));
                

        $validator
                ->maxLength('location', 255,'Location test is too long.')
                ->requirePresence('location', 'create',__('Location key is missing.'))
                ->notEmpty('location',__('Location is required field.'))
                ->regex('location','/[\w\s]/',__('Location must be alpha numeric only.'));

        $validator
                ->requirePresence('type', 'create',__('Type key is missing.'))
                ->notEmpty('type',__('Type is required field.'))
                ->inList('type', Configure::read('spayctype'),__('Type value must be any one '.implode(',',Configure::read('spayctype')).'.')); 

        $validator
                ->requirePresence('group_type', 'create',__('Group key is missing.'))
                ->notEmpty('group_type',__('Group is required field.'))
                ->inList('group_type', Configure::read('grouptype'),__('Group value must be any one '.implode(',',Configure::read('grouptype')).'.')); 

        $validator                
                ->requirePresence('start_date', 'create',__('Start Date key is missing.'))
                ->dateTime('start_date','ymd',__('Start date is not in format YYYY-MM-DD H:i:s'))
                ->notEmpty('start_date',__('Start date is required.'),function($context){
                     return ($context['data']['type'] =='Event');
                });
        $validator                
                ->requirePresence('end_date', 'create',__('End Date key is missing.'))
                ->dateTime('end_date','ymd',__('End date is not in format YYYY-MM-DD H:i:s'))
                ->notEmpty('end_date',__('End date is required.'),function($context){
                     return ($context['data']['type'] =='Event');
                });

        $validator
                ->maxLength('passcode', 30)
                ->requirePresence('passcode', 'create')
                ->notEmpty('passcode');

        $validator
                ->scalar('description')
                ->maxLength('description', 250)
                ->allowEmpty('description');

        $validator
                ->scalar('status')
                ->allowEmpty('status');

        return $validator;
    }

}
