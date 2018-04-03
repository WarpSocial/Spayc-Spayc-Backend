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
use Api\Controller\Component\PushComponent;
use Api\Controller\Component\MatrixComponent;

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
        
         $this->belongsToMany('Advertisements', [
            'joinTable' => 'spayc_advertisement',            
            'className' => 'Api.Advertisements'
        ]);
        
        /* Earth radius in miles 3959 */
        /* for postgresql cast is required else for mysql not*/
        $this->distanceInMiles = "(3958.756 * ACOS(
            COS(RADIANS(:lat)) *
            COS(RADIANS(Spaycs.latitude)) *
            COS( RADIANS(Spaycs.longitude) - RADIANS(:long) ) +
            SIN(RADIANS(:lat)) *
            SIN(RADIANS(Spaycs.latitude))
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
                                $currentDate->modify('+1 year')->modify('+1 minute');
                                return (bool) ($startDate >= $now && $startDate <= $currentDate);
                            }
                        },
                        'message'=>__('Start date can\'t be more than 1 year ahead or any past date.')
                    ]
                ]);
                
        $validator                
                ->requirePresence('end_date', 'create',__('End Date key is missing.'))                
                ->notEmpty('end_date',__('End date is required when type is event.'),function($context){
                     return (isset($context['data']['type']) && ($context['data']['type'] =='Event'));
                })
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
                },__('Passcode is required for private spayc.'))
                ->maxLength('passcode', 30,__('Max 30 character is allowed for passcode.'))
                ->notEmpty('passcode',__('Passcode is required for private spayc.'),function($context){             
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
                    'message'=>__('Please select only jpg,jpeg,png.')
                ])
                ->add('image','size',[
                    'rule' => ['fileSize', '<=',\Cake\Core\Configure::read('maxupload')],
                    'message'=>__('Image size must be less than '.\Cake\Core\Configure::read('maxupload').'.')
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
                ->requirePresence('name','create', __('Name key is missing.'))
                ->maxLength('name', 255,'Name text is too long.')
                ->notEmpty('name',__('Spayc name is required.'))
                ->notBlank('name',__('Spayc name is required.'));

        $validator
                ->requirePresence('group_type', 'create',__('Group key is missing.'))
                ->notEmpty('group_type',__('Group is required field.'))
                ->inList('group_type', Configure::read('grouptype'),__('Group value must be any one '.implode(',',Configure::read('grouptype')).'.')); 
        
        $validator
                ->requirePresence('passcode', function($context){
                    return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                },__('Passcode is required for private sub-spayc.'))
                ->maxLength('passcode', 30,__('Max 30 character is allowed for passcode.'))
                ->notBlank('passcode',__('Passcode is required in case of private group type.'),function($context){                    
                     return (isset($context['data']['group_type']) && ($context['data']['group_type'] =='Private'));
                })        
                ->notEmpty('passcode',__('Passcode is required for private spayc.'),function($context){             
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
         return $validator->errors($data);
    }
    
    public function searchSpaycs($request = [], $userId=null) {
        if(!empty($request['latitude']) && !empty($request['longitude'])) {
            //To search by kilometers instead of miles, replace 3959 with 6371.
            $distanceField = '(3959 * acos (cos ( radians(:latitude) )
                * cos( radians( Spaycs.latitude ) )
                * cos( radians( Spaycs.longitude )
                - radians(:longitude) )
                + sin ( radians(:latitude) )
                * sin( radians( Spaycs.latitude ) )))';
            $distance = 0;
            $spaycs = $this->find()
                ->select([
                    'distance' => $distanceField, 'id', 'name', 'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'passcode'])
                ->where(["$distanceField >=" => $distance, 'status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
                ->bind(':latitude', $request['latitude'], 'float')
                ->bind(':longitude', $request['longitude'], 'float')
                ->order(['distance'=>'ASC']);
        } else {
            $spaycs = $this->find()
                ->select(['id', 'name', 'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'passcode'])
                ->where(['Spaycs.status'=>'Active', 'Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
                ->order(['created'=>'DESC']);
        }
        $spaycs->contain([
            'JoinedSpayc' => function($q) {
                return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
            },
            'SubscribedUsers' => function($q) {
                return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
            }
        ]);
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $spaycs->limit($limit);
        if(!empty($request['keyword'])) {
            $spaycs->where(["LOWER(Spaycs.name) LIKE"=>"%".strtolower($request['keyword'])."%"]);
        }
        
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
        $spayc = $this->find()->select('id')->where(['matrix_room_id'=>$spaceid])->first();
        if(empty($spayc)){
            return false;
        }
        $loggedUser = Configure::read('auth');
        $matrix_room_id = $spayc->id;
        $query = $this->Users->find();
        $query->select(['Users.id', 'Users.username','Users.display_name', 'Users.email', 'Users.gender', 'Users.dob','Users.country_code', 'Users.phone', 'Users.website_url', 'Users.address', 'Users.bio_data', 'Users.longitude', 'Users.latitude', 'Users.matrix_user_id','JoinedSpayc.status']);
        $query->contain([
             'UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
            }
        ]);
        $query->innerJoinWith('JoinedSpayc',function($q)use($matrix_room_id,$status,$loggedUser) {
                $condition = ['JoinedSpayc.spayc_id'=>$matrix_room_id,'JoinedSpayc.user_id !='=>$loggedUser['id']];
                if($status != null){
                    $condition['JoinedSpayc.status'] = $status;
                }
                return $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin'])
                        ->where($condition);
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
            if(!empty($row->_matchingData['JoinedSpayc']->status)){
                $row->requested_status = $row->_matchingData['JoinedSpayc']->status;
            }else{
                $row->requested_status = "Pending";
            }
            
            $row->is_subscribed = false;
            $row->physically_present = false;
            $row->image_url = !empty($row->user_images[0]['image_url'])?$row->user_images[0]['image_url']:"";
            
            unset($row->_matchingData,$row->user_images);
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

            $joinData = [
                'status'=>'Joined',
                'matrix_room_id'=>$items['matrix_room_id'],
                'matrix_token'=>$val->matrix_access_token
            ];
            if($val->id != $adminUser){
                $matrix->joinRoom($joinData);
            }
            $push['requested_by'] = $adminUser;
            $push['requested_to'] = $val->id;
            $push['slug'] = 'new-spayc';
            $push['spayc_id'] = $spaycId;
            $push['spayc_name'] = $items['name'];
            $push['spayc_image'] = $items['image'];
            $push['matrix_room_id'] = $items['matrix_room_id'];
            $push['distance'] = $this->getSpaycDistanceFromUser($items['latitude'], $items['longitude'], $push['requested_to']);
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
//        if(!empty($request['latitude']) && !empty($request['longitude'])) {
//            $distanceField = '( 3959 * ACOS( COS( RADIANS(:latitude) ) *
//                COS( RADIANS(  latitude ) ) *
//                COS( RADIANS(  longitude ) - RADIANS(:longitude) ) +
//                SIN( RADIANS(:latitude) ) *
//                SIN( RADIANS(  latitude ) ) ) )';
//            
//            
//             $distance = 24;
//            $users = TableRegistry::get('Users')->find()
//                ->select([
//                    'distance' => $distanceField, 'id'])
////                ->where(['Users.id'=>$userId])
//                ->where(["$distanceField <=" => $distance])
//                ->bind(':latitude', $request['latitude'], 'float')
//                ->bind(':longitude', $request['longitude'], 'float')
//                ->order(['Users.id']);
//            print_R($users->toArray());die;
//            if(!$users->isEmpty()) {
//                return round($users->first()->distance, 2);
//            }
//            return 0;
//            $spaycs = $this->find()
//                ->select([
//                    'distance' => $distanceField, 'id', 'name', 'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'passcode'])
//                ->where(["$distanceField >=" => $distance, 'status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
//                ->bind(':latitude', $request['latitude'], 'float')
//                ->bind(':longitude', $request['longitude'], 'float')
//                ->order(['distance'=>'ASC']);
////            print_R($spaycs);die;
//            print_R($spaycs->toArray());die;
//        } else {
//            $spaycs = $this->find()
//                ->select(['id', 'name', 'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'passcode'])
//                ->where(['Spaycs.status'=>'Active', 'Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
//                ->order(['created'=>'DESC']);
//        }
//        $spaycs->contain([
//            'JoinedSpayc' => function($q) {
//                return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
//            },
//            'SubscribedUsers' => function($q) {
//                return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
//            }
//        ]);
//        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
//        $spaycs->limit($limit);
//        if(!empty($request['keyword'])) {
//            $spaycs->where(["LOWER(Spaycs.name) LIKE"=>"%".strtolower($request['keyword'])."%"]);
//        }
//        print_R($spaycs);die;
//        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId) {
//            return $results->map(function ($row) use($userId) {
//                $totalJoined = [];
//                if(!empty($row['joined_spayc'])) {
//                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
//                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.'].status');
//                }
//                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:null;
//                $row['is_joined'] = !empty($status[0])?true:false;
//                $row['joined_users'] = !empty($row['joined_spayc'])?count($totalJoined):0;
//                unset($row['joined_spayc']);
//                if(!empty($row['subscribed_users'])) {
//                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
//                }
//                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):0;
//                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
//                return $row;
//            });
//        });
//        
//        $page = (!empty($request['page']) && is_numeric($request['page']))?$request['page']:1;
//        if($page < 0) {
//            $page = $page*-1;
//            $spaycs->page($page);
//        } else {
//            $spaycs->page($page);
//        }
//        $newQuery = clone $spaycs;
//        $data['count'] = $newQuery->count();
//        $data['records'] = [];
//        if($spaycs->count()) {
//            $data['records'] = $spaycs->toArray();
//        }
//        return $data;
//        
    $end_date = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");   
           if(!empty($request['latitude']) && !empty($request['longitude'])) {
            //To search by kilometers instead of miles, replace 3959 with 6371.
              $distanceField = '( 3959 * ACOS( COS( RADIANS(:latitude) ) *
                COS( RADIANS(  latitude ) ) *
                COS( RADIANS(  longitude ) - RADIANS(:longitude) ) +
                SIN( RADIANS(:latitude) ) *
                SIN( RADIANS(  latitude ) ) ) )';
            $distance=  $this->distance($request['latitude'], $request['longitude'], $request['latitude2'], $request['longitude2']); 
    
            $spaycs = $this->find()
                ->select([
                    'distance' => $distanceField, 'id', 'name', 'location', 'matrix_room_id', 'start_date', 'end_date', 'image', 'type', 'group_type', 'passcode','latitude','longitude'])
                ->where(["$distanceField <=" => $distance, 'status'=>'Active',
                    'Spaycs.group_type !='=>'trusted_private', 
                    'Spaycs.parent_id IS'=>null
                    ])
//                    ->where(["end_date >="=>$date])
                ->bind(':latitude', $request['latitude'], 'float')
                ->bind(':longitude', $request['longitude'], 'float');
            
        if(isset($request['start_date']) && $request['start_date'] && isset($request['end_date']) && $request['end_date']) {
            $d1 = new \Cake\I18n\Time($request['start_date']);
            $startDate = Utils::setUtc($d1->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $spaycs->where(["Spaycs.start_date >="=>$startDate]);
            
            
            $d2 = new \Cake\I18n\Time($request['end_date']);
            $endDate = Utils::setUtc($d2->format('Y-m-d H:i:s'), Configure::read("timezone"));
            $spaycs->where(["Spaycs.end_date <="=>$endDate]);
        }else{
            $spaycs->where(["end_date >="=>$end_date]);
        }
        
        if(isset($request['spayc_type']) && in_array(ucfirst($request['spayc_type']), ['Event', 'Community'])) {
            $spaycs->where(["Spaycs.type"=>ucfirst($request['spayc_type'])]);
        }
        
        if(isset($request['group_type']) && in_array(ucfirst($request['group_type']), ['Public', 'Private'])) {
            $spaycs->where(["Spaycs.group_type"=>ucfirst($request['group_type'])]);
        }
        }
        $spaycs->contain([
            'JoinedSpayc' => function($q) {
                return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status']);
            },
            'SubscribedUsers' => function($q) {
                return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
            }
        ]);
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
    
    public function distance($lat1, $lon1, $lat2, $lon2) {

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
    return $km;
}
}
