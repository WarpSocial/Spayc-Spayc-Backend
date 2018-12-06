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
            'dependent' => true,
            'className' => 'Spaycs',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('SubSpaycs', [
            'dependent' => true,
            'className' => 'Spaycs',
            'foreignKey' => 'parent_id'
            
        ]);
        $this->hasMany('JoinedSpayc', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'JoinedSpayc'
        ]);
        $this->hasMany('SpamReports', [
            'foreignKey' => 'spayc_id',
            'className' => 'SpamReports'
        ]);
        $this->hasMany('ReportedWarps', [
            'foreignKey' => 'spayc_id',
            'className' => 'ReportedWarps'
        ]);
        $this->hasMany('SubscribedUsers', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'SubscribedUsers'
        ]);
        $this->belongsTo('SpaycCategories', [
            'foreignKey' => 'spayc_category_id',
            'joinType' => 'LEFT',
            'className' => 'Api.SpaycCategories'            
        ]);
        $this->hasMany('Comments', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'className' => 'Comments'
        ]);
        $this->hasMany('SpaycHashtags', [
            'dependent' => true,
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'SpaycHashtags'
        ]);
        
         $this->belongsToMany('Advertisements', [
            'joinTable' => 'spayc_advertisement',            
            'className' => 'Advertisements'
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
        $this->FRIEND_REQUESTED_STATUS_ARR = unserialize(FRIEND_REQUESTED_STATUS_ARR);
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

    public function getWarpsCreatedNJoinedByUser($userId, $listBy){
        $friend = TableRegistry::get('Api.FriendRequest')->getFriendIdsByUserId($userId, $this->FRIEND_REQUESTED_STATUS_ARR['accepted']);
        $spaycs = $this->find();
        $spaycs->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date', 'Spaycs.status','Spaycs.spayc_category_id'])
            ->where(['Spaycs.group_type !='=>'trusted_private','Spaycs.parent_id IS'=>null]);
            if($listBy == JOINED){
                $spaycs->where(['Spaycs.id IN'=>$this->joinedSpayc($userId)]);
            } else if($listBy == CREATED) {
                $spaycs->where(['Spaycs.id IN'=>$this->createdSpayc($userId)]);
            }
            $spaycs->contain([
                 'JoinedSpayc' => function($q) {
                     return $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status','JoinedSpayc.distance'])->where(['JoinedSpayc.status'=>JOINED]);
                 },               
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                },
                'Comments' => function($q) {
                    return $q->select(['Comments.spayc_id', 'Comments.comment']);
                },
                'SpaycCategories' => function($q) {
                    return $q->select(['SpaycCategories.id', 'SpaycCategories.name','SpaycCategories.code']);
                }
            ]);
        if($listBy == JOINED){
            $ids = TableRegistry::get("Api.JoinedSpayc")->getJoinedSpaycIds($userId);
            $spaycs->where(['Spaycs.id IN'=>$ids]);
        } else if($listBy == CREATED) {
            $spaycs->where(['Spaycs.user_id'=>$userId]);
        }
        $spaycs->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend,$userId){
            return $results->map(function ($row) use($friend,$userId) {
                $row['friends'] = TableRegistry::get('JoinedSpayc')->getTotalJoinedFriends($row->id, $friend);
                 $present= 0;$totalJoined=[];
                if(!empty($row['joined_spayc'])) {
                    $status = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.'].status');                
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }                
                $row['joined_spayc_status'] = !empty($status[0])?$status[0]:'';

                $row['is_joined'] = !empty($status[0])?true:false;
                $row['joined_users'] =  !empty($row['joined_spayc'])?count($totalJoined):BLANK_COUNT;
                unset($row['joined_spayc']);
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):BLANK_COUNT;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['comment'])?$row['comments'][0]['comment']:BLANK_COUNT;
                unset($row['comments']);
                $row['total_presents'] = $present;
                return $row;
            });
        });
        return $spaycs;
    }


    public function getWarpMembers($spaycId){
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
    public function joinedSpayc($userId){
        $jsRepo = TableRegistry::get('JoinedSpayc');
        return $jsRepo->find()->select(['spayc_id'])
                ->distinct()->where(['JoinedSpayc.status'=>JOINED,'JoinedSpayc.user_id'=>$userId]);
    }

    public function createdSpayc($userId){
        $jsRepo = TableRegistry::get('JoinedSpayc');
        return $jsRepo->find()->select(['spayc_id'])
                ->distinct()->where(['JoinedSpayc.status'=>JOINED,'JoinedSpayc.user_id'=>$userId,'JoinedSpayc.is_admin'=>SUPERADMIN]);
    }

    public function getWarpList(){
        $query = $this->find();
        $query->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.spayc_category_id','Users.display_name','Spaycs.status'])
            ->order(['Spaycs.created'=>'DESC'])    
            ->where(['Spaycs.parent_id IS'=>null,'Spaycs.group_type !='=>'trusted_private'])
            ->contain([
                'Users' => function($q) {
                        return  $q->select(['Users.display_name']);
                },
                'SubSpaycs' => function($q) {                    
                        return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'SubSpaycs.location', 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.matrix_room_id']);
                },
                'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin','JoinedSpayc.distance']);//joinded
                },
                'JoinedSpayc.Users' => function($q) {
                        return  $q->select(['Users.id','Users.display_name','Users.email']);//joinded
                },
                'JoinedSpayc.Users.UserImages'=>function($q) {
                return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
                },                
                'Comments' => function($q) {
                    return $q->select(['Comments.spayc_id', 'Comments.comment']);
                },
                'SubscribedUsers' => function($q) {
                    return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                },
                'ReportedWarps' => function($q) {
                    return $q->select(['ReportedWarps.id','ReportedWarps.spayc_id', 'ReportedWarps.reported_by']);
                }
        ]
        
        );       
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {   
               

                $row['spayc_admin'] = TableRegistry::get('Users')->get($row->user_id)->display_name;
                $present = 0;$totalJoined=$totalAdmin=[];
                if(!empty($row['joined_spayc'])) {                   
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'   {n}[status=Joined].status');
                    $totalAdmin = \Cake\Utility\Hash::extract($row['joined_spayc'],'{*}[status=Joined],[is_admin > 0]');
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{*}[status=Joined],[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }                 
                $row['total_spayc_admin'] = $totalAdmin;
                $row['joined_users'] =!empty($row['joined_spayc'])?count($totalJoined):BLANK_COUNT;
                $row['total_subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):BLANK_COUNT;   
                $row['total_subspaycs'] = !empty($row['sub_spaycs'])?count($row['sub_spaycs']):BLANK_COUNT;                               
                $row['total_comments'] = !empty($row['comments'][0]['comment'])?$row['comments'][0]['comment']:BLANK_COUNT;
                $row['total_presents'] = $present;
                unset($row['comments']);
                unset($row['subscribed_users']);
                unset($row['sub_spaycs']);
                return $row;
            });
        });
        return $query;
    }

    public function getSubwarpsListBySpaycId($spaycId = null) {
        $spayc = $this->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.parent_id','Spaycs.created','Spaycs.modified','Spaycs.status'])
            ->where(['id'=>$spaycId, 'Spaycs.group_type !=' =>'trusted_private'])
            ->contain([
                'SubSpaycs' => function($q) {
                $exp = $q->newExpr()->addCase($q->newExpr()->add(['location IS NULL']),"");
                    return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'location'=>$exp, 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id','SubSpaycs.status']);
                }
            ])->order(['created'=>'DESC']);
        $spayc = $spayc->first();     
        return $spayc;   
    }
    public function getWarpsViewBySpaycId($spaycId, $userId, $friend) {
        $spayc = $this->find();
        $spayc->select(['Spaycs.id', 'Spaycs.name','Spaycs.user_id', 'Spaycs.location', 'Spaycs.image', 'Spaycs.description', 'Spaycs.group_type', 'Spaycs.type','Spaycs.start_date','Spaycs.end_date','Spaycs.passcode','Spaycs.matrix_room_id','Spaycs.parent_id','Spaycs.created','Spaycs.modified','Spaycs.status', 'Spaycs.spayc_category_id'])
                ->where(['Spaycs.id'=>$spaycId, 'Spaycs.group_type !=' =>'trusted_private'])
                ->contain([
                    'SubSpaycs' => function($q) {
                    $exp = $q->newExpr()->addCase($q->newExpr()->add(['location IS NULL']),"");
                        return  $q->select(['SubSpaycs.id','SubSpaycs.parent_id', 'SubSpaycs.name', 'location'=>$exp, 'SubSpaycs.image', 'SubSpaycs.description', 'SubSpaycs.group_type', 'SubSpaycs.type','SubSpaycs.start_date','SubSpaycs.end_date','SubSpaycs.passcode','SubSpaycs.description','SubSpaycs.matrix_room_id', 'SubSpaycs.status','SubSpaycs.spayc_category_id']);
                    },
                    'JoinedSpayc' => function($q) {
                        return  $q->select(['JoinedSpayc.id','JoinedSpayc.spayc_id','JoinedSpayc.user_id', 'JoinedSpayc.status', 'JoinedSpayc.is_admin','JoinedSpayc.distance']);//joinded
                    },
                    'JoinedSpayc.Users' => function($q) {
                            return  $q->select(['Users.id','Users.display_name','Users.email']);//joinded
                    },
                    'JoinedSpayc.Users.UserImages'=>function($q) {
                    return $q->select(['UserImages.user_id', 'UserImages.image_url', 'UserImages.is_profile'])->where(['UserImages.is_profile'=>'Yes']);
                    },                    
                    'Comments' => function($q) {
                        return $q->select(['Comments.spayc_id', 'Comments.comment']);
                    },                            
                    'SubscribedUsers' => function($q) {
                        return $q->select(['SubscribedUsers.spayc_id', 'SubscribedUsers.user_id']);
                    },
                    'SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name','SpaycCategories.code']);
                    },
                    'SubSpaycs.SpaycCategories' => function($q) {
                        return $q->select(['SpaycCategories.id', 'SpaycCategories.name','SpaycCategories.code']);
                    }
                ]);
        $spayc->order(['Spaycs.created'=>'DESC']); 
        $spayc->formatResults(function (\Cake\Collection\CollectionInterface $results) use($friend, $userId) {
            return $results->map(function ($row) use($friend, $userId) {                
                $row['friends'] = TableRegistry::get('JoinedSpayc')->getTotalJoinedFriends($row->id, $friend);
                $present = 0;$totalJoined=$totalAdmin=[];
                if(!empty($row['joined_spayc'])) {
                    $joinedStatus = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[user_id='.$userId.']');
                    $totalAdmin = \Cake\Utility\Hash::extract($row['joined_spayc'],'{*}[status=Joined],[is_admin > 0]');
                    $totalJoined = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[status=Joined].status');
                    $miles = Configure::read('miles');
                    $physicalPresent = \Cake\Utility\Hash::extract($row['joined_spayc'],'{n}[distance <='.$miles.']');
                    $present = count($physicalPresent);
                }
                $row['total_spayc_admin'] = $totalAdmin;
                if(!empty($joinedStatus[0])){
                    $row['joined_spayc_status'] = $joinedStatus[0]['status'];
                    $row['is_admin'] = $joinedStatus[0]['is_admin'];
                }else{
                    $row['joined_spayc_status'] = '';
                    $row['is_admin'] = '';
                }
                $row['joined_users'] =!empty($row['joined_spayc'])?count($totalJoined):BLANK_COUNT;
                if(!empty($row['subscribed_users'])) {
                    $subUserId = \Cake\Utility\Hash::extract($row['subscribed_users'],'{n}[user_id='.$userId.']');
                }
                $row['subscribed_users'] = !empty($row['subscribed_users'])?count($row['subscribed_users']):BLANK_COUNT;
                $row['is_subscribed'] = !empty($subUserId[0])?true:false;
                $row['total_comments'] = !empty($row['comments'][0]['comment'])?$row['comments'][0]['comment']:BLANK_COUNT;
                unset($row['joined_spayc']);
                $row['total_presents'] = $present;
                return $row;
            });
        });

        return $spayc->first();
    }

    public function spaycObj($spaycId) {
        $entity = $this->find()
                ->where(['id'=>$spaycId])
                ->contain([
                    'SubSpaycs'=>function($q){
                        return $q->select(['id','name','image','matrix_room_id','parent_id']);
                    },
                    'SubSpaycs.JoinedSpayc'=>function($q){
                        return $q->select(['id','spayc_id','user_id']);
                    },'SubSpaycs.JoinedSpayc.Users'=>function($q){
                        return $q->select(['id','display_name','email','matrix_access_token','matrix_user_id']);
                    },   
                    'JoinedSpayc'=>function($q){
                        return $q->select(['id','spayc_id','user_id']);
                    },
                    'JoinedSpayc.Users'=>function($q){
                        return $q->select(['id','display_name','email','matrix_access_token','matrix_user_id']);
                    },   
                ]);
        $spayc = $entity->first();
        return $spayc;
    }
    public function deleteAllSpaycObj($child) {
        if(!empty($child)){
        TableRegistry::get('Api.JoinedSpayc')->deleteAll(['spayc_id IN' => $child]);
        TableRegistry::get('Api.SubscribedUsers')->deleteAll(['spayc_id IN' => $child]);
        TableRegistry::get('Api.SpaycHashtags')->deleteAll(['spayc_id IN' => $child]);
        TableRegistry::get('Api.SpaycAdvertisement')->deleteAll(['spayc_id IN' => $child]);
         $ids = TableRegistry::get('Api.Promotions')->find()
                 ->select(['id'])
                 ->where(['spayc_id IN' => $child]);
        TableRegistry::get('Api.SpaycPromotion')->deleteAll(['promotion_id IN' => $ids]);
        TableRegistry::get('Api.Promotions')->deleteAll(['spayc_id IN' => $child]);
        }
    }
    public function reportedWarpUsers($spaycId){ 
        $query = TableRegistry::get('Users')->find();
        $query->innerJoinWith('ReportedWarps',function($q) {
            $q->select(['user_id'=>'ReportedWarps.reported_by','ReportedWarps.spayc_id']);     
            $q->innerJoinWith('Spaycs',function($qq) {
                $qq->select(['Spaycs.user_id','Spaycs.id','Spaycs.parent_id'])->where(['Spaycs.group_type !=' =>'trusted_private','Spaycs.parent_id IS'=>null]); 
                return $qq;                        
            });      
            return $q;
        });
        $query->where(['ReportedWarps.spayc_id'=> $spaycId]);
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
