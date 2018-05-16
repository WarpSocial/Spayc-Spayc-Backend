<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StubhubEventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StubhubEventsTable Test Case
 */
class StubhubEventsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StubhubEventsTable
     */
    public $StubhubEvents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stubhub_events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('StubhubEvents') ? [] : ['className' => StubhubEventsTable::class];
        $this->StubhubEvents = TableRegistry::get('StubhubEvents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StubhubEvents);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
