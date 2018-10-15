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
use Cake\Utility\Hash;
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
        $this->belongsTo('SpaycCategories', [
            'foreignKey' => 'spayc_category_id',
            'joinType' => 'LEFT',
            'className' => 'Api.SpaycCategories'
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
        $this->belongsToMany('Promotions', [
            'foreignKey' => 'spayc_id',
            'targetForeignKey' => 'promotion_id',
            'joinTable' => 'spayc_promotion',
            'className' => 'Api.Promotions'
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
                ->notEmpty('name',__('Warp name is required.'));

        $validator
                ->maxLength('location', 255,__('Location test is too long.'))
                ->requirePresence('location', 'create',__('Location key is missing.'))
                ->notEmpty('location',__('Location is required field.'));
                // ->regex('location','/[\w\s]+$/',__('Location must be alpha numeric only.'));

        $validator
                ->requirePresence('type', 'create',__('Type key is missing.'))
                ->notEmpty('type',__('Type is required field.'),function($context){
                    if($context['newRecord']){
                        return true;
                    }else{
                        return false;
                    }
                })
                ->inList('type', Configure::read('spayctype'),__('Type value must be any one '.implode(',',Configure::read('spayctype')).'.')) ; 
                
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
                                $startDate = strtotime($startDate->format('Y-m-d H:i'));
                                $now = strtotime($now->format('Y-m-d H:i'));
                                $currentDate = strtotime($currentDate->format('Y-m-d H:i'));
                                return (bool) ($startDate <= $currentDate);
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
                ->requirePresence('spayc_category_id', 'create',__('Please select warp category.'))
                ->notEmpty('spayc_category_id',__('Please select category.'))
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
                ->notEmpty('name',__('Warp name is required.'))
                ->notBlank('name',__('Warp name is required.'));

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
                    'distance' => $distance, 'Spaycs.id', 'Spaycs.name', 'Spaycs.location', 'Spaycs.matrix_room_id', 'Spaycs.start_date', 'Spaycs.end_date', 'Spaycs.image', 'Spaycs.type', 'Spaycs.group_type', 'Spaycs.passcode','Spaycs.spayc_category_id'])
                ->where(['Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
               ->contain([
                    'JoinedSpayc' => function($q) {
                        return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status'])->where(['JoinedSpayc.status'=>'Joined']);
                    },
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
                    }
                ])
                ->order(['distance'=>'ASC','Spaycs.created'=>'DESC']);
                $bannedSpayc = $this->bannedSpayc($userId);    
                if(!empty($bannedSpayc)){
                    $spaycs->where(function (QueryExpression $exp, Query $q)use($bannedSpayc) {
                        return $exp->notIn('Spaycs.id', $bannedSpayc);
                     });
                }
        
        if(!empty($request['keyword'])) {
            $spaycs->where(["LOWER(Spaycs.name) LIKE"=>"%".strtolower($request['keyword'])."%"]);
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
        $query->select(['Users.id', 'Users.username','Users.display_name', 'Users.email','Users.matrix_user_id','JoinedSpayc.status']);
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
                return $q->select(['JoinedSpayc.user_id','JoinedSpayc.spayc_id','JoinedSpayc.status','JoinedSpayc.is_admin','JoinedSpayc.distance','JoinedSpayc.updated_by'])->where($condition)->order(['JoinedSpayc.created'=>'DESC']);;
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
    
    
    public function getNearBySpaycsOnMap_back($request = [], $userId=null) {
        $now = new Time('now', Configure::read('timezone'));
        $endObj = clone $now;
        $now->modify('today');
        $endObj->modify('+15 days');
        $endObj->modify('1 second ago'); 
        $today_date = $now->setTimezone('UTC')->format("Y-m-d H:i");
        $twoWeek = $endObj->setTimezone('UTC')->format("Y-m-d H:i");  
   
   
            //To search by kilometers instead of miles, replace 3959 with 6371.
              $distanceField = '( 3959 * ACOS( COS( RADIANS(:latitude) ) *
                COS( RADIANS(  latitude ) ) *
                COS( RADIANS(  longitude ) - RADIANS(:longitude) ) +
                SIN( RADIANS(:latitude) ) *
                SIN( RADIANS(  latitude ) ) ) )';
            $distance=  $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']); 
    $distance = $request['radius'];
            $spaycs = $this->find()
                ->select(['distance' => $distanceField,'id', 'name', 'matrix_room_id', 'image', 'type', 'modified', 'spayc_category_id','latitude','longitude',"score"=>"(case when website = 0 then 1 else 0 end)"])
                ->where(["$distanceField <=" => $distance, 'Spaycs.status'=>'Active',
                    'Spaycs.group_type !='=>'trusted_private', 
                    'Spaycs.parent_id IS'=>null
                    ])
                ->bind(':latitude', $request['center_latitude'], 'float')
                ->bind(':longitude', $request['center_longitude'], 'float');
        $period = null;
        if(!empty($request['time'])){
            $period = strtolower($request['time']);
        }
        
        $startDate = "TO_TIMESTAMP(cast(Spaycs.start_date as text),'YYYY-MM-DD HH24:MI')";
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD HH24:MI')";  
        $spaycs->where([
                'OR'=>[[$startDate.' >='=>$today_date],[$endDate.' >= '=>$today_date]]
                ]);
            $spaycs->where([
                'OR'=>[[$startDate.' <='=>$twoWeek],[$endDate.' <= '=>$twoWeek]]
                ]);
         
        if(isset($request['spayc_type']) && $request['spayc_type']) {
            $spayc_type = explode("|",ucfirst($request['spayc_type']));
            $spaycs->where(["Spaycs.type IN "=>$spayc_type]);
        }
       
        if(isset($request['group_type']) && $request['group_type']) {
            $group_type = explode("|",ucfirst($request['group_type']));
            $spaycs->where(["Spaycs.group_type IN "=>$group_type]);
        }
        
        if(isset($request['category_id'])) {
            $spaycs->where(['Spaycs.spayc_category_id in ('.$request['category_id'].')']);
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
            'SpaycCategories' => function($q) {
                return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
            }        
        ]);
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId) {
            return $results->map(function ($row) use($userId) {
                $totalJoined = [];
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
        #$spaycs->order(['Spaycs.id'=>'DESC']);
//        $spaycs->group('distance HAVING distance > 0');
        $spaycs->order(['score'=>'DESC','distance'=>'ASC','start_date'=>'ASC']);
        
        $spaycs->limit(MAP_LIMIT);
        $spaycs->groupBy('spaycs.id');
        
        $data['count'] = $spaycs->count();
        $data['records'] = [];
        //$spaycs->cache('map_warp', 'redis');
        $data['records'] = $spaycs;
        return $data;
    }
    public function getNearBySpaycsOnMap($request = [], $userId=null) {
        $now = new Time('now', Configure::read('timezone'));
        $endObj = clone $now;
        $now->modify('today');
        $endObj->modify('+15 days');
        $endObj->modify('1 second ago'); 
        $today_date = $now->setTimezone('UTC')->format("Y-m-d H:i");
        $twoWeek = $endObj->setTimezone('UTC')->format("Y-m-d H:i");          
        
        if (empty($request['radius'])) {
            $radius = $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']);
        } else {
            $radius = $request['radius'];
        }
//        $radius = $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']);
        $redis = new RedisComponent(new ComponentRegistry());
        $redisSpaycs = $redis->getGeoLocation('Spaycs',$request['center_latitude'], $request['center_longitude'], $radius);
        if(empty($redisSpaycs)){
            return ['count'=>0,'records'=>[]];
        }
        $requiredSpaycs = array_column($redisSpaycs,'id');
        $spaycs = $this->find()
                ->select(['id', 'name', 'matrix_room_id', 'image', 'type', 'modified', 'spayc_category_id','latitude','longitude','score'=>'website'])
                ->where(['Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null,'Spaycs.id IN'=>$requiredSpaycs]);
        $period = null;
        if(!empty($request['datetime'])){
            $period = strtolower($request['time']);
        }
        
        $startDate = "TO_TIMESTAMP(cast(Spaycs.start_date as text),'YYYY-MM-DD HH24:MI')";
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD HH24:MI')";  
        $spaycs->where([
                'OR'=>[[$startDate.' >='=>$today_date],[$endDate.' >= '=>$today_date]]
                ]);
            $spaycs->where([
                'OR'=>[[$startDate.' <='=>$twoWeek],[$endDate.' <= '=>$twoWeek]]
                ]);
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
        
        if(isset($request['category_id'])) {
            $spaycs->where(['Spaycs.spayc_category_id in ('.$request['category_id'].')']);
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
            'SpaycCategories' => function($q) {
                return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
            }        
        ]);
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId,$redisSpaycs) {
            return $results->map(function ($row) use($userId,$redisSpaycs) {
                $totalJoined = [];
                $row->distance = $redisSpaycs[$row->id]['distance'];//Hash::extract($redisSpaycs,'{n}[id='.$row->id.']')[0]['distance'];
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
        #$spaycs->order(['Spaycs.id'=>'DESC']);
//        $spaycs->group('distance HAVING distance > 0');
        $spaycs->order(['score'=>'DESC']);
        
        $spaycs->limit(MAP_LIMIT);
        //$spaycs->groupBy('spaycs.id');
        return ['count'=>$spaycs->count(),'records'=>$spaycs];
    }
    
    public function mapEvents($request = [], $userId=null) {
        $now = new Time('now', Configure::read('timezone'));
        $endObj = clone $now;
        $endObj->modify('+2 Week');
        $today_date = $now->setTimezone('UTC')->format("Y-m-d H:i");
        $twoWeek = $endObj->setTimezone('UTC')->format("Y-m-d H:i");
        $startDate = "TO_TIMESTAMP(cast(Spaycs.start_date as text),'YYYY-MM-DD HH24:MI')";
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD HH24:MI')";  
        
        //To search by kilometers instead of miles, replace 3959 with 6371.
        $distanceField = '( 3959 * ACOS( COS( RADIANS(:latitude) ) *
            COS( RADIANS(  latitude ) ) *
            COS( RADIANS(  longitude ) - RADIANS(:longitude) ) +
            SIN( RADIANS(:latitude) ) *
            SIN( RADIANS(  latitude ) ) ) )';
        $distance=  $this->distance($request['center_latitude'], $request['center_longitude'], $request['endpoint_latitude'], $request['endpoint_longitude']); 
    
        $spaycs = $this->find()
                ->select(['id', 'name', 'matrix_room_id', 'image','type','modified','spayc_category_id','latitude','longitude'])
                ->where(["$distanceField <=" => $distance, 'Spaycs.status'=>'Active','Spaycs.group_type !='=>'trusted_private', 'Spaycs.parent_id IS'=>null])
                ->bind(':latitude', $request['center_latitude'], 'float')
                ->bind(':longitude', $request['center_longitude'], 'float');
        
        if(!empty($request['current_date'])){
            $user_date = Time::createFromTimestamp($request['current_date'], Configure::read('timezone'));
            $endObj = clone $user_date;
            $user_date->modify('today');
            $endObj->modify('+15 days');
            $endObj->modify('1 second ago'); 
            $today_date = $user_date->setTimezone('UTC')->format("Y-m-d H:i");
            $twoWeek = $endObj->setTimezone('UTC')->format("Y-m-d H:i");  
        }
        $spaycs->where([
            'OR'=>[[$startDate.' >='=>$today_date],[$endDate.' >= '=>$today_date]]
           ]);
        $spaycs->where([
            'OR'=>[[$startDate.' <='=>$twoWeek],[$endDate.' <= '=>$twoWeek]]
            ]);
        if(isset($request['spayc_type']) && $request['spayc_type']) {
            $spayc_type = explode("|",ucfirst($request['spayc_type']));
            $spaycs->where(["Spaycs.type IN "=>$spayc_type]);
        }
        if(!empty($request['payment_type'])) {
            if(strtolower($request['payment_type']) == strtolower(FREE)){
                $spaycs->where(["LOWER(Spaycs.payment_type)"=> strtolower($request['payment_type'])]);
            }
        }
        
        if(isset($request['spayc_type']) && $request['spayc_type']) {
            $spayc_type = explode("|",ucfirst($request['spayc_type']));
            $spaycs->where(["Spaycs.type IN "=>$spayc_type]);
        }
        if(isset($request['group_type']) && $request['group_type']) {
            $group_type = explode("|",ucfirst($request['group_type']));
            $spaycs->where(["Spaycs.group_type IN "=>$group_type]);
        }
        
        if(isset($request['category_id'])) {
            $spaycs->where(['Spaycs.spayc_category_id in ('.$request['category_id'].')']);
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
            'SpaycCategories' => function($q) {
                return $q->select(['SpaycCategories.id', 'SpaycCategories.name']);
            }        
        ]);
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($userId) {
            return $results->map(function ($row) use($userId) {
                $totalJoined = [];
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
        #$spaycs->order(['Spaycs.id'=>'DESC']);
        $spaycs->distinct('spaycs.id');
        
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
            return ['id'=>$spaycId];
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

}
