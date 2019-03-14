<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
/**
 * BackgroundJob shell command.
 */
class BackgroundJobShell extends Shell {

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main() {
        $this->out('Moving the category in separate table warp_categories table');
        $warpOjb = TableRegistry::get('Api.Spaycs');
        $warpCat = $warpOjb->find()->select(['spayc_id'=>'id','start_date','end_date']);
        
        $conn = $warpOjb->getConnection();
        $conn->transactional(function ($conn) {
           
        });
        $this->out('All warp categories have been moved successfully');
        
    }

}
