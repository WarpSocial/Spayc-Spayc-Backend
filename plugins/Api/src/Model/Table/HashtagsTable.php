<?php
namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Api\Auth\ApiHasher;

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
        $hashTag = $this->find('all', ['fields'=>['Hashtags.id', 'Hashtags.name']]);
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $hashTag->order(['Hashtags.name'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $hashTag->where(['LOWER(Hashtags.name) LIKE'=>"%".strtolower($request['keyword'])."%"]);
        }
        $hashTag->contain([
            'SpaycHashtags'=>function($q) {
                return $q->select(['SpaycHashtags.hashtag_id', 'total_space'=>$q->func()->count('SpaycHashtags.id')])->group(['SpaycHashtags.hashtag_id']);
            }
        ]);
        $hashTag->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $hashId = ApiHasher::decrypt($row->id);
                $row['total_space'] = !empty($row['spayc_hashtags'][0]['total_space'])?$row['spayc_hashtags'][0]['total_space']:0;
                unset($row['spayc_hashtags']);
                return $row;
            });
        });
        
        $page = (!empty($request['page']) && is_numeric($request['page']))?$request['page']:1;
        if($page < 0) {
            $page = $page*-1;
            $hashTag->page($page);
        } else {
            $hashTag->page($page);
        }
        $hashTag->distinct(['Hashtags.name']);
        $data['count'] = $hashTag->count();
        $data['records'] = [];
        if($hashTag->count()) { 
            $data['records'] = $hashTag->toArray();
        }
        return $data;
    }
    
    public function saveHashTags($hashTags = null, $spaycId = null) {
        if(empty($hashTags) || empty($spaycId)) {
            return false;
        }
        preg_match_all('/#([^\s,#]+)/', $hashTags, $matches);
        if(empty($matches[1])) {
            return false;
        }
        $spHashtags = TableRegistry::get('Api.SpaycHashtags');
        foreach($matches[1] as $key=>$hash) {
            $entity = $this->find("all")->select(["id", "name"])->where(['LOWER(name)'=>  strtolower($hash)]);
            if(!$entity->isEmpty()) {
                $items = $entity->first();
            } else {
                $entity = $this->newEntity();
                $data = ['name'=>$hash, 'created'=>date('Y-m-d H:i:s')];
                $items = $this->patchEntity($entity, $data, ['validate'=>false]);
                $this->save($items);
            }
            $spaceHash = $spHashtags->findBySpaycIdAndHashtagId($spaycId, $items->id);
            if($spaceHash->isEmpty()) {
                $spaycHastag['spayc_id'] = $spaycId;
                $spaycHastag['hashtag_id'] = $items->id;
                $spaycHastag['created'] = date('Y-m-d H:i:s');
                $entity = $spHashtags->newEntity();
                $hasItems = $spHashtags->patchEntity($entity, $spaycHastag);
                $spHashtags->save($hasItems);
            }
        }
    }
}
