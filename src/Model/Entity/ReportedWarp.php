<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReportedWarp Entity
 *
 * @property int $id
 * @property int $spayc_id
 * @property string $matrix_room_id
 * @property int $reported_by
 * @property string $message
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Spayc $spayc
 * @property \App\Model\Entity\MatrixRoom $matrix_room
 */
class ReportedWarp extends Entity
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
        'matrix_room_id' => true,
        'reported_by' => true,
        'message' => true,
        'modified' => true,
        'spayc' => true,
        'matrix_room' => true
    ];
}
