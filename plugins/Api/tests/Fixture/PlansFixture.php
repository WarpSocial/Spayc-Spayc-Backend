<?php
namespace Api\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlansFixture
 *
 */
class PlansFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'name' => ['type' => 'string', 'length' => 200, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 200, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'amount' => ['type' => 'decimal', 'length' => 7, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 2, 'unsigned' => null],
        'currency' => ['type' => 'string', 'length' => 20, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'views' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'status' => ['type' => 'string', 'length' => null, 'default' => 'Active', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'plans_created_idx' => ['type' => 'index', 'columns' => ['created'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'created'], 'length' => []],
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
            'name' => 'Lorem ipsum dolor sit amet',
            'slug' => 'Lorem ipsum dolor sit amet',
            'amount' => 1.5,
            'currency' => 'Lorem ipsum dolor ',
            'views' => 1,
            'status' => 'Lorem ipsum dolor sit amet',
            'created' => 1524217380,
            'modified' => 1524217380
        ],
    ];
}
