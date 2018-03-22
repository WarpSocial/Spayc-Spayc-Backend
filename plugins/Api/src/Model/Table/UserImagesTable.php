<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * UserImages Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\UserImage get($primaryKey, $options = [])
 * @method \Api\Model\Entity\UserImage newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\UserImage[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\UserImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\UserImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\UserImage[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\UserImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserImagesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('user_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('ImgUpload', [
            'field' => 'image_url',
            'uploadPath' => 'profile/',
            'where' => 's3', /* local and s3 */
        ]);
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
                ->notEmpty('image_url', __('Please select profile image.'))
                ->add('image_url', 'extension', [
                    'rule' => ['extension', ['jpeg', 'png', 'jpg']],
                    'message' => __('Please select only jpg,jpeg,png.')
                ])
                ->add('image_url', 'size', [
                    'rule' => function($value,$context){                    
                        if($value['error'] == 0){
                            $sizeLimit =\Cake\Utility\Text::parseFileSize(Configure::read('maxupload'));
                            //$sizeLimit = 2536;//4793432
                            return (bool)($value['size'] <= $sizeLimit );
                        }
                       //$file = new \Cake\Filesystem\File($value['tmp_name'])
                    },
                    'message' => __('Image size must be less than ' . Configure::read('maxupload'). '.')
        ]);
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
    
    public function uploadFacebookImage($imgUrl, $userId) {
        $entity = $this->findByUserIdAndIsProfile($userId, 'Yes');
        if(!$entity->isEmpty()) {
            return false;
        }
        $fileName = $this->facebookImg($imgUrl);
        $data['user_id'] = $userId;
        $data['is_profile'] = 'Yes';
        $data['order_index'] = 1;
        $data['image_url']['tmp_name'] = $fileName;
        $entity = $this->newEntity();
        $items = $this->patchEntity($entity, $data, ['validate'=>false]);
        if($this->save($items)){
           unlink($fileName);
        }
        return $items;
    }
    public function facebookImg($imgUrl){
        $imgFile = parse_url($imgUrl);
        $absImgFile = $imgFile['scheme'].'://'.$imgFile['host'].$imgFile['path'];
        $fileInfo = pathinfo($absImgFile);
        $newImg = TMP.'/facebook_'.time().'.'.$fileInfo['extension'];
        
        file_put_contents($newImg, file_get_contents($imgUrl));
        switch ($fileInfo['extension']) {
            case 'gif' :
                $srcImg = imagecreatefromgif($newImg);
                break;
            case 'png' :
                $srcImg = imagecreatefrompng($newImg);
                break;
            case 'jpg' :
            case 'jpeg' :
                $srcImg = imagecreatefromjpeg($newImg);
                break;
            default :
                $srcImg = $imgUrl;
                break;
        }
        return $newImg;
    }
}
