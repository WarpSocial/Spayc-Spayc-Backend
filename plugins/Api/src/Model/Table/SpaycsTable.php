<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Controller\ComponentRegistry;
use Api\Utils\Utils;
use ArrayObject;
use Cake\Utility\Hash;
use Cake\Event\Event;
use Api\Controller\Component\PushComponent;
use Api\Controller\Component\MatrixComponent;
use Cake\Database\Expression\QueryExpression;
use Api\Controller\Component\RedisComponent;

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
    
    public $distanceInMiles = null;

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
        $this->belongsTo('ParentSpaycs', [
            'dependent' => true,
            'className' => 'Api.Spaycs',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('SubSpaycs', [
            'dependent' => true,
            'className' => 'Api.Spaycs',
            'foreignKey' => 'parent_id'
            
        ]);
        $this->hasMany('JoinedSpayc', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'Api.JoinedSpayc'
        ]);
        $this->hasMany('SubscribedUsers', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'Api.SubscribedUsers'
        ]);
        $this->hasMany('Comments', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'Api.Comments'
        ]);
        $this->hasMany('SpaycHashtags', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.SpaycHashtags'
        ]);
        $this->hasMany('SpaycHashtags', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.SpaycHashtags'
        ]);
        
         $this->belongsToMany('Advertisements', [
            'joinTable' => 'spayc_advertisement',            
            'className' => 'Api.Advertisements'
        ]);
        $this->belongsToMany('Promotions', [
            'foreignKey' => 'spayc_id',
            'targetForeignKey' => 'promotion_id',
            'joinTable' => 'spayc_promotion',
            'className' => 'Api.Promotions'
        ]);
        /* spayc categories via joindata*/
        $this->belongsToMany('SpaycCategories', [
            'foreignKey' => 'spayc_id',
            'targetForeignKey' => 'spayc_category_id',
            'joinTable' => 'warp_categories',
            'className' => 'Api.SpaycCategories',
            'through'=>'Api.WarpCategories'
        ]);
        /*spayc categories direct by left join*/
        $this->hasMany('WarpCategories', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'LEFT',
            'className' => 'Api.WarpCategories'
        ]);
        /*Relation for warp repeat*/
        $this->hasMany('WarpFrequency', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'LEFT',
            'className' => 'Api.WarpFrequency'
        ]);
        $this->hasOne('RepeatFrequency', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.WarpFrequency'
        ]);
        
        /* Earth radius in miles 3959 */
        /* for postgresql cast is required else for mysql not*/
        $this->distanceInMiles = "(3958.756 * ACOS(
            COS((:lat/57.29577951)) *
            COS((Spaycs.latitude/57.29577951)) *
            COS((Spaycs.longitude/57.29577951) - (:long/57.29577951) ) +
            SIN((:lat/57.29577951)) *
            SIN((Spaycs.latitude/57.29577951))
        ) )";
    }

    public function validateDate($value,$context, $format = 'm-d-Y H:i:s') {
        $d = \DateTime::createFromFormat($format, $value);
        $valid = \DateTime::getLastErrors(); 
        if($valid['warning_count']==0 && $valid['error_count']==0){
            return true;
        }else{ 
            return false;
        }       
    }
    
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options){
        /* if enddate not be set then event end date will for 2 years */
        if (empty($data['end_date']) && !empty($data['start_date'])) {
            $endDate = Utils::dateTimeFormatter($data['start_date'],null,'Y-m-d H:i:s');
            $endDate = new Time($endDate, Configure::read('timezone'));
            $endDate->modify('+2 Years');
            $data['end_date'] = $endDate->format('m-d-Y H:i:s');
        }
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('name','create', __('Warp title is missing.'))
                ->maxLength('name', 255,'Warp title is too long.')
                ->notEmpty('name',__('Warp title is required.'));

        $validator
                ->maxLength('location', 255,__('Location test is too long.'))
                ->requirePresence('location', 'create',__('Location key is missing.'))
                ->notEmpty('location',__('Location is required field.'));
                // ->regex('location','/[\w\s]+$/',__('Location must be alpha numeric only.'));

        $validator
                ->requirePresence('payment_type', 'create',__('Payment type key is missing.'))
                ->notEmpty('payment_type',__('Payment type is required field.'))
                ->inList('payment_type', Configure::read('payment_type'),__('Type value must be any one '.implode(',',Configure::read('payment_type')).'.'));
        
        $validator
                //->requirePresence('ticket_url', 'create',__('Payment type key is missing.'))
                ->allowEmpty('ticket_url',__('Payment type is required field.'))
                ->add('ticket_url','validurl',[
                    'rule'=>function($value,$context){
                        if(empty($value)){
                            return true;
                        }
                        $urls = explode(',',$value);
                        foreach($urls as $key => $val){
                            if(filter_var($val, FILTER_VALIDATE_URL) === FALSE){
                                return false;
                            }
                        }
                        return true;
                    },
                    'last' => true,
                    'message'=>__('Ticket url is not valid.')
                ]);

        $validator
                ->requirePresence('group_type', 'create',__('Group key is missing.'))
                ->notEmpty('group_type',__('Group is required field.'))
                ->inList('group_type', Configure::read('grouptype'),__('Group value must be any one '.implode(',',Configure::read('grouptype')).'.')); 

        $validator                
                ->requirePresence('start_date', 'create',__('Start Date key is missing.'))
                ->notEmpty('start_date',__('Start date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
                ->add('start_date', [
                    'format' => [
                        'rule' => ['datetime','mdy'],
                        'last' => true,
                        'message' => __('Start date is not in format MM-DD-YYYY H:i:s')
                    ],
                    'daterange' => [
                        'rule' => function($value,$context){
                            if(!empty($value)){
                                /* Doesn't exceed 1 year ahead */
                                $timezone = Configure::read('timezone');
                                $startDate = Time::createFromFormat('m-d-Y H:i:s',$value,$timezone);
                                $currentDate = new Time('now',$timezone);
                                $now = clone $currentDate;
                                $currentDate->modify('+1 year');
                                $startDate = strtotime($startDate->format('Y-m-d H'));
                                $now = strtotime($now->format('Y-m-d H'));
                                $currentDate = strtotime($currentDate->format('Y-m-d H'));
                                return (bool) ($currentDate >= $startDate) && ($startDate >= $now);
                            }
                        },
                        'message'=>__('Start date can\'t be more than 1 year ahead or any past date.')
                    ]
                ]);
                
        $validator                
                ->requirePresence('end_date', 'create',__('End Date key is missing.'))                
               ->allowEmpty('end_date')
                ->add('end_date', [
                    'format' => [
                        'rule' => ['datetime','mdy'],
                        'last' => true,
                        'message' => __('End date is not in format MM-DD-YYYY H:i:s')
                    ],
                    'daterange' => [
                        'rule' => function($value,$context){
                            $timezone = Configure::read('timezone');
                        if(!empty($value) && !empty($context['data']['end_date']) && !empty($context['data']['start_date'])){
                            /* End date must be below of start date */
                            if(!$this->validateDate($context['data']['start_date'], $context)){
                                return false;
                            }
                            $startDate = Time::createFromFormat('m-d-Y H:i:s',$context['data']['start_date'],$timezone);
                            $endDate = Time::createFromFormat('m-d-Y H:i:s',$value,$timezone);
                            if($endDate->format('H') == '00'){
                                $endDate->setTime(23,55);
                            }
                            $startDate = strtotime($startDate->format("Y-m-d H:i"));
                            $endDate = strtotime($endDate->format("Y-m-d H:i"));
                            return (bool)($startDate <= $endDate );
                        }
                        return true;
                        },
                        'message'=>__('End date must be ahead from start date.')
                    ]
                ]);               

        $validator
                ->requirePresence('passcode', function($context){
                    return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                },__('Passcode is required for private warp.'))
                ->maxLength('passcode', 30,__('Max 30 character is allowed for passcode.'))
                ->notEmpty('passcode',__('Passcode is required for private warp.'),function($context){             
                    return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                });

        $validator
                ->requirePresence('description', 'create',__('Description key is missing.'))
//                ->maxLength('description', 250,__('Description must be less than 250 characters.'))
                ->allowEmpty('description');
        
        $validator
                ->allowEmpty('image')
                ->add('image','isfile',[
                    'rule'=>function($value,$context){
                        if(filter_var($value, FILTER_VALIDATE_URL)){
                            return true;
                        }elseif(!is_array($value) && !is_file($value)){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'last' => true,
                    'message'=>__('Image is not valid image file.')
                ])
                ->add('image','extension',[
                'rule'=>function($value,$context){
                    if(filter_var($value, FILTER_VALIDATE_URL)){
                        return true;
                    }elseif($value['type'] == 'image/jpeg' || $value['type'] == 'image/jpg' || $value['type'] == 'image/png'){
                        return true;
                    }else{
                        return false;
                    }
                },
                    'last' => true,
                     'message'=>__('Please select only jpg,jpeg,png.')
                ])
//                ->add('image','extension',[
//                    'rule' => ['extension', ['jpeg', 'png','jpg']],
//                    'message'=>__('Please select only jpg,jpeg,png.')
//                ])
                ->add('image', 'size', [
                    'rule' => function($value,$context){                    
                        if(!empty($value['error']) && ($value['error'] == 0)){
                            $sizeLimit =\Cake\Utility\Text::parseFileSize(Configure::read('maxupload'));
                            //$sizeLimit = 2536;//4793432
                            return (bool)($value['size'] <= $sizeLimit );
                        }else{
                            return true;
                        }
                       //$file = new \Cake\Filesystem\File($value['tmp_name'])
                    },
                    'message' => __('Image size must be less than ' . Configure::read('maxupload'). '.')
        ]);
        $validator
                ->allowEmpty('longitude')
                //->requirePresence('longitude', 'create',__('Longitude key is missing.'))
                //->notEmpty('longitude',__('Please enter longitude.'))
                ->longitude('longitude',__('Please enter valid longitude.'));        
        $validator
                //->requirePresence('latitude', 'create',__('Latitude key is missing.'))
                //->notEmpty('latitude',__('Please enter latitude.'))
                ->allowEmpty('latitude')
                ->latitude('latitude',__('Please enter valid latitude.'));  
        $validator
                ->requirePresence('primary_category', 'update',__('Please select warp category.'))
                ->notEmpty('primary_category',__('Please select category.'))
                ->integer('primary_category',__('Please enter valid category.'))
                ->add('primary_category','validcategoryid',[
                    'rule'=>function($value,$context){
                        if(!empty($value)){                            
                            $exist = $this->SpaycCategories->exists(['id'=>$value]);
                            if($exist){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    },
                    'message'=>__('Please enter valid category.')
                ]);  
        $validator
                ->allowEmpty('other_category',__('Please select category.'))
                ->add('other_category','repeat_category',[
                    'rule'=>function($value,$context){
                        if(!empty($value) && !empty( $context['data']['primary_category'])){
                            $idVal = explode(',',$value);
                            $primaryCat = $context['data']['primary_category'];
                            /* in case of only comma value or not in format like comma separated and alos should not be the value of primary category*/
                            if(empty(array_filter($idVal)) || in_array($primaryCat, $idVal)){
                                return false;
                            }
                            return true;
                        }
                    },
                    'message'=> __('Primary category should not be in other category')
                ])
                ->add('other_category','valid_other_category',[
                    'rule'=>function($value,$context){
                        if(!empty($value)){
                            $idVal = explode(',',$value);
                            /* in case of only comma value or not in format like comma separated*/
                            if(empty(array_filter($idVal))){
                                return false;
                            }
                            $ids = $this->SpaycCategories->find()->where(["id IN"=>$idVal])->count();
                            if(count($idVal) == $ids){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    'message'=>__('Other category is not valid.')
                ]); 
        $validator->notEmpty('repeat_type',__('Please select repeat type.'))
                
                ->inList('repeat_type', array_keys(Configure::read('repeat_type')),__('Repeat type value must be any one '. Utils::explodeArray(Configure::read('repeat_type')).'.'));
        
        $validator
                ->requirePresence('day_of_week', function($context){
                    if(!empty($context['data']['repeat_type']) && ($context['data']['repeat_type'] == WEEKLY)){
                        return true;
                    }
                    return false;
                },__('Please select day of week.'))
                ->notEmpty('day_of_week',__('Please select day of week.'),function($context){
                    if(!empty($context['data']['repeat_type']) && ($context['data']['repeat_type'] == WEEKLY)){
                        return true;
                    }
                    return false;
                })        
                ->add('day_of_week','valid_day', [
                   'rule' => function($value,$context){
                        if(!empty($value)){
                            $repeatDays = explode(',',$value);
                            foreach($repeatDays as $days){
                                if(!in_array($days,array_keys(Configure::read('day_of_week')))){
                                    return false;
                                }
                            }
                        }
                        return true;
                        },
                        'message'=>__('Day of week value must be any one '.Utils::explodeArray(Configure::read('day_of_week')).'.'),
                    ]
                );
        $validator
                ->requirePresence('repeat_date', function($context){
                    if(!empty($context['data']['repeat_type']) && ($context['data']['repeat_type'] == CUSTOM)){
                        return true;
                    }
                    return false;
                },__('Please select date.'))
                ->notEmpty('repeat_date',__('Please select date.'),function($context){
                    if(!empty($context['data']['repeat_type']) && ($context['data']['repeat_type'] == CUSTOM)){
                        return true;
                    }
                    return false;
                })
               ->add('repeat_date','valid_date', [
                   'rule' => function($value,$context){
                        if(!empty($value)){
                            $repeatDates = explode(',',$value);
                            foreach($repeatDates as $date){
                                if(!$this->validateDate($date, $context,'m-d-Y')){
                                    return false;
                                }
                            }
                        }
                        return true;
                        },
                        'message'=>__('Repeat date must be in comma separated with valid date format(m-d-Y).'),
                    ]
                );
        
        return $validator;
    }
    /**
     * validateSubspace vlaidate create subspace
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validateSubspace($data) {
        $validator = new Validator();
        $validator
                ->requirePresence('parent_matrix_room_id','create', __('Matrix parent room id key is missing.'))
                ->notEmpty('parent_matrix_room_id',__('Matrix parent room id is required.'));
        
        $validator
                ->requirePresence('name','create', __('Warp title is missing.'))
                ->maxLength('name', 255,'Warp title is too long.')
                ->notEmpty('name',__('Warp title is required.'))
                ->notBlank('name',__('Warp title is required.'));

        $validator
                ->requirePresence('group_type', 'create',__('Group key is missing.'))
                ->notEmpty('group_type',__('Group is required field.'))
                ->inList('group_type', Configure::read('grouptype'),__('Group value must be any one '.implode(',',Configure::read('grouptype')).'.')); 
        
        $validator
                ->requirePresence('passcode', function($context){
                    return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                },__('Passcode is required for private sub-warp.'))
                ->maxLength('passcode', 30,__('Max 30 character is allowed for passcode.'))
                ->notBlank('passcode',__('Passcode is required in case of private group type.'),function($context){                    
                     return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                })        
                ->notEmpty('passcode',__('Passcode is required for private warp.'),function($context){             
                    return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                });

        $validator
                ->requirePresence('description', 'create',__('Description key is missing.'))
                ->maxLength('description', 250,__('Description must be less than 250 characters.'))
                ->allowEmpty('description');
        
        $validator                
                ->allowEmpty('image')
                ->add('image','isfile',[
                    'rule'=>function($value,$context){
                        if(!is_array($value) && !is_file($value)){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'last' => true,
                    'message'=>__('Image is not valid image file.')
                ])
                ->add('image','extension',[
                    'rule' => ['extension', ['jpeg', 'png','jpg']],
                    'last' => true,
                    'message'=>__('Please select only jpg,jpeg,png.')
                ])
                
                ->add('image','size',[
                    'rule' => ['fileSize', '<=',\Cake\Core\Configure::read('maxupload')],
                    'message'=>__('Image size must be less than '.\Cake\Core\Configure::read('maxupload').'.')
                ]);
         $validator                
                ->allowEmpty('spayc_category_id')
                ->integer('spayc_category_id',__('Please enter valid category.'))
                ->add('spayc_category_id','validcategoryid',[
                    'rule'=>function($value,$context){
                        if(!empty($value)){                            
                            $exist = $this->SpaycCategories->exists(['id'=>$value]);
                            if($exist){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    },
                    'message'=>__('Please enter valid category.')
                ]);             
         return $validator->errors($data);
    }
    
    public function searchSpaycs($request = [], $userId=null) {
        
        if(!empty($request['latitude']) && !empty($request['longitude'])) {
            $distance = "ROUND( CAST(".str_replace(':long',$request['longitude'],str_replace(':lat',$request['latitude'],$this->distanceInMiles))." AS numeric), 3)";
        }else{
            $distance = 0;
        }
        
        $spaycs = $this->find()
                ->select([
                    'distance' => $distance, 'Spaycs.id', 'Spaycs.name', 'Spaycs.location', 'Spaycs.matrix_room_id', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.type', 'Spaycs.group_type', 'Spaycs.passcode'])
                ->where(['Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
               ->contain([
                    'JoinedSpayc' => function($q) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status'])->where(['JoinedSpayc.status'=>'Joined']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'WarpCategories.SpaycCategories'
                ])
                ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
                $bannedSpayc = $this->bannedSpayc($userId);    
                if(!empty($bannedSpayc)){
                    $spaycs->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                        return $exp->notIn('Spaycs.id', $bannedSpayc);
                     });
                }
        if(!empty($request['keyword'])) {
            $dateRange = Utils::dateRangeUtc('now',DAYS_RANGE,Configure::read('timezone'));
            $spaycs->where(["LOWER(Spaycs.name) LIKE"=>"%".strtolower($request['keyword'])."%"]);
            $spaycs = $this->warpWhereFrequency($dateRange['start'], $dateRange['end'], $spaycs);
        }
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $spaycs->limit($limit);
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId) {
            return $results->map(function ($row) use($userId) {
                $totalJoined = [];
                if(!empty($row['joined_spayc'])) {
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.'].status');
                }
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:null;
                $row['is_joined'] = !empty($status[0])?true:false;
                $row['joined_users'] = !empty($row['joined_spayc'])?count($totalJoined):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                return $row;
            });
        });
        
        $page = (!empty($request['page']) && is_numeric($request['page']))?$request['page']:1;
        if($page < 0) {
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
    
    public function spaycMember($spaceid = null,$status = null,$page = null,$limit=null){ 
        if($spaceid == null){
            return false;
        }
        if(preg_match("/[a-z]/i", $spaceid)){
            $room_id = $this->find()->select('id')->where(['matrix_room_id'=>$spaceid])->first()->id;
        }else{
            $room_id = $spaceid;
        }
        
        if(empty($room_id)){
            return false;
        }
        if(!empty($status)){
            $status = explode(',', strtolower($status));
        }
        $loggedUser = Configure::read('auth');
        $query = $this->Users->find();
        $query->select(['Users.id', 'Users.username','Users.display_name','Users.full_name', 'Users.email','Users.matrix_user_id','JoinedSpayc.status']);
        $query->contain([
             'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            },
            'SubscribedUsers' => function($q)use($room_id) {
                return $q->select(['SubscribedUsers.id','SubscribedUsers.spayc_id', 'SubscribedUsers.user_id'])->where(['SubscribedUsers.status'=>'Active','SubscribedUsers.spayc_id'=>$room_id]);
            },        
            'Requestedby' => function($q)use($loggedUser) {
                return $q->select(['Requestedby.id','Requestedby.requested_by', 'Requestedby.requested_to','Requestedby.requested_status','Requestedby.matrix_room_id','Requestedby.action_by'])->where(['OR'=>[['Requestedby.requested_by'=>$loggedUser['id']],['Requestedby.requested_to'=>$loggedUser['id']]]]);
            },        
            'Requestedto' => function($q)use($loggedUser) {
                return $q->select(['Requestedto.id','Requestedto.requested_by', 'Requestedto.requested_to','Requestedto.requested_status','Requestedto.matrix_room_id','Requestedto.action_by'])->where(['OR'=>[['Requestedto.requested_by'=>$loggedUser['id']],['Requestedto.requested_to'=>$loggedUser['id']]]]);
            },        
        ]);
        $query->innerJoinWith('JoinedSpayc',function($q)use($room_id ,$status,$loggedUser) {
                $condition = ['JoinedSpayc.spayc_id'=>$room_id ,'JoinedSpayc.user_id !='=>$loggedUser['id']];
                if($status != null){
                    $condition['LOWER(JoinedSpayc.status) IN'] = $status;
                }
                return $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance','JoinedSpayc.updated_by'])->where($condition)->order(['JoinedSpayc.created'=>'DESC']);
        });
       $count = $query->count();
        if($limit != null){
            $query->limit($limit);
        }
        if($page != null){
            $query->page($page);
        }
        if($query->isEmpty()){
            return [];
        }
        
        $result = $query->map(function ($row) {
            if(!empty($row->_matchingData['JoinedSpayc']->is_admin)){
                $row->is_admin = $row->_matchingData['JoinedSpayc']->is_admin;
            }else{
                $row->is_admin = 0;
            }
            $row->matrix_room_id = '';
            $row->friend_status = '';
            $row->action_by = '';
            $row->joined_status = 'Not_Joined';
            $row->physically_present = false;
            if(!empty($row->requestedto[0])){
                $row->friend_status = $row->requestedto[0]->requested_status; 
                $row->matrix_room_id = $row->requestedto[0]->matrix_room_id;
                $row->action_by = $row->requestedto[0]->action_by;
            }elseif(!empty($row->requestedby[0])){
                $row->friend_status = $row->requestedby[0]->requested_status;
                $row->matrix_room_id = $row->requestedby[0]->matrix_room_id;
                $row->action_by = $row->requestedby[0]->action_by;
            }
            if(!empty($row->_matchingData['JoinedSpayc']->status)){
                $row->joined_status = $row->_matchingData['JoinedSpayc']->status;
            }
            $row->updated_by = $row->_matchingData['JoinedSpayc']->updated_by;
            if(!empty($row->_matchingData['JoinedSpayc']->distance)){
                $miles = Configure::read('miles');
                 $row->physically_present = ($row->_matchingData['JoinedSpayc']->distance <= $miles)?true:false;
            }
            $row->is_subscribed = !empty($row->subscribed_users[0])?true:false;
            
            $row->image_url = !empty($row->user_images[0]['image_url'])?$row->user_images[0]['image_url']:"";
            
            unset($row->_matchingData,$row->user_images,$row->subscribed_users,$row->requestedby,$row->requestedto);
            return $row;
        });
        return ['count'=>$count,'records'=>$result];
    }
    
    public function joinedInvite($items = [],$spaycId = null,$adminUser = null){
        if($adminUser == null || $spaycId == null){
            return;
        }
        $adminMatrixUserId = Configure::read('auth.UserLogs.matrix_user_id');

        if(!empty($items['invite'])) {
            $items['invite'] = $adminMatrixUserId.','.$items['invite'];
        }else{
            $items['invite'] = $adminMatrixUserId;
        }
        
        $invite  = explode(',',$items['invite']);
        $user = TableRegistry::get("Api.Users")->find()->contain(['PhysicalLocation'])->select(['id','matrix_access_token','PhysicalLocation.current_latitude','PhysicalLocation.current_longitude'])->where(['matrix_user_id IN'=>$invite]);
        if($user->isEmpty()){
            return;
        }            
        $pushNotification = new PushComponent(new ComponentRegistry());
        $matrix = new MatrixComponent(new ComponentRegistry());
        foreach($user as $key => $val){
            if(!empty($val->physical_location)){
                $lat = $val->physical_location['current_latitude'];
                $long = $val->physical_location['current_longitude'];
                $distance = \Api\Utils\Utils::distance($lat,$long,$items['latitude'],$items['longitude']);
            }else{
                $distance = null;
            }
            
            $member[] = [
                'spayc_id'=>$spaycId,
                'user_id'=>$val->id,
                'status' => 'Joined',
                'updated_by' => $adminUser,
                'created' => date("Y-m-d H:i:s"),
                'modified' => date("Y-m-d H:i:s"),
                'distance' => $distance,
                'is_admin'=>($val->id != $adminUser)?0:2
            ];

            $Queue = [
                'join'=>true,
                'rule'=>'mute',
                'status'=>'Joined',
                'matrix_token'=>$val->matrix_access_token,
                'matrix_room_id'=>$items['matrix_room_id']
            ];
            
            /*queue the request only if user subscribed parent spayc he will auto subscribed of sub spayc*/
            if(!empty($items->parent_id)){
                $parentSpayc = $this->get($items->parent_id);                
                if(TableRegistry::get('Api.SubscribedUsers')->isSubscribed($val->id,$parentSpayc->id,ACTIVE)){
                    TableRegistry::get('Api.SubscribedUsers')->subscribeSubSpayc([
                        'user_id' => $val->id,
                        'status' => ACTIVE,
                        'spayc_id' => $parentSpayc->id,
                        'datetime' => date('Y-m-d H:i:s')
                    ]);  
                    $Queue['rule'] = 'unmute';
                }else{
                    $Queue['rule'] = 'mute';
                }
            }
            if($items['is_direct']){
                $Queue['rule'] = 'unmute';
            }
            //if($val->id != $adminUser){
            TableRegistry::get('Queue.QueuedJobs')->createJob('MuteUnmute',$Queue);                
            //}
            $push['requested_by'] = $adminUser;
            $push['requested_to'] = $val->id;
            $push['slug'] = 'new-spayc';
            $push['spayc_id'] = $spaycId;
            $push['spayc_name'] = $items['name'];
            $push['spayc_image'] = $items['image'];
            $push['matrix_room_id'] = $items['matrix_room_id'];
            $push['distance'] = $distance;
            if(!$items['is_direct']){
                if(($val->id != $adminUser)){
                    $pushNotification->sendPushNotification($push);
                }
                /*In direct chat no need to send the notification */

            }
        }      
        
        /*In direct chat no need take the record */
        if($items['is_direct']){ 
            return true;
        }
        $joinedSpayc = TableRegistry::get('Api.JoinedSpayc');
        $entities = $joinedSpayc->newEntities($member);
        $result = $joinedSpayc->saveMany($entities,['checkRules' => false,'atomic'=>false]);
        return $result;
    }

    public function getSpaycDistanceFromUser($latitude = null, $longitude = null, $userId = null) {
        $distanceField = '(3959 * acos (cos ( radians(:latitude) )
                * cos( radians( Users.current_latitude ) )
                * cos( radians( Users.current_longitude )
                - radians(:longitude) )
                + sin ( radians(:latitude) )
                * sin( radians( Users.current_latitude ) )))';
            $distance = 0;
            $users = TableRegistry::get('Api.Users')->find()
                ->select([
                    'distance' => $distanceField, 'id'])
                ->where(["$distanceField >=" => $distance, 'Users.id'=>$userId])
                ->bind(':latitude', $latitude, 'float')
                ->bind(':longitude', $longitude, 'float')
                ->order(['Users.id']);
            if(!$users->isEmpty()) {
                return round($users->first()->distance, 2);
            }
            return 0;
    }
    public function getNearBySpaycsOnMap($request = [], $userId=null) {
        //$request['radius'] = '2799';
        $unit = 'm';//meter
        $now = new Time('now', Configure::read('timezone'));        
        $now->modify('today');
        $timeStmap = $now->getTimestamp();
        $fields = ['id', 'name','start_date', 'matrix_room_id', 'image', 'type', 'modified', 'latitude','longitude','score'=>'website'];
        /* if user filter past date event in that case calculate distance manually because redis clean past event */
        if(isset($request['is_filter']) && ($request['is_filter'] === true) && (isset($request['current_date']) && $request['current_date'] < $timeStmap)){ 
            $redisSpaycs = [];
            $distanceField = $this->geoDistance();
             $radius = $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude'],$unit);
             $fields['distance'] = $distanceField;
             $spaycs = $this->find()
                ->select($fields)
                ->where(["$distanceField <=" => $radius, 'Spaycs.status'=>'Active',
                    'Spaycs.group_type !='=>'trusted_private', 
                    'Spaycs.parent_id IS'=>null
                    ])
                ->bind(':latitude', $request['center_latitude'], 'float')
                ->bind(':longitude', $request['center_longitude'], 'float');
             
        }else {
            if (empty($request['radius'])) {
                $radius = $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']);
            }else{
                $radius = $request['radius'];
            }
            $redis = new RedisComponent(new ComponentRegistry());
            $redisSpaycs = $redis->getGeoLocation('Spaycs',$request['center_latitude'], $request['center_longitude'], $radius,$unit);
            if(empty($redisSpaycs)){
                return ['count'=>0,'records'=>[]];
            }
            $requiredSpaycs = array_column($redisSpaycs,'id');
            $spaycs = $this->find()
                ->select($fields)
                ->where(['Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null,'Spaycs.id IN'=>$requiredSpaycs]);
        }
        /*Get spayc Query object after adding event start and end date */
        $spaycs = $this->warpEventDate($request, $spaycs);
        
        if(isset($request['spayc_type']) && $request['spayc_type']) {
            $spayc_type = explode("|",ucfirst($request['spayc_type']));
            $spaycs->where(["Spaycs.type IN "=>$spayc_type]);
        }
        if(!empty($request['payment_type'])) {
            if(strtolower($request['payment_type']) == strtolower(FREE)){
                $spaycs->where(["LOWER(Spaycs.payment_type)"=> strtolower($request['payment_type'])]);
            }
        }
       
        if(isset($request['group_type']) && $request['group_type']) {
            $group_type = explode("|",ucfirst($request['group_type']));
            $spaycs->where(["Spaycs.group_type IN "=>$group_type]);
        }
        
        if(isset($request['wrap_with_friends']) && $request['wrap_with_friends']=="yes") {
        $child= TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId);
        
        if(empty($child)){
         $child = array(0);
        }
       
         $spaycs->join(
                [
                    'table' => 'joined_spayc',
                    'type' => 'INNER',
                    'conditions' => [
                        'Spaycs.id = joined_spayc.spayc_id',
                        'joined_spayc.user_id in ('.implode(",", $child).')'
                    ]
                ]
            );
           
        }
        if(isset($request['hashtag_id']) && $request['hashtag_id']) {
            $spaycs->join(
                [
                    'table' => 'spayc_hashtags',
                    'type' => 'INNER',
                    'conditions' => [
                         'Spaycs.id = spayc_hashtags.spayc_id',
                        'spayc_hashtags.hashtag_id IN  ('.$request['hashtag_id'].')',
                    ]
                ]
            );
        }
        if(isset($request['category_id'])) {
            $spaycs->join(
                [
                    'table' => 'warp_categories',
                    'type' => 'INNER',
                    'conditions' => [
                        'Spaycs.id = warp_categories.spayc_id',
                        'warp_categories.spayc_category_id IN  ('.$request['category_id'].')',
                    ]
                ]
            );
        }

        $subQuery = TableRegistry::get('Api.JoinedSpayc')->bannedSpaycQuery($userId);
        $spaycs->where(['Spaycs.id NOT IN'=>$subQuery]);
        $spaycs->contain([
            'JoinedSpayc' => function($q) {
                return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status'])
                        ->where(['JoinedSpayc.status' => "Joined"]);
            },
            'SubscribedUsers' => function($q) {
                return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id'])
                        ->where(['SubscribedUsers.status' => "Active"]);;
            },
           'WarpCategories.SpaycCategories'
        ]);
        /*remove duplicate id*/
        $spaycs->distinct(['Spaycs.id']);    
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId,$redisSpaycs) {
            return $results->map(function ($row) use($userId,$redisSpaycs) {
                $totalJoined = [];
                if(!empty($redisSpaycs)){
                    $row->distance = $redisSpaycs[$row->id]['distance'];//Hash::extract($redisSpaycs,'{n}[id='.$row->id.']')[0]['distance'];
                }
                
                if(!empty($row['joined_spayc'])) {
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.'].status');
                }
                $row['is_joined'] = !empty($status[0])?true:false;
//                $row['spayc_type'] = ($row['parent_id']==NULL || $row['parent_id']=="" )?"Spayc":"SubSpayc";
//                unset($row['parent_id']);
                $row['joined_users'] = !empty($row['joined_spayc'])?count($totalJoined):0;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                unset($row['subscribed_users']);
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                return $row;
            });
        });
        if(!isset($request['is_limit']) || (isset($request['is_limit']) && $request['is_limit'])){
            $spaycs->limit(100);
        }
        return ['count'=>($spaycs->isEmpty())?0:1,'records'=>$spaycs];
        //return ['count'=>$spaycs->count(),'records'=>$spaycs];
    }
    public function distance($lat1, $lon1, $lat2, $lon2,$unit='km') {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;

        $r = 3959; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        //echo '<br/>'.$km;
        if($unit == 'm'){
            return ($km * 1000);
        }
        return $km;
    }
    
    public function updateDistance($entity){ 
        if(!empty($entity['joined_spayc'])){
            $this->getConnection()->transactional(function () use ($entity) {                
                foreach ($entity->joined_spayc as $jp) {
                    $this->JoinedSpayc->query()
                            ->update()
                            ->set(['distance' => $jp->distance])
                            ->where(['id' => $jp->id])
                            ->execute();
                }
            });
        }
    }
    
    public function spaycPk($spaycId){
        if(preg_match("/[a-z]/i", $spaycId)){
            return ['matrix_room_id'=>$spaycId];        
        }else{
            return ['Spaycs.id'=>$spaycId];
        }
    }
    
    public function bannedSpayc($userId){
        $banned = TableRegistry::get('Api.JoinedSpayc')->find()->where(['user_id'=>$userId,'status'=>BANNED])->extract('spayc_id');
        if($banned->isEmpty()){
            return false;
        }
        return $banned->toArray();
    }
    public function spaycWithFriends($userId){
        if($userId == null){
            return false;
        }
        $subQuery = TableRegistry::get('Api.FriendRequest')->friendSubquery($userId);        
        $query = TableRegistry::get('Api.JoinedSpayc')->find()
                ->select(['spayc_id'])
                ->distinct()
                ->where(['user_id IN' => $subQuery,'status'=>'Joined']);
        //pr($query->toArray());die;
        return $query;
    }
    
    public function geoDistance(){
        return '( 3959 * ACOS( COS( RADIANS(:latitude) ) * COS( RADIANS(  latitude ) ) * COS( RADIANS(  longitude ) - RADIANS(:longitude) ) + SIN( RADIANS(:latitude) ) * SIN( RADIANS(  latitude ) ) ) )';
    }
    
    public function warpEventDate($request,$spaycs){
        /* get warp event of same date only */
        if(isset($request['is_filter']) && ($request['is_filter'] === true) && isset($request['current_date'])){
            $filterDate = Time::createFromTimestamp($request['current_date'], Configure::read('timezone'));
            /* reverse of timezone offset */
            $zoneOffset = -1 * $filterDate->getOffset();
            
            $beginOfDay = Time::createFromTimestamp($request['current_date'],'UTC');            
            $beginOfDay->modify($zoneOffset.' second');
           
            $endOfDay = Time::createFromTimestamp($request['current_date'],'UTC');
            $endOfDay->modify('tomorrow');            
            $endOfDay->modify($zoneOffset.' second');
            $warpStartAt = $beginOfDay->format('Y-m-d H:i');
            $warpEndAt = $endOfDay->format('Y-m-d H:i');
        }else{
            $dateRange = Utils::dateRangeUtc('now',MAP_DAYS_RANGE,Configure::read('timezone'));
            $warpStartAt = $dateRange['start'];
            $warpEndAt = $dateRange['end']; 
        }
        return $this->warpWhereFrequency($warpStartAt,$warpEndAt,$spaycs);
    }
    public function warpWhereFrequency($warpStartAt,$warpEndAt,$spaycs){
        $whereClause = "(warp_frequency.start_date, warp_frequency.end_date) OVERLAPS ('".$warpStartAt."'::TIMESTAMP, '".$warpEndAt."'::TIMESTAMP)";
        //$interval = Utils::dateIntervalAttribute($warpStartAt,$warpEndAt);
        //$daily = "(repeat_type=1 AND $overLaps)";
        //$weekly = "(repeat_type=2 AND day_of_week IN (".$interval['weekdays'].") AND $overLaps)";
        //$monthly = "(repeat_type=3 AND day_of_month IN (".$interval['monthdays'].") AND $overLaps)";
        //$yearly = "(repeat_type=4 AND day_of_month IN (".$interval['monthdays'].") AND month_of_year IN (".$interval['month'].") AND $overLaps)";
        //$custom = "(repeat_type=5 AND cast (CONCAT (custom_year, '-', month_of_year,'-',day_of_month) as TIMESTAMP) between '$warpStartAt' AND '$warpEndAt' AND $overLaps)";
        //$whereClause = '('.$weekly.' OR '.$monthly.' OR '.$yearly.' OR '.$custom.' OR '.$daily.')';
        $spaycs->select(['warp_frequency.start_date','warp_frequency.end_date','warp_frequency.repeat_type','warp_frequency.day_of_week','warp_frequency.repeat_date']);
        return $spaycs->join([
            'table' => 'warp_frequency',
            'type' => 'INNER',
            'alias' => 'warp_frequency',
            'conditions' => [
                '(Spaycs.id = warp_frequency.spayc_id)',
                $whereClause,
                ]
            ]);
    }
    public function warpRepeatFrequency_ol($warpStartAt,$warpEndAt,$spaycs){        
        return $spaycs->contain('RepeatFrequency',function($q)use($warpStartAt,$warpEndAt){
            $startDate = "TO_TIMESTAMP(cast(RepeatFrequency.start_date as text),'YYYY-MM-DD HH24:MI')"; 
            $endDate = "TO_TIMESTAMP(cast(RepeatFrequency.end_date as text),'YYYY-MM-DD HH24:MI')"; 
            $q->where([
                'OR'=>[[$startDate.' >='=>$warpStartAt],[$endDate.' >= '=>$warpStartAt]]
                ]);
            $q->where([
                'OR'=>[[$startDate.' <='=>$warpEndAt],[$endDate.' <= '=>$warpEndAt]]
                ]);
            return $q;
        });
    }
    public function warpRepeatFrequency($warpStartAt,$warpEndAt,$spaycs){        
        return $spaycs->contain('RepeatFrequency',function($q)use($warpStartAt,$warpEndAt){
            $q->select(['RepeatFrequency.start_date','RepeatFrequency.end_date','RepeatFrequency.repeat_type','RepeatFrequency.day_of_week','RepeatFrequency.repeat_date']);
            $startDate = "TO_TIMESTAMP(cast(RepeatFrequency.start_date as text),'YYYY-MM-DD HH24:MI')"; 
            $endDate = "TO_TIMESTAMP(cast(RepeatFrequency.end_date as text),'YYYY-MM-DD HH24:MI')"; 
            $q->where("RepeatFrequency.start_date BETWEEN '".$warpStartAt."' AND '".$warpEndAt."'");
            return $q;
        });
    }

}
