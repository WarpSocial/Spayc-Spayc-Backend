<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AdvertisementTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AdvertisementTable Test Case
 */
class AdvertisementTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AdvertisementTable
     */
    public $Advertisement;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.advertisement',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Advertisement') ? [] : ['className' => AdvertisementTable::class];
        $this->Advertisement = TableRegistry::get('Advertisement', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Advertisement);

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
