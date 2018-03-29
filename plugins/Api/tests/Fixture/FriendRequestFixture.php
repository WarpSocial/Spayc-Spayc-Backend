<?php
namespace Api\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FriendRequestFixture
 *
 */
class FriendRequestFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'friend_request';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'spayc_id' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_by' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_to' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_status' => ['type' => 'string', 'length' => null, 'default' => 'Requested', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'friend_status' => ['type' => 'string', 'length' => null, 'default' => 'Friend', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'spayc_id' => 1,
            'requested_by' => 1,
            'requested_to' => 1,
            'requested_status' => 'Lorem ipsum dolor sit amet',
            'friend_status' => 'Lorem ipsum dolor sit amet',
            'created' => 1515669148,
            'modified' => 1515669148
        ],
    ];
}
