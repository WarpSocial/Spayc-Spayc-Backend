<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $gender
 * @property \Cake\I18n\FrozenDate $dob
 * @property string $phone
 * @property string $status
 * @property string $website_url
 * @property string $address
 * @property string $bio_data
 * @property string $fb_id
 * @property string $fb_access_key
 * @property float $longitude
 * @property float $latitude
 * @property string $timezone
 * @property string $matrix_user_id
 * @property string $matrix_access_token
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $token_verification
 * @property string $forgot_password_token
 * @property \Cake\I18n\FrozenTime $forgot_password_timestamp
 * @property string $country_code
 * @property string $is_notify
 * @property float $current_latitude
 * @property float $current_longitude
 * @property int $role_id
 *
 * @property \App\Model\Entity\Fb $fb
 * @property \App\Model\Entity\MatrixUser $matrix_user
 * @property \App\Model\Entity\Role $role
 */
class User extends Entity
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
        'username' => true,
        'email' => true,
        'password' => true,
        'gender' => true,
        'dob' => true,
        'phone' => true,
        'status' => true,
        'website_url' => true,
        'address' => true,
        'bio_data' => true,
        'fb_id' => true,
        'fb_access_key' => true,
        'longitude' => true,
        'latitude' => true,
        'timezone' => true,
        'matrix_user_id' => true,
        'matrix_access_token' => true,
        'modified' => true,
        'token_verification' => true,
        'forgot_password_token' => true,
        'forgot_password_timestamp' => true,
        'country_code' => true,
        'is_notify' => true,
        'current_latitude' => true,
        'current_longitude' => true,
        'role_id' => true,
        'fb' => true,
        'matrix_user' => true,
        'role' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
