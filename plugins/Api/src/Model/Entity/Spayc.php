<?php
namespace Api\Model\Entity;

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
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\User $user
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
        'user_id' => true,
        'name' => true,
        'location' => true,
        'type' => true,
        'group_type' => true,
        'start_date' => true,
        'end_date' => true,
        'passcode' => true,
        'description' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
