<?php
namespace Api\Test\TestCase\Controller\Component;

use Api\Controller\Component\UtilityComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Controller\Component\UtilityComponent Test Case
 */
class UtilityComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Controller\Component\UtilityComponent
     */
    public $Utility;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Utility = new UtilityComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Utility);

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
