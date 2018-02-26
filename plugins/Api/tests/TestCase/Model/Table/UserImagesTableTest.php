<?php
namespace Api\Test\TestCase\Model\Table;

use Api\Model\Table\UserImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Model\Table\UserImagesTable Test Case
 */
class UserImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Model\Table\UserImagesTable
     */
    public $UserImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.api.user_images',
        'plugin.api.users',
        'plugin.api.user_logs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserImages') ? [] : ['className' => UserImagesTable::class];
        $this->UserImages = TableRegistry::get('UserImages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserImages);

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
