-- CREATE TYPE row_status AS ENUM('Active','Inactive','Pending','Approved','Removed');
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id BIGSERIAL NOT NULL,
    "username" character varying(100) NOT NULL,
    "display_name" character varying(100),
    "email" character varying(150),
    "password" character varying(1000),
    "gender" character varying(50),
    "dob" date,
    "phone" character varying(20),
    "status" row_status DEFAULT 'Pending' NOT NULL,
    "website_url" character varying(150),
    "address" text,
    "bio_data" text,
    "fb_id" character varying(200),
    "fb_access_key" character varying(1000),
    "longitude" double precision,
    "latitude" double precision,
    "timezone" character varying(100),
    "matrix_user_id" character varying(100),
    "matrix_access_token" character varying(1000),
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "token_verification" character varying(255),
    "forgot_password_token" character varying(255),
    "forgot_password_timestamp" timestamp,
    "country_code" character varying(10),
    "is_notify" character varying(10) DEFAULT 'Off',
    "current_latitude" double precision,
    "current_longitude" double precision,
    "role_id" integer,
    "device_token" character varying(100),
    primary key (id,created),
    unique (username,email,created)
);
SELECT create_hypertable('users', 'created');

DROP TABLE IF EXISTS user_category;
CREATE TABLE user_category (
    "id" BIGSERIAL NOT NULL,    
    "user_id" bigint NOT NULL,
    "category_id" bigint NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,category_id,user_id,created)
);
SELECT create_hypertable('user_category', 'created');

DROP TABLE IF EXISTS user_logs;
CREATE TABLE user_logs (
    id BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "token" character varying(255) NOT NULL,
    "plain_token" character varying(255) NOT NULL,
    "device_id" character varying(255),
    "matrix_access_token" character varying(1000),
    "matrix_user_id" character varying(255),
    "login_status" integer DEFAULT 0 NOT NULL,
    "last_login" timestamp NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "device_token" character varying(1000),
    PRIMARY KEY(id,user_id,created)
);
SELECT create_hypertable('user_logs', 'created');

DROP TABLE IF EXISTS friend_request;
CREATE TABLE friend_request (
    "id" BIGSERIAL NOT NULL,
    "requested_by" bigint NOT NULL,
    "requested_to" bigint NOT NULL,
    "requested_status" character varying(15) DEFAULT 'Requested',
    "friend_status" character varying(15) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "matrix_room_id" character varying(255),
    "blocked_by" bigint,
    "action_by" bigint,
    PRIMARY KEY (id,requested_by,requested_to,created)
);
SELECT create_hypertable('friend_request', 'created');

DROP TABLE IF EXISTS joined_spayc;
CREATE TABLE joined_spayc (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "user_id" bigint NOT NULL,
    "status" character varying(20) DEFAULT 'Pending',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "updated_by" bigint NOT NULL,
    "is_admin" smallint DEFAULT 0 NOT NULL,
    "distance" numeric,
    PRIMARY KEY (id,spayc_id,user_id,created)
);
SELECT create_hypertable('joined_spayc', 'created');

DROP TABLE IF EXISTS spaycs;
CREATE TABLE spaycs (
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "name" character varying(255),
    "location" character varying(255),
    "type" character varying(20) DEFAULT 'Event',
    "group_type" character varying(20) DEFAULT 'Public',
    "start_date" timestamp,
    "end_date" timestamp,
    "passcode" character varying(30),
    "description" text,
    "image" character varying(255),
    "longitude" double precision,
    "latitude" double precision,
    "status" row_status DEFAULT 'Inactive',
    "matrix_room_id" character varying(100),
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "parent_id" bigint,
    "spayc_category_id" bigint,
    "is_admin_update" smallint DEFAULT 0,
    "website" integer,
    "last_status" row_status,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('spaycs', 'created');

DROP TABLE IF EXISTS subscribed_users;
CREATE TABLE subscribed_users (
    "id" BIGSERIAL NOT NULL,
   "spayc_id" bigint NOT NULL,
    "user_id" bigint NOT NULL,
    "status" row_status DEFAULT 'Inactive',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,spayc_id,user_id,created)
);
SELECT create_hypertable('subscribed_users', 'created');

