<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Api\Auth\ApiHasher;
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
 * @property \Api\Model\Entity\User $user
 * @property \Api\Model\Entity\Device $device
 * @property \Api\Model\Entity\MatrixUser $matrix_user
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
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
    
    protected function _getId($id) {  
        return ApiHasher::encrypt($id);
    }
}
