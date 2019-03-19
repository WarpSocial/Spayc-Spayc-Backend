<?php

namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Time;
use Cake\Core\Configure;
/**
 * WarpFrequency Entity
 *
 * @property int $id
 * @property int $spayc_id
 * @property int $frequency_type
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property int $day_of_week
 * @property int $day_of_month
 * @property int $week_of_month
 * @property int $month_of_year
 * @property int $custom_year
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Spayc $spayc
 */
class WarpFrequency extends Entity {

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
    protected $_hidden = ['created','modified'];
    protected function _getStartDate($stardDate) {
        $timezone = Configure::read('timezone');
        if (!empty($stardDate)) {
            $sd = new Time($stardDate,'UTC');
            return $sd->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }
    protected function _getEndDate($endDate) {
        $timezone = Configure::read('timezone');
        if (!empty($endDate)) {
            $ed = new Time($endDate,'UTC');
            return $ed->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }

}
