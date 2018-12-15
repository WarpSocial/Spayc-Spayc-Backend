<?php

use Migrations\AbstractMigration;

class Project extends AbstractMigration {

    public function up() {

        $this->table('advertisement', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('price', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 12,
                    'scale' => 2,
                ])
                ->addColumn('views', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('balance', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('url', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Pending',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('categories', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('parent_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('lft', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('rght', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('slug', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('code', 'string', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('description', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('comments', ['id' => false, 'primary_key' => ['id', 'spayc_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('comment', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => false,
                ])
                ->addColumn('event_id', 'string', [
                    'default' => null,
                    'limit' => 150,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('custom_messages', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('user_id', 'string', [
                    'default' => null,
                    'limit' => 500,
                    'null' => false,
                ])
                ->addColumn('message', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('eventbrite_events', ['id' => false, 'primary_key' => ['id', 'eventbrite_event_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('eventbrite_event_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('location', 'string', [
                    'comment' => 'venue name, address obj, city, region, postalCode, country',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('start_date', 'timestamp', [
                    'comment' => 'eventbrite start_date is inside start obj utc',
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('end_date', 'timestamp', [
                    'comment' => 'eventbrite end_date is inside end obj utc',
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('category', 'string', [
                    'comment' => 'category_id, subcategory_id',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('city', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('region', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('postal_code', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('country', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('website', 'integer', [
                    'comment' => '1 for eventbrite, 2 for ticketmaster, 3 for stubhub',
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('event_status', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('group_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('payment_type', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('ticket_url', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->create();

        $this->table('friend_request', ['id' => false, 'primary_key' => ['id', 'requested_by', 'requested_to', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('requested_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('requested_to', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('requested_status', 'string', [
                    'default' => 'Requested',
                    'limit' => 15,
                    'null' => true,
                ])
                ->addColumn('friend_status', 'string', [
                    'default' => null,
                    'limit' => 15,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('matrix_room_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('blocked_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('action_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('hashtags', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('joined_spayc', ['id' => false, 'primary_key' => ['id', 'spayc_id', 'user_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Pending',
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('updated_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('is_admin', 'smallinteger', [
                    'default' => '0',
                    'limit' => 5,
                    'null' => false,
                ])
                ->addColumn('distance', 'decimal', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('notification_types', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('type', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('message', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('slug', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('notifications', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('requested_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('requested_to', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('notification_type', 'string', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('message', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('date_time', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('physical_location', ['id' => false, 'primary_key' => ['id', 'user_id']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('current_latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('current_longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('timezone', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->create();

        $this->table('plans', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('app_plan_id', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('slug', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('type', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('amount', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 7,
                    'scale' => 2,
                ])
                ->addColumn('currency', 'string', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('views', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('identifier', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('promotions', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('views', 'decimal', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('balance', 'decimal', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('amount', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 7,
                    'scale' => 2,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('purchase', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('plan_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('receipt', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('promotion_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('advertisement_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('platform', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('amount', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 7,
                    'scale' => 2,
                ])
                ->addColumn('purchase_date', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('pusher_data', ['id' => false, 'primary_key' => ['id']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('post_value', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('queue_processes')
                ->addColumn('pid', 'string', [
                    'default' => null,
                    'limit' => 30,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('queued_jobs')
                ->addColumn('job_type', 'string', [
                    'default' => null,
                    'limit' => 45,
                    'null' => false,
                ])
                ->addColumn('data', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('job_group', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('reference', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('notbefore', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('fetched', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('completed', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('progress', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('failed', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => false,
                ])
                ->addColumn('failure_message', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('workerkey', 'string', [
                    'default' => null,
                    'limit' => 45,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('priority', 'integer', [
                    'default' => '5',
                    'limit' => 10,
                    'null' => false,
                ])
                ->create();

        $this->table('reported_warps', ['id' => false, 'primary_key' => ['id', 'spayc_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('matrix_room_id', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => false,
                ])
                ->addColumn('reported_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('message', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('scraper_categories', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 250,
                    'null' => true,
                ])
                ->addColumn('scraper_category_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('spayc_category_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('website', 'integer', [
                    'comment' => '1 for eventbrite, 2 for ticketmaster, 3 for stubhub',
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('scraper_logs', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('status', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('start_time', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('end_time', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('unique_time', 'string', [
                    'default' => null,
                    'limit' => 250,
                    'null' => false,
                ])
                ->addColumn('response', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('shell', 'string', [
                    'default' => null,
                    'limit' => 250,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('scraper_spayc_categories', ['id' => false, 'primary_key' => ['id']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('category_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

        $this->table('spam_reports', ['id' => false, 'primary_key' => ['id', 'spayc_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('reported_by', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('reported_to', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('event_id', 'string', [
                    'default' => null,
                    'limit' => 60,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_advertisement', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('advertisement_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('priority', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('advertisement_status', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('display_times', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_advertisement_priority', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('cycle', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('comment_count', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_categories', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('parent_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('lft', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('rght', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('slug', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('code', 'string', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('description', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Active',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_hashtags', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('hashtag_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_promotion', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('promotion_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('priority', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('promotion_status', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('display_times', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spayc_promotion_priority', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('cycle', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('comment_count', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('spaycs', ['id' => false, 'primary_key' => ['id', 'user_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('location', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('type', 'string', [
                    'default' => 'Event',
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('group_type', 'string', [
                    'default' => 'Public',
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('start_date', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('end_date', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('passcode', 'string', [
                    'default' => null,
                    'limit' => 30,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Inactive',
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('matrix_room_id', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('parent_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('spayc_category_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('website', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('is_admin_update', 'smallinteger', [
                    'default' => null,
                    'limit' => 5,
                    'null' => true,
                ])
                ->addColumn('last_status', 'string', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('payment_type', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('ticket_url', 'string', [
                    'default' => null,
                    'limit' => 500,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('stubhub_events', ['id' => false, 'primary_key' => ['id', 'stubhub_event_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('stubhub_event_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('location', 'string', [
                    'comment' => 'venue name, address1, city, state, postalCode, country',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('start_date', 'timestamp', [
                    'comment' => 'stubhub start_date id eventDateUTC',
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('end_date', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('category', 'string', [
                    'comment' => 'categories array',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('city', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('region', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('postal_code', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('country', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('website', 'integer', [
                    'comment' => '1 for eventbrite, 2 for ticketmaster, 3 for stubhub',
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('event_status', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('group_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('payment_type', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('ticket_url', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->create();

        $this->table('subscribed_users', ['id' => false, 'primary_key' => ['id', 'spayc_id', 'user_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Inactive',
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('ticketmaster_events', ['id' => false, 'primary_key' => ['id', 'ticketmaster_event_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('ticketmaster_event_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('location', 'string', [
                    'comment' => 'venue name, address, city, state, postalCode, country',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('start_date', 'timestamp', [
                    'comment' => 'ticketmaster start_date is inside dates obj dateTime',
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('end_date', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('category', 'string', [
                    'comment' => 'category is classifications array',
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('city', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('region', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('postal_code', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('country', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('website', 'integer', [
                    'comment' => '1 for eventbrite, 2 for ticketmaster, 3 for stubhub',
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('event_status', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('group_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('spayc_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('payment_type', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('ticket_url', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->create();

        $this->table('user_category', ['id' => false, 'primary_key' => ['id', 'user_id', 'category_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('category_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('user_feedbacks', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('message', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('attachment', 'string', [
                    'default' => null,
                    'limit' => 250,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('user_images', ['id' => false, 'primary_key' => ['id', 'user_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('image_url', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('is_profile', 'string', [
                    'default' => 'No',
                    'limit' => 10,
                    'null' => false,
                ])
                ->addColumn('order_index', 'smallinteger', [
                    'default' => null,
                    'limit' => 5,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('user_logs', ['id' => false, 'primary_key' => ['id', 'user_id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('user_id', 'biginteger', [
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('token', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('plain_token', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => false,
                ])
                ->addColumn('device_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('matrix_access_token', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->addColumn('matrix_user_id', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('login_status', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => false,
                ])
                ->addColumn('last_login', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('device_token', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();

        $this->table('users', ['id' => false, 'primary_key' => ['id', 'created']])
                ->addColumn('id', 'biginteger', [
                    'autoIncrement' => true,
                    'default' => null,
                    'limit' => 20,
                    'null' => false,
                ])
                ->addColumn('created', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('username', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => false,
                ])
                ->addColumn('display_name', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('email', 'string', [
                    'default' => null,
                    'limit' => 150,
                    'null' => true,
                ])
                ->addColumn('password', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->addColumn('gender', 'string', [
                    'default' => null,
                    'limit' => 50,
                    'null' => true,
                ])
                ->addColumn('dob', 'date', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('phone', 'string', [
                    'default' => null,
                    'limit' => 20,
                    'null' => true,
                ])
                ->addColumn('status', 'string', [
                    'default' => 'Pending',
                    'limit' => null,
                    'null' => false,
                ])
                ->addColumn('website_url', 'string', [
                    'default' => null,
                    'limit' => 150,
                    'null' => true,
                ])
                ->addColumn('address', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('bio_data', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('fb_id', 'string', [
                    'default' => null,
                    'limit' => 200,
                    'null' => true,
                ])
                ->addColumn('fb_access_key', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->addColumn('longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('timezone', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('matrix_user_id', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('matrix_access_token', 'string', [
                    'default' => null,
                    'limit' => 1000,
                    'null' => true,
                ])
                ->addColumn('modified', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('token_verification', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('forgot_password_token', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('forgot_password_timestamp', 'timestamp', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('country_code', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('is_notify', 'string', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('current_latitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('current_longitude', 'float', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('role_id', 'integer', [
                    'default' => null,
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('device_token', 'string', [
                    'default' => null,
                    'limit' => 100,
                    'null' => true,
                ])
                ->addColumn('ghost_mode_search', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addColumn('ghost_mode_map', 'integer', [
                    'default' => '0',
                    'limit' => 10,
                    'null' => true,
                ])
                ->addIndex(
                        [
                    'username',
                    'email',
                    'created',
                        ], ['unique' => true]
                )
                ->addIndex(
                        [
                            'created',
                        ]
                )
                ->create();
    }

    public function down() {
        $this->dropTable('advertisement');
        $this->dropTable('categories');
        $this->dropTable('comments');
        $this->dropTable('custom_messages');
        $this->dropTable('eventbrite_events');
        $this->dropTable('friend_request');
        $this->dropTable('hashtags');
        $this->dropTable('joined_spayc');
        $this->dropTable('notification_types');
        $this->dropTable('notifications');
        $this->dropTable('physical_location');
        $this->dropTable('plans');
        $this->dropTable('promotions');
        $this->dropTable('purchase');
        $this->dropTable('pusher_data');
        $this->dropTable('queue_processes');
        $this->dropTable('queued_jobs');
        $this->dropTable('reported_warps');
        $this->dropTable('scraper_categories');
        $this->dropTable('scraper_logs');
        $this->dropTable('scraper_spayc_categories');
        $this->dropTable('spam_reports');
        $this->dropTable('spayc_advertisement');
        $this->dropTable('spayc_advertisement_priority');
        $this->dropTable('spayc_categories');
        $this->dropTable('spayc_hashtags');
        $this->dropTable('spayc_promotion');
        $this->dropTable('spayc_promotion_priority');
        $this->dropTable('spaycs');
        $this->dropTable('stubhub_events');
        $this->dropTable('subscribed_users');
        $this->dropTable('ticketmaster_events');
        $this->dropTable('user_category');
        $this->dropTable('user_feedbacks');
        $this->dropTable('user_images');
        $this->dropTable('user_logs');
        $this->dropTable('users');
    }

}
