<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Roles Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Role get($primaryKey, $options = [])
 * @method \App\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 */
class EventsTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {         
        parent::initialize($config);
        $this->setConnection(ConnectionManager::get('matrix'));
        $this->setTable('events');
        $this->setDisplayField('type');
        $this->setPrimaryKey('event_id');
    }
    
    public function getComments($spaycMatrixRoomId) {
        $chat_msg_type = unserialize(CHAT_MSG_TYPE);
        $query = $this->find()->where(['room_id'=>$spaycMatrixRoomId,'type'=>CHAT_ROOM_TYPE]);
        $query->where(['OR' => [['content LIKE' => '%"msgtype":"'.$chat_msg_type['text'].'"%'], ['content LIKE' => '%"msgtype":"'.$chat_msg_type['image'].'"%']]]);  
        return $query;
    }        

}
