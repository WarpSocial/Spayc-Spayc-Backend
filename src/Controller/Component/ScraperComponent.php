<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Http\Client;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Cake\I18n\Time;
use Api\Utils\Utils;
use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;
use Api\Auth\ApiHasher;

class ScraperComponent extends Component {

    public function initialize(array $config) {
        
        $this->StubhubEvents = TableRegistry::get('StubhubEvents');
        $this->TicketmasterEvents = TableRegistry::get('TicketmasterEvents');
        $this->EventbriteEvents = TableRegistry::get('EventbriteEvents');	    
        $this->SCRAPER_ROOT_URL = unserialize(SCRAPER_ROOT_URL);
        $this->SCRAPER_ROOT_URL_TOKEN = unserialize(SCRAPER_ROOT_URL_TOKEN);
        $this->STATES = unserialize(SCRAPERSTATES);
        $this->COUNTRIES = unserialize(SCRAPERCOUNTRIES); 
        $this->SCRAPER_WEBSITE = unserialize(SCRAPER_WEBSITE);   
        $this->ScraperCategories = TableRegistry::get('ScraperCategories');
        $this->ScraperLogs = TableRegistry::get('ScraperLogs');
        $this->SCRAPER_WEBSITE_FLIP = array_flip(unserialize(SCRAPER_WEBSITE));
    }    

    public function curlRequest($url, $time ,$token=false) {
        $headers = ['Content-Type' => 'application/json'];
        if($token){
            $headers['Authorization'] = 'Bearer ' . $token;
        }
        $http = new \Cake\Http\Client(['headers' => $headers]);
        try{
            $response = $http->get($url);
            if(!$response->isOk()){
                $this->updateScraperLog($time,json_encode($response->getBody()));
                return '';
            }
            return json_decode($response->body, true); 
        } catch (\Exception $ex) {
            $this->updateScraperLog($time,json_encode(['message'=>$ex->getMessage(),'code'=>$ex->getCode()]));
            return '';
        }
    }

