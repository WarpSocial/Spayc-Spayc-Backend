<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JoinedSpaycTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JoinedSpaycTable Test Case
 */
class JoinedSpaycTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JoinedSpaycTable
     */
    public $JoinedSpayc;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.joined_spayc',
        'app.spaycs',
        'app.users',
        'app.user_logs',
        'app.user_images',
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
