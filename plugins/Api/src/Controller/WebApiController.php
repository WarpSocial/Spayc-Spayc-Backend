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
        $this->Auth->allow(['addCategory', 'apilog', 'addComment', 'notify']);
    }

    public function addCategory() {
        $cats = [
            'Music' => ['title'=>'Music','code'=>'1F3B6','child'=>[                
                ["title" => "Hip Hop & Rap", "code" => "1F3B6"],
                ["title" => "Top 40", "code" => "1F3B6"],
                ["title" => "Blues & Jazz", "code" => "1F3B6"],
                ["title" => "Classical", "code" => "1F3B6"],
                ["title" => "Reggae", "code" => "1F3B6"],
                ["title" => "Other", "code" => "1F3B6"],
                ["title" => "Latin", "code" => "1F3B6"],
                ["title" => "Rock", "code" => "1F3B6"],
                ["title" => "R&B", "code" => "1F3B6"],
                ["title" => "Alternative", "code" => "1F3B6"],
                ["title" => "Pop", "code" => "1F3B6"],
                ["title" => "Country", "code" => "1F3B6"],
                ["title" => "Indie", "code" => "1F3B6"],
                ["title" => "Electronic & EDM", "code" => "1F3B6"],
                ["title" => "Cultural", "code" => "1F3B6"],
                ["title" => "Folk", "code" => "1F3B6"],
                ["title" => "Opera", "code" => "1F3B6"],
                ["title" => "Spiritual & Religious", "code" => "1F3B6"],
                ["title" => "Metal", "code" => "1F3B6"],
                ["title" => "Acid Jazz ", "code" => "1F3B6"],
                ["title" => "Acoustic", "code" => "1F3B6"],
                ["title" => "Alternative Music", "code" => "1F3B6"],
                ["title" => "Ambient ", "code" => "1F3B6"],
                ["title" => "Bluegrass", "code" => "1F3B6"],
                ["title" => "Blues Music ", "code" => "1F3B6"],
                ["title" => "Bossa Nova", "code" => "1F3B6"],
                ["title" => "Breakbeat ", "code" => "1F3B6"],
                ["title" => "Cajun and Zydeco", "code" => "1F3B6"],
                ["title" => "Calypso", "code" => "1F3B6"],
                ["title" => "Caribbean", "code" => "1F3B6"],
                ["title" => "Celtic", "code" => "1F3B6"],
                ["title" => "Childrens", "code" => "1F3B6"],
                ["title" => "Christian", "code" => "1F3B6"],
                ["title" => "Classical and vocal music", "code" => "1F3B6"],
                ["title" => "Country and folk music", "code" => "1F3B6"],
                ["title" => "Cover/Tribute", "code" => "1F3B6"],
                ["title" => "Dance and Electronic music", "code" => "1F3B6"],
                ["title" => "Disco", "code" => "1F3B6"],
                ["title" => "Dixieland", "code" => "1F3B6"],
                ["title" => "Doo Wop", "code" => "1F3B6"],
                ["title" => "Easy Listening", "code" => "1F3B6"],
                ["title" => "Electronic", "code" => "1F3B6"],
                ["title" => "Flamenco", "code" => "1F3B6"],
                ["title" => "Freestyle", "code" => "1F3B6"],
                ["title" => "Funk", "code" => "1F3B6"],
                ["title" => "Garage", "code" => "1F3B6"],
                ["title" => "Gospel", "code" => "1F3B6"],
                ["title" => "Gothic", "code" => "1F3B6"],
                ["title" => "Hard Rock and Metal music", "code" => "1F3B6"],
                ["title" => "Hardcore", "code" => "1F3B6"],
                ["title" => "House", "code" => "1F3B6"],
                ["title" => "Indie", "code" => "1F3B6"],
                ["title" => "Industrial", "code" => "1F3B6"],
                ["title" => "Jazz Music", "code" => "1F3B6"],
                ["title" => "Jazz, Blues and RnB music", "code" => "1F3B6"],
                ["title" => "Karaoke / Open mic", "code" => "1F3B6"],
                ["title" => "Latic music", "code" => "1F3B6"],
                ["title" => "Lounge", "code" => "1F3B6"],
                ["title" => "Mariachi", "code" => "1F3B6"],
                ["title" => "Miscellaneous music", "code" => "1F3B6"],
                ["title" => "Music Festival", "code" => "1F3B6"],
                ["title" => "New Age and Spiritual Music", "code" => "1F3B6"],
                ["title" => "Polka", "code" => "1F3B6"],
                ["title" => "Pop Music", "code" => "1F3B6"],
                ["title" => "Progressive rock", "code" => "1F3B6"],
                ["title" => "Punk", "code" => "1F3B6"],
                ["title" => "Rap and Hip", "code" => "1F3B6"],
                ["title" => "RB and Soul music", "code" => "1F3B6"],
                ["title" => "Reggae Music", "code" => "1F3B6"],
                ["title" => "Rock, Pop and hip", "code" => "1F3B6"],
                ["title" => "Rockabilly", "code" => "1F3B6"],
                ["title" => "Samba", "code" => "1F3B6"],
                ["title" => "Ska", "code" => "1F3B6"],
                ["title" => "Surf Rock", "code" => "1F3B6"],
                ["title" => "Tejano", "code" => "1F3B6"],
                ["title" => "Trance", "code" => "1F3B6"],
                ["title" => "Vocal Performance Music", "code" => "1F3B6"],
                ["title" => "Western", "code" => "1F3B6"],
                ["title" => "World Music", "code" => "1F3B6"],
                ["title" => "Alternative Rock", "code" => "1F3B6"],
                ["title" => "Cabaret", "code" => "1F3B6"],
                ["title" => "Classical", "code" => "1F3B6"],
                ["title" => "Comedy", "code" => "1F3B6"],
                ["title" => "Country and Folk", "code" => "1F3B6"],
                ["title" => "Dance/Electronic", "code" => "1F3B6"],
                ["title" => "Festivals", "code" => "1F3B6"],
                ["title" => "Hard Rock/Metal", "code" => "1F3B6"],
                ["title" => "Jazz and Blues", "code" => "1F3B6"],
                ["title" => "Latin", "code" => "1F3B6"],
                ["title" => "New Age and Spiritual", "code" => "1F3B6"],
                ["title" => "R&B/Urban Soul", "code" => "1F3B6"],
                ["title" => "Rap and Hip", "code" => "1F3B6"],
                ["title" => "Rock and Pop", "code" => "1F3B6"],
                ["title" => "World Music", "code" => "1F3B6"],
                ["title" => "Miscellaneous", "code" => "1F3B6"]
            ]],
            'Sports' => ['title'=>'Sports','code'=>'1F3BD','child'=>[
                ["title" => "Amateur sports", "code" => "1F3BD"],
                ["title" => "Athletics", "code" => "1F3BD"],
                ["title" => "Aviation", "code" => "1F3BD"],
                ["title" => "Baseball ", "code" => "26BE"],
                ["title" => "Birding", "code" => "1F3BD"],
                ["title" => "Bodybuilding ", "code" => "1F3CB"],
                ["title" => "Bowling ", "code" => "1F3B3"],
                ["title" => "Chess", "code" => "265F"],
                ["title" => "Cricket ", "code" => "1F3CF"],
                ["title" => "Curling", "code" => "1F3CB"],
                ["title" => "Cycling ", "code" => "1F6B4"],
                ["title" => "Dance", "code" => "1F483"],
                ["title" => "Darts ", "code" => "1F3AF"],
                ["title" => "Equestrian ", "code" => "1F3C7"],
                ["title" => "Extreme Sports", "code" => "1F3BD"],
                ["title" => "Fight ", "code" => "1F94A"],
                ["title" => "Figure Skating ", "code" => "26F8"],
                ["title" => "Fishing ", "code" => "1F41F"],
                ["title" => "Football ", "code" => "1FC38"],
                ["title" => "Golf ", "code" => "1F3CC"],
                ["title" => "Gymnastics ", "code" => "1F938"],
                ["title" => "Handball ", "code" => "1F93E"],
                ["title" => "Hockey", "code" => "1F3D1"],
                ["title" => "Horse Racing ", "code" => "1F3C7"],
                ["title" => "Hunting ", "code" => "1F52B"],
                ["title" => "Hurling", "code" => "1F3BD"],
                ["title" => "Jousting ", "code" => "1F93C"],
                ["title" => "Judo ", "code" => "1F94B"],
                ["title" => "Kabaddi ", "code" => "1F94B"],
                ["title" => "Karate ", "code" => "1F94B"],
                ["title" => "Lacrosse", "code" => "1F94D"],
                ["title" => "Marching Band ", "code" => "FE0F"],
                ["title" => "Motorsports ", "code" => "1F3CD"],
                ["title" => "Polo ", "code" => "1F3C7"],
                ["title" => "Rec and Wellness", "code" => "1F3BD"],
                ["title" => "Recreation", "code" => "1F3BD"],
                ["title" => "Rodeo ", "code" => "1F403"],
                ["title" => "Roller Derby", "code" => "1F3A2"],
                ["title" => "Roller Skating", "code" => "1F3A2"],
                ["title" => "Rowing ", "code" => "1F6A3"],
                ["title" => "Rugby ", "code" => "1F3C9"],
                ["title" => "Sailing ", "code" => "26F5"],
                ["title" => "Skateboarding", "code" => "1F3BD"],
                ["title" => "Ski Lift ", "code" => "26F7"],
                ["title" => "Snooker", "code" => "1F3BD"],
                ["title" => "Soccer ", "code" => "26BD"],
                ["title" => "Softball ", "code" => "1F94E"],
                ["title" => "Sports and outdoors", "code" => "1F3BD"],
                ["title" => "Squash", "code" => "1F3BD"],
                ["title" => "Sumo Wrestling ", "code" => "1F93C"],
                ["title" => "Swimming ", "code" => "1F3CA"],
                ["title" => "Table Tennis ", "code" => "1F3BE"],
                ["title" => "Tennis ", "code" => "1F3BE"],
                ["title" => "Track and Field ", "code" => "1F3BD"],
                ["title" => "Volleyball ", "code" => "1F3D0"],
                ["title" => "Waterpolo ", "code" => "1F93D"],
                ["title" => "Winter Sports ", "code" => "26F7"],
                ["title" => "Wrestling ", "code" => "1F93C"],
                ["title" => "Baseball ", "code" => "26BE"],
                ["title" => "Basketball", "code" => "1F3C0"],
                ["title" => "Boxing", "code" => "1F94A"],
                ["title" => "Bull Riding", "code" => "1F402"],
                ["title" => "Competitions", "code" => "1F3C6"],
                ["title" => "Curling", "code" => "1F94C"],
                ["title" => "Field Sports", "code" => "1F3D1"],
                ["title" => "Golf", "code" => "1F3CC"],
                ["title" => "Handball", "code" => "1F93E"],
                ["title" => "Hockey", "code" => "1F3D1"],
                ["title" => "Lacrosse", "code" => "1F94D"],
                ["title" => "Mixed Martial Arts", "code" => "1F94B"],
                ["title" => "Motorsports", "code" => "1F3C4"],
                ["title" => "Rodeo", "code" => "1F40E"],
                ["title" => "Skating", "code" => "26F8"],
                ["title" => "Soccer", "code" => "26BD"],
                ["title" => "Tennis", "code" => "1F3BE"],
                ["title" => "Volleyball", "code" => "1F3D0"],
                ["title" => "Wrestling", "code" => "1F93C"]
            ]],
            'Theater and Comedy' => ['title'=>'Theater and Comedy','code'=>'','child'=>[
                ["title" => "Arts & crafts", "code" => "1F3A8"],
                ["title" => "Classical Music and Opera", "code" => "1F3BB"],
                ["title" => "Comedy", "code" => "1F923"],
                ["title" => "Dance / Ballet", "code" => "1F483"],
                ["title" => "Family", "code" => "1F46A"],
                ["title" => "Festivals and fairs", "code" => "1F3AA"],
                ["title" => "Food and Dining", "code" => "1F37D"],
                ["title" => "Horse show", "code" => "1F3C7"],
                ["title" => "Movie Event", "code" => "1F3AC"],
                ["title" => "Museum", "code" => "26F0"],
                ["title" => "Musicals", "code" => "1F3BC"],
                ["title" => "Performing Arts", "code" => "1F3AD"],
                ["title" => "Plays", "code" => "1F3AD"],
                ["title" => "Speaking Tour / Convention", "code" => "1F5E3"],
                ["title" => "VIP events and party", "code" => "1F465"],
                ["title" => "Visual Arts", "code" => "1F4F9"]
            ]],
            'Arts and Theater' => ['title'=>'Arts and Theater','code'=>'','child'=>[
                ["title" => "Broadway ", "code" => "1F3AD"],
                ["title" => "Off-Broadway ", "code" => "1F3AD"],
                ["title" => "Ballet and Dance ", "code" => "1F483"],
                ["title" => "Classical ", "code" => "1F3BB"],
                ["title" => "Comedy ", "code" => "1F602"],
                ["title" => "Film Festivals  ", "code" => "1F3A5"],
                ["title" => "Museums and Exhibits ", "code" => "26F0"],
                ["title" => "Musicals ", "code" => "1F3AD"],
                ["title" => "Opera ", "code" => "1F3AD"],
                ["title" => "Plays ", "code" => "1F3AD"]
            ]],
            'Family' => ['title'=>'Family','code'=>'','child'=>[
                ["title" => "Children's Music and Theater", "code" => "26F0"],
                ["title" => "Circus", "code" => "1F939"],
                ["title" => "Fairs and Festivals", "code" => "1F3AA"],
                ["title" => "Family Attractions", "code" => "1F46A"],
                ["title" => "Ice Shows", "code" => "1F3AD"],
                ["title" => "Magic Shows", "code" => "1F3AD"]
            ]],
            'Other' => ['title'=>'Other','code'=>'','child'=>[
                ["title" => "Party ", "code" => "1F389"],
                ["title" => "party popper", "code" => "1F389"],
                ["title" => "Performance ", "code" => "1F3AD"],
                ["title" => "Class ", "code" => "270F"],
                ["title" => "Tour ", "code" => "1F5FA"],
                ["title" => "Festival ", "code" => "1F3AA"],
                ["title" => "Appearance ", "code" => "1F460"],
                ["title" => "Networking ", "code" => "1F91D"],
                ["title" => "Other ", "code" => ""],
                ["title" => "Seminar ", "code" => "270F"],
                ["title" => "Gala ", "code" => "1F91D"],
                ["title" => "Attraction ", "code" => "1F365"],
                ["title" => "Conference ", "code" => "1F91D"],
                ["title" => "Game ", "code" => "1F3AE"],
                ["title" => "Screening ", "code" => "1F3AC"],
                ["title" => "Tournament ", "code" => "1F3C6"],
                ["title" => "Retreat ", "code" => "1F365"],
                ["title" => "Expo ", "code" => "1F91D"]
            ]]
        ];
        $catEntity = \Cake\ORM\TableRegistry::get('Api.SpaycCategories');
        $catEntity->connection()->query('TRUNCATE TABLE spayc_categories RESTART IDENTITY')->execute();
        foreach ($cats as $cat => $item) {
            $pcat = $catEntity->newEntity([
                'name' => trim($item['title']),
                'code' => trim($item['code']),
                'slug' => \Cake\Utility\Inflector::slug(strtolower(trim($item['title']))),
                'description' => trim($item['title'])
                ]
            );
            $pEntity = $catEntity->save($pcat);
            if ($pEntity && is_array($item['child'])) {
                foreach ($item['child'] as $key => $child) {
                    $slug = \Cake\Utility\Inflector::slug(strtolower(trim($child['title'])));
                    if(!$catEntity->exists(['slug'=>$slug])){
                        $cInput = [
                            'parent_id' => $pcat->id,
                            'name' => trim($child['title']),
                            'code' => trim($child['code']),
                            'slug' => $slug,
                            'description' => trim($child['title'])
                            ];
                        
                        $childCat = $catEntity->newEntity($cInput);
                        $catEntity->save($childCat);
                    }
                }
            }
        }
         \Cake\Cache\Cache::delete('spayc_categories', 'long'); 
        die("END");
    }

    public function apilog() {
        $del = $this->request->getQuery('clean');
        $logfile = $this->request->getQuery('file', 'api.log');
        $file = new \Cake\Filesystem\File(LOGS . $logfile);
        if (!empty($del) && ($del == 1)) {
            $file->write(null);
        }
        $errorfile = $file->read();
        pr($errorfile);
        die;
        $this->set(print_r($errorfile, false));
    }

    public function notify() {
        $this->loadComponent('Api.Notification');
        $items = $this->request->getData();
        $deviceToken = $this->request->getData('device_token');
        //$this->Push->sendOnIOS($items);
        $this->Notification->iosPush($items, $deviceToken);
    }

}
