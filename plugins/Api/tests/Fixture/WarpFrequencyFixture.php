<?php
namespace Api\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WarpFrequencyFixture
 *
 */
class WarpFrequencyFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'warp_frequency';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'spayc_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'frequency_type' => ['type' => 'integer', 'length' => 10, 'default' => '1', 'null' => false, 'comment' => '1=>Daily,2=>Weekly,3=>Monthly,4=>Yearly,5=>Custom', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'start_date' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'end_date' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        'day_of_week' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => 'When frequenty type is weekly', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'day_of_month' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => 'When frequenty type is monthly', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'week_of_month' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => 'When frequenty type is monthly,yearly,custom. But not required', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'month_of_year' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => 'When frequenty type is yearly and custom', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'custom_year' => ['type' => 'integer', 'length' => 10, 'default' => null, 'null' => true, 'comment' => 'When frequenty type is custom', 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'warp_frequency_created_idx' => ['type' => 'index', 'columns' => ['created'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'created'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'spayc_id' => 1,
                'frequency_type' => 1,
                'start_date' => 1552029243,
                'end_date' => 1552029243,
                'day_of_week' => 1,
                'day_of_month' => 1,
                'week_of_month' => 1,
                'month_of_year' => 1,
                'custom_year' => 1,
                'created' => 1552029243,
                'modified' => 1552029243
            ],
        ];
        parent::init();
    }
}
