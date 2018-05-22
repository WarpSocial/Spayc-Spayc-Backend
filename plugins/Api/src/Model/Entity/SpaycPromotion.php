<?php

namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpaycPromotion Entity
 *
 * @property int $id
 * @property int $promotion_id
 * @property int $spayc_id
 * @property int $priority
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Promotion $promotion
 * @property \Api\Model\Entity\Spayc $spayc
 */
class SpaycPromotion extends Entity {

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
