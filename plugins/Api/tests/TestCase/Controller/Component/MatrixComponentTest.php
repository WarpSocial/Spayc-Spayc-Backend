<?php
namespace Api\Test\TestCase\Controller\Component;

use Api\Controller\Component\MatrixComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * Api\Controller\Component\MatrixComponent Test Case
 */
class MatrixComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Api\Controller\Component\MatrixComponent
     */
    public $Matrix;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Matrix = new MatrixComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Matrix);

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
