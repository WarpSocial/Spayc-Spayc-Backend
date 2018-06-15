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
class failureRecordsShell extends Shell
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
        $data=$this->Scraper->failureRecords();
        if(!empty($data)){
            foreach($data as $val){
                $this->Scraper->updateScraperLog($val['unique_time']);
                $this->dispatchShell($val['shell']);
            }
        }
        
        $data=$this->Scraper->failureRecords();
        if(!empty($data)){
            foreach($data as $val){
                // Mail function Here
            }
        }
        
    }
}
