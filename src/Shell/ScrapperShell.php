<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\Event\Event;
/**
 * Scrapper shell command.
 */
class ScrapperShell extends Shell
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
        $this->StubhubEvents = TableRegistry::get('StubhubEvents');
        $this->TicketmasterEvents = TableRegistry::get('TicketmasterEvents');
        $this->EventbriteEvents = TableRegistry::get('EventbriteEvents');
        $this->SCRAPER_ROOT_URL = unserialize(SCRAPER_ROOT_URL);
        $this->SCRAPER_ROOT_URL_TOKEN = unserialize(SCRAPER_ROOT_URL_TOKEN);

        $this->out($this->OptionParser->help());
    }

    public function curlRequest($url, $token=false)
    {
        $headers = array('Content-Type: application/json');
        if($token)
        $headers[] ='Authorization: Bearer '.$token;

        $resp='';
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);     
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);   
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);        
        $resp=curl_exec($curl); 
        $resp=json_decode($resp, true);    
        curl_close($curl);
        return $resp;
    }

    public function getEventBriteAllSubcategories($pageNumber=1, $continuation=null, $getSubcategory=[])
    {
        //$url ='https://www.eventbriteapi.com/v3/subcategories/?token=JRTJ7FHW3TG7F5U535RN&page='.$pageNumber;

        $url =$this->SCRAPER_ROOT_URL['eventbriteurl'].'subcategories/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'].'&page='.$pageNumber;
        if($pageNumber >1)
            $url .='&continuation='.$continuation;
           
        $getEventBriteAllSubcategories=$this->curlRequest($url);   
        $getSubcategory =array_merge($getSubcategory,$getEventBriteAllSubcategories['subcategories']);
        if($getEventBriteAllSubcategories['pagination']['has_more_items']){
            $pageNumber=$pageNumber+1;                       
            return $this->getEventBriteAllSubcategories($pageNumber,$getEventBriteAllSubcategories['pagination']['continuation'],$getSubcategory);
        }        
        return $getSubcategory;
    }

    public function getEventbriteData($pageNumber=1)
    { 
       $getSubcategory =$this->getEventBriteAllSubcategories(1);             
       // $url='https://www.eventbriteapi.com/v3/events/search/?location.longitude=-73.935242&start_date.range_start=2018-04-26T00%3A00%3A00&sort_by=-date&token=JRTJ7FHW3TG7F5U535RN&start_date.range_end=2018-05-08T00%3A00%3A00&location.latitude=40.7128';
        $url= $this->SCRAPER_ROOT_URL['eventbriteurl'].'events/search/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'].'&location.latitude=40.7128&location.longitude=-73.935242&sort_by=date&start_date.range_start='.TODAY_DATE.'T00%3A00%3A00&start_date.range_end='.AFTER14DAYS_DATE.'T00%3A00%3A00&page='.$pageNumber;

        $resp=$this->curlRequest($url); 
        if((isset($resp['events']) && !empty($resp['events'])) &&count($resp['events'])){
        $i=0;
        $events = array();
        $eventIds = array();
        foreach ($resp['events'] as $value) {

            $eventIds[]= trim($value['id']);
            $events[$i]['eventbrite_event_id'] = trim($value['id']);
            $events[$i]['name'] = (isset($value['name']['text']) && !empty($value['name']))?trim($value['name']['text']):null;
            $events[$i]['start_date'] = (isset($value['start']['utc']) && !empty($value['start']['utc']))?new time($value['start']['utc']):null;
            $events[$i]['end_date'] =(isset($value['end']['utc']) && !empty($value['end']['utc']))?new time($value['end']['utc']):null;
            $events[$i]['description'] = (isset($value['description']['text']) && !empty($value['description']['text']))?trim($value['description']['text']):null;
            $events[$i]['image'] = (isset($value['logo']['original']['url']) && !empty($value['logo']['original']['url']))?$value['logo']['original']['url']:null;
            $location=$eventsCategory='';
            if(isset($value['venue_id']) && !empty($value['venue_id'])){
               $venueUrl = $this->SCRAPER_ROOT_URL['eventbriteurl'].'venues/'.trim($value['venue_id']).'/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'];
               $venueResp=$this->curlRequest($venueUrl);
               $events[$i]['latitude'] = (isset($venueResp['latitude']) && !empty($venueResp['latitude']))?trim($venueResp['latitude']):null;
               $events[$i]['longitude'] = (isset($venueResp['longitude']) && !empty($venueResp['longitude']))?trim($venueResp['longitude']):null;

                if(isset($venueResp['name']) && !empty($venueResp['name']))
                     $location = $venueResp['name'].',&nbsp;';
                if(isset($venueResp['address']['localized_address_display']) && !empty($venueResp['address']['localized_address_display']))
                    $location .= $venueResp['address']['localized_address_display'].',&nbsp;';
                if(isset($venueResp['address']['country']) && !empty($venueResp['address']['country']))
                    $location .= $venueResp['address']['country'];
            }
            if(isset($value['subcategory_id']) && !empty($value['subcategory_id'])){
               foreach ($getSubcategory as $val) {
                if($val['id']==$value['subcategory_id']){
                    $eventsCategory = $val['parent_category']['name'].',&nbsp;'.$val['name'];
                }
               } 
            }
            $events[$i]['location'] = $location;
            $events[$i]['category'] = $eventsCategory;
            $i++;
        }         
        $getIds = $this->EventbriteEvents->find()->select(['eventbrite_event_id'])->
        where(['eventbrite_event_id IN' => $eventIds])->extract('eventbrite_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);
        if(count($diffIds)){
            $eventbriteEvents = TableRegistry::get('EventbriteEvents');        
            $entities = $eventbriteEvents->newEntities($events);
            $result = $eventbriteEvents->saveMany($entities);
        }
        if($resp['pagination']['has_more_items']){
            $pageNumber=$pageNumber+1;
            $this->getEventbriteData($pageNumber);
        }           
        }        
    }
    
    public function getStubhubData($start=0)
    {
        //$url ='https://api.stubhub.com/search/catalog/events/v3/?city=%22New%20York%22&state=%22NY%22%20|%22New%20York%22&country=US&start=0&rows=20&date=2018-04-26T00:00%20TO%202018-04-27T23:59&sort=eventDateUTC%20asc';       
       
        $url =$this->SCRAPER_ROOT_URL['stubhuburl'].'?city=%22New%20York%22&state=%22NY%22%20|%22New%20York%22&country=US&date='.TODAY_DATE.'T00:00%20TO%20'.AFTER14DAYS_DATE.'T23:59&sort=eventDateUTC%20asc&rows=500&start='.$start;
        $resp=$this->curlRequest($url,$this->SCRAPER_ROOT_URL_TOKEN['stubhubtoken']);
        $eventsCount = count($resp['events']);
        if((isset($resp['events']) && !empty($resp['events'])) && $eventsCount){
        $i=0;
        $events = array();
        foreach ($resp['events'] as $value) {
            $eventIds[]= trim($value['id']);
            $events[$i]['stubhub_event_id'] = trim($value['id']);
            $events[$i]['name'] = (isset($value['name']) && !empty($value['name']))?trim($value['name']):null;
            $events[$i]['start_date'] = (isset($value['eventDateUTC']) && !empty($value['eventDateUTC']))?new time($value['eventDateUTC']):null;
            $events[$i]['end_date'] = null;
            $events[$i]['description'] = (isset($value['description']) && !empty($value['description']))?trim($value['description']):null;
            $events[$i]['latitude'] = (isset($value['venue']['latitude']) && !empty($value['venue']['latitude']))?trim($value['venue']['latitude']):null;
            $events[$i]['longitude'] = (isset($value['venue']['longitude']) && !empty($value['venue']['longitude']))?trim($value['venue']['longitude']):null;
            $events[$i]['image'] = (isset($value['imageUrl']) && !empty($value['imageUrl']))?$value['imageUrl']:null;

           
            if(isset($value['venue']['name']) && !empty($value['venue']['name']))
                $location = trim($value['venue']['name']).',&nbsp;';
            if(isset($value['venue']['address1']) && !empty($value['venue']['address1']))
                $location .= trim($value['venue']['address1']).',&nbsp;';
            if(isset($value['venue']['city']) && !empty($value['venue']['city']))
                $location .= trim($value['venue']['city']).',&nbsp;';
            if(isset($value['venue']['state']) && !empty($value['venue']['state']))
                $location .= trim($value['venue']['state']).',&nbsp;';
            if(isset($value['venue']['postalCode']) && !empty($value['venue']['postalCode']))
                $location .= trim($value['venue']['postalCode']).',&nbsp;';
            if(isset($value['venue']['country']) && !empty($value['venue']['country']))
                $location .= trim($value['venue']['country']);
            

            $events[$i]['location'] = $location;
            $eventsCategory = '';
            if(count($value['categories'])){
                foreach ($value['categories'] as  $val) {                    
                    if(isset($val['name']) && !empty($val['name']))
                        $eventsCategory .= $val['name'].', ';                    
                }
                $eventsCategory= substr($eventsCategory, 0, -2);
            }
            $events[$i]['category'] = $eventsCategory;
            $i++;
        } 
        $getIds = $this->StubhubEvents->find()->select(['stubhub_event_id'])->
        where(['stubhub_event_id IN' => $eventIds])->extract('stubhub_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);
        if(count($diffIds)){            
            $stubhubEvent = TableRegistry::get('StubhubEvents');        
            $entities = $stubhubEvent->newEntities($events);
            $result = $stubhubEvent->saveMany($entities);
        }
        $dataLimit=500;  
        $countNoOfHits=ceil($resp['numFound']/$dataLimit);
        $total = $eventsCount+$start;         
        if($resp['numFound'] > $total){            
            $start = $start+$dataLimit;                  
            if($countNoOfHits > 10){ 
                sleep(6); //Stubhub allows 10 calls per minute
            }
            $this->getStubhubData($start);
        } 
        }
    }

// pass Startdate and endDate as argument 
    public function getTicketmasterData($startDate, $endDate=null)
    {    
        //$url='https://app.ticketmaster.com/discovery/v2/events.json?apikey=FGCdJbUpn9mAmyE9Rlqdi8CYfdhNQMsa&city=%22New%20York%22&stateCode=NY&countryCode=US&page=0&size=200&sort=date,asc&startDateTime=2018-04-24T00:00:00Z&endDateTime=2018-04-24T23:59:00Z';          
        $url=$this->SCRAPER_ROOT_URL['ticketmasterurl'].'?apikey='.$this->SCRAPER_ROOT_URL_TOKEN['ticketmastertoken'].'&city=%22New%20York%22&stateCode=NY&countryCode=US&page=0&size=200&sort=date,asc&startDateTime='.$startDate.'T00:00:00Z&endDateTime='.$startDate.'T23:59:00Z';
        $resp=$this->curlRequest($url);
        if(count($resp['_embedded']['events'])){
        $i=0;
        $events = array();
        $eventIds = array();
        foreach ($resp['_embedded']['events'] as $value) {            
             if(isset($value['dates']['start']['dateTime']) && !empty($value['dates']['start']['dateTime']))
                $startDateTime = new time($value['dates']['start']['dateTime']);
            else
                $startDateTime = new time($value['dates']['start']['localDate']);
            if(($startDateTime < new time(date('Y-m-d', strtotime($startDate . ' +1 day')))) && ($startDateTime >= new time(date('Y-m-d', strtotime($startDate . ' -1 day'))))){
            $eventIds[]=trim($value['id']);
            $events[$i]['ticketmaster_event_id'] = trim($value['id']);
            $events[$i]['name'] = (isset($value['name']) && !empty($value['name']))?trim($value['name']):null;
            $events[$i]['start_date'] = $startDateTime;           
            $events[$i]['description'] = (isset($value['info']) && !empty($value['info']))?trim($value['info']):null;
            $events[$i]['latitude'] = (isset($value['_embedded']['venues']['0']['location']['latitude']) && !empty($value['_embedded']['venues']['0']['location']['latitude']))?trim($value['_embedded']['venues']['0']['location']['latitude']):null;
            $events[$i]['longitude'] = (isset($value['_embedded']['venues']['0']['location']['longitude']) && !empty($value['_embedded']['venues']['0']['location']['longitude']))?trim($value['_embedded']['venues']['0']['location']['longitude']):null;
            $events[$i]['image'] = (isset($value['images']['0']['url']) && !empty($value['images']['0']['url']))?$value['images']['0']['url']:null;

            $location = $value['_embedded']['venues']['0']['name'];
            if(!empty($value['_embedded']['venues']['0']['address']['line1']))
                $location .= ',&nbsp;'.$value['_embedded']['venues']['0']['address']['line1'];
            if(!empty($value['_embedded']['venues']['0']['city']['name']))
                $location .= ',&nbsp;'.$value['_embedded']['venues']['0']['city']['name'];
            if(!empty($value['_embedded']['venues']['0']['state']['name']))
                $location .= ',&nbsp;'.$value['_embedded']['venues']['0']['state']['name'];
            if(!empty($value['_embedded']['venues']['0']['postalCode']))
                $location .= '&nbsp;'.$value['_embedded']['venues']['0']['postalCode'];
            if(!empty($value['_embedded']['venues']['0']['country']['countryCode']))
                $location .= ',&nbsp;'.$value['_embedded']['venues']['0']['country']['countryCode'];            

            $events[$i]['location'] = $location;
            $eventsCategory = [];
            if(!empty($value['classifications']['0']['segment']['name']))
                $eventsCategory[] = $value['classifications']['0']['segment']['name'];
            if(!empty($value['classifications']['0']['genre']['name'])){
                $eventsCategory[] = $value['classifications']['0']['genre']['name'];
            }
            if(!empty($value['classifications']['0']['subGenre']['name'])){
                $eventsCategory[]=$value['classifications']['0']['subGenre']['name'];
            }
            $eventsCategory = implode(', ', array_unique($eventsCategory));
            $events[$i]['category'] = $eventsCategory;
            $i++;
            } 
        } 
        $getIds = $this->TicketmasterEvents->find()->select(['ticketmaster_event_id'])->
        where(['ticketmaster_event_id IN' => $eventIds])->extract('ticketmaster_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);
        if(count($diffIds)){
            $ticketmasterEvents = TableRegistry::get('TicketmasterEvents');        
            $entities = $ticketmasterEvents->newEntities($events);
            $result = $ticketmasterEvents->saveMany($entities);
        }
        if($startDate <= $endDate){
            $nextDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
            $this->getTicketmasterData($nextDate, $endDate);
        } 
        
        }
        
    }
}
