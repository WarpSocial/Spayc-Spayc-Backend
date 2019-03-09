<?php

namespace Api\Model\Entity;

use Cake\ORM\Entity;

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

}
