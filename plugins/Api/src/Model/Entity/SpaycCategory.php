<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpaycCategory Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $lft
 * @property int $right
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\SpaycCategory $parent_spayc_category
 * @property \Api\Model\Entity\SpaycCategory[] $child_spayc_categories
 */
class SpaycCategory extends Entity
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
