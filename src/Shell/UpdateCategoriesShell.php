<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Event\Event;
use Cake\Network\Http\Client;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\ScraperComponent;

/**
 * Savedata shell command.
 */
class UpdateCategoriesShell extends Shell
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
    public function main(){
       $this->out('Process start at '.$this->Scraper->currentDateTime());
       $time=UNIQUE_TOKEN;
       $this->Scraper->setScraperLog('Update Scraper Category based on Spayc Category',$time,'UpdateCategoriesShell');
        $response = $this->Scraper->updateScraperCategory();        
       $this->Scraper->updateScraperLog($time);
       $this->out('Process end at '.$this->Scraper->currentDateTime());
    }
}
