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
INSERT INTO "spayc_categories" ("id", "parent_id", "lft", "rght", "name", "slug", "code", "description", "status", "created", "modified") VALUES
(2,	1,	2,	3,	'Hip Hop & Rap',	'hip-hop-rap',	'1F3B6',	'Hip Hop & Rap',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(37,	1,	72,	73,	'Cover/Tribute',	'cover-tribute',	'1F3B6',	'Cover/Tribute',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(3,	1,	4,	5,	'Top 40',	'top-40',	'1F3B6',	'Top 40',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(53,	1,	104,	105,	'Industrial',	'industrial',	'1F3B6',	'Industrial',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(4,	1,	6,	7,	'Blues & Jazz',	'blues-jazz',	'1F3B6',	'Blues & Jazz',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(38,	1,	74,	75,	'Dance and Electronic music',	'dance-and-electronic-music',	'1F3B6',	'Dance and Electronic music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(5,	1,	8,	9,	'Classical',	'classical',	'1F3B6',	'Classical',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(60,	1,	118,	119,	'Miscellaneous music',	'miscellaneous-music',	'1F3B6',	'Miscellaneous music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(6,	1,	10,	11,	'Reggae',	'reggae',	'1F3B6',	'Reggae',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(39,	1,	76,	77,	'Disco',	'disco',	'1F3B6',	'Disco',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(7,	1,	12,	13,	'Other',	'other',	'1F3B6',	'Other',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(54,	1,	106,	107,	'Jazz Music',	'jazz-music',	'1F3B6',	'Jazz Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(8,	1,	14,	15,	'Latin',	'latin',	'1F3B6',	'Latin',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(40,	1,	78,	79,	'Dixieland',	'dixieland',	'1F3B6',	'Dixieland',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(9,	1,	16,	17,	'Rock',	'rock',	'1F3B6',	'Rock',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(10,	1,	18,	19,	'R&B',	'r-b',	'1F3B6',	'R&B',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(41,	1,	80,	81,	'Doo Wop',	'doo-wop',	'1F3B6',	'Doo Wop',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(11,	1,	20,	21,	'Alternative',	'alternative',	'1F3B6',	'Alternative',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(55,	1,	108,	109,	'Jazz, Blues and RnB music',	'jazz-blues-and-rnb-music',	'1F3B6',	'Jazz, Blues and RnB music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(12,	1,	22,	23,	'Pop',	'pop',	'1F3B6',	'Pop',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(42,	1,	82,	83,	'Easy Listening',	'easy-listening',	'1F3B6',	'Easy Listening',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(13,	1,	24,	25,	'Country',	'country',	'1F3B6',	'Country',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(14,	1,	26,	27,	'Indie',	'indie',	'1F3B6',	'Indie',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(43,	1,	84,	85,	'Electronic',	'electronic',	'1F3B6',	'Electronic',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(15,	1,	28,	29,	'Electronic & EDM',	'electronic-edm',	'1F3B6',	'Electronic & EDM',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(56,	1,	110,	111,	'Karaoke / Open mic',	'karaoke-open-mic',	'1F3B6',	'Karaoke / Open mic',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(16,	1,	30,	31,	'Cultural',	'cultural',	'1F3B6',	'Cultural',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(44,	1,	86,	87,	'Flamenco',	'flamenco',	'1F3B6',	'Flamenco',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(17,	1,	32,	33,	'Folk',	'folk',	'1F3B6',	'Folk',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(18,	1,	34,	35,	'Opera',	'opera',	'1F3B6',	'Opera',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(45,	1,	88,	89,	'Freestyle',	'freestyle',	'1F3B6',	'Freestyle',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(19,	1,	36,	37,	'Spiritual & Religious',	'spiritual-religious',	'1F3B6',	'Spiritual & Religious',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(57,	1,	112,	113,	'Latic music',	'latic-music',	'1F3B6',	'Latic music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(20,	1,	38,	39,	'Metal',	'metal',	'1F3B6',	'Metal',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(46,	1,	90,	91,	'Funk',	'funk',	'1F3B6',	'Funk',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(21,	1,	40,	41,	'Acid Jazz',	'acid-jazz',	'1F3B6',	'Acid Jazz',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(22,	1,	42,	43,	'Acoustic',	'acoustic',	'1F3B6',	'Acoustic',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(47,	1,	92,	93,	'Garage',	'garage',	'1F3B6',	'Garage',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(23,	1,	44,	45,	'Alternative Music',	'alternative-music',	'1F3B6',	'Alternative Music',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(58,	1,	114,	115,	'Lounge',	'lounge',	'1F3B6',	'Lounge',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(24,	1,	46,	47,	'Ambient',	'ambient',	'1F3B6',	'Ambient',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(48,	1,	94,	95,	'Gospel',	'gospel',	'1F3B6',	'Gospel',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(25,	1,	48,	49,	'Bluegrass',	'bluegrass',	'1F3B6',	'Bluegrass',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(26,	1,	50,	51,	'Blues Music',	'blues-music',	'1F3B6',	'Blues Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(49,	1,	96,	97,	'Gothic',	'gothic',	'1F3B6',	'Gothic',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(27,	1,	52,	53,	'Bossa Nova',	'bossa-nova',	'1F3B6',	'Bossa Nova',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(59,	1,	116,	117,	'Mariachi',	'mariachi',	'1F3B6',	'Mariachi',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(28,	1,	54,	55,	'Breakbeat',	'breakbeat',	'1F3B6',	'Breakbeat',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(50,	1,	98,	99,	'Hard Rock and Metal music',	'hard-rock-and-metal-music',	'1F3B6',	'Hard Rock and Metal music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(29,	1,	56,	57,	'Cajun and Zydeco',	'cajun-and-zydeco',	'1F3B6',	'Cajun and Zydeco',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(30,	1,	58,	59,	'Calypso',	'calypso',	'1F3B6',	'Calypso',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(51,	1,	100,	101,	'Hardcore',	'hardcore',	'1F3B6',	'Hardcore',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(31,	1,	60,	61,	'Caribbean',	'caribbean',	'1F3B6',	'Caribbean',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(61,	1,	120,	121,	'Music Festival',	'music-festival',	'1F3B6',	'Music Festival',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(32,	1,	62,	63,	'Celtic',	'celtic',	'1F3B6',	'Celtic',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(52,	1,	102,	103,	'House',	'house',	'1F3B6',	'House',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(33,	1,	64,	65,	'Childrens',	'childrens',	'1F3B6',	'Childrens',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(34,	1,	66,	67,	'Christian',	'christian',	'1F3B6',	'Christian',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(62,	1,	122,	123,	'New Age and Spiritual Music',	'new-age-and-spiritual-music',	'1F3B6',	'New Age and Spiritual Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(35,	1,	68,	69,	'Classical and vocal music',	'classical-and-vocal-music',	'1F3B6',	'Classical and vocal music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(36,	1,	70,	71,	'Country and folk music',	'country-and-folk-music',	'1F3B6',	'Country and folk music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(63,	1,	124,	125,	'Polka',	'polka',	'1F3B6',	'Polka',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(64,	1,	126,	127,	'Pop Music',	'pop-music',	'1F3B6',	'Pop Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(65,	1,	128,	129,	'Progressive rock',	'progressive-rock',	'1F3B6',	'Progressive rock',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(92,	NULL,	183,	314,	'Sports',	'sports',	'1F3BD',	'Sports',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(66,	1,	130,	131,	'Punk',	'punk',	'1F3B6',	'Punk',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(99,	92,	196,	197,	'Bowling',	'bowling',	'1F3B3',	'Bowling',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(67,	1,	132,	133,	'Rap and Hip',	'rap-and-hip',	'1F3B6',	'Rap and Hip',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(114,	92,	226,	227,	'Handball',	'handball',	'1F93E',	'Handball',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(68,	1,	134,	135,	'RB and Soul music',	'rb-and-soul-music',	'1F3B6',	'RB and Soul music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(100,	92,	198,	199,	'Chess',	'chess',	'265F',	'Chess',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(69,	1,	136,	137,	'Reggae Music',	'reggae-music',	'1F3B6',	'Reggae Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(122,	92,	242,	243,	'Karate',	'karate',	'1F94B',	'Karate',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(70,	1,	138,	139,	'Rock, Pop and hip',	'rock-pop-and-hip',	'1F3B6',	'Rock, Pop and hip',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(101,	92,	200,	201,	'Cricket',	'cricket',	'1F3CF',	'Cricket',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(71,	1,	140,	141,	'Rockabilly',	'rockabilly',	'1F3B6',	'Rockabilly',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(115,	92,	228,	229,	'Hockey',	'hockey',	'1F3D1',	'Hockey',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(72,	1,	142,	143,	'Samba',	'samba',	'1F3B6',	'Samba',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(102,	92,	202,	203,	'Curling',	'curling',	'1F3CB',	'Curling',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(73,	1,	144,	145,	'Ska',	'ska',	'1F3B6',	'Ska',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(125,	92,	248,	249,	'Motorsports',	'motorsports',	'1F3CD',	'Motorsports',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(74,	1,	146,	147,	'Surf Rock',	'surf-rock',	'1F3B6',	'Surf Rock',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(103,	92,	204,	205,	'Cycling',	'cycling',	'1F6B4',	'Cycling',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(75,	1,	148,	149,	'Tejano',	'tejano',	'1F3B6',	'Tejano',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(116,	92,	230,	231,	'Horse Racing',	'horse-racing',	'1F3C7',	'Horse Racing',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(76,	1,	150,	151,	'Trance',	'trance',	'1F3B6',	'Trance',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(104,	92,	206,	207,	'Dance',	'dance',	'1F483',	'Dance',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(77,	1,	152,	153,	'Vocal Performance Music',	'vocal-performance-music',	'1F3B6',	'Vocal Performance Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(123,	92,	244,	245,	'Lacrosse',	'lacrosse',	'1F94D',	'Lacrosse',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(78,	1,	154,	155,	'Western',	'western',	'1F3B6',	'Western',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(105,	92,	208,	209,	'Darts',	'darts',	'1F3AF',	'Darts',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(79,	1,	156,	157,	'World Music',	'world-music',	'1F3B6',	'World Music',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(117,	92,	232,	233,	'Hunting',	'hunting',	'1F52B',	'Hunting',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(80,	1,	158,	159,	'Alternative Rock',	'alternative-rock',	'1F3B6',	'Alternative Rock',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(106,	92,	210,	211,	'Equestrian',	'equestrian',	'1F3C7',	'Equestrian',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(81,	1,	160,	161,	'Cabaret',	'cabaret',	'1F3B6',	'Cabaret',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(127,	92,	252,	253,	'Rec and Wellness',	'rec-and-wellness',	'1F3BD',	'Rec and Wellness',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(82,	1,	162,	163,	'Comedy',	'comedy',	'1F3B6',	'Comedy',	'Active',	'2018-05-23 07:21:49',	'2018-05-23 07:21:49'),
(107,	92,	212,	213,	'Extreme Sports',	'extreme-sports',	'1F3BD',	'Extreme Sports',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(83,	1,	164,	165,	'Country and Folk',	'country-and-folk',	'1F3B6',	'Country and Folk',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(118,	92,	234,	235,	'Hurling',	'hurling',	'1F3BD',	'Hurling',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(84,	1,	166,	167,	'Dance/Electronic',	'dance-electronic',	'1F3B6',	'Dance/Electronic',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(108,	92,	214,	215,	'Fight',	'fight',	'1F94A',	'Fight',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(85,	1,	168,	169,	'Festivals',	'festivals',	'1F3B6',	'Festivals',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(86,	1,	170,	171,	'Hard Rock/Metal',	'hard-rock-metal',	'1F3B6',	'Hard Rock/Metal',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(109,	92,	216,	217,	'Figure Skating',	'figure-skating',	'26F8',	'Figure Skating',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(87,	1,	172,	173,	'Jazz and Blues',	'jazz-and-blues',	'1F3B6',	'Jazz and Blues',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(119,	92,	236,	237,	'Jousting',	'jousting',	'1F93C',	'Jousting',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(88,	1,	174,	175,	'New Age and Spiritual',	'new-age-and-spiritual',	'1F3B6',	'New Age and Spiritual',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(110,	92,	218,	219,	'Fishing',	'fishing',	'1F41F',	'Fishing',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(89,	1,	176,	177,	'R&B/Urban Soul',	'r-b-urban-soul',	'1F3B6',	'R&B/Urban Soul',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(90,	1,	178,	179,	'Rock and Pop',	'rock-and-pop',	'1F3B6',	'Rock and Pop',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(1,	NULL,	1,	182,	'Music',	'music',	'1F3B6',	'Music',	'Active',	'2018-05-23 07:21:48',	'2018-05-23 07:21:48'),
(91,	1,	180,	181,	'Miscellaneous',	'miscellaneous',	'1F3B6',	'Miscellaneous',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(111,	92,	220,	221,	'Football',	'football',	'1FC38',	'Football',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(93,	92,	184,	185,	'Amateur sports',	'amateur-sports',	'1F3BD',	'Amateur sports',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(120,	92,	238,	239,	'Judo',	'judo',	'1F94B',	'Judo',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(94,	92,	186,	187,	'Athletics',	'athletics',	'1F3BD',	'Athletics',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(112,	92,	222,	223,	'Golf',	'golf',	'1F3CC',	'Golf',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(95,	92,	188,	189,	'Aviation',	'aviation',	'1F3BD',	'Aviation',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(126,	92,	250,	251,	'Polo',	'polo',	'1F3C7',	'Polo',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(96,	92,	190,	191,	'Baseball',	'baseball',	'26BE',	'Baseball',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(128,	92,	254,	255,	'Recreation',	'recreation',	'1F3BD',	'Recreation',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(97,	92,	192,	193,	'Birding',	'birding',	'1F3BD',	'Birding',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(121,	92,	240,	241,	'Kabaddi',	'kabaddi',	'1F94B',	'Kabaddi',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(98,	92,	194,	195,	'Bodybuilding',	'bodybuilding',	'1F3CB',	'Bodybuilding',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(113,	92,	224,	225,	'Gymnastics',	'gymnastics',	'1F938',	'Gymnastics',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(129,	92,	256,	257,	'Rodeo',	'rodeo',	'1F403',	'Rodeo',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(130,	92,	258,	259,	'Roller Derby',	'roller-derby',	'1F3A2',	'Roller Derby',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(131,	92,	260,	261,	'Roller Skating',	'roller-skating',	'1F3A2',	'Roller Skating',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(132,	92,	262,	263,	'Rowing',	'rowing',	'1F6A3',	'Rowing',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(133,	92,	264,	265,	'Rugby',	'rugby',	'1F3C9',	'Rugby',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(134,	92,	266,	267,	'Sailing',	'sailing',	'26F5',	'Sailing',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(135,	92,	268,	269,	'Skateboarding',	'skateboarding',	'1F3BD',	'Skateboarding',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(136,	92,	270,	271,	'Ski Lift',	'ski-lift',	'26F7',	'Ski Lift',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(137,	92,	272,	273,	'Snooker',	'snooker',	'1F3BD',	'Snooker',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(138,	92,	274,	275,	'Soccer',	'soccer',	'26BD',	'Soccer',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(139,	92,	276,	277,	'Softball',	'softball',	'1F94E',	'Softball',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(140,	92,	278,	279,	'Sports and outdoors',	'sports-and-outdoors',	'1F3BD',	'Sports and outdoors',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(141,	92,	280,	281,	'Squash',	'squash',	'1F3BD',	'Squash',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(142,	92,	282,	283,	'Sumo Wrestling',	'sumo-wrestling',	'1F93C',	'Sumo Wrestling',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(143,	92,	284,	285,	'Swimming',	'swimming',	'1F3CA',	'Swimming',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(144,	92,	286,	287,	'Table Tennis',	'table-tennis',	'1F3BE',	'Table Tennis',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(145,	92,	288,	289,	'Tennis',	'tennis',	'1F3BE',	'Tennis',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50'),
(146,	92,	290,	291,	'Track and Field',	'track-and-field',	'1F3BD',	'Track and Field',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(147,	92,	292,	293,	'Volleyball',	'volleyball',	'1F3D0',	'Volleyball',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(148,	92,	294,	295,	'Waterpolo',	'waterpolo',	'1F93D',	'Waterpolo',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(149,	92,	296,	297,	'Winter Sports',	'winter-sports',	'26F7',	'Winter Sports',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(150,	92,	298,	299,	'Wrestling',	'wrestling',	'1F93C',	'Wrestling',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(151,	92,	300,	301,	'Basketball',	'basketball',	'1F3C0',	'Basketball',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(152,	92,	302,	303,	'Boxing',	'boxing',	'1F94A',	'Boxing',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(153,	92,	304,	305,	'Bull Riding',	'bull-riding',	'1F402',	'Bull Riding',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(154,	92,	306,	307,	'Competitions',	'competitions',	'1F3C6',	'Competitions',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(155,	92,	308,	309,	'Field Sports',	'field-sports',	'1F3D1',	'Field Sports',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(156,	92,	310,	311,	'Mixed Martial Arts',	'mixed-martial-arts',	'1F94B',	'Mixed Martial Arts',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(157,	92,	312,	313,	'Skating',	'skating',	'26F8',	'Skating',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(159,	158,	316,	317,	'Arts & crafts',	'arts-crafts',	'1F3A8',	'Arts & crafts',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(177,	174,	352,	353,	'Ballet and Dance',	'ballet-and-dance',	'1F483',	'Ballet and Dance',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(160,	158,	318,	319,	'Classical Music and Opera',	'classical-music-and-opera',	'1F3BB',	'Classical Music and Opera',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(172,	158,	342,	343,	'VIP events and party',	'vip-events-and-party',	'1F464',	'VIP events and party',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(161,	158,	320,	321,	'Dance / Ballet',	'dance-ballet',	'1F483',	'Dance / Ballet',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(178,	174,	354,	355,	'Film Festivals',	'film-festivals',	'1F3A5',	'Film Festivals',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(162,	158,	322,	323,	'Family',	'family',	'1F46A',	'Family',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(158,	NULL,	315,	346,	'Theater and Comedy',	'theater-and-comedy',	'1F602',	'Theater and Comedy',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(163,	158,	324,	325,	'Festivals and fairs',	'festivals-and-fairs',	'1F3AA',	'Festivals and fairs',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(164,	158,	326,	327,	'Food and Dining',	'food-and-dining',	'1F37D',	'Food and Dining',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(165,	158,	328,	329,	'Horse show',	'horse-show',	'1F3C7',	'Horse show',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(188,	187,	374,	375,	'Party',	'party',	'1F389',	'Party',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(166,	158,	330,	331,	'Movie Event',	'movie-event',	'1F3AC',	'Movie Event',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(193,	187,	384,	385,	'Festival',	'festival',	'1F3AA',	'Festival',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(168,	158,	334,	335,	'Musicals',	'musicals',	'1F3BC',	'Musicals',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(182,	180,	362,	363,	'Circus',	'circus',	'1F939',	'Circus',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(169,	158,	336,	337,	'Performing Arts',	'performing-arts',	'1F3AD',	'Performing Arts',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(189,	187,	376,	377,	'party popper',	'party-popper',	'1F389',	'party popper',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(170,	158,	338,	339,	'Plays',	'plays',	'1F3AD',	'Plays',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(183,	180,	364,	365,	'Fairs and Festivals',	'fairs-and-festivals',	'1F3AA',	'Fairs and Festivals',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(171,	158,	340,	341,	'Speaking Tour / Convention',	'speaking-tour-convention',	'1F5E3',	'Speaking Tour / Convention',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(187,	NULL,	373,	408,	'Other',	'other',	'1F3AD',	'Other',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(180,	NULL,	359,	372,	'Family',	'family',	'1F468',	'Family',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(173,	158,	344,	345,	'Visual Arts',	'visual-arts',	'1F4F9',	'Visual Arts',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(184,	180,	366,	367,	'Family Attractions',	'family-attractions',	'1F46A',	'Family Attractions',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(175,	174,	348,	349,	'Broadway',	'broadway',	'1F3AD',	'Broadway',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(190,	187,	378,	379,	'Performance',	'performance',	'1F3AD',	'Performance',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(176,	174,	350,	351,	'Off-Broadway',	'off-broadway',	'1F3AD',	'Off-Broadway',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(194,	187,	386,	387,	'Appearance',	'appearance',	'1F460',	'Appearance',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(185,	180,	368,	369,	'Ice Shows',	'ice-shows',	'1F3AD',	'Ice Shows',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(186,	180,	370,	371,	'Magic Shows',	'magic-shows',	'1F3AD',	'Magic Shows',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(191,	187,	380,	381,	'Class',	'class',	'270F',	'Class',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(195,	187,	388,	389,	'Networking',	'networking',	'1F91D',	'Networking',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(192,	187,	382,	383,	'Tour',	'tour',	'1F5FA',	'Tour',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(196,	187,	390,	391,	'Seminar',	'seminar',	'270F',	'Seminar',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(197,	187,	392,	393,	'Gala',	'gala',	'1F91D',	'Gala',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(199,	187,	396,	397,	'Conference',	'conference',	'1F91D',	'Conference',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(200,	187,	398,	399,	'Game',	'game',	'1F3AE',	'Game',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(201,	187,	400,	401,	'Screening',	'screening',	'1F3AC',	'Screening',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(198,	187,	394,	395,	'Attraction',	'attraction',	'1F300',	'Attraction',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(167,	158,	332,	333,	'Museum',	'museum',	'1F5FF',	'Museum',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(181,	180,	360,	361,	'Children''s Music and Theater',	'children-s-music-and-theater',	'1F5FF',	'Children''s Music and Theater',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(174,	NULL,	347,	358,	'Arts and Theater',	'arts-and-theater',	'1F3AD',	'Arts and Theater',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(202,	187,	402,	403,	'Tournament',	'tournament',	'1F3C6',	'Tournament',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(204,	187,	406,	407,	'Expo',	'expo',	'1F91D',	'Expo',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(179,	174,	356,	357,	'Museums and Exhibits',	'museums-and-exhibits',	'1F5FF',	'Museums and Exhibits',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(203,	187,	404,	405,	'Retreat',	'retreat',	'1F300',	'Retreat',	'Active',	'2018-05-23 07:21:51',	'2018-05-23 07:21:51'),
(124,	92,	246,	247,	'Marching Band',	'marching-band',	'1F468',	'Marching Band',	'Active',	'2018-05-23 07:21:50',	'2018-05-23 07:21:50');

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