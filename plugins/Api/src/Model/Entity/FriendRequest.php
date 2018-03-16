<?php
namespace Api\Model\Entity;

use Cake\ORM\Entity;
use Api\Auth\ApiHasher;
/**
 * FriendRequest Entity
 *
 * @property int $id
 * @property int $spayc_id
 * @property int $requested_by
 * @property int $requested_to
 * @property string $requested_status
 * @property string $friend_status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\Spayc $spayc
 */
class FriendRequest extends Entity
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
    
    protected function _getId($id) {      
        return ApiHasher::encrypt($id);
    }
    protected function _getRequestedBy($requested_by) {      
        return (string) $requested_by;
    }
    protected function _getRequestedTo($requested_to) {      
        return (string) $requested_to;
    }
    protected function _getActionBy($action_by) {      
        return (string) $action_by;
    }
}
