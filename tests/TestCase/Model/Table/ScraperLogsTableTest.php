<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScraperLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ScraperLogsTable Test Case
 */
class ScraperLogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScraperLogsTable
     */
    public $ScraperLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scraper_logs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ScraperLogs') ? [] : ['className' => ScraperLogsTable::class];
        $this->ScraperLogs = TableRegistry::get('ScraperLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScraperLogs);

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
