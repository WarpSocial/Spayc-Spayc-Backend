<?php

namespace Api\Controller;

use Api\Controller\AppController;

/**
 * WebApi Controller
 *
 * @property \Api\Model\Table\WebApiTable $WebApi
 */
class WebApiController extends AppController {

    /**
     * initialize the controller config
     */
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Matrix');
        $this->loadComponent('Api.Push');
    }
    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['addCategory','apilog','addComment']);
    }
    
    
    
    public function addCategory(){
        $cats = [
            'Music'=>["Hip Hop & Rap ","Top 40","Blues & Jazz","Classical","Reggae","Other","Latin","Rock","R&B","Alternative","Pop","Country","Indie","Electronic & EDM","Cultural","Folk","Opera","Spiritual & Religious","Metal","Acid Jazz","Acoustic ","Alternative Music","Ambient","Bluegrass","Blues Music","Bossa Nova ","Breakbeat","Cajun and Zydeco ","Calypso ","Caribbean","Celtic","Childrens","Christian","Classical and vocal music","Country and folk music","Cover/Tribute","Dance and Electronic music ","Disco ","Dixieland ","Doo Wop ","Easy Listening ","Electronic ","Flamenco","Freestyle ","Funk ","Garage ","Gospel ","Gothic","Hard Rock and Metal music","Hardcore ","House ","Indie ","Industrial","Jazz Music","Jazz","Karaoke","Latic music","Lounge ","Mariachi","Miscellaneous music","Music Festival","New Age and Spiritual Music","Polka ","Pop Music","Progressive rock ","Punk ","Rap and Hip-hop music","RB and Soul music","Reggae Music","Rock, Pop and hip-hop","Rockabilly ","Samba","Ska","Surf Rock ","Tejano","Trance","Vocal Performance Music ","Western","World Music"],
            'Sports'=>["Amateur sports","Athletics","Aviation","Baseball","Basketball","Birding","Bodybuilding","Bowling","Chess ","Cricket","Curling","Cycling","Dance","Darts","Equestrian","Extreme Sports","Fight","Figure Skating","Fishing","Football","Golf","Gymnastics","Handball","Hockey","Horse Racing","Hunting","Hurling","Jousting","Judo","Kabaddi","Karate","Lacrosse ","Marching Band","Motorsports","Polo","Rec and Wellness","Recreation","Rodeo","Roller Derby","Roller Skating","Rowing","Rugby","Sailing","Skateboarding","Ski Lift","Snooker","Soccer","Softball","Sports and outdoors","Squash","Sumo Wrestling","Swimming","Table Tennis","Tennis","Track and Field","Volleyball","Waterpolo","Winter Sports","Wrestling","Boxing","Bull Riding","Competitions","Field Sports","Mixed Martial Arts"],
            'Theater and Comedy'=>["Arts & crafts","Classical Music and Opera","Comedy","Dance / Ballet","Family","Festivals and fairs","Food and Dining","Horse show","Movie Event","Museum","Musicals","Performing Arts","Plays","Speaking Tour / Convention","VIP events and party","Visual Arts"],
            'TicketMaster'=>["Alternative Rock ","Cabaret ","Classical ","Comedy ","Country and Folk ","Dance/Electronic ","Festivals ","Hard Rock/Metal ","Jazz and Blues ","Latin ","New Age and Spiritual ","R&B/Urban Soul ","Rap and Hip-Hop ","Rock and Pop ","World Music ","Miscellaneous"],
            'Arts and Theater'=>["Broadway","Off-Broadway","Ballet and Dance","Classical","Comedy","Film Festivals","Museums and Exhibits","Musicals","Opera","Plays"],
            'Family'=>["Children's Music and Theater","Circus","Fairs and Festivals","Family Attractions","Ice Shows","Magic Shows"],
            'Other'=>["Party","Performance","Class","Tour","Festival","Appearance","Networking","Other","Seminar","Gala","Attraction","Conference","Game","Screening","Tournament","Retreat","Expo"]
        ];
        $catEntity = \Cake\ORM\TableRegistry::get('Api.SpaycCategories');
        $catEntity->connection()->query('TRUNCATE TABLE spayc_categories')->execute();
        foreach($cats as $cat=>$subcats){
            $pcat = $catEntity->newEntity([
                'name'=>$cat,
                'slug'=> \Cake\Utility\Inflector::slug(strtolower($cat)),
                'description'=>$cat]
                );
            $pEntity = $catEntity->save($pcat);
            if($pEntity && is_array($subcats)){
                foreach($subcats as $key=>$child){
                    $childCat = $catEntity->newEntity([
                    'parent_id'=>$pcat->id,
                    'name'=>$child,
                    'slug'=> \Cake\Utility\Inflector::slug(strtolower($child)),
                    'description'=>$child]
                    );
                    $catEntity->save($childCat);
                }
            }
        }
        die("END");
    }
    
    public function apilog(){
        $del = $this->request->getQuery('clean');
        $file = new \Cake\Filesystem\File(LOGS.'api.log');
        if(!empty($del) && ($del == 1)){
            $file->write(null);
        }
        $errorfile = $file->read();
        $this->set($errorfile);
    }


}
