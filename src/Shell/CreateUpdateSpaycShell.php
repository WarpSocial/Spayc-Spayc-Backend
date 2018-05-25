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
class CreateUpdateSpaycShell extends Shell
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
    public function main()
    {
        $this->out($this->OptionParser->help());
        $time=UNIQUE_TOKEN;
        $this->Scraper->setScraperLog('Create and Update Spayc',$time);
        $this->out('Process start at '.$this->Scraper->currentDateTime());
         $response = $this->Scraper->saveDataSpaceTable();
        $this->out('Response - '.$response);
         $this->Scraper->updateScraperLog($time);
        $this->out('Completed at '.$this->Scraper->currentDateTime());
    }
}
