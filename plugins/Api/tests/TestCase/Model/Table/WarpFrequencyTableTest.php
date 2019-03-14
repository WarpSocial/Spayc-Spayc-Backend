<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\WarpFrequencyTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\WarpFrequencyTable Test Case
 */
class WarpFrequencyTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\WarpFrequencyTable
     */
    public $WarpFrequency;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.warp_frequency',
        'plugin.api.spaycs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WarpFrequency') ? [] : ['className' => WarpFrequencyTable::class];
        $this->WarpFrequency = TableRegistry::get('WarpFrequency', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WarpFrequency);

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
