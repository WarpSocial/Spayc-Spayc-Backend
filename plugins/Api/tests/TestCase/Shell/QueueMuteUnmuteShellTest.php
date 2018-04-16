<?php
namespace Api\Test\TestCase\Shell;

use Api\Shell\QueueMuteUnmuteShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * Api\Shell\QueueMuteUnmuteShell Test Case
 */
class QueueMuteUnmuteShellTest extends ConsoleIntegrationTestCase
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
     * @var \Api\Shell\QueueMuteUnmuteShell
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
        $this->QueueMuteUnmute = new QueueMuteUnmuteShell($this->io);
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
