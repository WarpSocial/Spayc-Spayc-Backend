<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\PushComponent;
use Api\Controller\Component\MatrixComponent;

/**
 * Spaycs Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\MatrixRoomsTable|\Cake\ORM\Association\BelongsTo $MatrixRooms
 * @property \App\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $ParentSpaycs
 *
 * @method \App\Model\Entity\Spayc get($primaryKey, $options = [])
 * @method \App\Model\Entity\Spayc newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Spayc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Spayc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Spayc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Spayc[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Spayc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycsTable extends Table
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

        $this->setTable('spaycs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('ImgUpload', [
            'field' => 'image',
            'uploadPath' => 'room/',
            'where' => 's3', /* local and s3 */
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        
        $this->belongsTo('ParentSpaycs', [
            'className' => 'Spaycs',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('SubSpaycs', [
            'className' => 'Spaycs',
            'foreignKey' => 'parent_id'
            
        ]);
        $this->hasMany('JoinedSpayc', [
            'foreignKey' => 'spayc_id',
            'className' => 'JoinedSpayc'
        ]);
        $this->hasMany('SubscribedUsers', [
            'foreignKey' => 'spayc_id',
            'className' => 'SubscribedUsers'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'spayc_id',
            'className' => 'Comments'
        ]);
        $this->hasMany('SpaycHashtags', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'SpaycHashtags'
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
                ->maxLength('location', 255,__('Location test is too long.'))
                ->requirePresence('location', 'create',__('Location key is missing.'))
                ->notEmpty('location',__('Location is required field.'))
                ->regex('location','/[\w\s]+$/',__('Location must be alpha numeric only.'));

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
                ->notEmpty('start_date',__('Start date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
                ->dateTime('start_date','mdy',__('Start date is not in format MM-DD-YYYY H:i:s'))
                        
                ->add('start_date','daterange',[
                    'rule'=> function($value,$context){
                        if(!empty($value)){
                            /* Doesn't exceed 1 year ahead */
                            $timezone = Configure::read('timezone');
                            $startDate = Time::createFromFormat('m-d-Y H:i:s',$value,$timezone);
                            $currentDate = new Time('now',$timezone);
                            $now = clone $currentDate;
                            $currentDate->modify('+1 year')->modify('+1 minute');
                            return (bool) ($startDate >= $now && $startDate <= $currentDate);
                        }
                    },
                    'message'=>__('Start date can\'t be more than 1 year ahead or any past date.')
                ]);
        $validator                
                ->requirePresence('end_date', 'create',__('End Date key is missing.'))                
                ->notEmpty('end_date',__('End date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
                ->dateTime('end_date','mdy',__('End date is not in format MM-DD-YYYY H:i:s'))
                ->add('end_date','daterange',[
                    'rule'=> function($value,$context){
                     $timezone = Configure::read('timezone');
                        if(!empty($value) && !empty($context['data']['end_date']) && !empty($context['data']['start_date'])){
                            /* End date must be below of start date */
                            $startDate = Time::createFromFormat('m-d-Y H:i:s',$context['data']['start_date'],$timezone);
                            $endDate = Time::createFromFormat('m-d-Y H:i:s',$value,$timezone);
                            if($endDate->format('H') == '00'){
                                $endDate->setTime(23,55);
                            }
                            return (bool)($startDate <= $endDate );
                        }
                        return true;
                    },
                    'message'=>__('End date must be ahead from start date.')
                ]);

        $validator
                //->requirePresence('passcode', 'create',__('Passcode key is missing.'))
                ->maxLength('passcode', 30,__('Max 30 character is allowed for passcode.'))
                //->add('passcode', 'unique', ['rule' => 'validateUnique','message'=>'Username must be unique.', 'provider' => 'table'])
                ->notEmpty('passcode',__('Passcode is required in case of private group type.'),function($context){                    
                     return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                });

        $validator
                ->requirePresence('description', 'create',__('Description key is missing.'))
                ->maxLength('description', 250,__('Description must be less than 250 characters.'))
                ->allowEmpty('description');
        
        $validator
                ->allowEmpty('image')
                ->add('image','extension',[
                    'rule' => ['extension', ['jpeg', 'png','jpg']],
                    'message'=>__('Please select only jpg,jpeg,png.')
                ])
                ->add('image','size',[
                    'rule' => ['fileSize', '<=',\Cake\Core\Configure::read('maxupload')],
                    'message'=>__('Image size must be less than '.\Cake\Core\Configure::read('maxupload').'.')
                ]);
        $validator
                ->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                ->notEmpty('longitude',__('Please enter longitude.'))
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                ->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                ->notEmpty('latitude',__('Please enter latitude.'))
                ->latitude('latitude',__('Please enter valid latitude.'));  
        
        return $validator;
    }

    

    // /**
    //  * Returns a rules checker object that will be used for validating
    //  * application integrity.
    //  *
    //  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
    //  * @return \Cake\ORM\RulesChecker
    //  */
    // public function buildRules(RulesChecker $rules)
    // {
    //     $rules->add($rules->existsIn(['user_id'], 'Users'));
    //     $rules->add($rules->existsIn(['matrix_room_id'], 'MatrixRooms'));
    //     $rules->add($rules->existsIn(['parent_id'], 'ParentSpaycs'));

    //     return $rules;
    // }
}
