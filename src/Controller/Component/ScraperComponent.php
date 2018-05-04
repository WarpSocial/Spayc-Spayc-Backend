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
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);   
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);        
        $resp=curl_exec($curl); 
        $resp=json_decode($resp, true);    
        curl_close($curl);
        return $resp;
    }


    public function getLoctaion($name, $address, $city, $state, $zipCode, $country)
    { 
        $location = [];
        if(isset($name) && !empty($name))
            $location[] = $name;

        if(isset($address) && !empty($address))
            $location[] = $address;            

        if(isset($city) && !empty($city))
            $location[] = $city;

        if(isset($state) && !empty($state)) 
            $location[] = $state;

        if(isset($zipCode) && !empty($zipCode)) 
            $location[] = $zipCode;
        if(isset($country) && !empty($country)) 
            $location[] = $country;

        if(!empty($location))
          $location =implode(", ",$location);
        else
          $location =''; 

        return $location;
        
    }

    // get and save Eventbrite data current date to after 14 days
    public function getEventbriteData($pageNumber=1)
    {  
        $url= $this->SCRAPER_ROOT_URL['eventbriteurl'].'events/search/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'].'&sort_by=date&start_date.range_start='.TODAY_DATE.'T00%3A00%3A00&start_date.range_end='.AFTER14DAYS_DATE.'T23%3A59%3A00&location.address=New+York%2C+NY&page='.$pageNumber;

        $resp=$this->curlRequest($url);            
        if((isset($resp['events']) && !empty($resp['events'])) &&count($resp['events'])){
        $i=0;
        $events = array();
        $eventIds = array();
        foreach ($resp['events'] as $value) {
            $stateExist='';
            $eventIds[]= trim($value['id']);
            $events[$i]['eventbrite_event_id'] = trim($value['id']);
            $events[$i]['name'] = (isset($value['name']['text']) && !empty($value['name']))?trim($value['name']['text']):null;
            $events[$i]['start_date'] = (isset($value['start']['utc']) && !empty($value['start']['utc']))?new time($value['start']['utc']):null;
            $events[$i]['end_date'] =(isset($value['end']['utc']) && !empty($value['end']['utc']))?new time($value['end']['utc']):null;
            $events[$i]['description'] = (isset($value['description']['text']) && !empty($value['description']['text']))?trim($value['description']['text']):null;
            $events[$i]['image'] = (isset($value['logo']['original']['url']) && !empty($value['logo']['original']['url']))?$value['logo']['original']['url']:null;
            $eventsCategory='';
            $location=[];
            if(isset($value['venue_id']) && !empty($value['venue_id'])){
               $venueUrl = $this->SCRAPER_ROOT_URL['eventbriteurl'].'venues/'.trim($value['venue_id']).'/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'];
               $venueResp=$this->curlRequest($venueUrl);
               $events[$i]['latitude'] = (isset($venueResp['latitude']) && !empty($venueResp['latitude']))?trim($venueResp['latitude']):null;
               $events[$i]['longitude'] = (isset($venueResp['longitude']) && !empty($venueResp['longitude']))?trim($venueResp['longitude']):null;

                if(isset($venueResp['name']) && !empty($venueResp['name']))
                     $location[] = $venueResp['name'];
                if(isset($venueResp['address']['localized_address_display']) && !empty($venueResp['address']['localized_address_display']))
                    $location[] = $venueResp['address']['localized_address_display'];
                if(isset($venueResp['address']['country']) && !empty($venueResp['address']['country']))
                    $location[] = $venueResp['address']['country'];

                if(isset($venueResp['address']['city']) && !empty($venueResp['address']['city'])){
                    $events[$i]['city']= $venueResp['address']['city'];
                    if (!in_array(trim($venueResp['address']['city']), $this->STATES))
                       $stateExist = $i;
                }

                if(isset($venueResp['address']['region']) && !empty($venueResp['address']['region'])) {
                 $events[$i]['region']= $venueResp['address']['region'];
                 if (!in_array(trim($venueResp['address']['region']), $this->STATES))
                    $stateExist = $i;                    
                }

                if(isset($venueResp['address']['postal_code']) && !empty($venueResp['address']['postal_code']))
                 $events[$i]['postal_code']= $venueResp['address']['postal_code'];

                if(isset($venueResp['address']['country']) && !empty($venueResp['address']['country'])){
                 $events[$i]['country']= $venueResp['address']['country'];
                 if (($stateExist =='') && !in_array(trim($venueResp['address']['country']), $this->COUNTRIES))
                      $stateExist = $i;
                }

                if( (empty($venueResp['address']['city']) || empty($venueResp['address']['region']) || empty($venueResp['address']['country'])) && ($stateExist =='')){
                    $stateExist = $i;
                }

            }
            
            if(isset($value['category_id']) && !empty($value['category_id']))
                $eventsCategory = $value['category_id'];
            if(isset($value['subcategory_id']) && !empty($value['subcategory_id']))
                $eventsCategory .= ', '.$value['subcategory_id'];
            if(!empty($location))
              $location =implode(", ",$location);
            else
              $location =''; 

            $events[$i]['location'] = $location;
            $events[$i]['category'] = $eventsCategory;
            $events[$i]['modified'] = (isset($value['changed']) && !empty($value['changed']))?new time($value['changed']):null;
            $events[$i]['website'] = $this->SCRAPER_WEBSITE['eventbrite'];
            if($stateExist !='' || $stateExist===0){
                unset($events[$stateExist]);
                unset($eventIds[$stateExist]);
            }
            $i++;
        }         
        $getIds = $this->EventbriteEvents->find()->select(['eventbrite_event_id'])->
        where(['eventbrite_event_id IN' => $eventIds])->extract('eventbrite_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);       
        if(count($diffIds)){
            $getuniqueevents =[];
            foreach ($events as $val) {
                if (in_array($val['eventbrite_event_id'],$diffIds))
                    $getuniqueevents[]=$val;
            }
            $eventbriteEvents = TableRegistry::get('EventbriteEvents');        
            $entities = $eventbriteEvents->newEntities($getuniqueevents);
            $result = $eventbriteEvents->saveMany($entities);
        }       
        if($resp['pagination']['has_more_items']){
            $pageNumber=$pageNumber+1;
            $this->getEventbriteData($pageNumber);
        }          
        }        
    }
   
    // get and save Stubhub website data for current date to after 14 days
    public function getStubhubData($start=0)
    {
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
            $events[$i]['location'] = $this->getLoctaion($value['venue']['name'], $value['venue']['address1'], $value['venue']['city'], $value['venue']['state'], $value['venue']['postal_code'], $value['venue']['country']);
            if(isset($value['venue']['city']) && !empty($value['venue']['city']))
                $events[$i]['city'] = trim($value['venue']['city']);
            
            if(isset($value['venue']['state']) && !empty($value['venue']['state']))
                $events[$i]['region'] = trim($value['venue']['state']);
               
            if(isset($value['venue']['postalCode']) && !empty($value['venue']['postalCode']))
                $events[$i]['postal_code'] = trim($value['venue']['postalCode']);
            
            if(isset($value['venue']['country']) && !empty($value['venue']['country']))
                $events[$i]['country'] = trim($value['venue']['country']);

            $eventsCategory = '';
            if(count($value['categories'])){
                foreach ($value['categories'] as  $val) {                    
                    if(isset($val['name']) && !empty($val['name']))
                        $eventsCategory .= $val['name'].', ';                    
                }
                $eventsCategory= substr($eventsCategory, 0, -2);
            }
            $events[$i]['category'] = $eventsCategory;
            $events[$i]['website'] = $this->SCRAPER_WEBSITE['stubhub'];
            $i++;
        } 
        $getIds = $this->StubhubEvents->find()->select(['stubhub_event_id'])->
        where(['stubhub_event_id IN' => $eventIds])->extract('stubhub_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);
        if(count($diffIds)){    
            $getuniqueevents =[];
            foreach ($events as $val) {
                if (in_array($val['stubhub_event_id'],$diffIds))
                    $getuniqueevents[]=$val;
            }        
            $stubhubEvent = TableRegistry::get('StubhubEvents');        
            $entities = $stubhubEvent->newEntities($getuniqueevents);
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

    // get and save Stubhub website data for current date to after 14 days and pass Startdate and endDate as argument data should be Y-m-d format
    public function getTicketmasterData($startDate, $endDate=null)
    {  
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
            
            $events[$i]['location'] = $this->getLoctaion($value['_embedded']['venues']['0']['name'], $value['_embedded']['venues']['0']['address']['line1'], $value['_embedded']['venues']['0']['city']['name'], $value['_embedded']['venues']['0']['state']['name'], $value['_embedded']['venues']['0']['postalCode'], $value['_embedded']['venues']['0']['country']['countryCode']);

            if(!empty($value['_embedded']['venues']['0']['city']['name']))
            $events[$i]['city'] = $value['_embedded']['venues']['0']['city']['name'];
            
            if(!empty($value['_embedded']['venues']['0']['state']['name']))
            $events[$i]['region'] = $value['_embedded']['venues']['0']['state']['name'];
                
            if(!empty($value['_embedded']['venues']['0']['postalCode']))
            $events[$i]['postal_code'] = $value['_embedded']['venues']['0']['postalCode'];
               
            if(!empty($value['_embedded']['venues']['0']['country']['countryCode']))
            $events[$i]['country'] = $value['_embedded']['venues']['0']['country']['countryCode'];

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
            $events[$i]['website'] = $this->SCRAPER_WEBSITE['ticketmaster'];
            $i++;
            } 
        } 
        $getIds = $this->TicketmasterEvents->find()->select(['ticketmaster_event_id'])->
        where(['ticketmaster_event_id IN' => $eventIds])->extract('ticketmaster_event_id')->toList();
        $diffIds=array_diff($eventIds,$getIds);
        if(count($diffIds)){
            $getuniqueevents =[];
            foreach ($events as $val) {
                if (in_array($val['ticketmaster_event_id'],$diffIds))
                    $getuniqueevents[]=$val;
            }  
            $ticketmasterEvents = TableRegistry::get('TicketmasterEvents');        
            $entities = $ticketmasterEvents->newEntities($getuniqueevents);
            $result = $ticketmasterEvents->saveMany($entities);
        }
        if($startDate <= $endDate){
            $nextDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
            $this->getTicketmasterData($nextDate, $endDate);
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

    public function saveDataSpaceTable()
    {
        $obj = TableRegistry::get("Users")->find('all', ['conditions' => 
                            ['Users.email' => trim(SCRAPER_EMAIL)],
                            'limit' => '1'
                ])->first();
        $token = TableRegistry::get("Api.UserLogs")->findByUserId($obj->id)->select(['plain_token'])->first();      
        if(isset($token) && !empty($token)) {
        $url= Router::url('/', true).'api/spaycs.json'; 
        $stubhubData = $this->StubhubEvents->find('all');
        $ticketmasterData = $this->TicketmasterEvents->find('all');
        $eventbriteData = $this->EventbriteEvents->find('all');
        $totalRecord = $eventbriteData->union($ticketmasterData)->union($stubhubData)->toArray();
        $createSpaceData=[];
        foreach ($totalRecord as $value) {         
         $createSpaceData['name']=$value['name'];
         $createSpaceData['location']=$value['location'];
         $createSpaceData['type']='Event';
         $createSpaceData['group_type']='Public';
         $createSpaceData['start_date']=$value['start_date']->format('m-d-Y H:i:s');
         $createSpaceData['end_date']=$value['start_date']->format('m-d-Y H:i:s');
         $createSpaceData['description']=$value['description'];
         $createSpaceData['image']=null;
         $createSpaceData['longitude']=$value['longitude'];
         $createSpaceData['latitude']=$value['latitude'];  
         $http = new Client(['headers' => ['token' => $token->plain_token]]);
         $httpResponse = $http->post($url,$createSpaceData);
        }
        }
    }
    
}
/**** End ThirdPartyData Component*******/
