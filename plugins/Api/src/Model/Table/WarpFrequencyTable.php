<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Validation\Validator;

/**
 * WarpFrequency Model
 *
 * @property \Api\Model\Table\SpaycsTable|\Cake\ORM\Association\BelongsTo $Spaycs
 *
 * @method \Api\Model\Entity\WarpFrequency get($primaryKey, $options = [])
 * @method \Api\Model\Entity\WarpFrequency newEntity($data = null, array $options = [])
 * @method \Api\Model\Entity\WarpFrequency[] newEntities(array $data, array $options = [])
 * @method \Api\Model\Entity\WarpFrequency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Api\Model\Entity\WarpFrequency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Api\Model\Entity\WarpFrequency[] patchEntities($entities, array $data, array $options = [])
 * @method \Api\Model\Entity\WarpFrequency findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WarpFrequencyTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('warp_frequency');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Spaycs', [
            'foreignKey' => 'spayc_id',
            'joinType' => 'INNER',
            'className' => 'Api.Spaycs'
        ]);
    }
    
    /**
     * saveWarpFrequency method to create new freaquency for a warp 
     * 
     */
    public function saveWarpFrequency($request,$spayc){
        $data = [
            'spayc_id'=>$spayc->id,
            'start_date'=>$spayc->start_date,
            'end_date'=>$spayc->end_date,
            'repeat_type'=> $request['repeat_type']
        ];
        switch($request['repeat_type']){
            case 2://weekly
                foreach(explode(',',$request['day_of_week']) as $day){
                    $wpData[] = $data+['day_of_week'=>$day];
                }
                break;
            case 3://monthly
                foreach(explode(',',$request['repeat_date']) as $date){
                    list($month,$day,$year) = explode('-',$date);
                    $wpData[] = $data+['day_of_month'=>$day];
                }
                break;
            case 4://yearly
                foreach(explode(',',$request['repeat_date']) as $date){
                    list($month,$day,$year) = explode('-',$date);
                    $wpData[] = $data+['day_of_month'=>$day,'month_of_year'=>$month];
                }
                break;
            case 5://custom
                foreach(explode(',',$request['repeat_date']) as $date){
                    list($month,$day,$year) = explode('-',$date);
                    $wpData[] = $data+['day_of_month'=>$day,'month_of_year'=>$month,'custom_year'=>$year];
                }
                break;
            case 1://daily
            default:
                $wpData[] = $data;
                break;
        }
        try{
            $this->deleteAll(['spayc_id' => $spayc->id]);
            return $this->saveMany($this->newEntities($wpData));
        } catch (\Exception $ex) {
            \Cake\Log\Log::error('Repeat warp failed to save',$ex->getMessage());
            return false;
        }
        //pr($wpData);die;
        
    }

}
