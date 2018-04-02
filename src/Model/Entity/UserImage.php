<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserImage Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $image_url
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $is_profile
 * @property int $order_index
 *
 * @property \App\Model\Entity\User $user
 */
class UserImage extends Entity
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