    /*************  get Events from Eventbrite API and Save it *********************/
     public function getEventbriteData($pageNumber=1,$time) { 
        $dtNow = new \DateTime(TODAY_DATE);
        $beginOfDay = clone $dtNow;
        $beginOfDay->modify('today'); 
        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('+15 days');
        $endOfDay->modify('1 second ago'); 
        $url=$this->SCRAPER_ROOT_URL['eventbriteurl'].'events/search/?'. http_build_query([
           'expand'=> 'venue',
           'token' => $this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'],
           'sort_by'=>'date',
           'start_date.range_start'=> $beginOfDay->format('Y-m-d\TH:i:s'),
           'start_date.range_end' => $endOfDay->format('Y-m-d\TH:i:s'),
           'location.address'=> 'New York,NY',
            'page' => $pageNumber
        ]);  
        
        $resp=$this->curlRequest($url,$time);
        if((isset($resp['events']) && !empty($resp['events'])) && count($resp['events'])) {
        $events=$eventIds= array();
        foreach ($resp['events'] as $value) {                      
            $stateExist='';
            $eventIds[]=$eventId=trim($value['id']);  
            $events[$eventId]['eventbrite_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']['text']) && !empty($value['name']))?html_entity_decode(trim($value['name']['text'])):null;
            $events[$eventId]['ticket_url'] = (isset($value['url']) && !empty($value['url']))?trim($value['url']):null;
            $events[$eventId]['payment_type'] = (isset($value['is_free']) && ($value['is_free']))?FREE:PAID;
            $events[$eventId]['start_date'] = (isset($value['start']['utc']) && !empty($value['start']['utc']))?new time($value['start']['utc']):null;
            /* check to get only upcoming events */
            if($events[$eventId]['start_date'] > Time::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', strtotime(SCRAPER_DAYS)))->setTime(23,59))
            {
                $stateExist = $eventId;
            }
            $events[$eventId]['end_date'] =(isset($value['end']['utc']) && !empty($value['end']['utc']))?new time($value['end']['utc']):null;
            $events[$eventId]['description'] = (isset($value['description']['text']) && !empty($value['description']['text']))?html_entity_decode(strip_tags(trim($value['description']['text']))):null;
            $events[$eventId]['image'] = (isset($value['logo']['original']['url']) && !empty($value['logo']['original']['url']))?$value['logo']['original']['url']:null;            
            $events[$eventId]['event_status'] = (isset($value['status']) && !empty($value['status']))?trim($value['status']):null;

            if(isset($value['venue']) && !empty($value['venue'])) {
                
               $events[$eventId]['latitude'] = (isset($value['venue']['latitude']) && !empty($value['venue']['latitude']))?trim($value['venue']['latitude']):null;
               $events[$eventId]['longitude'] = (isset($value['venue']['longitude']) && !empty($value['venue']['longitude']))?trim($value['venue']['longitude']):null;
               $events[$eventId]['location'] = $this->createEventLoctaionData($value['venue'], $this->SCRAPER_WEBSITE['eventbrite']);

               $events[$eventId]['city'] = (isset($value['venue']['address']['city']) && !empty($value['venue']['address']['city']))?trim($value['venue']['address']['city']):null;
               /* check NY region events */
               if(isset($value['venue']['address']['region']) && !empty($value['venue']['address']['region'])) {
                 $events[$eventId]['region']= $value['venue']['address']['region'];
                    if (!in_array(strtolower(trim($value['venue']['address']['region'])), $this->STATES)){
                        $stateExist = $eventId;                   
                    }
                } else if(empty($value['venue']['address']['region'])) {
                    $stateExist = $eventId;                   
                }
                $events[$eventId]['postal_code'] = (isset($value['venue']['address']['postal_code']) && !empty($value['venue']['address']['postal_code']))?trim($value['venue']['address']['postal_code']):null;

               if(isset($value['venue']['address']['country']) && !empty($value['venue']['address']['country'])){
                 $events[$eventId]['country']= $value['venue']['address']['country'];
                 if (($stateExist =='') && !in_array(strtolower(trim($value['venue']['address']['country'])), $this->COUNTRIES)){
                      $stateExist = $eventId;
                 }
                } else if(empty($value['venue']['address']['country'])) {
                    $stateExist = $eventId;                   
                }
            }                                 
            $events[$eventId]['category'] = $this->createEventCategoryData($value, $this->SCRAPER_WEBSITE['eventbrite']);
            
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['eventbrite'];
            if(!empty($stateExist)){
                /* remove events which not belogns  to NY state*/
                unset($events[$stateExist],$eventIds[$stateExist]);
            }
        } 
        //echo count($eventIds)." hhhhh ";
        //echo implode(',',$eventIds);
        if(!empty($eventIds)){
            $this->EventbriteEvents->saveNupdateData($events, $eventIds,$pageNumber);
            if($resp['pagination']['has_more_items']){
                $pageNumber=$pageNumber+1;               
                //echo "##$pageNumber##";die('end');
                /* To avoid consecutive hit on eventbrite website for pagination*/
                //sleep(SCRAPPER_PAGE_DELAY_TIME);
                $this->getEventbriteData($pageNumber,$time);
            }          
        }   
        }     
    }

   
    /*************  get Events from Stubhub API and save it *********************/
    public function getStubhubData($start=0,$time) {
        $dtNow = new \DateTime(TODAY_DATE);
        $beginOfDay = clone $dtNow;
        $beginOfDay->modify('today'); 
        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('+15 days');
        $endOfDay->modify('1 second ago');
        $url=$this->SCRAPER_ROOT_URL['stubhuburl'].'?'.'state='.rawurlencode('"NY" ').'|'.rawurlencode('"New York"').'&'. http_build_query([
            'country'=>'US',
            'date'=> $beginOfDay->format('Y-m-d\TH:i').'TO'.$endOfDay->format('Y-m-d\TH:i'),
            'sort'=>'eventDateUTC',
            'rows' => 500,
            'start'=>$start            
        ]);          
        $resp=$this->curlRequest($url,$time,$this->SCRAPER_ROOT_URL_TOKEN['stubhubtoken']);
        //$eventsCount = count($resp['events']);       
        if((isset($resp['events']) && !empty($resp['events']))){
        $events=$eventIds=$eventsCategory=$eventsCatIds= array();
        foreach ($resp['events'] as $value) {
            $eventIds[]= $eventId = trim($value['id']);
            $events[$eventId]['stubhub_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']) && !empty($value['name']))?html_entity_decode(trim($value['name'])):null;
            $events[$eventId]['ticket_url'] = (isset($value['webURI']) && !empty($value['webURI']))?STUBHUB_EVENT_URL.trim($value['webURI']):STUBHUB_EVENT_URL;
            $events[$eventId]['payment_type'] = PAID;
            $events[$eventId]['start_date'] = (isset($value['eventDateUTC']) && !empty($value['eventDateUTC']))?new time($value['eventDateUTC']):null;
            $events[$eventId]['end_date'] = null;
            $events[$eventId]['description'] = (isset($value['description']) && !empty($value['description']))? html_entity_decode(trim($value['description'])):null;
            $events[$eventId]['latitude'] = (isset($value['venue']['latitude']) && !empty($value['venue']['latitude']))?trim($value['venue']['latitude']):null;
            $events[$eventId]['longitude'] = (isset($value['venue']['longitude']) && !empty($value['venue']['longitude']))?trim($value['venue']['longitude']):null;
            $events[$eventId]['image'] = (isset($value['imageUrl']) && !empty($value['imageUrl']))?$value['imageUrl']:null;
            $events[$eventId]['location'] = $this->createEventLoctaionData($value['venue'], $this->SCRAPER_WEBSITE['stubhub']);
            if(isset($value['venue']['city']) && !empty($value['venue']['city']))
                $events[$eventId]['city'] = trim($value['venue']['city']);
            
            if(isset($value['venue']['state']) && !empty($value['venue']['state']))
                $events[$eventId]['region'] = trim($value['venue']['state']);
               
            if(isset($value['venue']['postalCode']) && !empty($value['venue']['postalCode']))
                $events[$eventId]['postal_code'] = trim($value['venue']['postalCode']);
            
            if(isset($value['venue']['country']) && !empty($value['venue']['country']))
                $events[$eventId]['country'] = trim($value['venue']['country']);

            $events[$eventId]['event_status'] = (isset($value['status']) && !empty($value['status']))?trim($value['status']):null;
            if(isset($value['categories']) && count($value['categories'])){            
                foreach ($value['categories'] as  $val) {                    
                    if(isset($val['name']) && !empty($val['name'])){
                        $eventsCatIds[]= $catId = trim($val['id']);
                        $eventsCategory[$catId]['scraper_category_id'] = $val['id'];
                        $eventsCategory[$catId]['name'] = $val['name'];
                        $eventsCategory[$catId]['website'] = $this->SCRAPER_WEBSITE['stubhub'];                     
                    }
                }
            $events[$eventId]['category'] = $this->createEventCategoryData($value, $this->SCRAPER_WEBSITE['stubhub']);
            }
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['stubhub'];
        }    
        if(!empty($eventIds)){

            $this->StubhubEvents->saveNupdateData($events, $eventIds);
            /****** Save stubhub category in Scraper category table *****/
            if(!empty($eventsCategory)){                
                $this->ScraperCategories->updateScraperCategories($eventsCategory, array_unique($eventsCatIds), $this->SCRAPER_WEBSITE['stubhub']);
            }
            $dataLimit=500;  
            $countNoOfHits=ceil($resp['numFound']/$dataLimit);
            $total = $eventsCount+$start;         
            if($resp['numFound'] > $total){            
                $start = $start+$dataLimit;                  
                if($countNoOfHits > 10){ 
                    sleep(6); //Stubhub allows 10 calls per minute
                }
                $this->getStubhubData($start,$time);
            } 
        }
        }
    }

    /*************  get Events from Ticketmaster URL pass Startdate and endDate as argument data should be Y-m-d format *********************/
    public function getTicketmasterData($startDate, $endDate=null,$time) {  
        $dtNow = new \DateTime($startDate);
        $beginOfDay = clone $dtNow;
        $beginOfDay->modify('today'); 
        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('tomorrow');
        // adjust from the next day to the end of the day, per original question
        $endOfDay->modify('1 second ago');
        $url=$this->SCRAPER_ROOT_URL['ticketmasterurl'].'events.json?'. http_build_query([
            'apikey'=>$this->SCRAPER_ROOT_URL_TOKEN['ticketmastertoken'],
            'stateCode'=>'NY',
            'countryCode'=>'US',
            'page'=>0,
            'size'=>200,
            'sort'=>'date,asc',
            'startDateTime'=> $beginOfDay->format('Y-m-d\TH:i:s\Z'),
            'endDateTime'=> $endOfDay->format('Y-m-d\TH:i:s\Z'),
        ]);
        //$url=$this->SCRAPER_ROOT_URL['ticketmasterurl'].'events.json?apikey='.$this->SCRAPER_ROOT_URL_TOKEN['ticketmastertoken'].'&city=%22New%20York%22&stateCode=NY&countryCode=US&page=0&size=200&sort=date,asc&startDateTime='.$startDate.'T00:00:00Z&endDateTime='.$startDate.'T23:59:00Z';        
        $resp=$this->curlRequest($url,$time);       
        if(isset($resp['_embedded']['events']) && count($resp['_embedded']['events'])){
        $events = $eventIds = array();
        foreach ($resp['_embedded']['events'] as $value) {            
            if(isset($value['dates']['start']['dateTime']) && !empty($value['dates']['start']['dateTime']))
                $startDateTime = new time($value['dates']['start']['dateTime']);
            else
                $startDateTime = new time($value['dates']['start']['localDate']);

            if($startDateTime < Time::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', strtotime(SCRAPER_DAYS)))->setTime(23,59)){
            if(($startDateTime < new time(date('Y-m-d', strtotime($startDate . ' +1 day')))) && ($startDateTime >= new time(date('Y-m-d', strtotime($startDate . ' -1 day'))))){
            $eventIds[]= $eventId =trim($value['id']);
            $events[$eventId]['ticketmaster_event_id'] = trim($value['id']);
            $events[$eventId]['name'] = (isset($value['name']) && !empty($value['name']))?html_entity_decode(trim($value['name'])):null;
             $events[$eventId]['ticket_url'] = (isset($value['url']) && !empty($value['url']))?trim($value['url']):null;
            $events[$eventId]['payment_type'] = !empty($value['priceRanges'])?PAID:FREE;
            $events[$eventId]['start_date'] = $startDateTime;                    
            $events[$eventId]['description'] = (isset($value['info']) && !empty($value['info']))?html_entity_decode(trim($value['info'])):null;
            $events[$eventId]['latitude'] = (isset($value['_embedded']['venues']['0']['location']['latitude']) && !empty($value['_embedded']['venues']['0']['location']['latitude']))?trim($value['_embedded']['venues']['0']['location']['latitude']):null;
            $events[$eventId]['longitude'] = (isset($value['_embedded']['venues']['0']['location']['longitude']) && !empty($value['_embedded']['venues']['0']['location']['longitude']))?trim($value['_embedded']['venues']['0']['location']['longitude']):null;
            $events[$eventId]['image'] = (isset($value['images']['0']['url']) && !empty($value['images']['0']['url']))?$value['images']['0']['url']:null;
           
            $events[$eventId]['location'] = $this->createEventLoctaionData($value['_embedded']['venues']['0'], $this->SCRAPER_WEBSITE['ticketmaster']);

            if(!empty($value['_embedded']['venues']['0']['city']['name']))
            $events[$eventId]['city'] = $value['_embedded']['venues']['0']['city']['name'];
            
            if(!empty($value['_embedded']['venues']['0']['state']['name']))
            $events[$eventId]['region'] = $value['_embedded']['venues']['0']['state']['name'];
                
            if(!empty($value['_embedded']['venues']['0']['postalCode']))
            $events[$eventId]['postal_code'] = $value['_embedded']['venues']['0']['postalCode'];
               
            if(!empty($value['_embedded']['venues']['0']['country']['countryCode']))
            $events[$eventId]['country'] = $value['_embedded']['venues']['0']['country']['countryCode'];

            $events[$eventId]['event_status'] = (isset($value['dates']['status']['code']) && !empty($value['dates']['status']['code']))?trim($value['dates']['status']['code']):null;

            $events[$eventId]['category'] = $this->createEventCategoryData($value['classifications']['0'], $this->SCRAPER_WEBSITE['ticketmaster']);
            $events[$eventId]['website'] = $this->SCRAPER_WEBSITE['ticketmaster'];
            }
            } 
        }        
            if(!empty($eventIds)) {
                $this->TicketmasterEvents->saveNupdateData($events, $eventIds);
                if($startDate <= $endDate){
                    $nextDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
                    $this->getTicketmasterData($nextDate, $endDate,$time);
                } 
            }
        }
        
    }

    /************* Make Event Category data *********************/
    public function createEventCategoryData($value=array(), $website) { 
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

     /************* Make Event Location Data *********************/
    public function createEventLoctaionData($address=array(), $website) { 
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

    /** get categories & subcategories form EventBrite API and Save it *****/
    public function getEventBriteCategories($pageNumber=1, $continuation=NULL, $type=NULL,$time)
    {
        if(!empty($type)){
            $url =$this->SCRAPER_ROOT_URL['eventbriteurl'].$type.'/?token='.$this->SCRAPER_ROOT_URL_TOKEN['eventbritetoken'].'&page='.$pageNumber;
            if($pageNumber >1)
                $url .='&continuation='.$continuation;

            $getData=$this->curlRequest($url,$time); 
            $getSubcategory=$eventIds=[];
            if(!empty($getData[$type]) && count($getData[$type])){
                foreach ($getData[$type] as $key => $value){
                    $eventIds[]= trim($value['id']);
                    $getSubcategory[$key]['scraper_category_id']=$value['id'];
                    $getSubcategory[$key]['name']=$value['name'];
                    $getSubcategory[$key]['website']=$this->SCRAPER_WEBSITE['eventbrite'];
                }
                $this->ScraperCategories->updateScraperCategories($getSubcategory, $eventIds, $this->SCRAPER_WEBSITE['eventbrite']);
                if(!empty($getData['pagination']['has_more_items'])){
                  $pageNumber=$pageNumber+1;        
                  $this->getEventBriteCategories($pageNumber,$getData['pagination']['continuation'],$type,$time);  
                }
                return true;
            }
        }
    }

    
    // Update Category in Scraping table
    
    public function updateScraperCategory() {        
        $spaycCategories = $this->getSpaycCategories();
        $scraperCategories = $this->getScraperCategories();
        $response = [];
        //Fuzzy Logic
//        $fuzz = new Fuzz();
//        $process = new Process($fuzz);

        if ($spaycCategories) {
            foreach ($spaycCategories as $spayc) {
                foreach ($scraperCategories as $scrap) {
                    if (!$scrap['spayc_category_id']) {
//                    $percentage=$fuzz->tokenSetRatio($spayc['name'], $scrap['name']);
//                    if($percentage>MAX_CATEGORY_PERCENTAGE){
                        if (strtolower($spayc['name']) == strtolower($scrap['name'])) {
                            $update['spayc_category_id'] = $spayc['id'];
                            $condition['id'] = $scrap['id'];
                            $response[] = TableRegistry::get('scraper_categories')->UpdateAll($update, $condition);
                        }
//                        else{
//                            $otherCat = TableRegistry::get('scraper_categories')->createOtherCategory($scrap['name']);
//                            if($otherCat){
//                                $update['spayc_category_id'] = $otherCat['id'];
//                                $condition['id'] = $scrap['id'];
//                                $response[] = TableRegistry::get('scraper_categories')->UpdateAll($update, $condition);
//                            }
//                            
//                        }
                    }
                }
            }
        }
        return $response;
    }

    public function getSpaycCategories() {
       $categories = TableRegistry::get('Api.SpaycCategories')->find('all',['conditions' => ['SpaycCategories.parent_id IS NOT NULL']])->toArray();       
       return $categories;
    }
    
    
     public function getScraperCategories() {
       $categories = TableRegistry::get('scraper_categories')->find('all')->toArray();
       return $categories;
    }
    
    // Update Category in Scraping table
    
    //Create & Update Spayc Logic
    
    public function saveDataSpaceTable()
    {       
        //Getting Token User
        $plain_token= TableRegistry::get('Users')->getUserTokenScraper();
        
        //Moving Events from 3 Tables into Spayc
         if(isset($plain_token) && !empty($plain_token)) {
            $this->createSpayc($plain_token);
         }else{
             return "Invalid User or Token";
         }
    }
    
    public function createSpayc($plain_token) {
        
            
            $where=['group_id IS' => NULL,'latitude IS NOT' => NULL,'longitude IS NOT' => NULL];
          //Stubhub
          $stubhub_data = $this->StubhubEvents->find('all',['conditions' => $where])->toArray();
          $this->cURLProcess($stubhub_data,$plain_token,$this->StubhubEvents,$this->SCRAPER_WEBSITE['stubhub'],UNIQUE);

          //TicketMaster
          $ticketmaster_data = $this->TicketmasterEvents->find('all',['conditions' => $where])->toArray();
          $this->cURLProcess($ticketmaster_data,$plain_token,$this->TicketmasterEvents,$this->SCRAPER_WEBSITE['ticketmaster'],UNIQUE);
          
          //EventbriteEvents
          $eventbrite_data = $this->EventbriteEvents->find('all',['conditions' => $where])->toArray();           
          $this->cURLProcess($eventbrite_data,$plain_token, $this->EventbriteEvents,$this->SCRAPER_WEBSITE['eventbrite'],UNIQUE);
            
            
            
           //Duplicate Data
               
            $duplicate_date = $this->getDuplicateData('eventbrite_events');   
            if($duplicate_date)
            $this->cURLProcess($duplicate_date,$plain_token,$this->EventbriteEvents,$this->SCRAPER_WEBSITE['eventbrite'],DUPLICATE);
    
            
            $duplicate_date = $this->getDuplicateData('stubhub_events');   
            if($duplicate_date)
            $this->cURLProcess($duplicate_date,$plain_token,$this->StubhubEvents,$this->SCRAPER_WEBSITE['stubhub'],DUPLICATE);
    
            
            $duplicate_date = $this->getDuplicateData('ticketmaster_events');   
            if($duplicate_date)
            $this->cURLProcess($duplicate_date,$plain_token,$this->TicketmasterEvents,$this->SCRAPER_WEBSITE['ticketmaster'],DUPLICATE);
    
            
        
    }
    
    public function cURLProcess($record, $plain_token, $obj,$website,$duplicate) {
        $base_url = Configure::read('App.BASE_URL');
        $url = $base_url . 'api/spaycs.json';
        $update_url = $base_url . 'api/spayc-edit.json';
        foreach ($record as $value) {
            $getIds = $createSpaceData = [];
            $starttime = microtime(true);       //Checking time
            $spayc_id=0;    //Default Spayc Define
            $response=[];
            $getIds[] = $value['id'];
            $createSpaceData['name'] = $value['name'];
            $createSpaceData['ticket_url'] = trim($value['ticket_url']);
            $createSpaceData['payment_type'] = trim($value['payment_type']);
            if($value['location']){ 
                $createSpaceData['location'] = $value['location'];            
            }else{
                $createSpaceData['location'] = "NA";                
            }
            $createSpaceData['type'] = 'Event';
            $createSpaceData['group_type'] = 'Public';
            $createSpaceData['start_date'] = date('m-d-Y H:i:s', strtotime($value['start_date']));
            $createSpaceData['end_date'] = !empty($value['end_date']) ? date('m-d-Y H:i:s', strtotime($value['end_date'])) : date('m-d-Y H:i:s', strtotime('+1 day', strtotime($value['start_date'])));
            $description = $value['description'];
            if ($description) {
                $createSpaceData['description'] = $description;
            } else {
                $createSpaceData['description'] = "";
            }
            $createSpaceData['image'] = $value['image'];
            $createSpaceData['longitude'] = $value['longitude'];
            $createSpaceData['latitude'] = $value['latitude'];
            $createSpaceData['website'] = $website;
            $http = new Client(['headers' => ['token' => $plain_token]]);
            
            
                if ($value['spayc_id']) {
                    $createSpaceData['spayc_id'] = $value['spayc_id'];
                    $createSpaceData['is_admin_update'] = 1;

                    //cUrl Request for Update Spayc Details
                    $httpResponse = $http->post($update_url, $createSpaceData);
                    $response['Update Spayc'][] = json_decode($httpResponse->body, true);
                    $spayc_id=$value['spayc_id'];
                } else {
                    $cat =str_replace(" ", "", $value['category']);
                     $category = $this->ScraperCategories->isCatExist($cat,$website);
                    //If Category Exist in Spayc
                    if ($category) {
                        $createSpaceData['spayc_category_id'] = $category[1];
                        if($category[2]){
                            $createSpaceData['description'].= " #".str_replace(" ", "", $category[2]);
                        }
                        $httpResponse = $http->post($url, $createSpaceData);
                        $response['Create New Spayc'][] =$created= json_decode($httpResponse->body, true);
                        //Updating Spayc ID in Related tables
                        if ($created['status'] == 'success') {
                            $update['spayc_id'] = $created['data']['id'];
                            $condition['id'] = $value['id'];
                            $response['Update 3 Scrap Tables Spayc_id'] = $obj->UpdateAll($update, $condition);
                            
                        //Saving All Categories with Spayc
                                if(!empty($category[0])){
                                $scrapModel = TableRegistry::get('scraper_spayc_categories');
                                    foreach ($category[0] as $val){
                                        $entity = $scrapModel->newEntity();
                                        $entity->category_id = $val->spayc_category_id;
                                        $entity->spayc_id = $update['spayc_id'];
                                        $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                                        $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                                        $created = $scrapModel->save($entity);
                                    }
                                }
                                 $spayc_id=$update['spayc_id'];
                        }else{
                            //Saving logs
                            $pushData['post_value'] = json_encode($created);
                            $pushData['created'] = date("Y-m-d H:i:s");
                            //Log::info(json_encode($pushData,JSON_PRETTY_PRINT));
                            $pusher = TableRegistry::get("Api.PusherData");
                            $push = $pusher->newEntity();
                            $entity = $pusher->patchEntity($push, $pushData,['validate'=>false]);
                            $pusher->save($entity);
                        }
                    } else {
                        $response['Category'][] = $value['category'] . " - Category Not Exist";
                    }
                }
            
                //Updating Group ID in 3 tables
                if($spayc_id && $duplicate==DUPLICATE){
                    $update_duplicate['spayc_id'] = $spayc_id;
                    $condition_duplicate['group_id'] = $value['group_id'];
                    $condition_duplicate['start_date'] = $value['start_date'];
                    $this->EventbriteEvents->UpdateAll($update_duplicate, $condition_duplicate);
                    $this->TicketmasterEvents->UpdateAll($update_duplicate, $condition_duplicate);
                    $this->StubhubEvents->UpdateAll($update_duplicate, $condition_duplicate);
                }
                $endtime = microtime(true);       //Checking time
                $response['Time Taken']=$endtime - $starttime;
            // pr(json_encode($response,JSON_PRETTY_PRINT));
        }
    }
    
   public function array_flatten($array) { 
    foreach ($array as $childArray) {
        foreach ($childArray as $value) {
            $flattenArray[] = $value;
        }
    }
    return $flattenArray;
} 


   
    //Create & Update Spayc Logic
    
    /** get primary,secondary and Tertiary categories level form Ticketmaster API and Save it *****/
    public function getTicketmasterCategories($time) {
        $url=$this->SCRAPER_ROOT_URL['ticketmasterurl'].'classifications.json?apikey='.$this->SCRAPER_ROOT_URL_TOKEN['ticketmastertoken'].'&size=200';
        $resp=$this->curlRequest($url,$time); 
        if((isset($resp['_embedded']['classifications']) && !empty($resp['_embedded']['classifications'])) && count($resp['_embedded']['classifications'])){
            $geCategory=$eventIds=[];
            foreach ($resp['_embedded']['classifications'] as $key => $value){
                if(isset($value['segment']) && !empty($value['segment'])){
                    $eventIds[]=$catId=trim($value['segment']['id']);
                    $geCategory[$catId]['scraper_category_id']=trim($value['segment']['id']);
                    $geCategory[$catId]['name']=trim($value['segment']['name']);
                    $geCategory[$catId]['website']=$this->SCRAPER_WEBSITE['ticketmaster'];
                    foreach ($value['segment']['_embedded']['genres'] as $key => $value) {
                        $eventIds[]=$catId=trim($value['id']);
                        $geCategory[$catId]['scraper_category_id']=trim($value['id']);
                        $geCategory[$catId]['name']=trim($value['name']);
                        $geCategory[$catId]['website']=$this->SCRAPER_WEBSITE['ticketmaster'];
                        foreach ($value['_embedded']['subgenres'] as $key => $value) {
                            $eventIds[]=$catId=trim($value['id']);
                            $geCategory[$catId]['scraper_category_id']=trim($value['id']);
                            $geCategory[$catId]['name']=trim($value['name']);
                            $geCategory[$catId]['website']=$this->SCRAPER_WEBSITE['ticketmaster'];
                        }
                    }
                }
            }
            $this->ScraperCategories->updateScraperCategories($geCategory, $eventIds, $this->SCRAPER_WEBSITE['ticketmaster']);
        }
    }

    /*** returns currentDateTime in Y-m-d H:i:s Format***/
    public function currentDateTime(){                                        
        return date(DATE_TIME_FORMAT);
    }

    /*** Takes an array and returns an array of duplicate items */
    public function get_duplicates($array) {
        return array_unique(array_diff_assoc($array, array_unique($array)));
    }

    /*** Take string and return with single quote ***/
    public function get_quotesstring($string) {
        return (!empty($string))?"'".$string."'":'';
    }
    
    /*** get db connection obj ***/
    public function getConnectionObj($obj){
        return ConnectionManager::get($obj);
    }

    /*** Take website name and return table Obj ***/
    public function gettableObj($data) {
        $obj='';
        if(!empty($data)){            
            if($data == $this->SCRAPER_WEBSITE_FLIP['1'])
                $obj=$this->EventbriteEvents;
            else if($data == $this->SCRAPER_WEBSITE_FLIP['2'])
                $obj=$this->TicketmasterEvents;
            else if($data == $this->SCRAPER_WEBSITE_FLIP['3'])
                $obj=$this->StubhubEvents;
        }
        return $obj;
    }    

    /*** Get all union data from eventbrite,ticketmaster and stubhub table ***/
    public function getUnionData($condition) {          
        $sql="select event_id,type,name,start_date,latitude,longitude,group_id,location,category from 
        (
        ".$this->EventbriteEvents->unionCommonQuery()."
        ) as A ".$condition;
        $stmt = $this->getConnectionObj('default')->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }
    
     /*** Get all union data from  eventbrite,ticketmaster and stubhub table ***/
    public function getDuplicateData($table) {          
        $sql="select * from $table where latitude IS NOT NULL and longitude IS NOT NULL and spayc_id IS NULL AND group_id IS NOT NULL ORDER BY group_id,start_date desc";
        $stmt = $this->getConnectionObj('default')->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        $duplicate=[];
        $duplicate_date=[];
        if($rows){
        foreach ($rows as $key => $value) {            
           $duplicate[$value['group_id']][$value['start_date']]=$value;
            }  
        
        $duplicate_date=$this->array_flatten($duplicate);
        }
        return $duplicate_date;
    }
    
    /***  Get all Common Date data from eventbrite,ticketmaster and stubhub table ***/
    public function getUnionDataWithCommonDate($having) {          
        $sql="select count(group_id),group_id,array_agg(start_date) from 
        (".$this->EventbriteEvents->unionCommonQuery()."
        ) as A group by A.group_id ".$having;

        $stmt = $this->getConnectionObj('default')->execute($sql);
        $rows = $stmt->fetchAll('assoc');
        return $rows;
    }

    /*** uddate record based on several condition in eventbrite,ticketmaster and stubhub table ***/
    public function updateScraper($table, $tableObj, $value, $type, $group_id) {  
        if(!empty($type)) {                
            if($type == SCRAPERGROUPFILTER){
                $sql=" select ".$table."_event_id from ".$table."_events where gc_dist(latitude,longitude,".$value['latitude'].",".$value['longitude'].") <= ".DISTANCEINMETER." and group_id IS NULL";
            } else if ($type == SCRAPERCOMMONDATEFILTER){
                $sql=" select ".$table."_event_id from ".$table."_events where group_id=".$value['group_id']." and start_date NOT IN (".$value['start_date'].")";
            } else if ($type == SCRAPERUNIQUEFILTER){
                $sql=" select ".$table."_event_id from ".$table."_events where group_id=".$value['group_id']." and start_date IN (".$value['start_date'].")";
            }    
            $stmt = $this->getConnectionObj('default')->execute($sql);
            $rows = $stmt->fetchAll('assoc');
            if(!empty($rows)){
              $masterIds = array_column($rows, $table.'_event_id');
              $eventsquery = $tableObj->query();
              $res = $eventsquery->update()
                        ->set(['group_id' => $group_id])
                        ->where([$table.'_event_id IN ' => $masterIds])
                        ->execute();
            }
        }   
        
    }

    /*** set group_id NULL based on $table_event_id in eventbrite,ticketmaster and stubhub table ***/
    public function updateSingleReord($table, $tableObj, $id, $group_id) {       
        if(!empty($table)) {
            $tablequery = $tableObj->query();
            $res = $tablequery->update()
                    ->set(['group_id' => $group_id])
                    ->where([$table.'_event_id IN ' => $id])
                    ->execute();
        }
    }

    /** First step assign group for same(under 100 meter) lat long*****/
    public function filterByLatLong() {
        $lat_long_group = $this->getUnionData('ORDER BY A.latitude, A.longitude desc');
        $checkStatus=false;
        if(count($lat_long_group)){            
            foreach ($lat_long_group as $key => $value) {
                $token = md5(uniqid(mt_rand(), true));
                $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['3'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['3']), $value, SCRAPERGROUPFILTER, $token);
                $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['2'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['2']), $value, SCRAPERGROUPFILTER, $token);
                $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['1'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['1']), $value, SCRAPERGROUPFILTER, $token);
            }
            $checkStatus=true; 
        }
        return $checkStatus;
    }

    /** Second step Re-assign group for same lat long and same date*****/
    public function filterByDate($type) {  
         
        if($type==SCRAPERUNIQUEFILTER){
            $groupByDate = $this->getUnionDataWithCommonDate('having count(group_id)=1');
        } else if($type==SCRAPERCOMMONDATEFILTER){
            $groupByDate = $this->getUnionDataWithCommonDate('having count(group_id)>1');            
        }
        $checkStatus=false;
        if(count($groupByDate)){     
            foreach ($groupByDate as $key => $value) { 
                $array_agg=str_replace(["{","}"], "", $value['array_agg']);
                $array_agg=explode(',', $array_agg);   
                $value['group_id'] = $this->get_quotesstring($value['group_id']);
                if($type!=SCRAPERUNIQUEFILTER)
                    $duplicateDates = $this->get_duplicates($array_agg);

                if(!empty($duplicateDates)){ 
                    $start_date=str_replace('"', "'",implode(",",$duplicateDates));
                    $value['start_date']=$start_date;
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['3'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['3']), $value, $type, NULL);
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['2'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['2']), $value, $type, NULL);
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['1'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['1']), $value, $type, NULL);
                } else{
                    $start_date=str_replace('"', "'",implode(",",$array_agg));
                    $value['start_date']=$start_date;
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['3'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['3']), $value, SCRAPERUNIQUEFILTER, NULL);
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['2'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['2']), $value, SCRAPERUNIQUEFILTER, NULL);
                    $this->updateScraper($this->SCRAPER_WEBSITE_FLIP['1'], $this->gettableObj($this->SCRAPER_WEBSITE_FLIP['1']), $value, SCRAPERUNIQUEFILTER, NULL);
                }
            }
            $checkStatus=true;
        }
        return $checkStatus;
    }

    /*** compare events name which belong to same date and lat-long***/
    public function checkNameByFuzzyLogic($eventName, $eventType, $value){
        if(!empty($eventName) && !empty($value)){
            $fuzz = new Fuzz();
            $process = new Process($fuzz);
            $total = count($value);
            $firstEventId=$value['0']['event_id'];
            $firstEventName=$value['0']['name'];
            $firstEventType=$value['0']['type'];
            unset($eventName[$firstEventId]);  
            $checkCount=1;
            foreach($eventName as $eventId =>$name) {                        
                if($eventId != $firstEventId) { 
                    $eventNamePer=$fuzz->tokenSetRatio($firstEventName, $name);
                    $checkFuzzyMatch=false;
                    if($eventNamePer < FUZZYPERCENT){ 
                        $checkFuzzyMatch=true;
                        $this->updateSingleReord($eventType[$eventId], $this->gettableObj($eventType[$eventId]), $eventId, NULL);
                    }
                    if($checkFuzzyMatch && ($total==($checkCount+1))){
                        $this->updateSingleReord($firstEventType, $this->gettableObj($firstEventType), $firstEventId, NULL);
                    }
                    $checkCount++;
                }
            }                
        }
    }

    /*** set log for scraper to identify all process running smoothly ***/
    public function setScraperLog($status,$time,$shell=null){
        if(!empty($status)){
            $data['status'] = trim($status);
            $data['shell'] = $shell;
            $data['unique_time'] = $time;
            $data['start_time'] = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
            $data['end_time'] = NULL;
            $scraperlogs = $this->ScraperLogs->newEntity();
            $scraperlog = $this->ScraperLogs->patchEntity($scraperlogs,$data);
            $this->ScraperLogs->save($scraperlog); 
        }
    }
    
     /*** update log for scraper to identify all process running smoothly ***/
    public function updateScraperLog($time,$response=""){
        if(!empty($time)){
            $data['end_time'] = (new Time('now', Configure::read('timezone')))->setTimezone('UTC')->format("Y-m-d H:i:s");
            if($response)
                $data['response'] = $response;
              $query = $this->ScraperLogs->query();
              $res = $query->update()
                        ->set($data)
                        ->where(['unique_time' => $time])
                        ->execute();
        }
    }
    
     /*** fetch Failure Process ***/
    public function failureRecords(){
            
        $where=['end_time IS' => NULL,'response IS NOT' => NULL,'DATE(start_time)' => date('Y-m-d')];
        return $data = $this->ScraperLogs->find('all',['fields' => ['shell','unique_time']])->where($where)->toArray();
        
    }

    /*** Get all events name which belong to same date and lat-long ***/
    public function checkEventName($data){
        if(!empty($data)){        
            foreach ($data as $key => $value) { 
                $alleventsName =  \Cake\Utility\Hash::combine($value, '{n}.event_id', '{n}.name');
                $alleventsType =  \Cake\Utility\Hash::combine($value, '{n}.event_id', '{n}.type');
                $this->checkNameByFuzzyLogic($alleventsName, $alleventsType, $value);
            }
        }
    }

    /*** Third step Re -assign group for same lat-long, date, name ***/
    public function filterByName() {
        $groupBydateAndLatLong = $this->getUnionData('where A.group_id IS NOT NULL ORDER BY group_id,start_date desc');    
        $checkStatus=false;   
        if(count($groupBydateAndLatLong)){
            $gr=$res=$date=[];  
            foreach ($groupBydateAndLatLong as $key => $value) {             
                if(in_array($value['group_id'], $gr)){
                    if(in_array($value['start_date'], $date)){                        
                        $res[$value['group_id']][$value['start_date']][]=$value;
                    } else {
                        array_push($date, $value['start_date']);
                        $res[$value['group_id']][$value['start_date']][]=$value;
                    }
                } else {
                    if(!empty($gr) && ($value['group_id'] != end($gr)))
                       $this->checkEventName($res[end($gr)]);
                    array_push($gr, $value['group_id']);
                    array_push($date, $value['start_date']);
                    $res[$value['group_id']][$value['start_date']][]=$value;
                }
               
            }
            $checkStatus=true; 
        }
        return $checkStatus;
    }
}
/**** End ThirdPartyData Component*******/
