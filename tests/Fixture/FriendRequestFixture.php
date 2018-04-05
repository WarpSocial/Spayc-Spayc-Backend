<?php
namespace App\Test\Fixture;

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
        'id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_by' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_to' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'requested_status' => ['type' => 'string', 'length' => 15, 'default' => 'Requested', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'friend_status' => ['type' => 'string', 'length' => 15, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'matrix_room_id' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'blocked_by' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'action_by' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_indexes' => [
            'friend_request_created_idx' => ['type' => 'index', 'columns' => ['created'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'requested_by', 'requested_to', 'created'], 'length' => []],
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
            'requested_by' => 1,
            'requested_to' => 1,
            'requested_status' => 'Lorem ipsum d',
            'friend_status' => 'Lorem ipsum d',
            'created' => 1521818107,
            'modified' => 1521818107,
            'matrix_room_id' => 'Lorem ipsum dolor sit amet',
            'blocked_by' => 1,
            'action_by' => 1
        ],
    ];
}
