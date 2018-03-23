<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

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
 * @property string $image
 * @property float $longitude
 * @property float $latitude
 * @property string $status
 * @property string $matrix_room_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $parent_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\MatrixRoom $matrix_room
 * @property \App\Model\Entity\ParentSpayc $parent_spayc
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
}
