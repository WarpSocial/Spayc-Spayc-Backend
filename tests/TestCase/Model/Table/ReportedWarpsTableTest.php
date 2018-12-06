<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReportedWarpsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportedWarpsTable Test Case
 */
class ReportedWarpsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ReportedWarpsTable
     */
    public $ReportedWarps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.reported_warps',
        'app.spaycs',
        'app.matrix_rooms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ReportedWarps') ? [] : ['className' => ReportedWarpsTable::class];
        $this->ReportedWarps = TableRegistry::get('ReportedWarps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReportedWarps);

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
