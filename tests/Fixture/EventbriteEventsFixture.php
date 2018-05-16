<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventbriteEventsFixture
 *
 */
class EventbriteEventsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'autoIncrement' => true, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'eventbrite_event_id' => ['type' => 'biginteger', 'length' => 20, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => false, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'location' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => 'venue name, address obj, city, region, postalCode, country', 'precision' => null, 'fixed' => null],
        'latitude' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'longitude' => ['type' => 'float', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null, 'unsigned' => null],
        'start_date' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => 'eventbrite start_date is inside start obj utc', 'precision' => null],
        'end_date' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => 'eventbrite end_date is inside end obj utc', 'precision' => null],
        'description' => ['type' => 'text', 'length' => null, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null],
        'image' => ['type' => 'string', 'length' => 255, 'default' => null, 'null' => true, 'collate' => null, 'comment' => null, 'precision' => null, 'fixed' => null],
        'category' => ['type' => 'string', 'length' => 255, 'default' => 'NULL::character varying', 'null' => true, 'collate' => null, 'comment' => 'category_id, subcategory_id', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => false, 'comment' => null, 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'default' => null, 'null' => true, 'comment' => null, 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id', 'eventbrite_event_id', 'created'], 'length' => []],
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
            'eventbrite_event_id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'location' => 'Lorem ipsum dolor sit amet',
            'latitude' => 1,
            'longitude' => 1,
            'start_date' => 1524470318,
            'end_date' => 1524470318,
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'image' => 'Lorem ipsum dolor sit amet',
            'category' => 'Lorem ipsum dolor sit amet',
            'created' => 1524470318,
            'modified' => 1524470318
        ],
    ];
}
