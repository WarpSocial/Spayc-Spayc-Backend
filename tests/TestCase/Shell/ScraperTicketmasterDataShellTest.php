<?php
namespace App\Test\TestCase\Shell;

use App\Shell\ScraperTicketmasterDataShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\ScraperTicketmasterDataShell Test Case
 */
class ScraperTicketmasterDataShellTest extends ConsoleIntegrationTestCase
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
     * @var \App\Shell\ScraperTicketmasterDataShell
     */
    public $ScraperTicketmasterData;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->ScraperTicketmasterData = new ScraperTicketmasterDataShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScraperTicketmasterData);

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
