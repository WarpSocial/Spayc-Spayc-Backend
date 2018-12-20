<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\UserCategoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\UserCategoryTable Test Case
 */
class UserCategoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\UserCategoryTable
     */
    public $UserCategory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.user_category',
        'plugin.api.users',
        'plugin.api.categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserCategory') ? [] : ['className' => UserCategoryTable::class];
        $this->UserCategory = TableRegistry::get('UserCategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserCategory);

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
