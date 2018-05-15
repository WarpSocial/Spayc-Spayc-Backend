<?php
namespace App\Test\TestCase\Shell;

use App\Shell\ScraperFilterEventsDataShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\ScraperFilterEventsDataShell Test Case
 */
class ScraperFilterEventsDataShellTest extends ConsoleIntegrationTestCase
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
     * @var \App\Shell\ScraperFilterEventsDataShell
     */
    public $ScraperFilterEventsData;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->ScraperFilterEventsData = new ScraperFilterEventsDataShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScraperFilterEventsData);

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
