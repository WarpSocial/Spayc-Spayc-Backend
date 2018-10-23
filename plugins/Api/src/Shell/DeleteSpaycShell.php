<?php

namespace Api\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
/**
 * DeleteSpayc shell command.
 */
class DeleteSpaycShell extends Shell {

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main() {
        $now = new Time('now', 'UTC');
        $daysBack = new Time('1 days ago','UTC');
        $this->out('NOW = '.$now->format('Y-m-d H:i:s'));
        $this->out('2 Days Back = '.$daysBack->format('Y-m-d H:i:s'));
        $endDate = "TO_TIMESTAMP(cast(Spaycs.end_date as text),'YYYY-MM-DD HH24:MI')"; 
        $spaycs = TableRegistry::get('Api.Spaycs')->find()
                ->select(['id'])
                ->where([$endDate.' <'=>$daysBack->format('Y-m-d H:i')])->extract('id');
        pr($spaycs->toArray());
        
    }

}
