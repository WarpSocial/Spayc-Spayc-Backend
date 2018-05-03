<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StubhubEvent Entity
 *
 * @property int $id
 * @property int $stubhub_event_id
 * @property string $name
 * @property string $location
 * @property float $latitude
 * @property float $longitude
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime $end_date
 * @property string $description
 * @property string $image
 * @property string $category
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\StubhubEvent $stubhub_event
 */
class StubhubEvent extends Entity
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
        '*' => true
    ];
}
