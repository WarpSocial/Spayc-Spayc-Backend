<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * SpaycAdvertisement Entity
 *
 * @property int $id
 * @property int $advertisement_id
 * @property int $spayc_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Advertisement $advertisement
 * @property \Api\Model\Entity\Spayc $spayc
 */
class SpaycAdvertisement extends Entity
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
        'advertisement_id' => true,
        'spayc_id' => true,
        'modified' => true,
        'advertisement' => true,
        'spayc' => true
    ];
}
