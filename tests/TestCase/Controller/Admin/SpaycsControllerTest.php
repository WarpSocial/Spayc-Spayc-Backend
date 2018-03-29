<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\SpaycsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\SpaycsController Test Case
 */
class SpaycsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.spaycs',
        'app.users',
        'app.user_logs',
        'app.user_images',
        'app.joined_spayc',
        'app.subscribed_users',
        'app.requestedby',
        'app.requestedto',
        'app.friend_request',
        'app.roles',
        'app.matrix_rooms'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
