<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FriendRequestTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FriendRequestTable Test Case
 */
class FriendRequestTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FriendRequestTable
     */
    public $FriendRequest;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.friend_request',
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
