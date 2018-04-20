<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\SpaycCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\SpaycCategoriesTable Test Case
 */
class SpaycCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\SpaycCategoriesTable
     */
    public $SpaycCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('SpaycCategories') ? [] : ['className' => SpaycCategoriesTable::class];
        $this->SpaycCategories = TableRegistry::get('SpaycCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SpaycCategories);

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
