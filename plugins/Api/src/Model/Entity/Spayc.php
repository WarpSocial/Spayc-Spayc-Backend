<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Api\Auth\ApiHasher;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Event\Event;
/**
 * Spayc Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $location
 * @property string $type
 * @property string $group_type
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property string $passcode
 * @property string $description
 * @property string $status
 * @property string $image
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\User $user
 */
class Spayc extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    
    protected function _getId($id) {      
        return ApiHasher::encrypt($id);
    }
    
    protected function _setStartDate($stardDate) {
        
        $timezone = Configure::read('timezone');
        if (!empty($stardDate)) {
            $startdate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$stardDate,$timezone);
            #pr($startdate->setTimezone('UTC')->format("Y-m-d H:i:s"));die;
            return $startdate->setTimezone('UTC')->format("Y-m-d H:i:s");
        } else {
            return;
        }
    }
    protected function _setEndDate($endDate) {
        $timezone = Configure::read('timezone');
        if (!empty($endDate)) {
            $endDate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$endDate,$timezone);
            return $endDate->setTimezone('UTC')->format("Y-m-d H:i:s");
        } else {
            return;
        }
    }
    protected function _getStartDate($stardDate) {
        $request = new \Cake\Http\ServerRequest();
         if($this->isNew() || strstr($request->getRequestTarget(),'edit')) { die("dkls");
             return $stardDate;
         }
        $timezone = Configure::read('timezone');
        if (!empty($stardDate)) {
            $sd = new Time($stardDate,'UTC');
            return $sd->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }
    protected function _getEndDate($endDate) {
        $request = new \Cake\Http\ServerRequest();
         if($this->isNew() || strstr($request->getRequestTarget(),'edit')) {
             return $endDate;
         }
        $timezone = Configure::read('timezone');
        if (!empty($endDate)) {
            $ed = new Time($endDate,'UTC');
            return $ed->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }
}
