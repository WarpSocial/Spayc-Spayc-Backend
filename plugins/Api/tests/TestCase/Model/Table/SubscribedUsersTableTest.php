<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\SubscribedUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\SubscribedUsersTable Test Case
 */
class SubscribedUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\SubscribedUsersTable
     */
    public $SubscribedUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.subscribed_users',
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
        $config = TableRegistry::exists('SubscribedUsers') ? [] : ['className' => SubscribedUsersTable::class];
        $this->SubscribedUsers = TableRegistry::get('SubscribedUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SubscribedUsers);

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
