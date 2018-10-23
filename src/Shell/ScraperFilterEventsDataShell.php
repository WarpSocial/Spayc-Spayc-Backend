<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\ScraperComponent;

/**
 * ScraperFilterEventsData shell command.
 */
class ScraperFilterEventsDataShell extends Shell
{

    public function initialize() {
        $this->Scraper = new ScraperComponent(new ComponentRegistry());
    }

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

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */

    /*** Filter common events based on same lat-long,date and Name ***/ 
    public function main() {
        $time=UNIQUE_TOKEN;
        $this->Scraper->setScraperLog('Filter Events by LatLong/date/name',$time,'ScraperFilterEventsDataShell');
        $this->out('Process start at '.$this->Scraper->currentDateTime());       
        $response = $this->Scraper->filterByLatLong();
        if($response)
        $response = $this->Scraper->filterByDate(SCRAPERUNIQUEFILTER);
        if($response)
        $response = $this->Scraper->filterByDate(SCRAPERCOMMONDATEFILTER);
        if($response)
         $response = $this->Scraper->filterByName();
        $this->out('Process end at '.$this->Scraper->currentDateTime());
        $this->Scraper->updateScraperLog($time);
    }
}
