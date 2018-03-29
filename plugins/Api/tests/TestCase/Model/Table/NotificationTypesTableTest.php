<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\NotificationTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\NotificationTypesTable Test Case
 */
class NotificationTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\NotificationTypesTable
     */
    public $NotificationTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.notification_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NotificationTypes') ? [] : ['className' => NotificationTypesTable::class];
        $this->NotificationTypes = TableRegistry::get('NotificationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotificationTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
