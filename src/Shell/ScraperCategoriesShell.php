<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\ScraperComponent;

/**
 * ScraperCategories shell command.
 */
class ScraperCategoriesShell extends Shell
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
    
    /*** save categories,subcategories from Eventbrite and Ticketmaster API ***/
    public function main()
    {
        $this->out('Process start at '.$this->Scraper->currentDateTime());
        $time=UNIQUE_TOKEN;
        $this->Scraper->setScraperLog('Scraping Eventbrite and TicketMaster Categories',$time,'ScraperCategories');
        $response = $this->Scraper->getEventBriteCategories(1, NULL,'categories',$time);
        if($response)
        $response = $this->Scraper->getEventBriteCategories(1, NULL,'subcategories',$time);
        if($response)
        $response = $this->Scraper->getTicketmasterCategories($time);
        $this->Scraper->updateScraperLog($time);
        $this->out('Process end at '.$this->Scraper->currentDateTime());
    }
     public function maina()
    {
         $this->out("asd");
     }
}
