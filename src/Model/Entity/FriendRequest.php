<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FriendRequest Entity
 *
 * @property int $id
 * @property int $requested_by
 * @property int $requested_to
 * @property string $requested_status
 * @property string $friend_status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $matrix_room_id
 * @property int $blocked_by
 * @property int $action_by
 *
 * @property \App\Model\Entity\MatrixRoom $matrix_room
 */
class FriendRequest extends Entity
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
