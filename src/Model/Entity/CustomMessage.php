<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomMessage Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string $event_id
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Event $event
 */
class CustomMessage extends Entity
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
        'message' => true,
        'event_id' => true,
        'status' => true,
        'modified' => true,
        'user' => true,
        'event' => true
    ];
}
