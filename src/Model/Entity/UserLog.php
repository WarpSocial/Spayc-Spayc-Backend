<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserLog Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $plain_token
 * @property string $device_id
 * @property string $matrix_access_token
 * @property string $matrix_user_id
 * @property int $login_status
 * @property \Cake\I18n\FrozenTime $last_login
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Device $device
 * @property \App\Model\Entity\MatrixUser $matrix_user
 */
class UserLog extends Entity
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
        'user_id' => true,
        'token' => true,
        'plain_token' => true,
        'device_id' => true,
        'matrix_access_token' => true,
        'matrix_user_id' => true,
        'login_status' => true,
        'last_login' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'device' => true,
        'matrix_user' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
