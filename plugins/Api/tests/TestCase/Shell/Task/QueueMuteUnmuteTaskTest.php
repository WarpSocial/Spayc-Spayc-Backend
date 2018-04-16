<?php
namespace Api\Test\TestCase\Shell\Task;

use Api\Shell\Task\QueueMuteUnmuteTask;
use Cake\TestSuite\TestCase;

/**
 * Api\Shell\Task\QueueMuteUnmuteTask Test Case
 */
class QueueMuteUnmuteTaskTest extends TestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \Api\Shell\Task\QueueMuteUnmuteTask
     */
    public $QueueMuteUnmute;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();

        $this->QueueMuteUnmute = $this->getMockBuilder('Api\Shell\Task\QueueMuteUnmuteTask')
            ->setConstructorArgs([$this->io])
            ->getMock();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QueueMuteUnmute);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
