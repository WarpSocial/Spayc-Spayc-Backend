<?php

namespace Api\Controller;

use Api\Controller\AppController;
use Cake\I18n\Time;
use \Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Api\Utils\Utils;
use Cake\Core\Configure;
use Api\Auth\ApiHasher;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Advertisement Controller
 *
 * @property \Api\Model\Table\SpaycsTable $Spaycs
 *
 * @method \Api\Model\Entity\Spayc[] paginate($object = null, array $settings = [])
 */
class AdvertisementController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Api.Push');
        $this->loadComponent('Api.Matrix');
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);
    }

    /**
     * Edit method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        if (!$this->request->is(['put', 'patch', 'post'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }
        $user = $this->Auth->user();
        $data = $this->request->getData();
        $data['name'] = !empty($data['name']) ? ucfirst($data['name']) : '';
        if (empty($data['id'])) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement id is required.'], 400);
        }
        if (empty($data['spayc_id'])) {
            $this->restException(['status' => 'failed', 'message' => 'Spayc id is required.'], 400);
        }

        $entities = $this->Advertisement->find()->where(['id' => $data['id']]);

        if ($entities->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => __('Invalid Advertisement id.')], 400);
        }

        $entity = $entities->first();
        if ($user['id'] != $entity->user_id) {
            $this->restException(['status' => 'failed', 'message' => __('Insufficient privileges to edit this Advertisement.')], 400);
        }

        unset($data['id']);


        // Check IF Exist (Public || Private)
        $exist = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'joined_spayc',
                            'alias' => 'JoinedSpayc',
                            'type' => 'LEFT',
                            'conditions' => [
                                'Spaycs.id = JoinedSpayc.spayc_id',
                            ]
                        ]
                )->where(['OR' =>
                        [
                            ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'JoinedSpayc.user_id' => $user['id'], 'JoinedSpayc.status' => 'Joined', 'Spaycs.group_type' => 'Private'],
                            ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'Spaycs.group_type' => 'Public']]])
                ->distinct(['Spaycs.id']);
        $spayc_id = explode(",", $data['spayc_id']);

        if (count($exist->toArray()) != count($spayc_id)) {
            $this->restException(['status' => 'failed', 'message' => __('Not Authorized to Create Ad in listed warps.')], 400);
        }
        // Check IF Exist 
        $items = $this->Advertisement->patchEntity($entity, $data);

        if (!empty($items->errors())) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($items->errors())], 400);
        }
        unset($data['id']);

        $items = $this->Advertisement->patchEntity($entity, $data);

        if (!empty($items->errors())) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($items->errors())], 400);
        }

        if (isset($data['price']) && !$this->isCurrency($data['price'])) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid Price.')], 400);
        }
        if (isset($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid URL.')], 400);
        }

        $items->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
        $items->expired = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");



        if ($success = $this->Advertisement->save($items)) {
            $success->created = Utils::toClient($success->created);

            // Saving Ad into Spayc_Ad 
            $ad_spayc = array();
            $spayc_id = explode(",", $data['spayc_id']);
            foreach ($spayc_id as $k => $v) {

                $spaycRow = TableRegistry::get('Api.SpaycAdvertisement')->find()->where(['spayc_id' => $v]);
                if ($spaycRow->isEmpty()) {
                    $advModel = TableRegistry::get('Api.SpaycAdvertisement');
                    $entity = $advModel->newEntity();
                    $entity->advertisement_id = $success->id;
                    $entity->spayc_id = $v;
                    $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                    $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                    $created = $advModel->save($entity);
                    $ad_spayc[] = $v;
                }
                $spaycRow = TableRegistry::get('Api.SpaycAdvertisementPriority')->find()->where(['spayc_id' => $v]);
                if ($spaycRow->isEmpty()) {
                    $priorityModel = TableRegistry::get('Api.SpaycAdvertisementPriority');
                    $entity = $priorityModel->newEntity();
                    $entity->spayc_id = $v;
                    $entity->cycle = 0;
                    $entity->comment_count = 0;
                    $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                    $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                    $createdPriority = $priorityModel->save($entity);
                }
            }
            // Saving Ad into Spayc_Ad 

            $success['created_spayc'] = $data['spayc_id'];

            $response = ['status' => 'success', 'message' => __('Advertisement Updated Successfully'), 'data' => $success];
        } else {
            $this->restException(['status' => 'failed', 'message' => __('The warp could not be updated. Please, try again.')], 400);
        }
        $this->set($response);
    }

    /**
     * Delete method
     *
     * @param string|null $id Spayc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }
        if ($id == null) {
            $id = $this->request->query('id');
        }
        $user = $this->Auth->user();
        $entity = $this->Advertisement->find()
                ->where(['id' => $id, 'user_id' => $user['id'], "status != 'Removed'"]);
        if ($entity->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Record not found.'], 404);
        }
        $ad = $entity->first();
        $id = $ad->id;

        if ($ad) {
            $update['status'] = 'Removed';
            $condition['id'] = $id;
            TableRegistry::get('Api.Advertisement')->UpdateAll($update, $condition);
            $response = ['status' => 'success', 'message' => __('Advertisement has been removed.')];
        } else {
            $response = ['status' => 'failed', 'message' => __('Advertisement could not be removed.')];
        }
        $this->set(compact('response'));
    }

    /**
     * publicSpayc method to get the public and joined spayces
     * End point map-spaycs for Advertisement
     */
    public function viewAdvertisement() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }

        if (empty($this->request->query('id'))) {
            $this->restException(['status' => 'failed', 'message' => __('Advertisement id is required field.')], 400);
        }
        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.Advertisement')->findById($this->request->getQuery('id', null))
                ->select(['id', 'name', 'user_id', 'image', 'price', 'description', 'url', 'status', 'views', 'balance'])
                ->where(["status != 'Removed'"]);

        if ($pquery->toArray()) {

            $data = $pquery->toArray();
            if ($data[0]->user_id != $user['id']) {
                $this->restException(['status' => 'failed', 'message' => __('Not Authorized to view that Advertisement.')], 400);
            }
            unset($data[0]->user_id);

            $entity = TableRegistry::get('Api.Spaycs')->find('all', ['fields' => [
                            'Spaycs.name', 'Spaycs.id', 'Spaycs.type', 'Spaycs.image']])->join(
                            [
                                'table' => 'spayc_advertisement',
                                'type' => 'INNER',
                                'conditions' => [
                                    'Spaycs.id = spayc_advertisement.spayc_id',
                                    'spayc_advertisement.advertisement_id' => $data[0]->id
                                ]
                            ]
                    )
                    ->where(["status != 'Removed'"]);
            $spayc = $entity->toArray();
            $array['advertisement'] = $data[0];
            if ($spayc)
                $array['spaycs'] = $spayc;
            $response = ['status' => 'success', 'message' => 'Advertisement Details', 'data' => $array];
        }else {
            $response = ['status' => 'failed', 'message' => __('No Advertisement found')];
        }
        $this->set($response);
    }

    /**
      /**
     * createAdvertisement method to create subspace
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function createAdvertisement() {
        if (!$this->request->is('post')) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();

        $user = $this->Auth->user();

        $entity = TableRegistry::get('Api.Spaycs')->find()->contain('JoinedSpayc', function($q)use($user) {
            return $q->where(['user_id' => $user['id']]);
        });

        $advModel = TableRegistry::get('Api.Advertisement');

        $entity = $advModel->newEntity();

        $exist = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'joined_spayc',
                            'alias' => 'JoinedSpayc',
                            'type' => 'LEFT',
                            'conditions' => [
                                'Spaycs.id = JoinedSpayc.spayc_id',
                            ]
                        ]
                )->where(['OR' =>
                        [
                            ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'JoinedSpayc.user_id' => $user['id'], 'JoinedSpayc.status' => 'Joined', 'Spaycs.group_type' => 'Private'],
                            ['Spaycs.id IN (' . $data['spayc_id'] . ')', 'Spaycs.group_type' => 'Public']]])
                ->distinct(['Spaycs.id']);
        $spayc_id = explode(",", $data['spayc_id']);

        if (count($exist->toArray()) != count($spayc_id)) {
            $this->restException(['status' => 'failed', 'message' => __('Not Authorized to Create Ad in listed warps.')], 400);
        }
        $data['spaycs'] = ['_ids' => [1]];
        $items = $advModel->patchEntity($entity, $data);

        if (!empty($items->errors())) {
            $this->restException(['status' => 'failed', 'message' => $this->mapErrors($items->errors())], 400);
        }

        if (isset($data['price']) && !$this->isCurrency($data['price'])) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid Price.')], 400);
        }
        if (isset($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $this->restException(['status' => 'failed', 'message' => __('Enter Valid URL.')], 400);
        }


        //Fetcing Plan 
        $pquery = TableRegistry::get('Api.Plans')->findById($data['plan_id']);

        if ($pquery->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Plan not found.'], 404);
        }
        $plan = $pquery->first();
        $items->user_id = $user['id'];
        $items->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
        $items->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
        $items->views = $plan['views'];
        $items->balance = $plan['views'];
        $items->status = 'Active';
        $success = $advModel->save($items);



        //Mapping Spayc with Ad & saving into Priority
        $ad_spayc = array();
        $spayc_id = explode(",", $data['spayc_id']);
        foreach ($spayc_id as $k => $v) {
            $advModel = TableRegistry::get('Api.SpaycAdvertisement');
            $entity = $advModel->newEntity();
            $entity->advertisement_id = $success->id;
            $entity->spayc_id = $v;
            $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $created = $advModel->save($entity);
            $spaycRow = TableRegistry::get('Api.SpaycAdvertisementPriority')->find()->where(['spayc_id' => $v]);
            if ($spaycRow->isEmpty()) {
                $priorityModel = TableRegistry::get('Api.SpaycAdvertisementPriority');
                $entity = $priorityModel->newEntity();
                $entity->spayc_id = $v;
                $entity->cycle = 0;
                $entity->comment_count = 0;
                $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
                $createdPriority = $priorityModel->save($entity);
            }
            //Ad Bucket Active & Expire
            TableRegistry::get('Api.SpaycAdvertisement')->updateAdActive($v);
            TableRegistry::get('Api.SpaycAdvertisement')->updateAdExpired($v);
            $ad_spayc[] = $v;
        }

        //Saving into the Purchase
        if ($success->id) {
            $purchaseModel = TableRegistry::get('Api.Purchase');
            $entity = $purchaseModel->newEntity();
            $entity->advertisement_id = $success->id;
            $entity->plan_id = $data['plan_id'];
            $entity->receipt = $data['receipt'];
            $entity->amount = $plan['amount'];
            if (isset($data['platform']))
                $entity->platform = $data['platform'];
            if (isset($data['purchase_date']) && $data['purchase_date'])
                $entity->purchase_date = $data['purchase_date'];
            $entity->modified = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $entity->created = (new \Cake\I18n\Time())->format("Y-m-d H:i:s");
            $purchase = $purchaseModel->save($entity);
        }

        if (!count($ad_spayc)) {
            $this->restException(['status' => 'failed', 'message' => __('Advertisement could not be saved. Please, try again.')], 400);
        }
        $success['created_spayc'] = implode(",", $ad_spayc);
        $response = ['status' => 'success', 'message' => __('Advertisement Created Successfully'), 'data' => $success];
        $this->set($response);
    }

    public function userAdvertisement() {
        if (!$this->request->is(['get'])) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 400);
        }

        $user = $this->Auth->user();
        $pquery = TableRegistry::get('Api.Advertisement')->findByUserId($user['id'])
                ->select(['id', 'name', 'image', 'price', 'description', 'url', 'status', 'views', 'balance'])
                ->where(["status != 'Removed'"]);

        $page = $this->request->getQuery('page', 1);
        $limit = $this->request->getQuery('limit', Configure::read('pagelimit'));
        $pquery->limit($limit)->page($page);
        $pquery->order(['created' => 'DESC']);

        if ($pquery->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Record not found.'], 404);
        }
        if ($pquery->toArray()) {
            $data = $pquery->toArray();
            $response = ['status' => 'success', 'message' => 'List of Advertisement.', 'data' => $data];
        } else {
            $response = ['status' => 'failed', 'message' => __('No Advertisement found')];
        }



        $this->set($response);
    }

    //Ad Logic
    public function adLogic() {
        if (!$this->request->is('post')) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
        if (!isset($data['spayc_id'])) {
            $this->restException(['status' => 'failed', 'message' => __('Warp ID field required.')], 400);
        }
        if (!isset($data['cycle'])) {
            $this->restException(['status' => 'failed', 'message' => __('Cycle field required.')], 400);
        }
        if (!isset($data['comment_count'])) {
            $this->restException(['status' => 'failed', 'message' => __('Comment Count field required.')], 400);
        }
        $spaycRow = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'spayc_advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'Spaycs.id = spayc_advertisement.spayc_id',
                                'advertisement_status != '.EXPIRED_AD_STATUS,
                            ]
                        ]
                )->where(['spayc_id' => $data['spayc_id']])
                ->distinct(['Spaycs.id']);
        ;

        if ($spaycRow->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement could not be found.'], 404);
        }


        $spayc = $spaycRow->first();

        $cycleRow = TableRegistry::get('Api.SpaycAdvertisementPriority')->find()->where(['spayc_id' => $data['spayc_id']])
                ->order(['id' => 'DESC']);

        //Ad Bucket Active & Expire         
        TableRegistry::get('Api.SpaycAdvertisement')->updateAdExpired($data['spayc_id']);
        TableRegistry::get('Api.SpaycAdvertisement')->updateAdActive($data['spayc_id']);

        $cycleData = $cycleRow->first();
        $frequency = TableRegistry::get('Api.SpaycAdvertisement')->adFrequency($data['spayc_id']);

        if ($data['comment_count'] > $frequency) {
            $this->restException(['status' => 'failed', 'message' => __('Comment Count Must be less than from Comment Frequency.')], 400);
        }
        if ($cycleData) {
            $cycle = $cycleData['cycle'];
            $comment_count = $cycleData['comment_count'];


            if ($data['cycle'] <= $cycle && $data['comment_count'] <= $comment_count) {
                // If Cycle Same or Low Count Comment or Low Cycle
            } elseif ($data['cycle'] == $cycle && $data['comment_count'] >= $comment_count) {
                // If Cycle Same and Count Comment Greater
                $update['comment_count'] = $data['comment_count'];
                $condition['spayc_id'] = $data['spayc_id'];
                $condition['cycle'] = $data['cycle'];
                TableRegistry::get('Api.SpaycAdvertisementPriority')->UpdateAll($update, $condition);
            } elseif ($data['cycle'] > $cycle || !$cycleData) {

                //Ad Expire,Active,View Balance
                TableRegistry::get('Api.SpaycAdvertisement')->updateAdvertisementStatus($data['spayc_id']);

                // If Cycle Greater, Update Cycle
                $update['comment_count'] = $data['comment_count'];
                $update['cycle'] = $data['cycle'];
                $condition['spayc_id'] = $data['spayc_id'];
                TableRegistry::get('Api.SpaycAdvertisementPriority')->UpdateAll($update, $condition);

                $priority = TableRegistry::get('Api.SpaycAdvertisement')
                        ->setPriority($data['spayc_id']);
            }
        }

        $ad = TableRegistry::get('Api.SpaycAdvertisement')->find('all', ['fields' =>
                        [
                        'advertisement.user_id',
                        'advertisement.name',
                        'advertisement.price',
                        'advertisement.image',
                        'advertisement.description',
                        'advertisement.url',
                        'priority.cycle',
                        'priority.comment_count',
                        'matrix_room_id' => 'friend_request.matrix_room_id',
                        'matrix_user_id' => 'users.matrix_user_id',
            ]])
                ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->join(
                        [
                            'table' => 'spayc_advertisement_priority',
                            'alias' => 'priority',
                            'type' => 'INNER',
                            'conditions' => [
                                'priority.spayc_id = SpaycAdvertisement.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'users',
                            'alias' => 'users',
                            'type' => 'INNER',
                            'conditions' => [
                                'users.id = advertisement.user_id',
                            ]
                        ]
                )
                ->join(
                        [
                            'table' => 'friend_request',
                            'type' => 'LEFT',
                            'conditions' =>
                                [
                                'OR' => [
                                        [
                                        'friend_request.requested_by = advertisement.user_id', 'friend_request.requested_to = ' . $user['id']
                                    ],
                                        [
                                        'friend_request.requested_to = advertisement.user_id', 'friend_request.requested_by = ' . $user['id']
                                    ]
                                ]
                            ]
                        ]
                )
                ->where(['SpaycAdvertisement.spayc_id' => $data['spayc_id'], "balance > 0", "advertisement_status" => ACTIVE_AD_STATUS, 'advertisement.status' => 'Active'])
                ->order(['SpaycAdvertisement.priority' => 'ASC'])
                ->limit(1)
        ;

        $data = [];
        if ($ad->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement not found.'], 404);
        } else {
            $data = $ad->first();
        }
        $data['frequency'] = $frequency;
        $response = ['status' => 'success', 'message' => __('Advertisement Find Successfully'), 'data' => $data];
        $this->set($response);
    }

    //Ad Logic First Time Enter
    public function adLogicStart() {
        if (!$this->request->is('post')) {
            $this->restException(['status' => 'failed', 'message' => __('Method not allowed.')], 405);
        }
        $data = $this->request->getData();
        $user = $this->Auth->user();
        if (!isset($data['spayc_id'])) {
            $this->restException(['status' => 'failed', 'message' => __('Warp ID field required.')], 400);
        }


        $spaycRow = TableRegistry::get('Api.Spaycs')->find()
                ->join(
                        [
                            'table' => 'spayc_advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'Spaycs.id = spayc_advertisement.spayc_id',
                                'advertisement_status != '.EXPIRED_AD_STATUS,
                            ]
                        ]
                )->where(['spayc_id' => $data['spayc_id']])
                ->distinct(['Spaycs.id']);
        ;

        if ($spaycRow->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement could not be found.'], 404);
        }

        //Ad Bucket Active & Expire
        TableRegistry::get('Api.SpaycAdvertisement')->updateAdExpired($data['spayc_id']);
        TableRegistry::get('Api.SpaycAdvertisement')->updateAdActive($data['spayc_id']);


        $ad = TableRegistry::get('Api.SpaycAdvertisement')->find('all', ['fields' =>
                        [
                        'advertisement.name',
                        'advertisement.price',
                        'advertisement.image',
                        'advertisement.description',
                        'advertisement.url',
                        'priority.cycle',
                        'priority.comment_count',
                        'matrix_room_id' => 'friend_request.matrix_room_id',
                        'matrix_user_id' => 'users.matrix_user_id',
            ]])
                ->join(
                        [
                            'table' => 'advertisement',
                            'type' => 'INNER',
                            'conditions' => [
                                'advertisement.id = SpaycAdvertisement.advertisement_id',
                            ]
                        ]
                )
                ->join(
                        [
                            'table' => 'spayc_advertisement_priority',
                            'alias' => 'priority',
                            'type' => 'INNER',
                            'conditions' => [
                                'priority.spayc_id = SpaycAdvertisement.spayc_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'users',
                            'alias' => 'users',
                            'type' => 'INNER',
                            'conditions' => [
                                'users.id = advertisement.user_id',
                            ]
                        ]
                )->join(
                        [
                            'table' => 'friend_request',
                            'type' => 'LEFT',
                            'conditions' =>
                                [
                                'OR' => [
                                        [
                                        'friend_request.requested_by = advertisement.user_id', 'friend_request.requested_to = ' . $user['id']
                                    ],
                                        [
                                        'friend_request.requested_to = advertisement.user_id', 'friend_request.requested_by = ' . $user['id']
                                    ]
                                ]
                            ]
                        ]
                )
                ->where(['SpaycAdvertisement.spayc_id' => $data['spayc_id'], "balance > 0", 'advertisement.status' => 'Active'])
                ->order(['SpaycAdvertisement.priority' => 'ASC'])
                ->limit(1)
        ;
        $frequency = TableRegistry::get('Api.SpaycAdvertisement')->adFrequency($data['spayc_id']);
        $data = [];
        if ($ad->isEmpty()) {
            $this->restException(['status' => 'failed', 'message' => 'Advertisement not found.'], 404);
        } else {
            $data = $ad->first();
        }
        $data['frequency'] = $frequency;
        $response = ['status' => 'success', 'message' => __('Advertisement Find Successfully'), 'data' => $data];
        $this->set($response);
    }

    public function isCurrency($number) {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }

}
