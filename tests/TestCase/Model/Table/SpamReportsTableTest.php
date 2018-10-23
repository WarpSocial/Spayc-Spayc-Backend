<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpamReportsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpamReportsTable Test Case
 */
class SpamReportsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpamReportsTable
     */
    public $SpamReports;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.spam_reports',
        'app.spaycs',
        'app.events'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SpamReports') ? [] : ['className' => SpamReportsTable::class];
        $this->SpamReports = TableRegistry::get('SpamReports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SpamReports);

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
