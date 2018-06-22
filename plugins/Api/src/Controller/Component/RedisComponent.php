<?php

namespace Api\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Redis component
 */
class RedisComponent extends Component {

    /**
     * Default configuration.
     *
     * @redis redis connection object
     */
    public $_Redis = null;
    protected $userKey = 'user';
    protected $spaycKey = 'spayc';

    /**
     * The default config used unless overridden by runtime configuration
     *
     * - `database` database number to use for connection.
     * - `duration` Specify how long items in this cache configuration last.
     * - `groups` List of groups or 'tags' associated to every key stored in this config.
     *    handy for deleting a complete group from cache.
     * - `password` Redis server password.
     * - `persistent` Connect to the Redis server with a persistent connection
     * - `port` port number to the Redis server.
     * - `prefix` Prefix appended to all entries. Good for when you need to share a keyspace
     *    with either another cache config or another application.
     * - `probability` Probability of hitting a cache gc cleanup. Setting to 0 will disable
     *    cache::gc from ever being called automatically.
     * - `server` URL or ip to the Redis server host.
     * - `timeout` timeout in seconds (float).
     * - `unix_socket` Path to the unix socket file (default: false)
     *
     * @var array
     */
    protected $_defaultConfig = [
        'database' => 0,
        'duration' => 3600,
        'groups' => [],
        'password' => false,
        'persistent' => true,
        'port' => 6379,
        'prefix' => 'cake_',
        'probability' => 100,
        'host' => null,
        'server' => '127.0.0.1',
        'timeout' => 0,
        'unix_socket' => false,
    ];

    /**
     * initialize method to overwrite the default config
     * @param Array $config pre-configure value when component constructed
     */
    public function initialize(array $config) {
        parent::initialize($config);
        if (is_null($this->_Redis)) {
            $this->_Redis = ConnectionManager::get('redis');
        }
    }

    /**
     * geoAddSpayc to add user geo associated data
     * 
     * @param array $data contain spayc related data
     * @return bool true if added successfully false on failure
     */
    public function addSpayc($data) {        
       if (is_null($data['latitude']) || is_null($data['longitude']) || is_null($data['id'])) {
            return false;
        }
        $key = $this->spaycKey.'_'.$data['id'];
        if ($this->_Redis->geoAdd($this->spaycKey, $data['latitude'], $data['longitude'], $data['id'])) {
            $spaycData = [
                'id' => $data['id'],
                'name' => $data['id'],
                'status' => $data['status'],
                'matrix_room_id' => $data['matrix_room_id'],
                'image' => $data['image'],
                'type' => $data['type'],
                'modified' => $data['modified'],
                'spayc_category_id' => $data['spayc_category_id'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'website' => $data['website'],
            ];
            $this->write($key,$spaycData);
        }
    }
    
    /**
     * getSpaycGeo method to get the list of spayc located near the reius
     */
    public function getSpaycGeo($latitude,$longitude,$radius,$unit='mi'){
        $spaycs = $this->_Redis->geoRadius($this->spaycKey,$latitude,$longitude,$radius,$unit,['WITHDIST']);
        $items = [];
        if(!empty($spaycs)){
            for($i=0;$i<count($spaycs);$i++){
                $items[] = ['id'=>$spaycs[$i][0],'distance'=>$spaycs[$i][1]];
            }
        }
        return $items;
    }
    
    /**
     * geoAddUser to add user geo associated data
     * 
     * @param array $data contain user related data
     * @return bool true if added successfully false on failure
     */
    public function geoAddUser($data) {
        if (is_null($data['latitude']) || is_null($data['longitude']) || is_null($data['id'])) {
            return false;
        }
        $key = $this->userKey.$data['id'];
        if ($this->_Redis->geoAdd('user', $data['latitude'], $data['longitude'], $key)) {
            $this->write($key,$data);
        }
    }

    /**
     * Write data for key to redis cache.
     *
     * @param string $key Identifier for the data
     * @param mixed $value Data to be cached
     * @return bool True if the data was successfully cached, false on failure
     */
    public function write($key, $value) {
        if (!is_int($value)) {
            $value = serialize($value);
        }
        return $this->_Redis->set($key, $value);
    }

    /**
     * Read a key from the cache
     *
     * @param string $key Identifier for the data
     * @return mixed The cached data, or false if the data doesn't exist, has expired, or if there was an error fetching it
     */
    public function read($key) {
        $value = $this->_Redis->get($key);
        if (preg_match('/^[-]?\d+$/', $value)) {
            return (int) $value;
        }
        if ($value !== false && is_string($value)) {
            return unserialize($value);
        }

        return $value;
    }
    
    /**
     * Delete a key from the cache
     *
     * @param string $key Identifier for the data
     * @return bool True if the value was successfully deleted, false if it didn't exist or couldn't be removed
     */
    public function delete($key){
        return $this->_Redis->delete($key) > 0;
    }

    /**
     * Disconnects from the redis server
     */
    public function __destruct() {
        if (empty($this->_config['persistent']) && $this->_Redis instanceof Redis) {
            $this->_Redis->close();
        }
    }

}
