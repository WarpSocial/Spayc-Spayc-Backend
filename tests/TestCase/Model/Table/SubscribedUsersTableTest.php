<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubscribedUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubscribedUsersTable Test Case
 */
class SubscribedUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubscribedUsersTable
     */
    public $SubscribedUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.subscribed_users',
        'app.spaycs',
        'app.users',
        'app.user_logs',
        'app.user_images',
        'app.joined_spayc',
        'app.requestedby',
        'app.requestedto',
        'app.friend_request',
        'app.matrix_rooms',
        'app.roles'
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
