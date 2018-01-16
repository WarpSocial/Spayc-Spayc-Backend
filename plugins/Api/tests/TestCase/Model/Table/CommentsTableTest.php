<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\CommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\CommentsTable Test Case
 */
class CommentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\CommentsTable
     */
    public $Comments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.comments',
        'plugin.api.spaycs',
        'plugin.api.users',
        'plugin.api.user_logs',
        'plugin.api.user_images',
        'plugin.api.joined_spayc',
        'plugin.api.subscribed_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Comments') ? [] : ['className' => CommentsTable::class];
        $this->Comments = TableRegistry::get('Comments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Comments);

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
