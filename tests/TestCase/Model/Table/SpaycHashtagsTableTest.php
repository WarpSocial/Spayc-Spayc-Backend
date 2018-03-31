<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SpaycHashtagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SpaycHashtagsTable Test Case
 */
class SpaycHashtagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SpaycHashtagsTable
     */
    public $SpaycHashtags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.spayc_hashtags',
        'app.spaycs',
        'app.users',
        'app.user_logs',
        'app.user_images',
        'app.joined_spayc',
        'app.subscribed_users',
        'app.requestedby',
        'app.requestedto',
        'app.friend_request',
        'app.matrix_rooms',
        'app.roles',
        'app.hashtags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SpaycHashtags') ? [] : ['className' => SpaycHashtagsTable::class];
        $this->SpaycHashtags = TableRegistry::get('SpaycHashtags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SpaycHashtags);

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
