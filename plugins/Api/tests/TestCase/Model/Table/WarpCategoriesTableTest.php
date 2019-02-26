<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\WarpCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\WarpCategoriesTable Test Case
 */
class WarpCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\WarpCategoriesTable
     */
    public $WarpCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.warp_categories',
        'plugin.api.spaycs',
        'plugin.api.spayc_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WarpCategories') ? [] : ['className' => WarpCategoriesTable::class];
        $this->WarpCategories = TableRegistry::get('WarpCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WarpCategories);

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
