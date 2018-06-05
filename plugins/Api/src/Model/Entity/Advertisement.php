<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Time;
use Cake\Core\Configure;
/**
 * Advertisement Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property float $price
 * @property string $description
 * @property string $url
 * @property string $image
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\User $user
 */
class Advertisement extends Entity
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
        'price' => true,
        'description' => true,
        'url' => true,
        'image' => true,
        'status' => true,
        'modified' => true,
        'user' => true
    ];
    
     protected function _getExpired($date) {
        $request = new \Cake\Http\ServerRequest();
         if($this->isNew() || strstr($request->getRequestTarget(),'edit')) {
             return $date;
         }
        $timezone = Configure::read('timezone');
        if (!empty($date)) {
            $ed = new Time($date,'UTC');
            return $ed->setTimezone($timezone)->format('m-d-Y H:i:s');
        } else {
            return;
        }
    }
}
