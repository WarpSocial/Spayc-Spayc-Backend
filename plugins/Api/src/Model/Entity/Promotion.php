<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * Promotion Entity
 *
 * @property int $id
 * @property int $spayc_id
 * @property float $views
 * @property float $balanced_views
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Spayc $spayc
 */
class Promotion extends Entity
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
        'spayc_id' => true,
        'views' => true,
        'balanced_views' => true,
        'status' => true,
        'modified' => true,
        'spayc' => true
    ];
}
