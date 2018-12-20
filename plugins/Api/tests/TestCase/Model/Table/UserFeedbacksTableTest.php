<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\UserFeedbacksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\UserFeedbacksTable Test Case
 */
class UserFeedbacksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\UserFeedbacksTable
     */
    public $UserFeedbacks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.user_feedbacks',
        'plugin.api.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserFeedbacks') ? [] : ['className' => UserFeedbacksTable::class];
        $this->UserFeedbacks = TableRegistry::get('UserFeedbacks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserFeedbacks);

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
