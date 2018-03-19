<?php

namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Api\Auth\ApiHasher;
use Cake\I18n\Time;
use Cake\Core\Configure;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int $requested_by
 * @property int $requested_to
 * @property string $notification_type
 * @property string $status
 * @property string $message
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $date_time
 * @property int $spayc_id
 *
 * @property \Api\Model\Entity\Spayc $spayc
 */
class Notification extends Entity {

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

    protected function _getDateTime($date) {
        $request = new \Cake\Http\ServerRequest();
        if($this->isNew() || strstr($request->getRequestTarget(),'edit')) {
             return $date;
         }
        $timezone = Configure::read('timezone');
        if (!empty($date)) {
            $sd = new Time($date, 'UTC');
            return $sd->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }

    protected function _setDateTime($datetime) {
        $timezone = Configure::read('timezone');
        if (!empty($datetime)) {
            $datetime = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s', $datetime, $timezone);
            return $datetime->setTimezone('UTC')->format("Y-m-d H:i:s");
        } else {
            return;
        }
    }

//    protected function _setDateTime($datetime) {
//        $timezone = Configure::read('timezone');
//        if (!empty($datetime)) {
//            $startdate = \Cake\I18n\Time::createFromFormat('m-d-Y H:i:s',$datetime,$timezone);
//            return $startdate->setTimezone('UTC')->format("Y-m-d H:i:s");
//        } else {
//            return;
//        }
//    }
}
