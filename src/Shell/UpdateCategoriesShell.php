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
    public function main()
    {
       $this->out('Process start at '.$this->currentDateTime());
        $response = $this->Scraper->updateScraperCategory();
//        if($response)
//        $response = $this->Scraper->getEventBriteCategories(1, NULL,'subcategories');
//        if($response)
//        $response = $this->Scraper->getTicketmasterCategories();
        $this->out('Process end at '.$this->currentDateTime());
    }

    public function currentDateTime(){                                        
        return date(DATE_TIME_FORMAT);
    }

    
   
    
    public function createSpayc($plain_token) {
          
        // Should be Removed
          $pageLimit=10; 
        //        $plain_token="04d903e2d89fda57517fe4d6e917507effe329bb0ec96365e23671f049e8e96e";
              
        
//          $plain_token="8bfa1623f5366cc966add372b5834cfdc52136daac6fe2bb16b4c2893f9dbd3c";
          
          // Should be Removed
          
          
          //Stubhub
          $stubhub_data = $this->StubhubEvents->find('all',
                  [
//                      'conditions' => ['StubhubEvents.is_status' => 0],
                       'limit' => $pageLimit
                    ])
//                    ->page($page)
                    ->toArray();           
//            $this->cURLProcess($stubhub_data,$plain_token,$this->StubhubEvents);
            
            
          //TicketMaster
          $ticketmaster_data = $this->TicketmasterEvents->find('all',
                 [
//                      'conditions' => ['StubhubEvents.is_status' => 0],
                       'limit' => $pageLimit
                    ])
//                    ->page($page)
                    ->toArray();           
//            $this->cURLProcess($ticketmaster_data,$plain_token,$this->TicketmasterEvents);
            
            
            
          //EventbriteEvents
          $eventbrite_data = $this->EventbriteEvents->find('all',
                  [
//                      'conditions' => ['StubhubEvents.is_status' => 0],
                       'limit' => $pageLimit
                    ])
//                    ->page($page)
                    ->toArray();           
            $this->cURLProcess($eventbrite_data,$plain_token, $this->EventbriteEvents);
            
            
            
        
    }
    
    public function cURLProcess($record,$plain_token,$obj){
        $base_url=Configure::read('App.BASE_URL');
          //            $url= 'http://172.16.145.210/spayc/api/spaycs.json';   
//            $url= 'http://spayc-dev.kiwireader.com/api/spaycs.json';  
            $url= $base_url.'api/spaycs.json';  
//            $update_url= 'http://spayc-dev.kiwireader.com/api/spayc-edit.json';  
            $update_url= $base_url.'api/spayc-edit.json';  
          $getIds=$createSpaceData=[];
            $i=0;
            foreach ($record as $value) {
                
                $getIds[] = $value['id'];
                $createSpaceData['name']=$value['name'];
                $createSpaceData['location']=$value['location'];
                $createSpaceData['type']='Event';
                $createSpaceData['group_type']='Public';
                $createSpaceData['start_date']=$value['start_date']->format('m-d-Y H:i:s');
                $date1 = str_replace('-', '/', $createSpaceData['start_date']);
                $next = date('m-d-Y H:i:s',strtotime($date1 . "+1 days"));
                $createSpaceData['end_date']=$next;
                $description=substr($value['description'], 0, 250);
                if($description){
                $createSpaceData['description']=$description;
                }else{
                    $createSpaceData['description']="";
                }
                $createSpaceData['image']=$value['image'];
                $createSpaceData['longitude']=$value['longitude'];
                $createSpaceData['latitude']=$value['latitude'];          
                $http = new Client(['headers' => ['token' => $plain_token]]);
//                print_R($value);die;
                if($value['spayc_id']){ 
                    $createSpaceData['spayc_id']=$value['spayc_id'];     
                    
                    $httpResponse = $http->post($update_url,$createSpaceData);
                    $response = json_decode($httpResponse->body,true);    
                }else{
                    
                    $category=$this->isCatExist($value['category']);
                    
                    //If Category Exist in Spayc
                    if($category){ 
                        $createSpaceData['spayc_category_id']=$category;  
                        $httpResponse = $http->post($url,$createSpaceData);
                        $response = json_decode($httpResponse->body,true); 
                        
                        //Updating Spayc ID in Related tables
                        if($response['status']!='failed'){
                            $update['spayc_id'] = $response['data']['id'];
                            $condition['id'] = $value['id'];
                            $response=$obj->UpdateAll($update, $condition);
                        }
                    }
                    
                }
                
                pr($response);
//                $this->out($i);
//                $this->out($value['id']);
//                if($httpResponse->isOk()){
                    $i++;
//                }
            }
        
            
    }
    
     public function isCatExist($category) {
         $ids=explode(',',$category);
        $obj = TableRegistry::get("scraper_categories")->find('all',
                ['fields' =>['spayc_category_id',]])
                ->where(['scraper_category_id IN '=>$ids,'spayc_category_id IS NOT NULL'])
                ->first();
        if(!empty($obj)){
            return $obj->spayc_category_id;
        }else{
            return false;
        }
    }
}
