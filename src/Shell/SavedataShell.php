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

/**
 * Savedata shell command.
 */
class SavedataShell extends Shell
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

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
        $this->out('Process start at '.$this->currentDateTime());
        $this->saveDataSpaceTable();
        $this->out('Completed at '.$this->currentDateTime());
    }

    public function currentDateTime(){                                        
        return date(DATE_TIME_FORMAT);
    }

    public function saveDataSpaceTable($page=1)
    {       

        // ini_set('max_execution_time', 0);        
        $this->StubhubEvents = TableRegistry::get('StubhubEvents');
        $obj = TableRegistry::get("Users")->find('all', ['conditions' => 
                            ['Users.email' => trim(SCRAPER_EMAIL)],
                            'limit' => '1'
                ])->first();
        $pageLimit=10;
        $token = TableRegistry::get("Api.UserLogs")->findByUserId($obj->id)->select(['plain_token'])->first();  
        $token->plain_token="04d903e2d89fda57517fe4d6e917507effe329bb0ec96365e23671f049e8e96e";
        if(isset($token) && !empty($token)) {

            $url= 'http://172.16.145.210/spayc/api/spaycs.json';             
            $totalRecord = $this->StubhubEvents->find('all')->count();
            $totalPageNumber = round($totalRecord/$pageLimit);        
            $record = $this->StubhubEvents->find('all',['conditions' => 
                            ['StubhubEvents.is_status' => 0],
//                'limit' => $pageLimit
                    ])
                    ->page($page)
                    ->toArray();           
            $getIds=$createSpaceData=[];
            $i=0;
            foreach ($record as $value) {   
                $getIds[] = $value['id'];
                $createSpaceData['name']=$value['name'];
                $createSpaceData['location']=$value['location'];
                $createSpaceData['type']='Event';
                $createSpaceData['group_type']='Public';
                $createSpaceData['start_date']=$value['start_date']->format('m-d-Y H:i:s');
                $createSpaceData['end_date']=$value['start_date']->format('m-d-Y H:i:s');
                $createSpaceData['description']=$value['description'];
                $createSpaceData['image']=$value['image'];
                $createSpaceData['longitude']=$value['longitude'];
                $createSpaceData['latitude']=$value['latitude'];          
                $http = new Client(['headers' => ['token' => $token->plain_token]]);
                $httpResponse = $http->post($url,$createSpaceData);
                $response = json_decode($httpResponse->body,true);
//                if($i%5 == 0) 
//                    sleep(30);
                pr($response);
                $this->out($i);
                if($httpResponse->isOk()){
                    $i++;
                }
            }
//            if($i >=10) { 
//                $query = $this->StubhubEvents->query();
//                $query->update()
//                    ->set(['is_status' => true])
//                    ->where(['id IN' => $getIds])
//                    ->execute();
//                if($page <= 2){
//                if($page <= $totalPageNumber){
//                    $page = $page+1;                    
//                    $this->saveDataSpaceTable($page);
//                    //sleep(110);
//                }
//                }
//            } 
        }
    }
}
