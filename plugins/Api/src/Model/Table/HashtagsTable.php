<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Hashtags Model
 *
 * @method \Api\Model\Entity\Hashtag get($primaryKey, $options = [])
 * @method \Api\Model\Entity\Hashtag newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\Hashtag[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\Hashtag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\Hashtag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\Hashtag[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\Hashtag findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HashtagsTable extends Table
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

        $this->setTable('hashtags');
        $this->setDisplayField('name');
        $this->setPrimaryKey(['id']);

        $this->addBehavior('Timestamp');
        $this->hasMany('SpaycHashtags', [
            'foreignKey' => 'hashtag_id',
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
    
    public function searchHashtags($request = []) {
        $hashTag = $this->find('all', ['fields'=>['Hashtags.id', 'Hashtags.name', 'Hashtags.created', 'Hashtags.modified']])
        ->contain([
            'SpaycHashtags' => function($q) {
                return $q->select(['SpaycHashtags.hashtag_id', 'total_spayc' => $q->func()->count('SpaycHashtags.hashtag_id')])->group(['SpaycHashtags.hashtag_id']);
            }
        ])
        ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $row->total_space = !empty($row['spayc_hashtags'][0]['total_spayc'])? $row['spayc_hashtags'][0]['total_spayc']:0;
                unset($row['spayc_hashtags']);
                return $row;
            });
        });
        $limit = is_numeric($request['limit'])?$request['limit']:5;
        $hashTag->order(['Hashtags.name'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $hashTag->where(['Hashtags.name LIKE'=>"%".$request['keyword']."%"]);
        }
        $page = is_numeric($request['page'])?$request['page']:1;
        if($page < 0) {
            $page = $page*-1;
            $hashTag->page($page);
        } else {
            $hashTag->page($page);
        }
        $data['count'] = $hashTag->count();
        $data['records'] = [];
        if($hashTag->count()) { 
            $data['records'] = $hashTag->toArray();
        }
        return $data;
    }
}
