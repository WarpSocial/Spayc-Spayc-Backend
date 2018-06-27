<?php
namespace Api\Test\TestCase\Controller\Component;

use Api\Controller\Component\RedisComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Controller\Component\RedisComponent Test Case
 */
class RedisComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Controller\Component\RedisComponent
     */
    public $Redis;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Redis = new RedisComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Redis);

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
