<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TicketmasterEventsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TicketmasterEventsTable Test Case
 */
class TicketmasterEventsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TicketmasterEventsTable
     */
    public $TicketmasterEvents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ticketmaster_events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('TicketmasterEvents') ? [] : ['className' => TicketmasterEventsTable::class];
        $this->TicketmasterEvents = TableRegistry::get('TicketmasterEvents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TicketmasterEvents);

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
