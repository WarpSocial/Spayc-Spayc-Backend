<?php
namespace Api\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PromotionsFixture
 *
 */
class PromotionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'spayc_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'views' => ['type' => 'decimal', 'length' => 50, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'balanced_views' => ['type' => 'decimal', 'length' => 50, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'amount' => ['type' => 'decimal', 'length' => 7, 'default' => null, 'null' => true, 'comment' => null, 'precision' => 2, 'unsigned' => null],
        'status' => ['type' => 'string', 'length' => null, 'default' => 'Active', 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
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
            'spayc_id' => 1,
            'user_id' => 1,
            'views' => 1.5,
            'balanced_views' => 1.5,
            'amount' => 1.5,
            'status' => 'Lorem ipsum dolor sit amet',
            'created' => 1524459373,
            'modified' => 1524459373
        ],
    ];
}
