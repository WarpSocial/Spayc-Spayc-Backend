<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * Plan Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property float $amount
 * @property string $currency
 * @property int $views
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Plan extends Entity
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
        'name' => true,
        'slug' => true,
        'amount' => true,
        'currency' => true,
        'views' => true,
        'status' => true,
        'modified' => true
    ];
}
