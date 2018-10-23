<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CustomMessagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CustomMessagesTable Test Case
 */
class CustomMessagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CustomMessagesTable
     */
    public $CustomMessages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.custom_messages',
        'app.users',
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
        $config = TableRegistry::exists('CustomMessages') ? [] : ['className' => CustomMessagesTable::class];
        $this->CustomMessages = TableRegistry::get('CustomMessages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomMessages);

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
