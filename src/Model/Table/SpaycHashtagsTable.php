<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SpaycHashtags Model
 *
 * @property \App\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 * @property \App\Model\Table\HashtagsTable|\Cake\ORM\Association\BelongsTo $Hashtags
 *
 * @method \App\Model\Entity\SpaycHashtag get($primaryKey, $options = [])
 * @method \App\Model\Entity\SpaycHashtag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SpaycHashtag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SpaycHashtag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SpaycHashtag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SpaycHashtag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SpaycHashtag findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SpaycHashtagsTable extends Table
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

        $this->setTable('spayc_hashtags');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'created']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Hashtags', [
            'foreignKey' => 'hashtag_id',
            'joinType' => 'INNER'
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

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['spayc_id'], 'Spaycs'));
        $rules->add($rules->existsIn(['hashtag_id'], 'Hashtags'));

        return $rules;
    }
}
