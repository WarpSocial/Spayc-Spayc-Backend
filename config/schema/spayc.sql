-- CREATE TYPE row_status AS ENUM('Active','Inactive','Pending','Approved','Removed');
DROP TABLE "comments";
DROP TABLE "friend_request";
DROP TABLE "hashtags";
DROP TABLE "joined_spayc";
DROP TABLE "notifications";
DROP TABLE "notification_types";
DROP TABLE "spayc_hashtags";
DROP TABLE "spaycs";
DROP TABLE "subscribed_users";
DROP TABLE "user_images";
DROP TABLE "user_logs";
DROP TABLE "users";
DROP TABLE "physical_location";

CREATE TABLE users (
    id BIGSERIAL NOT NULL,
    "username" character varying(100) NOT NULL,
    "display_name" character varying(100) NULL,
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
    "is_notify" character varying(10),
    "current_latitude" double precision,
    "current_longitude" double precision,
    primary key (id,created),
    unique (username,email,created)
);
SELECT create_hypertable('users', 'created');
CREATE TABLE user_logs (
    id BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "token" character varying(255) NOT NULL,
    "plain_token" character varying(255) NOT NULL,
    "device_id" character varying(255),
    "device_token" character varying(1000),
    "matrix_access_token" character varying(1000),
    "matrix_user_id" character varying(255),
    "login_status" integer DEFAULT 0 NOT NULL,
    "last_login" timestamp NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY(id,user_id,created)
);
SELECT create_hypertable('user_logs', 'created');
CREATE TABLE comments (
    id BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "user_id" bigint NULL,
    "comment" integer NOT NULL,
    "event_id" varchar(150) NULL,
    "status" row_status DEFAULT 'Active' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp NULL,
    PRIMARY KEY(id,spayc_id,created)
);
SELECT create_hypertable('comments', 'created');
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
CREATE TABLE joined_spayc (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" BIGINT  NOT NULL,
    "user_id" BIGINT NOT NULL,
    "status" VARCHAR(20) DEFAULT 'Pending',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    "updated_by" BIGINT NOT NULL,
    "is_admin" smallint DEFAULT 0 NOT NULL,
    "distance" numeric,
    PRIMARY KEY (id,spayc_id,user_id,created)
);
SELECT create_hypertable('joined_spayc', 'created');
CREATE TABLE spaycs (
    "id" BIGSERIAL NOT NULL,
    "user_id" bigint NOT NULL,
    "name" character varying(100),
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
    "category_id" bigint NULL,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('spaycs', 'created');
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
CREATE TABLE hashtags (
    "id" BIGSERIAL NOT NULL,
    "name" character varying(255) NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('hashtags', 'created');
CREATE TABLE spayc_hashtags (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "hashtag_id" bigint NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('spayc_hashtags', 'created');
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

CREATE TABLE physical_location (
    "id" BIGSERIAL NOT NULL,
    "user_id" BIGINT NOT NULL,
    "current_latitude" double precision,
    "current_longitude" double precision,
    "created" timestamp DEFAULT NULL,
    "modified" timestamp DEFAULT NULL,
    PRIMARY KEY (id,user_id)
);

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
(18,	'Admin of the warp commented',	'The admin of the Warp, <SpaycName> commented <COMMENT>',	'admin-of-the-spayc-commented',	'2018-03-05 17:27:10.578674',	NULL),
(9,	'friend like your comment',	'<FRIEND> liked your comment, <COMMENT>. Well, you aren''t friends for no reason',	'friend-like-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(1,	'Friend Request',	'Apparently, you''re so cool <USERNAME> wants to be friends with you.',	'friend-request',	'2018-02-28 17:27:10.578674',	NULL),
(2,	'Friend Added',	'You made another friend! Look at you go!',	'friend-added',	'2018-02-28 17:27:10.578674',	NULL),
(15,	'Warp will be inactive in <days> days',	'Your warp, Warp <SpaycName> will be inactive in <days> days unless somebody interacts with it!',	'spayc-inative',	'2018-02-28 17:27:10.578674',	NULL),
(16,	'Warp Deleted',	'Your Warp has been deleted either by you or due to inactivity! Sorry!',	'spayc-deleted',	'2018-02-28 17:27:10.578674',	NULL),
(11,	'Friend replyed to your comment',	'<FRIEND> replied, REPLY on your comment, <COMMENT>',	'friend replyed to your comment',	'2018-02-28 17:27:10.578674',	NULL),
(4,	'Friend joined your warp',	'Let''s get this party started! A friend joined your Warp, <SpaycName>',	'friend-join-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(3,	'Blocked',	'You''ve been blocked. What did you do now?',	'blocked',	'2018-02-28 17:27:10.578674',	NULL),
(12,	'Admin asigned',	'You''ve been asigned as admin, can you handle that responsibility?',	'admin-asigned',	'2018-02-28 17:27:10.578674',	NULL),
(13,	'Kick from a warp',	'You''ve been kicked from a warp. Another rude comment or was it a pic?',	'kick-from-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(6,	'Friend subscribed to your warp',	'Your friend, <USERNAME> has subscribed your Warp, <SpaycName>. That''s what friends are for, right?',	'friend-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(7,	'User subscribed to your warp',	'There ya go! A USER <USERNAME>, subscribed to your Warp, <SpaycName>',	'user-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(5,	'User joined your warp',	'<USERNAME> who joined your Warp, <SpaycName>',	'user-joined-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(8,	'A user liked your comment',	'<USERNAME> liked your comment, <COMMENT>. Way to say that great thing you said',	'a-user-liked-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(10,	'Someone replyed to your comment',	'<USERNAME> replied, REPLY your comment, <COMMENT>. Check it out!',	'someone-replyed-to-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(14,	'Someone commented',	'<USERNAME> has commented, <COMMENT> in your warp, <SpaycName>',	'someone-commented',	'2018-02-28 17:27:10.578674',	NULL),
(17,	'New Warp',	'<SpaycName> warp has been created within <X> miles of you',	'new-spayc',	'2018-02-28 17:27:10.578674',	NULL);

CREATE TABLE "advertisement" (
    "id" BIGSERIAL NOT NULL,
    "user_id" BIGINT NOT NULL,
    "name" character varying(255) NOT NULL,
    "price" decimal(12,2) NULL,
    "views" BIGINT NOT NULL,
    "balance" BIGINT NOT NULL,
    "description" text NULL,
    "url" character varying(255) NULL,
    "image" character varying(1000) NULL,
    "status" row_status DEFAULT 'Pending' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('advertisement', 'created');
CREATE TABLE "spayc_advertisement" (
    "id" BIGSERIAL NOT NULL,
    "advertisement_id" BIGINT NOT NULL,
    "spayc_id" BIGINT NOT NULL,
    "priority" INTEGER NULL,
    "advertisement_status" INTEGER NULL DEFAULT '0',
    "display_times" INTEGER NULL DEFAULT '0',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('spayc_advertisement', 'created');

ALTER TABLE "joined_spayc" ADD "updated_by" bigint NULL;
ALTER TABLE "spaycs" ADD "parent_id" bigint NULL;
ALTER TABLE "joined_spayc" ADD "is_admin" smallint NOT NULL DEFAULT '0';


CREATE TABLE "spayc_advertisement_priority" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" BIGINT NULL,
    "cycle" INTEGER NULL,
    "comment_count" INTEGER NULL,
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_advertisement_priority', 'created');

-- 15-march 2018 for admin  --
CREATE TABLE roles (
   id BIGSERIAL NOT NULL,
   title VARCHAR(50) NULL, 
   primary key (id)
);
INSERT INTO roles (id, title) VALUES (1, 'Admin');
ALTER TABLE "users" ADD "role_id" integer DEFAULT NULL;
INSERT INTO "users" ("id", "username", "email", "password", "gender", "dob", "phone", "status", "website_url", "address", "bio_data", "fb_id", "fb_access_key", "longitude", "latitude", "timezone", "matrix_user_id", "matrix_access_token", "created", "modified", "token_verification", "forgot_password_token", "forgot_password_timestamp", "country_code", "is_notify", "current_latitude", "current_longitude", "role_id") VALUES
('56',  'admin',    'ankur.gupta@kiwitech.com', 'ODIyZDBkN2MxYWVlOTcxZTZhNmMxNjhjZTNjMGQ3ZGMyYzk2ODY4MzM3MDQ3MDZmOTZhMTM0YjU1MzA1YmYzYnwyLmLenyaqlsnztYhQTM8dc+OpkWpoF/jvMx9EELyk', 'Male', NULL, NULL, 'Active',   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   '2018-03-15 15:40:41',  '2018-03-15 15:40:41',  NULL,   NULL,   NULL,   NULL,   NULL,   NULL,   NULL,'1');


-- Adminer 4.3.1 PostgreSQL dump
INSERT INTO "notification_types" ("id", "type", "message", "slug", "created", "modified")
VALUES ('19', 'Blocked by admin', 'You''ve been blocked. What did you do now?', 'blocked-by-admin', now(), NULL),
VALUES ('20', 'UNblocked by admin', 'You''ve been unblocked.', 'unblocked-by-admin', now(), NULL);


DROP TABLE IF EXISTS "queue_phinxlog";
CREATE TABLE "public"."queue_phinxlog" (
    "version" bigint NOT NULL,
    "migration_name" character varying(100),
    "start_time" timestamp,
    "end_time" timestamp,
    "breakpoint" boolean DEFAULT false NOT NULL,
    CONSTRAINT "queue_phinxlog_pkey" PRIMARY KEY ("version")
) WITH (oids = false);


DROP TABLE IF EXISTS "queued_jobs";
CREATE SEQUENCE queued_tasks_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."queued_jobs" (
    "id" integer DEFAULT nextval('queued_tasks_id_seq') NOT NULL,
    "job_type" character varying(45) NOT NULL,
    "data" text,
    "job_group" character varying(255),
    "reference" character varying(255),
    "created" timestamp,
    "notbefore" timestamp,
    "fetched" timestamp,
    "completed" timestamp,
    "progress" real,
    "failed" integer DEFAULT 0 NOT NULL,
    "failure_message" text,
    "workerkey" character varying(45),
    "status" character varying(255),
    "priority" integer DEFAULT 5 NOT NULL,
    CONSTRAINT "queued_tasks_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "queue_processes";
CREATE SEQUENCE queue_processes_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE "public"."queue_processes" (
    "id" integer DEFAULT nextval('queue_processes_id_seq') NOT NULL,
    "pid" character varying(30) NOT NULL,
    "created" timestamp,
    "modified" timestamp,
    CONSTRAINT "queue_processes_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2018-04-13 16:39:12.591553+05:30
CREATE TABLE "spayc_categories" (
    "id" BIGSERIAL NOT NULL,
    "parent_id" bigint NULL,
    "lft" integer NULL,
    "rght" integer NULL,
    "name" character varying(100),
    "slug" character varying(100),
    "code" character varying(50),
    "description" character varying(200),
    "status" row_status DEFAULT 'Active' NOT NULL,
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_categories', 'created');

CREATE TABLE "promotions" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" BIGINT NULL,
    "user_id" BIGINT NULL,
    "views" numeric(50) NULL,
    "balance" numeric(50) NULL,
    "amount" DECIMAL(7,2) NULL,
    "status" row_status NOT NULL DEFAULT 'Active',
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('promotions', 'created');
CREATE TABLE "spayc_promotion" (
    "id" BIGSERIAL NOT NULL,
    "promotion_id" BIGINT NULL,
    "spayc_id" BIGINT NULL,
    "priority" INTEGER NULL,
    "promotion_status" INTEGER NULL DEFAULT '0',
    "display_times" INTEGER NULL DEFAULT '0',
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_promotion', 'created');
CREATE TABLE "spayc_promotion_priority" (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" BIGINT NULL,
    "priority" INTEGER NULL,
    "comment_count" INTEGER NULL,
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('spayc_promotion_priority', 'created');
CREATE TABLE "purchase" (
    "id" BIGSERIAL NOT NULL,
    "plan_id" BIGINT NULL,
    "receipt" text NULL,
    "promotion_id" BIGINT NULL,
    "advertisement_id" BIGINT NULL,
    "platform" BIGINT NULL,
    "amount" DECIMAL(7,2) NULL,
    "purchase_date" timestamp,
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('purchase', 'created');
CREATE TABLE "plans" (
    "id" BIGSERIAL NOT NULL,
    "app_plan_id" VARCHAR(200) NULL,    
    "name" VARCHAR(200) NULL,    
    "slug" VARCHAR(200) NULL,
    "type" VARCHAR(100) NULL,    
    "amount" DECIMAL(7,2) NULL,
    "currency" VARCHAR(20) NULL,
    "views" INTEGER NULL,
    "status" row_status NOT NULL DEFAULT 'Active',
    "identifier" VARCHAR(200) NULL,
    "created" timestamp,
    "modified" timestamp,
    PRIMARY KEY ("id","created")
);
SELECT create_hypertable('plans', 'created');
INSERT INTO "plans" ("id","app_plan_id","type", "name","slug", "amount", "currency", "views", "status", "created", "modified") VALUES
(1, 'com.warp.warpapp.adviews500', 'advertisement',	'Plan I',	'plan-1',	'0.99',	'USD',	500,	'Active',	'2018-04-20 15:07:23.713696',	'2018-04-20 15:07:23.713696'),
(2, 'com.warp.warpapp.adviews1000', 'advertisement',	'Plan II',	'plan-2',	'1.99',	'USD',	1000,	'Active',	'2018-04-20 15:08:21.355268',	'2018-04-20 15:08:21.355268'),
(3, 'com.warp.warpapp.adviews2500', 'advertisement',	'Plan III',	'plan-3',	'4.99',	'USD',	2500,	'Active',	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612'),
(4, 'com.warp.warpapp.adviews6000', 'advertisement',	'Plan IV',	'plan-4',	'9.99',	'USD',	6000,	'Active',	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612'),
(5, NULL, 'promotional',	'Plan I',	'plan-1',	'0.99',	'USD',	500,	'Active',	'2018-04-20 15:07:23.713696',	'2018-04-20 15:07:23.713696'),
(6, NULL, 'promotional',	'Plan II',	'plan-2',	'1.99',	'USD',	1000,	'Active',	'2018-04-20 15:08:21.355268',	'2018-04-20 15:08:21.355268'),
(7, NULL, 'promotional',	'Plan III',	'plan-3',	'4.99',	'USD',	2500,	'Active',	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612'),
(8, NULL, 'promotional',	'Plan IV',	'plan-4',	'9.99',	'USD',	6000,	'Active',	'2018-04-20 15:10:22.46612',	'2018-04-20 15:10:22.46612');

INSERT INTO "spayc_categories" ("id", "parent_id", "lft", "right", "name", "slug", "description", "status", "created", "modified") VALUES
(1,	NULL,	1,	2,	'Music',	'music',	'Music',	'Active',	'2018-04-19 21:00:59.737171',	'2018-04-19 21:00:59.737171'),
(2,	1,	3,	4,	'Blues & Jazz',	'blues-jazz',	'Blues & Jazz',	'Active',	'2018-04-19 21:02:01.031273',	'2018-04-19 21:02:01.031273'),
(3,	1,	5,	7,	'Alternative',	'alternative',	'Alternative',	'Active',	'2018-04-19 21:02:32.883426',	'2018-04-19 21:02:32.883426'),
(4,	1,	8,	10,	'Classical',	'classical',	'Classical',	'Active',	'2018-04-19 21:03:00.810881',	'2018-04-19 21:03:00.810881'),
(5,	NULL,	11,	13,	'Science & Technology',	'science-technology',	'Science & Technology',	'Active',	'2018-04-19 21:03:43.820194',	'2018-04-19 21:03:43.820194'),
(6,	NULL,	13,	14,	'Business & Professional',	'business-professional',	'Business & Professional',	'Active',	'2018-04-19 21:04:33.062492',	'2018-04-19 21:04:33.062492');

/*** For Scrapper Tables ***/
CREATE TABLE eventbrite_events (
    "id" BIGSERIAL NOT NULL,
    "eventbrite_event_id"  character varying(255) NOT NULL,
    "name" character varying(255)  NULL,
    "location" character varying(255) NULL,
    "latitude" double precision NULL,
    "longitude" double precision NULL,    
    "start_date" timestamp DEFAULT NULL,
    "end_date" timestamp DEFAULT NULL,
    "description" text NULL,
    "image" character varying(255) DEFAULT NULL,
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp DEFAULT NULL,     
    "city" character varying(100) NULL,  
    "region" character varying(100) NULL,
    "postal_code" character varying(100) NULL,
    "country" character varying(100) NULL,
    "website" integer DEFAULT NULL,
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint DEFAULT NULL,
    CONSTRAINT "eventbrite_events_pkey" PRIMARY KEY ("id", "eventbrite_event_id", "created")
);
COMMENT ON COLUMN "eventbrite_events"."start_date" IS 'eventbrite start_date is inside start obj utc';
COMMENT ON COLUMN "eventbrite_events"."end_date" IS 'eventbrite end_date is inside end obj utc';
COMMENT ON COLUMN "eventbrite_events"."location" IS 'venue name, address obj, city, region, postalCode, country';
COMMENT ON COLUMN "eventbrite_events"."category" IS 'category_id, subcategory_id';
COMMENT ON COLUMN "eventbrite_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

CREATE TABLE stubhub_events (
    "id" BIGSERIAL NOT NULL,
    "stubhub_event_id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "location" character varying(255) NULL,
    "latitude" double precision,
    "longitude" double precision,    
    "start_date" timestamp DEFAULT NULL,
    "end_date" timestamp DEFAULT NULL,
    "description" text,
    "image" character varying(255),
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp DEFAULT NULL,  
    "city" character varying(100) NULL,  
    "region" character varying(100) NULL,
    "postal_code" character varying(100) NULL,
    "country" character varying(100) NULL,   
    "website" integer DEFAULT NULL,
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint DEFAULT NULL,
    CONSTRAINT "stubhub_events_pkey" PRIMARY KEY ("id", "stubhub_event_id", "created")
);
COMMENT ON COLUMN "stubhub_events"."start_date" IS 'stubhub start_date id eventDateUTC';
COMMENT ON COLUMN "stubhub_events"."location" IS 'venue name, address1, city, state, postalCode, country';
COMMENT ON COLUMN "stubhub_events"."category" IS 'categories array';
COMMENT ON COLUMN "stubhub_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

CREATE TABLE ticketmaster_events (
    "id" BIGSERIAL NOT NULL,
    "ticketmaster_event_id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "location" character varying(255) NULL,
    "latitude" double precision,
    "longitude" double precision,    
    "start_date" timestamp DEFAULT NULL,
    "end_date" timestamp DEFAULT NULL,
    "description" text,
    "image" character varying(255),
    "category" character varying(255) DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp DEFAULT NULL,     
    "city" character varying(100) NULL,  
    "region" character varying(100) NULL,
    "postal_code" character varying(100) NULL,
    "country" character varying(100) NULL,   
    "website" integer DEFAULT NULL, 
    "event_status" character varying(255) DEFAULT NULL,
    "group_id" character varying(255) DEFAULT NULL,
    "spayc_id" bigint DEFAULT NULL,
    CONSTRAINT "ticketmaster_events_pkey" PRIMARY KEY ("id", "ticketmaster_event_id", "created")
);
COMMENT ON COLUMN "ticketmaster_events"."start_date" IS 'ticketmaster start_date is inside dates obj dateTime';
COMMENT ON COLUMN "ticketmaster_events"."location" IS 'venue name, address, city, state, postalCode, country';
COMMENT ON COLUMN "ticketmaster_events"."category" IS 'category is classifications array';
COMMENT ON COLUMN "ticketmaster_events"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

ALTER TABLE "spaycs" ADD "is_admin_update" smallint NULL DEFAULT '0';
ALTER TABLE "spaycs" ADD "website" integer DEFAULT NULL;

CREATE TABLE scraper_categories (
    id BIGSERIAL NOT NULL,
    "name" character varying(250) NULL,
    "scraper_category_id" character varying(255) NOT NULL,
    "spayc_category_id" bigint DEFAULT NULL,
    "website" integer DEFAULT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp NULL,   
    primary key (id,created)
);
COMMENT ON COLUMN "scraper_categories"."website" IS '1 for eventbrite, 2 for ticketmaster, 3 for stubhub';

CREATE TABLE scraper_spayc_categories (
    "id" BIGSERIAL NOT NULL,
    "spayc_id" bigint NOT NULL,
    "category_id" bigint NOT NULL,
    "status" row_status DEFAULT 'Active',
    "created" timestamp NOT NULL,
    "modified" timestamp,
    PRIMARY KEY (id)
);

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
