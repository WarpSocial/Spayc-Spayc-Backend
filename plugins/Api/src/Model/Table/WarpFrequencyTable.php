<?php

namespace Api\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Api\Utils\Utils;

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
        if(empty($request['repeaty_type'])){
            return;
        }
        $wpData = $this->eventRepeat($request, $spayc);
        try{
            $this->deleteAll(['spayc_id' => $spayc['id']]);
            return $this->saveMany($this->newEntities($wpData));
        } catch (\Exception $ex) {
            \Cake\Log\Log::error('Repeat warp failed to save',$ex->getMessage());
            return false;
        }
    }
    
    public function eventRepeat($request,$spayc){
        if(empty($request['timezone'])){
            $request['timezone'] = 'America/New_York';
        }
        $startDate = Utils::toUtc($spayc['start_date'],'m-d-Y H:i:s','Y-m-d H:i:s',$request['timezone']);
        $endDate = Utils::toUtc($spayc['end_date'],'m-d-Y H:i:s','Y-m-d H:i:s',$request['timezone']);
        $data = [
            'spayc_id'=>$spayc['id'],
            'end_date'=>$endDate,
            'repeat_type'=> $request['repeat_type']
        ];
        switch($request['repeat_type']){
            case 2://weekly
                $repeatObj = $this->weeklyRepeat($startDate, $endDate, $data,$request);
                break;
            case 3://custom
                $repeatObj = $this->customRepeat($startDate, $endDate, $data,$request);
                break;
            case 1://daily
            default:
                $repeatObj = $this->dailyRepeat($startDate, $endDate, $data,$request);
                break;
        }
        return $repeatObj;
    }
    public function weeklyRepeat($startDate,$endDate,$data,$request){
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $startTime = $startDate->format('H:i:s');
        $interval = new \DateInterval("P1D");
        $period = new \DatePeriod($startDate, $interval, $endDate->modify("+1 days"));
        $repeatDay = explode(',',$request['day_of_week']);
        $wpData = [];
        foreach ($period as $pd) {
            if (in_array($pd->format('w'), $repeatDay)) { 
                $wpData[] = $data+['start_date'=>$pd->format('Y-m-d '.$startTime),'day_of_week'=> $request['day_of_week']];
            }
        }
        return $wpData;
    }
    public function dailyRepeat($startDate,$endDate,$data){
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $startTime = $startDate->format('H:i:s');
        $wpData = [];
        $interval = new \DateInterval("P1D");
        $period = new \DatePeriod($startDate, $interval, $endDate->modify("+1 days"));
        foreach ($period as $pd) {
            $wpData[] = $data+['start_date'=>$pd->format('Y-m-d '.$startTime)];
        }
        return $wpData;
    }   
    public function customRepeat($startDate,$endDate,$data,$request){
        $startDate = new \DateTime($startDate);
        $startTime = $startDate->format('H:i:s');
        $endDate = new \DateTime($endDate);
        $wpData[] = $data+['start_date'=>$startDate->format('Y-m-d H:i:s')];
        foreach(explode(',',$request['repeat_date']) as $date){
            $repeatStartDate = Utils::toUtc($date,'m-d-Y','Y-m-d',$request['timezone']);
            list($month,$day,$year) = explode('-',$date);
            $wpData[] = $data+['start_date'=>$repeatStartDate.' '.$startTime,'day_of_month'=>$day,'month_of_year'=>$month,'custom_year'=>$year];
        }
        return $wpData;
    }
    

}
