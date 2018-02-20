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
        $this->addBehavior('ImgUpload', [
            'field' => 'image',
            'uploadPath' => 'room/',
            'where' => 's3', /* local and s3 */
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        
        $this->hasMany('JoinedSpayc', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.JoinedSpayc'
        ]);
        $this->hasMany('SubscribedUsers', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.SubscribedUsers'
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'spayc_id',
            'className' => 'Api.Comments'
        ]);
        $this->hasMany('SpaycHashtags', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.SpaycHashtags'
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
                ->dateTime('start_date','mdy',__('Start date is not in format MM-DD-YYYY H:i:s'))
                ->notEmpty('start_date',__('Start date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
                ->add('start_date','daterange',[
                    'rule'=> function($value,$context){
                        if(!empty($value)){
                            /* Doesn't exceed 1 year ahead */
                            $startDate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$value);
                            return (bool)$startDate->isWithinNext('1 year');
                        }
                    },
                    'message'=>__('Start date can\'t be more than 1 year ahead or any past date.')
                ]);
        $validator                
                ->requirePresence('end_date', 'create',__('End Date key is missing.'))
                ->dateTime('end_date','mdy',__('End date is not in format MM-DD-YYYY H:i:s'))
                ->notEmpty('end_date',__('End date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
                ->add('end_date','daterange',[
                    'rule'=> function($value,$context){
                        if(!empty($value) && !empty($context['data']['end_date']) && !empty($context['data']['start_date'])){
                            /* End date must be below of start date */
                            $startDate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$context['data']['start_date']);
                            $endDate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$value);
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
                ->maxLength('description', 50,__('Description must be less than 50 characters.'))
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
    
    public function searchSpaycs($request = []) {
        //To search by kilometers instead of miles, replace 3959 with 6371.
        $distanceField = '(3959 * acos (cos ( radians(:latitude) )
            * cos( radians( Spaycs.latitude ) )
            * cos( radians( Spaycs.longitude )
            - radians(:longitude) )
            + sin ( radians(:latitude) )
            * sin( radians( Spaycs.latitude ) )))';
        $distance = 25;
        $spaycs = $this->find()
            ->select([
                'distance' => $distanceField, 'id', 'user_id', 'name', 'address'=>'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'status', 'latitude', 'longitude', 'created', 'modified'
            ])
            ->where(["$distanceField <" => $distance, 'status'=>'Active'])
            ->bind(':latitude', $request['latitude'], 'float')
            ->bind(':longitude', $request['longitude'], 'float');
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $spaycs->order(['distance'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $spaycs->where(["Spaycs.name LIKE"=>"%".$request['keyword']."%"]);
        }
        $page = (!empty($request['page']) && is_numeric($request['page']))?$request['page']:1;
        if($page < 0){
            $page = $page*-1;
            $spaycs->page($page);
        } else {
            $spaycs->page($page);
        }
        $newQuery = clone $spaycs;
        $data['count'] = $newQuery->count();
        $data['records'] = [];
        if($spaycs->count()) {
            $data['records'] = $spaycs->toArray();
        }
        return $data;
    }

}
