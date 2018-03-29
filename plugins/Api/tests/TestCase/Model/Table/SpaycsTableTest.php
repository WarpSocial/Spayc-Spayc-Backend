<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\SpaycsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\SpaycsTable Test Case
 */
class SpaycsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\SpaycsTable
     */
    public $Spaycs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.spaycs',
        'plugin.api.users',
        'plugin.api.user_logs',
        'plugin.api.user_images'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Spaycs') ? [] : ['className' => SpaycsTable::class];
        $this->Spaycs = TableRegistry::get('Spaycs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Spaycs);

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
