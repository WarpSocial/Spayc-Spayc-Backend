<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserImagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserImagesTable Test Case
 */
class UserImagesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserImagesTable
     */
    public $UserImages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_images',
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
