<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserCategory Model
 *
 * @property \Api\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Api\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \Api\Model\Entity\UserCategory get($primaryKey, $options = [])
 * @method \Api\Model\Entity\UserCategory newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\UserCategory[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\UserCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\UserCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\UserCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\UserCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserCategoryTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('user_category');
        $this->setDisplayField('id');
       $this->primaryKey(['user_id', 'category_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Api.Users'
        ]);
        $this->belongsTo('SpaycCategories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
            'className' => 'Api.SpaycCategories'
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
                ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['category_id'], 'SpaycCategories'));

        return $rules;
    }

    /**
     * userCategoreis
     */
    public function userCategories($users){
        if(is_array($users)){
            $condition = ['user_id IN'=>$users];
        }else{
            $condition = ['user_id'=>$users];
        }
        return $this->find()->where($condition);
    }
    
    public function listCategories($users){ 
        $userCategories = [];
        if(empty($users)){
            return false;
        }
        $categories = $this->userCategories($users);
        if(!$categories->isEmpty()){
            foreach($categories as $cat){
                $userCategories[$cat->user_id][] = $cat->category_id;
            }
        }
        return $userCategories;    
    }
   
}
