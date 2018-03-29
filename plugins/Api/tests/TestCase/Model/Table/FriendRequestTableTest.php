<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\FriendRequestTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\FriendRequestTable Test Case
 */
class FriendRequestTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\FriendRequestTable
     */
    public $FriendRequest;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.friend_request',
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
        $config = TableRegistry::exists('FriendRequest') ? [] : ['className' => FriendRequestTable::class];
        $this->FriendRequest = TableRegistry::get('FriendRequest', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FriendRequest);

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