DROP TABLE IF EXISTS user_images;
CREATE TABLE user_images (
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "image_url" character varying(255),
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "is_profile" character varying(10) DEFAULT 'No' NOT NULL,
    "order_index" smallint,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('user_images', 'created');

DROP TABLE IF EXISTS hashtags;
CREATE TABLE hashtags (
    "id" BIGSERIAL NOT NULL,
    "name" character varying(255) NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('hashtags', 'created');

DROP TABLE IF EXISTS spayc_hashtags;
CREATE TABLE spayc_hashtags (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "hashtag_id" bigint NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('spayc_hashtags', 'created');

DROP TABLE IF EXISTS notifications;
CREATE TABLE notifications (
    "id" BIGSERIAL NOT NULL,
    "requested_by" bigint NOT NULL,
    "requested_to" bigint NOT NULL,
    "notification_type" character varying(200) DEFAULT NULL,
    "status" character varying(20) DEFAULT NULL,
    "message" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "date_time" timestamp,
    "spayc_id" bigint,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('notifications', 'created');

DROP TABLE IF EXISTS notification_types;
CREATE TABLE "notification_types" (
    "id" BIGSERIAL NOT NULL,
    "type" character varying(200),
    "message" text,
    "slug" character varying(200),
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('notification_types', 'created');
INSERT INTO "notification_types" ("id", "type", "message", "slug", "created", "modified") VALUES
(3,	'Admin of the warp commented',	'The admin of the Warp, <SpaycName> commented <COMMENT>',	'admin-of-the-spayc-commented',	'2018-03-05 17:27:10.578674',	NULL),
(4,	'friend like your comment',	'<FRIEND> liked your comment, <COMMENT>. Well, you aren''t friends for no reason',	'friend-like-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(5,	'Friend Request',	'Apparently, you''re so cool <USERNAME> wants to be friends with you.',	'friend-request',	'2018-02-28 17:27:10.578674',	NULL),
(6,	'Friend Added',	'You made another friend! Look at you go!',	'friend-added',	'2018-02-28 17:27:10.578674',	NULL),
(7,	'Warp will be inactive in <days> days',	'Your warp, Warp <SpaycName> will be inactive in <days> days unless somebody interacts with it!',	'spayc-inative',	'2018-02-28 17:27:10.578674',	NULL),
(8,	'Warp Deleted',	'Your Warp has been deleted either by you or due to inactivity! Sorry!',	'spayc-deleted',	'2018-02-28 17:27:10.578674',	NULL),
(9,	'Friend replyed to your comment',	'<FRIEND> replied, REPLY on your comment, <COMMENT>',	'friend replyed to your comment',	'2018-02-28 17:27:10.578674',	NULL),
(10,	'Friend joined your warp',	'Let''s get this party started! A friend joined your Warp, <SpaycName>',	'friend-join-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(11,	'Blocked',	'You''ve been blocked. What did you do now?',	'blocked',	'2018-02-28 17:27:10.578674',	NULL),
(13,	'Kick from a warp',	'You''ve been kicked from a warp. Another rude comment or was it a pic?',	'kick-from-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(14,	'Friend subscribed to your warp',	'Your friend, <USERNAME> has subscribed your Warp, <SpaycName>. That''s what friends are for, right?',	'friend-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(15,	'User subscribed to your warp',	'There ya go! A USER <USERNAME>, subscribed to your Warp, <SpaycName>',	'user-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(16,	'User joined your warp',	'<USERNAME> who joined your Warp, <SpaycName>',	'user-joined-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(17,	'A user liked your comment',	'<USERNAME> liked your comment, <COMMENT>. Way to say that great thing you said',	'a-user-liked-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(18,	'Someone replyed to your comment',	'<USERNAME> replied, REPLY your comment, <COMMENT>. Check it out!',	'someone-replyed-to-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(19,	'Someone commented',	'<USERNAME> has commented, <COMMENT> in your warp, <SpaycName>',	'someone-commented',	'2018-02-28 17:27:10.578674',	NULL),
(20,	'New Warp',	'<SpaycName> warp has been created within <X> miles of you',	'new-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(21,	'Accept Join Request',	'You are now part of <SpaycName>',	'accept-join-request',	'2018-02-28 17:27:10.578674',	'2018-02-28 17:27:10.578674'),
(22,	'Join Request',	'<USERNAME> requested to join your warp',	'join-request',	'2018-02-28 17:27:10.578674',	'2018-02-28 17:27:10.578674'),
(12,	'Admin asigned',	'You''ve been assigned as admin, can you handle that responsibility?',	'admin-asigned',	'2018-02-28 17:27:10.578674',	NULL),
(26,	'Spayc Event End',	'Your warp, <WarpName> will be inactive in 2 days unless somebody interacts with it!',	'spayc-end-event',	'2018-05-03 09:33:16.45028',	'2018-05-03 09:33:16.45028'),
(25,	'Spayc Event Start',	'Your warp, <WarpName> is now active',	'spayc-start-event',	'2018-05-03 09:40:16.45028',	'2018-05-03 09:33:16.45028'),
(23,	'User blocked by admin',	'You have been blocked as an Admin by the Admin',	'user-blocked-by-admin',	'2018-04-30 13:56:38.827738',	NULL),
(24,	'User unblocked by admin',	'You have been unblocked as an Admin by the Admin',	'user-unblocked-by-admin',	'2018-04-30 13:56:38.827738',	NULL),
(27,	'Warp blocked by admin',	'You have been blocked from a warp by the Admin',	'blocked-spayc-by-admin',	'2018-06-13 13:05:55.855479',	NULL),
(28,	'Warp unblocked by admin',	'You have been unblocked from a warp by the Admin',	'unblocked-spayc-by-admin',	'2018-06-13 13:05:55.855479',	NULL),
(27,	'Warp deleted by admin',	'A Warp has been deleted',	'spayc-deleted-by-admin',	'2018-05-30 16:05:02.554126',	NULL),
(29,	'Advertisement delete by admin',	'An Advertisement has been deleted',	'advertisement-deleted-by-admin',	'2018-06-13 12:34:51.833118',	NULL),
(30,	'Custom Messages',	'Message from Admin',	'custom-messages',	'2018-06-25 07:03:43.005185',	NULL);

DROP TABLE IF EXISTS physical_location;
CREATE TABLE physical_location (
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "current_latitude" double precision,
    "current_longitude" double precision,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('physical_location', 'created');

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
   "id" BIGSERIAL NOT NULL,
   "title" VARCHAR(50) NULL,
   "created" timestamp NOT NULL,
   "modified" timestamp,
   primary key (id,created)
);
SELECT create_hypertable('roles', 'created');
INSERT INTO roles (id, title,created) VALUES (1, 'Admin',now());


DROP TABLE IF EXISTS advertisement;
CREATE TABLE "advertisement" (
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "name" character varying(255) NOT NULL,
    "price" numeric(12,2),
    "description" text,
    "url" character varying(255),
    "image" character varying(1000),
    "status" row_status DEFAULT 'Pending' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "views" bigint,
    "balance" bigint,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('advertisement', 'created');

DROP TABLE IF EXISTS spayc_advertisement;
CREATE TABLE "spayc_advertisement" (
    "id" BIGSERIAL NOT NULL,
    "advertisement_id" bigint NOT NULL,
    "spayc_id" bigint NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "priority" integer,
    "advertisement_status" integer DEFAULT 0 NOT NULL,
    "display_times" integer DEFAULT 0 NOT NULL,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('spayc_advertisement', 'created');

DROP TABLE IF EXISTS "queue_phinxlog";
CREATE TABLE "queue_phinxlog" (
    "version" bigint NOT NULL,
    "migration_name" character varying(100),
    "start_time" timestamp,
    "end_time" timestamp,
    "breakpoint" boolean DEFAULT false NOT NULL,
    CONSTRAINT "queue_phinxlog_pkey" PRIMARY KEY ("version")
);

DROP TABLE IF EXISTS "queued_jobs";
CREATE TABLE "queued_jobs" (
    "id" BIGSERIAL NOT NULL,
    "job_type" character varying(45) NOT NULL,
    "data" text,
    "job_group" character varying(255),
    "reference" character varying(255),
    "created" timestamp NOT NULL,
    "notbefore" timestamp,
    "fetched" timestamp,
    "completed" timestamp,
    "progress" real,
    "failed" integer DEFAULT 0 NOT NULL,
    "failure_message" text,
    "workerkey" character varying(45),
    "status" character varying(255),
    "priority" integer DEFAULT 5 NOT NULL,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('queued_jobs', 'created');

DROP TABLE IF EXISTS "queue_processes";
CREATE TABLE "queue_processes" (
    "id" BIGSERIAL NOT NULL,
    "pid" character varying(30) NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('queue_processes', 'created');

DROP TABLE IF EXISTS spayc_promotion;
CREATE TABLE "spayc_promotion" (
    "id" BIGSERIAL NOT NULL,
    "promotion_id" bigint,
    "spayc_id" bigint,
    "priority" integer,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "promotion_status" integer DEFAULT 0,
    "display_times" integer DEFAULT 0,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_promotion', 'created');

DROP TABLE IF EXISTS spayc_promotion_priority;
CREATE TABLE "spayc_promotion_priority" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint,
    "cycle" integer,
    "comment_count" integer,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_promotion_priority', 'created');

DROP TABLE IF EXISTS purchase;
CREATE TABLE "purchase" (
    "id" BIGSERIAL NOT NULL,
    "plan_id" bigint,
    "receipt" text,
    "promotion_id" bigint,
    "advertisement_id" bigint,
    "platform" character varying(100),
    "purchase_date" timestamp,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "amount" numeric(7,2),
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('purchase', 'created');

DROP TABLE IF EXISTS spayc_advertisement_priority;
CREATE TABLE "spayc_advertisement_priority" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint,
    "cycle" integer,
    "comment_count" integer,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_advertisement_priority', 'created');

DROP TABLE IF EXISTS promotions;
CREATE TABLE "promotions" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint,
    "user_id" bigint,
    "views" numeric(50,0),
    "balance" numeric(50,0),
    "amount" numeric(7,2),
    "status" row_status DEFAULT 'Active' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('promotions', 'created');

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "user_id" bigint,
    "comment" integer NOT NULL,
    "event_id" character varying(150),
    "status" row_status DEFAULT 'Active' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY(id,spayc_id,created)
);
SELECT create_hypertable('comments', 'created');

DROP TABLE IF EXISTS spayc_categories;
CREATE TABLE "spayc_categories" (
    "id" BIGSERIAL NOT NULL,
    "parent_id" bigint,
    "lft" integer,
    "rght" integer,
    "name" character varying(100),
    "slug" character varying(100),
    "code" character varying(50),
    "description" character varying(200),
    "status" row_status DEFAULT 'Active' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_categories', 'created');

DROP TABLE IF EXISTS eventbrite_events;
CREATE TABLE eventbrite_events (
    "id" BIGSERIAL NOT NULL,
    "eventbrite_event_id" character varying(255) NOT NULL,
    "name" character varying(255),
    "location" character varying(255),
    "latitude" double precision,
    "longitude" double precision,
    "start_date" timestamp,
    "end_date" timestamp,
    "description" text,
    "image" character varying(255) DEFAULT NULL,
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "city" character varying(100),
    "region" character varying(100),
    "postal_code" character varying(100),
    "country" character varying(100),
    "website" integer,
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint,
    PRIMARY KEY ("id", "eventbrite_event_id", "created")
);
SELECT create_hypertable('eventbrite_events', 'created');
COMMENT ON COLUMN "eventbrite_events"."start_date" IS 'eventbrite start_date is inside start obj utc';
COMMENT ON COLUMN "eventbrite_events"."end_date" IS 'eventbrite end_date is inside end obj utc';
COMMENT ON COLUMN "eventbrite_events"."location" IS 'venue name, address obj, city, region, postalCode, country';
COMMENT ON COLUMN "eventbrite_events"."category" IS 'category_id, subcategory_id';
COMMENT ON COLUMN "eventbrite_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

DROP TABLE IF EXISTS stubhub_events;
CREATE TABLE stubhub_events (
    "id" BIGSERIAL NOT NULL,
     "stubhub_event_id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "location" character varying(255),
    "latitude" double precision,
    "longitude" double precision,
    "start_date" timestamp,
    "end_date" timestamp,
    "description" text,
    "image" character varying(255),
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "city" character varying(100),
    "region" character varying(100),
    "postal_code" character varying(100),
    "country" character varying(100),
    "website" integer,
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint,
    PRIMARY KEY ("id", "stubhub_event_id", "created")
);
SELECT create_hypertable('stubhub_events', 'created');
COMMENT ON COLUMN "stubhub_events"."start_date" IS 'stubhub start_date id eventDateUTC';
COMMENT ON COLUMN "stubhub_events"."location" IS 'venue name, address1, city, state, postalCode, country';
COMMENT ON COLUMN "stubhub_events"."category" IS 'categories array';
COMMENT ON COLUMN "stubhub_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

DROP TABLE IF EXISTS ticketmaster_events;
CREATE TABLE ticketmaster_events (
    "id" BIGSERIAL NOT NULL,
    "ticketmaster_event_id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "location" character varying(255),
    "latitude" double precision,
    "longitude" double precision,
    "start_date" timestamp,
    "end_date" timestamp,
    "description" text,
    "image" character varying(255),
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "city" character varying(100),
    "region" character varying(100),
    "postal_code" character varying(100),
    "country" character varying(100),
    "website" integer,
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint,
    CONSTRAINT "ticketmaster_events_pkey" PRIMARY KEY ("id", "ticketmaster_event_id", "created")
);
SELECT create_hypertable('ticketmaster_events', 'created');
COMMENT ON COLUMN "ticketmaster_events"."start_date" IS 'ticketmaster start_date is inside dates obj dateTime';
COMMENT ON COLUMN "ticketmaster_events"."location" IS 'venue name, address, city, state, postalCode, country';
COMMENT ON COLUMN "ticketmaster_events"."category" IS 'category is classifications array';
COMMENT ON COLUMN "ticketmaster_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

DROP TABLE IF EXISTS scraper_categories;
CREATE TABLE scraper_categories (
    id BIGSERIAL NOT NULL,
    "name" character varying(250),
    "scraper_category_id" character varying(255) NOT NULL,
    "spayc_category_id" bigint,
    "website" integer,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    primary key (id,created)
);
COMMENT ON COLUMN "scraper_categories"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';
SELECT create_hypertable('scraper_categories', 'created');

DROP TABLE IF EXISTS scraper_spayc_categories;
CREATE TABLE scraper_spayc_categories (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "category_id" bigint NOT NULL,
    "status" row_status DEFAULT 'Active',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('scraper_spayc_categories', 'created');

DROP TABLE IF EXISTS plans;
CREATE TABLE "plans" (
    "id" BIGSERIAL NOT NULL,
    "app_plan_id" character varying(200),
    "name" character varying(200),
    "slug" character varying(200),
    "type" character varying(100),
    "amount" numeric(7,2),
    "currency" character varying(20),
    "views" integer,
    "status" row_status DEFAULT 'Active' NOT NULL,
    "identifier" character varying(200),
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('plans', 'created');
INSERT INTO "plans" ("id", "app_plan_id", "name", "slug", "type", "amount", "currency", "views", "status", "identifier", "created", "modified") VALUES
(1,	'com.warp.warpapp.adviews1000',	'Plan I',	'plan-1',	'advertisement',	'0.99',	'USD',	1000,	'Active',	NULL,	'2018-04-20 15:07:23.713696',	'2018-04-20 15:07:23.713696'),
(2,	'com.warp.warpapp.adviews2000',	'Plan II',	'plan-2',	'advertisement',	'1.99',	'USD',	2000,	'Active',	NULL,	'2018-04-20 15:08:21.355268',	'2018-04-20 15:08:21.355268'),
(3,	'com.warp.warpapp.adviews6000',	'Plan III',	'plan-3',	'advertisement',	'4.99',	'USD',	6000,	'Active',	NULL,	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612'),
(4,	'com.warp.warpapp.adviews25000',	'Plan IV',	'plan-4',	'advertisement',	'19.99',	'USD',	25000,	'Active',	NULL,	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612');

DROP TABLE IF EXISTS spam_reports;
CREATE TABLE IF NOT EXISTS spam_reports(
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "reported_by" bigint NOT NULL,
    "reported_to" bigint NOT NULL,
    "event_id" character varying(60) NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY(id,spayc_id,created)
);
SELECT create_hypertable('spam_reports', 'created');

DROP TABLE IF EXISTS reported_warps;
CREATE TABLE IF NOT EXISTS reported_warps(
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "matrix_room_id" varchar(100) NOT NULL,
    "reported_by" bigint NOT NULL,
    "message" text NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY(id,spayc_id,created)
);
SELECT create_hypertable('reported_warps', 'created');

DROP TABLE IF EXISTS user_feedbacks;
CREATE TABLE IF NOT EXISTS user_feedbacks(
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "message" text NULL,
    "attachment" character varying(250) NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY(id,created)
);
SELECT create_hypertable('user_feedbacks', 'created');

DROP TABLE IF EXISTS scraper_logs;
CREATE TABLE "scraper_logs" (
    "id" BIGSERIAL NOT NULL,
    "status" character varying(255),
    "created" timestamp NOT NULL,
    "modified" timestamp NOT NULL,
    "start_time" timestamp,
    "end_time" timestamp,
    "unique_time" character varying(250) NOT NULL,
    "response" text,
    "shell" character varying(250),
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('scraper_logs', 'created');

DROP TABLE IF EXISTS "custom_messages";
CREATE TABLE "custom_messages" (
    "id" BIGSERIAL NOT NULL,
    "user_id" character varying(500) NOT NULL,
    "message" text NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('custom_messages', 'created');

DROP TABLE IF EXISTS "pusher_data";
CREATE TABLE public.pusher_data (
    id BIGSERIAL NOT NULL,
    post_value text NULL,
    created timestamp NULL,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('pusher_data', 'created');

INSERT INTO "users" ("username", "email", "password", "gender", "dob", "phone", "status", "website_url", "address", "bio_data", "fb_id", "fb_access_key", "longitude", "latitude", "timezone", "matrix_user_id", "matrix_access_token", "created", "modified", "token_verification", "forgot_password_token", "forgot_password_timestamp", "country_code", "is_notify", "current_latitude", "current_longitude", "role_id") VALUES
('admin','kiwiwarp@gmail.com', 'NzcyNmRmZDg4ZTRjOTg4OWI2NDg4ZWY1N2VkNzNhOWQ1NDcwOTk5ZDExN2NmNmFhMjI1ZmU3ODYxNjZkMmNjMEGrBiCupha2QHSHFUvMuDXwNeXkxmTGyh9Nf7kodS7u', 'Male', NULL, NULL, 'Active',   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   '2018-03-15 15:40:41',  '2018-03-15 15:40:41',  NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,'1');
-- gc_dist custom function
CREATE OR REPLACE FUNCTION public.gc_dist(alat double precision, alng double precision, blat double precision, blng double precision)
RETURNS double precision AS
$BODY$
SELECT asin(
  sqrt(
    sin(radians($3-$1)/2)^2 +
    sin(radians($4-$2)/2)^2 *
    cos(radians($1)) *
    cos(radians($3))
  )
) * 7926.3352 * 1609.34 AS distance;
$BODY$
LANGUAGE sql IMMUTABLE;

ALTER TABLE "spaycs"
ADD "payment_type" varchar(10) NULL,
ADD "ticket_url" varchar(1000) NULL;

ALTER TABLE "eventbrite_events"
ADD "payment_type" varchar(10) NULL,
ADD "ticket_url" varchar(1000) NULL;

ALTER TABLE "ticketmaster_events"
ADD "payment_type" varchar(10) NULL,
ADD "ticket_url" varchar(1000) NULL;

ALTER TABLE "stubhub_events"
ADD "payment_type" character(10) NULL,
ADD "ticket_url" varchar(1000) NULL;

ALTER TABLE public.users ADD ghost_mode_search int NULL DEFAULT 0;
ALTER TABLE public.users ADD ghost_mode_map int NULL DEFAULT 0;
ALTER TABLE "physical_location" ADD "timezone" varchar(100) NULL;
ALTER TABLE "users" ADD "matrix_password" text NULL;