<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * Purchase Entity
 *
 * @property int $id
 * @property int $plan_id
 * @property string $receipt
 * @property int $promotion_id
 * @property int $advertisement_id
 * @property int $plateform
 * @property \Cake\I18n\FrozenTime $purchase_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Plan $plan
 * @property \Api\Model\Entity\Promotion $promotion
 * @property \Api\Model\Entity\Advertisement $advertisement
 */
class Purchase extends Entity
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
        'plan_id' => true,
        'receipt' => true,
        'promotion_id' => true,
        'advertisement_id' => true,
        'plateform' => true,
        'purchase_date' => true,
        'modified' => true,
        'plan' => true,
        'promotion' => true,
        'advertisement' => true
    ];
}
