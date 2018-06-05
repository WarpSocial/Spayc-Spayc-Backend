<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\HashtagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\HashtagsTable Test Case
 */
class HashtagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\HashtagsTable
     */
    public $Hashtags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.hashtags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Hashtags') ? [] : ['className' => HashtagsTable::class];
        $this->Hashtags = TableRegistry::get('Hashtags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Hashtags);

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
}
