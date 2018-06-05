<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\JoinedSpaycTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\JoinedSpaycTable Test Case
 */
class JoinedSpaycTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\JoinedSpaycTable
     */
    public $JoinedSpayc;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.joined_spayc',
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
        $config = TableRegistry::exists('JoinedSpayc') ? [] : ['className' => JoinedSpaycTable::class];
        $this->JoinedSpayc = TableRegistry::get('JoinedSpayc', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JoinedSpayc);

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
