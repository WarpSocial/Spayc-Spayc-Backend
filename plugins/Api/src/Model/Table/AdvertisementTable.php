<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Advertisement Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Api\Model\Entity\Advertisement get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Advertisement newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Advertisement[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Advertisement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Advertisement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Advertisement[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Advertisement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdvertisementTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('advertisement');
        $this->setDisplayField('name');
        $this->setPrimaryKey(['id', 'created']);

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
        
//        $this->belongsToMany('Spaycs', [            
//            'className' => 'Api.Spaycs'
//        ]);
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->requirePresence('name', 'create', __('Name key is missing.'))
                ->maxLength('name', 255, 'Name should not exceed more then 255 characters.')
                ->notEmpty('name', __('Spayc name is required.'))
                ->notBlank('name', __('Spayc name is required.'));
//        $validator
//                ->requirePresence('price', 'create', __('Price key is missing.'))
//                ->notEmpty('price', __('Price is required.'));

        $validator
                ->requirePresence('spayc_id', 'create', __('Spayc key is missing.'))
                ->notEmpty('spayc_id', __('Spayc is required.'));

//        $validator
//                ->requirePresence('description', 'create', __('Description key is missing.'))
//                ->maxLength('description', 250, __('Description must be less than 250 characters.'))
//                ->allowEmpty('description');
//
        
        $validator
                ->requirePresence('plan_id', 'create', __('Plan key is missing.'))
                ->notEmpty('plan_id', __('Plan key is required.'));
        
        $validator
                ->requirePresence('receipt', 'create', __('Receipt key is missing.'))
                ->notEmpty('receipt', __('Receipt key is required.'));
        
        $validator
                ->allowEmpty('image')
                ->add('image', 'extension', [
                    'rule' => ['extension', ['jpeg', 'png', 'jpg']],
                    'message' => __('Please select only jpg,jpeg,png.')
                ])
                ->add('image', 'size', [
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

}
