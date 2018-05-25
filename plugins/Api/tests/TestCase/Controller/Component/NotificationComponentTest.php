<?php
namespace Api\Test\TestCase\Controller\Component;

use Api\Controller\Component\NotificationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Controller\Component\NotificationComponent Test Case
 */
class NotificationComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Controller\Component\NotificationComponent
     */
    public $Notification;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Notification = new NotificationComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notification);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
