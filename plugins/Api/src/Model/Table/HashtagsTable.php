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
        $hashTag = $this->find('all', ['fields'=>['Hashtags.id', 'Hashtags.name', 'Hashtags.created', 'Hashtags.modified']]);
        $limit = (!empty($request['limit']) && is_numeric($request['limit']))?$request['limit']:5;
        $hashTag->order(['Hashtags.name'=>'ASC'])->limit($limit);
        if(!empty($request['keyword'])) {
            $hashTag->where(['LOWER(Hashtags.name) LIKE'=>"%".strtolower($request['keyword'])."%"]);
        }
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
        if(!empty($hashTags) and !empty($spaycId)) {
            preg_match_all('/#([^\s,#]+)/', $hashTags, $matches);
            if(!empty($matches[1])) {
                foreach($matches[1] as $key=>$hash) {
                    $hastag[$key]['name'] = $hash;
                }
            }
            if(empty($hastag)){
                return;
            }
            $entities = $this->newEntities($hastag);
            $this->saveMany($entities);
            if(!empty($entities)) {
                $spaycId = ApiHasher::decrypt($spaycId);
                foreach($entities as $key=>$entity) {
                    $spaycHastag[$key]['spayc_id'] = $spaycId;
                    $spaycHastag[$key]['hashtag_id'] = ApiHasher::decrypt($entity['id']);
                }
                $spHashtags = TableRegistry::get('Api.SpaycHashtags');
                $shEntities = $spHashtags->newEntities($spaycHastag);
                $spHashtags->saveMany($shEntities);
            }
        }
    }
}
