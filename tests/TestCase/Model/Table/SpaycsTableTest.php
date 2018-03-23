<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpaycsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpaycsTable Test Case
 */
class SpaycsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpaycsTable
     */
    public $Spaycs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.spaycs',
        'app.users',
        'app.user_logs',
        'app.user_images',
        'app.joined_spayc',
        'app.subscribed_users',
        'app.requestedby',
        'app.requestedto',
        'app.friend_request',
        'app.roles',
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
