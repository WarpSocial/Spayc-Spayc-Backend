<?php

namespace Api\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property \Cake\I18n\FrozenDate $dob
 * @property string $status
 * @property string $website_url
 * @property string $address
 * @property string $timezone
 * @property string $token_verification
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \Api\Model\Entity\UsersLog[] $users_logs
 */
class User extends Entity {

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
        'first_name' => true,
        'last_name' => true,
        'user_name' => true,
        'email' => true,
        'password' => true,
        'dob' => true,
        'status' => true,
        'website_url' => true,
        'address' => true,
        'timezone' => true,
        'token_verification' => true,
        'created' => true,
        'modified' => true,
        'users_logs' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password) {
        return (new \Cake\Auth\DefaultPasswordHasher())->hash($password);
    }

    protected function _setDob($dob) {
        if (!empty($dob)) {
            return $dob->format("Y-m-d");
        } else {
            return;
        }
    }

    protected function _getDob($dob) {
        if (!empty($dob)) {
            return (new \Cake\I18n\Time($dob))->format("Y-m-d");
        } else {
            return;
        }
    }

}
