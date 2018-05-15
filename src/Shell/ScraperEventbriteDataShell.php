<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\ScraperComponent;

/**
 * ScraperEventbriteData shell command.
 */
class ScraperEventbriteDataShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    public function initialize() {
        $this->Scraper = new ScraperComponent(new ComponentRegistry());
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */

    /*** save events current date to 14days from Eventbrite API ***/ 
    public function main() {
        $this->out('Process start at '.$this->Scraper->currentDateTime());
        $this->Scraper->getEventbriteData(1);
        $this->out('Process end at '.$this->Scraper->currentDateTime());
    }
}
