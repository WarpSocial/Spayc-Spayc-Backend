<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
                    'rule' => ['fileSize', '<=', \Cake\Core\Configure::read('maxupload')],
                    'message' => __('Image size must be less than ' . \Cake\Core\Configure::read('maxupload') . '.')
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
    
    public function uploadFacebookImage($fileName, $userId) {
        $data['user_id'] = $userId;
        $data['image_url']['tmp_name'] = $fileName;
        $entity = $this->newEntity();
        $items = $this->patchEntity($entity, $data, ['validate'=>false]);
        $this->save($items);
    }

}
