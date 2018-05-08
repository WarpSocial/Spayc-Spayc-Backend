<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;



class ScraperComponent extends Component {

    public function initialize(array $config) {

	    $this->Spaycs = TableRegistry::get('Spaycs');
	    $this->StubhubEvents = TableRegistry::get('StubhubEvents');
	    $this->TicketmasterEvents = TableRegistry::get('TicketmasterEvents');
	    $this->EventbriteEvents = TableRegistry::get('EventbriteEvents');
	    $this->SCRAPER_ROOT_URL = unserialize(SCRAPER_ROOT_URL);
	    $this->SCRAPER_ROOT_URL_TOKEN = unserialize(SCRAPER_ROOT_URL_TOKEN);
	    $this->STATES = unserialize(SCRAPERSTATES);
	    $this->COUNTRIES = unserialize(SCRAPERCOUNTRIES); 
        $this->SCRAPER_WEBSITE = unserialize(SCRAPER_WEBSITE);         
    }

    public function curlRequest($url, $token=false)
    {
        $headers = array('Content-Type: application/json');
        if($token)
        $headers[] ='Authorization: Bearer '.$token;

        $resp='';
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);     
        if($token)
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);   
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);        
        $resp=curl_exec($curl); 
        $resp=json_decode($resp, true);    
        curl_close($curl);
        return $resp;
    }

     /************* For Event Location *********************/
    public function getEventLoctaion($address=array(), $website)
    { 
        $location=[];
        if(!empty($address)){

            if($website === $this->SCRAPER_WEBSITE['eventbrite']){
                
                if(isset($address['name']) && !empty($address['name']))
                    $location[] = $address['name'];
                if(isset($address['address']['localized_address_display']) && !empty($address['address']['localized_address_display']))
                    $location[] = $address['address']['localized_address_display'];
                if(isset($address['address']['country']) && !empty($address['address']['country']))
                    $location[] = $address['address']['country'];

            } else if($website === $this->SCRAPER_WEBSITE['stubhub']){

                if(isset($address['name']) && !empty($address['name']))
                    $location[] = $address['name'];
                if(isset($address['address1']) && !empty($address['address1']))
                    $location[] = $address['address1'];
                if(isset($address['city']) && !empty($address['city']))
                    $location[] = $address['city'];
                if(isset($address['state']) && !empty($address['state']))
                    $location[] = $address['state'];
                if(isset($address['postalCode']) && !empty($address['postalCode']))
                    $location[] = $address['postalCode'];
                if(isset($address['country']) && !empty($address['country']))
                    $location[] = $address['country'];

            } else if($website === $this->SCRAPER_WEBSITE['ticketmaster']){                
                if(isset($address['name']) && !empty($address['name']))
                    $location[] = $address['name'];
                if(isset($address['address']['line1']) && !empty($address['address']['line1']))
                    $location[] = $address['address']['line1'];
                if(isset($address['city']['name']) && !empty($address['city']['name']))
                    $location[] = $address['city']['name'];
                if(isset($address['state']['name']) && !empty($address['state']['name']))
                    $location[] = $address['state']['name'];
                if(isset($address['postalCode']) && !empty($address['postalCode']))
                    $location[] = $address['postalCode'];
                if(isset($address['country']['countryCode']) && !empty($address['country']['countryCode']))
                    $location[] = $address['country']['countryCode'];
            }
        }
        if(!empty($location))
          $location =implode(", ",$location);
        else
          $location =''; 

        return $location;
    }
    // /************* For Event Category *********************/
    public function getEventCategory($value=array(), $website)
    { 
        $category=[];
        if(!empty($value)){
            if($website === $this->SCRAPER_WEBSITE['eventbrite']){

                if(isset($value['category_id']) && !empty($value['category_id']))
                    $category[]=$value['category_id'];
                if(isset($value['subcategory_id']) && !empty($value['subcategory_id']))
                    $category[]=$value['subcategory_id'];

            } else if($website === $this->SCRAPER_WEBSITE['stubhub']){

                if(isset($value['categories']) && count($value['categories'])){
                    foreach ($value['categories'] as  $val) {                    
                        if(isset($val['name']) && !empty($val['name']))
                           $category[]=$val['id'];                    
                    }
                }

            } else if($website === $this->SCRAPER_WEBSITE['ticketmaster']){

                if(isset($value['segment']['id']) && !empty($value['segment']['id']))
                    $category[] = $value['segment']['id'];
                if(isset($value['genre']['id']) && !empty($value['genre']['id']))
                    $category[] = $value['genre']['id'];                
                if(isset($value['subGenre']['id']) && !empty($value['subGenre']['id']))
                    $category[]=$value['subGenre']['id'];
            }
        }
        if(!empty($category))
          $category =implode(", ",$category);
        else
          $category =''; 

        return $category;
    }

    
    /*************  get Events from Eventbrite URL *********************/
     public function getEventbriteData($pageNumber=1)
    {   
        $url= $this->SCRAPER_ROOT_URL['eventbriteurl'].'events/search/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'].'&sort_by=date&start_date.range_start='.TODAY_DATE.'T00%3A00%3A00&start_date.range_end='.AFTER14DAYS_DATE.'T23%3A59%3A00&location.address=New+York%2C+NY&page='.$pageNumber;
        $resp=$this->curlRequest($url);
        if((isset($resp['events']) && !empty($resp['events'])) && count($resp['events'])) {        
        $events=$eventIds= array();
        foreach ($resp['events'] as $value) {          
            $stateExist='';
            $eventIds[]=$eventId=trim($value['id']);  
            $events[$eventId]['eventbrite_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']['text']) && !empty($value['name']))?trim($value['name']['text']):null;
            $events[$eventId]['start_date'] = (isset($value['start']['utc']) && !empty($value['start']['utc']))?new time($value['start']['utc']):null;
            $events[$eventId]['end_date'] =(isset($value['end']['utc']) && !empty($value['end']['utc']))?new time($value['end']['utc']):null;
            $events[$eventId]['description'] = (isset($value['description']['text']) && !empty($value['description']['text']))?trim($value['description']['text']):null;
            $events[$eventId]['image'] = (isset($value['logo']['original']['url']) && !empty($value['logo']['original']['url']))?$value['logo']['original']['url']:null;            
            $events[$eventId]['event_status'] = (isset($value['status']) && !empty($value['status']))?trim($value['status']):null;            
            if(isset($value['venue_id']) && !empty($value['venue_id'])) {

               $venueUrl = $this->SCRAPER_ROOT_URL['eventbriteurl'].'venues/'.trim($value['venue_id']).'/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'];
               $venueResp=$this->curlRequest($venueUrl);            
               $events[$eventId]['latitude'] = (isset($venueResp['latitude']) && !empty($venueResp['latitude']))?trim($venueResp['latitude']):null;
               $events[$eventId]['longitude'] = (isset($venueResp['longitude']) && !empty($venueResp['longitude']))?trim($venueResp['longitude']):null;

                $events[$eventId]['location'] = $this->getEventLoctaion($venueResp, $this->SCRAPER_WEBSITE['eventbrite']);
                if(isset($venueResp['address']['city']) && !empty($venueResp['address']['city']))
                    $events[$eventId]['city']= $venueResp['address']['city'];

                if(isset($venueResp['address']['region']) && !empty($venueResp['address']['region'])) {
                 $events[$eventId]['region']= $venueResp['address']['region'];
                 if (!in_array(strtolower(trim($venueResp['address']['region'])), $this->STATES))
                    $stateExist = $eventId;                   
                }
                if(isset($venueResp['address']['postal_code']) && !empty($venueResp['address']['postal_code']))
                    $events[$eventId]['postal_code']= $venueResp['address']['postal_code'];

                if(isset($venueResp['address']['country']) && !empty($venueResp['address']['country'])){
                 $events[$eventId]['country']= $venueResp['address']['country'];
                 if (($stateExist =='') && !in_array(strtolower(trim($venueResp['address']['country'])), $this->COUNTRIES))
                      $stateExist = $eventId;
                }
            }                       
            $events[$eventId]['category'] = $this->getEventCategory($value, $this->SCRAPER_WEBSITE['eventbrite']);
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['eventbrite'];
            if(!empty($stateExist)){
                unset($events[$stateExist]);
                unset($eventIds[$stateExist]);
            }
        } 
        if(!empty($eventIds)){ 
            $getIds = $this->EventbriteEvents->find()->select(['eventbrite_event_id'])->
            where(['eventbrite_event_id IN' => $eventIds])->extract('eventbrite_event_id')->toList();
            $diffIds=array_diff($eventIds,$getIds);       
            if(count($diffIds)){
                $getuniqueevents =[];           
                foreach ($events as $val) {
                    if (in_array($val['eventbrite_event_id'],$diffIds)){
                        $Entity = $this->EventbriteEvents->newEntity($events[$val['eventbrite_event_id']]);
                        $result = $this->EventbriteEvents->save($Entity);
                    }else if(in_array($val['eventbrite_event_id'],$getIds)){
                        $query = $this->EventbriteEvents->query();
                        $query->update()
                        ->set($events[$val['eventbrite_event_id']])
                        ->where(['eventbrite_event_id' => $val['eventbrite_event_id']])
                        ->execute();
                     }else{
                        continue;
                     }
                }

            }  else {
                foreach ($getIds as $id) {
                    $query = $this->EventbriteEvents->query();
                    $query->update()
                    ->set($events[$id])
                    ->where(['eventbrite_event_id' => $id])
                    ->execute();
                } 
            } 

            if($resp['pagination']['has_more_items']){
                $pageNumber=$pageNumber+1;
                $this->getEventbriteData($pageNumber);
            }          
        }   
        }     
    }

   
    /*************  get Events from Stubhub URL *********************/
    public function getStubhubData($start=0)
    {       
        $url =$this->SCRAPER_ROOT_URL['stubhuburl'].'?city=%22New%20York%22&state=%22NY%22%20|%22New%20York%22&country=US&date='.TODAY_DATE.'T00:00%20TO%20'.AFTER14DAYS_DATE.'T23:59&sort=eventDateUTC%20asc&rows=500&start='.$start;
        $resp=$this->curlRequest($url,$this->SCRAPER_ROOT_URL_TOKEN['stubhubtoken']);
        $eventsCount = count($resp['events']);
        if((isset($resp['events']) && !empty($resp['events'])) && $eventsCount){
        $events = $eventIds = array();
        foreach ($resp['events'] as $value) {
            $eventIds[]= $eventId = trim($value['id']);
            $events[$eventId]['stubhub_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']) && !empty($value['name']))?trim($value['name']):null;
            $events[$eventId]['start_date'] = (isset($value['eventDateUTC']) && !empty($value['eventDateUTC']))?new time($value['eventDateUTC']):null;
            $events[$eventId]['end_date'] = null;
            $events[$eventId]['description'] = (isset($value['description']) && !empty($value['description']))?trim($value['description']):null;
            $events[$eventId]['latitude'] = (isset($value['venue']['latitude']) && !empty($value['venue']['latitude']))?trim($value['venue']['latitude']):null;
            $events[$eventId]['longitude'] = (isset($value['venue']['longitude']) && !empty($value['venue']['longitude']))?trim($value['venue']['longitude']):null;
            $events[$eventId]['image'] = (isset($value['imageUrl']) && !empty($value['imageUrl']))?$value['imageUrl']:null;
            $events[$eventId]['location'] = $this->getEventLoctaion($value['venue'], $this->SCRAPER_WEBSITE['stubhub']);
            if(isset($value['venue']['city']) && !empty($value['venue']['city']))
                $events[$eventId]['city'] = trim($value['venue']['city']);
            
            if(isset($value['venue']['state']) && !empty($value['venue']['state']))
                $events[$eventId]['region'] = trim($value['venue']['state']);
               
            if(isset($value['venue']['postalCode']) && !empty($value['venue']['postalCode']))
                $events[$eventId]['postal_code'] = trim($value['venue']['postalCode']);
            
            if(isset($value['venue']['country']) && !empty($value['venue']['country']))
                $events[$eventId]['country'] = trim($value['venue']['country']);

            $events[$eventId]['event_status'] = (isset($value['status']) && !empty($value['status']))?trim($value['status']):null;
            $category = $this->getEventCategory($value['categories'], $this->SCRAPER_WEBSITE['eventbrite']); 

            $eventsCategory =[];
            if(isset($value['categories']) && count($value['categories'])){
                foreach ($value['categories'] as  $val) {                    
                    if(isset($val['name']) && !empty($val['name']))
                        $eventsCategory[$val['id']] = $val['name'];                    
                }
            }
            $events[$eventId]['category'] = $category;
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['stubhub'];
        }
        if(!empty($eventIds)){
            $getIds = $this->StubhubEvents->find()->select(['stubhub_event_id'])->
            where(['stubhub_event_id IN' => $eventIds])->extract('stubhub_event_id')->toList();
            $diffIds=array_diff($eventIds,$getIds);            
            if(count($diffIds)){
                $getuniqueevents =[];           
                foreach ($events as $val) {
                    if (in_array($val['stubhub_event_id'],$diffIds)){
                        $entities = $this->StubhubEvents->newEntity($events[$val['stubhub_event_id']]);
                        $result = $this->StubhubEvents->save($entities);
                    }else if(in_array($val['stubhub_event_id'],$getIds)){
                        $query = $this->StubhubEvents->query();
                        $query->update()
                        ->set($events[$val['stubhub_event_id']])
                        ->where(['stubhub_event_id' => $val['stubhub_event_id']])
                        ->execute();
                     }else{
                        continue;
                     }                    
                } 
            }  else {
                foreach ($getIds as $id) {
                    $query = $this->StubhubEvents->query();
                    $query->update()
                    ->set($events[$id])
                    ->where(['stubhub_event_id' => $id])
                    ->execute();
                } 
            }
            /****** Save stubhub category in category table *****/
            // if(!empty($eventsCategory)){
            //     foreach ($eventsCategory as $key => $val) {
            //     }
            // }
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
    }

    /*************  get Events from Ticketmaster URL pass Startdate and endDate as argument data should be Y-m-d format *********************/
    public function getTicketmasterData($startDate, $endDate=null)
    {  
        $url=$this->SCRAPER_ROOT_URL['ticketmasterurl'].'?apikey='.$this->SCRAPER_ROOT_URL_TOKEN['ticketmastertoken'].'&city=%22New%20York%22&stateCode=NY&countryCode=US&page=0&size=200&sort=date,asc&startDateTime='.$startDate.'T00:00:00Z&endDateTime='.$startDate.'T23:59:00Z';        
        $resp=$this->curlRequest($url);       
        if(isset($resp['_embedded']['events']) && count($resp['_embedded']['events'])){
        $events = $eventIds = array();
        foreach ($resp['_embedded']['events'] as $value) {            
            if(isset($value['dates']['start']['dateTime']) && !empty($value['dates']['start']['dateTime']))
                $startDateTime = new time($value['dates']['start']['dateTime']);
            else
                $startDateTime = new time($value['dates']['start']['localDate']);

            if(($startDateTime < new time(date('Y-m-d', strtotime($startDate . ' +1 day')))) && ($startDateTime >= new time(date('Y-m-d', strtotime($startDate . ' -1 day'))))){
            $eventIds[]= $eventId =trim($value['id']);
            $events[$eventId]['ticketmaster_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']) && !empty($value['name']))?trim($value['name']):null;
            $events[$eventId]['start_date'] = $startDateTime;                    
            $events[$eventId]['description'] = (isset($value['info']) && !empty($value['info']))?trim($value['info']):null;
            $events[$eventId]['latitude'] = (isset($value['_embedded']['venues']['0']['location']['latitude']) && !empty($value['_embedded']['venues']['0']['location']['latitude']))?trim($value['_embedded']['venues']['0']['location']['latitude']):null;
            $events[$eventId]['longitude'] = (isset($value['_embedded']['venues']['0']['location']['longitude']) && !empty($value['_embedded']['venues']['0']['location']['longitude']))?trim($value['_embedded']['venues']['0']['location']['longitude']):null;
            $events[$eventId]['image'] = (isset($value['images']['0']['url']) && !empty($value['images']['0']['url']))?$value['images']['0']['url']:null;
           
            $events[$eventId]['location'] = $this->getEventLoctaion($value['_embedded']['venues']['0'], $this->SCRAPER_WEBSITE['ticketmaster']);

            if(!empty($value['_embedded']['venues']['0']['city']['name']))
            $events[$eventId]['city'] = $value['_embedded']['venues']['0']['city']['name'];
            
            if(!empty($value['_embedded']['venues']['0']['state']['name']))
            $events[$eventId]['region'] = $value['_embedded']['venues']['0']['state']['name'];
                
            if(!empty($value['_embedded']['venues']['0']['postalCode']))
            $events[$eventId]['postal_code'] = $value['_embedded']['venues']['0']['postalCode'];
               
            if(!empty($value['_embedded']['venues']['0']['country']['countryCode']))
            $events[$eventId]['country'] = $value['_embedded']['venues']['0']['country']['countryCode'];

            $events[$eventId]['event_status'] = (isset($value['dates']['status']['code']) && !empty($value['dates']['status']['code']))?trim($value['dates']['status']['code']):null;

            $events[$eventId]['category'] = $this->getEventCategory($value['classifications']['0'], $this->SCRAPER_WEBSITE['ticketmaster']);
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['ticketmaster'];
            } 
        }        
        if(!empty($eventIds)) {
            $getIds = $this->TicketmasterEvents->find()->select(['ticketmaster_event_id'])->where(['ticketmaster_event_id IN' => $eventIds])->extract('ticketmaster_event_id')->toList();
            $diffIds=array_diff($eventIds,$getIds);    

            if(count($diffIds)){
                $getuniqueevents =[];           
                foreach ($events as $val) {
                    if (in_array($val['ticketmaster_event_id'],$diffIds)){
                        $entities = $this->TicketmasterEvents->newEntity($events[$val['ticketmaster_event_id']]);
                        $result = $this->TicketmasterEvents->save($entities);
                    }else if(in_array($val['ticketmaster_event_id'],$getIds)){
                        $query = $this->TicketmasterEvents->query();
                        $query->update()
                        ->set($events[$val['ticketmaster_event_id']])
                        ->where(['ticketmaster_event_id' => $val['ticketmaster_event_id']])
                        ->execute();
                     }else{
                        continue;
                     }                    
                } 
            }  else {              
                foreach ($getIds as $id) {
                    $query = $this->TicketmasterEvents->query();
                    $query->update()
                    ->set($events[$id])
                    ->where(['ticketmaster_event_id' => $id])
                    ->execute();
                } 
            }

            if($startDate <= $endDate){
                $nextDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
                $this->getTicketmasterData($nextDate, $endDate);
            } 
        }
        }
        
    }
    
    public function getEventBriteAllSubcategories($pageNumber=1, $continuation=null, $getSubcategory=[])
    {
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

    public function saveDataSpaceTable($page=1)
    {        
        ini_set('max_execution_time', 0);        
        $obj = TableRegistry::get("Users")->find('all', ['conditions' => 
                            ['Users.email' => trim(SCRAPER_EMAIL)],
                            'limit' => '1'
                ])->first();
        $pageLimit=10;
        $token = TableRegistry::get("Api.UserLogs")->findByUserId($obj->id)->select(['plain_token'])->first();      
        if(isset($token) && !empty($token)) {

            $url= Router::url('/', true).'api/spaycs.json'; 
            $totalRecord = $this->StubhubEvents->find('all')->count();
            $totalPageNumber = round($totalRecord/$pageLimit);        
            $record = $this->StubhubEvents->find('all',['conditions' => 
                            ['StubhubEvents.is_status' => 0],'limit' => $pageLimit])->page($page)->toArray();           
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
                $createSpaceData['image']=null;
                $createSpaceData['longitude']=null;
                $createSpaceData['latitude']=$value['latitude'];          
                $http = new Client(['headers' => ['token' => $token->plain_token]]);
                $httpResponse = $http->post($url,$createSpaceData);
                $response = json_decode($httpResponse->body,true);
                if($httpResponse->isOk()){
                    $i++;
                }
            }
            if($i >=10) { 
                $query = $this->StubhubEvents->query();
                $query->update()
                    ->set(['is_status' => true])
                    ->where(['id IN' => $getIds])
                    ->execute();
                if($page <= 2){
                if($page < $totalPageNumber){
                    $page = $page+1;
                    $this->saveDataSpaceTable($page);
                }
                }
            } else {
                die($i);
            }
          

        }
    }
}
/**** End ThirdPartyData Component*******/
