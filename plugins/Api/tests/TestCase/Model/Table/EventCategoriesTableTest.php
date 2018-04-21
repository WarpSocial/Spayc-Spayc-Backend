<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\EventCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\EventCategoriesTable Test Case
 */
class EventCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\EventCategoriesTable
     */
    public $EventCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.event_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('EventCategories') ? [] : ['className' => EventCategoriesTable::class];
        $this->EventCategories = TableRegistry::get('EventCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EventCategories);

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
