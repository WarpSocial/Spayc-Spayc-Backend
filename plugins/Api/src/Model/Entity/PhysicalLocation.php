<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * PhysicalLocation Entity
 *
 * @property int $id
 * @property int $user_id
 * @property float $current_latitude
 * @property float $current_longitude
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $updated_by
 *
 * @property \Api\Model\Entity\User $user
 */
class PhysicalLocation extends Entity
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
        'current_latitude' => true,
        'current_longitude' => true,
        'modified' => true,
        'updated_by' => true,
        'user' => true,
        'id'=>true
    ];
}
