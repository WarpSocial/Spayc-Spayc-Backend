<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserLogsTable Test Case
 */
class UserLogsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserLogsTable
     */
    public $UserLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_logs',
        'app.users',
        'app.user_images',
        'app.joined_spayc',
        'app.spaycs',
        'app.matrix_rooms',
        'app.subscribed_users',
        'app.requestedby',
        'app.requestedto',
        'app.friend_request',
        'app.roles',
        'app.devices',
        'app.matrix_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserLogs') ? [] : ['className' => UserLogsTable::class];
        $this->UserLogs = TableRegistry::get('UserLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserLogs);

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
