-- CREATE TYPE row_status AS ENUM('Active','Inactive','Pending','Approved');
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
    "user_id" bigint NOT NULL,
    "comment" text,
    "status" row_status DEFAULT 'Pending' NOT NULL,
    "created" timestamp NOT NULL,
    "modified" timestamp NOT NULL,
    PRIMARY KEY(id,spayc_id,user_id,created)
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
(18,	'Admin of the spayc commented',	'The admin of the Spayc, <SpaycName> commented <COMMENT>',	'admin-of-the-spayc-commented',	'2018-03-05 17:27:10.578674',	NULL),
(9,	'friend like your comment',	'<FRIEND> liked your comment, <COMMENT>. Well, you aren''t friends for no reason',	'friend-like-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(1,	'Friend Request',	'Apparently, you''re so cool <USERNAME> wants to be friends with you.',	'friend-request',	'2018-02-28 17:27:10.578674',	NULL),
(2,	'Friend Added',	'You made another friend! Look at you go!',	'friend-added',	'2018-02-28 17:27:10.578674',	NULL),
(15,	'Spayc will be inactive in <days> days',	'Your spayc, Spayc <SpaycName> will be inactive in <days> days unless somebody interacts with it!',	'spayc-inative',	'2018-02-28 17:27:10.578674',	NULL),
(16,	'Spayc Deleted',	'Your Spayc has been deleted either by you or due to inactivity! Sorry!',	'spayc-deleted',	'2018-02-28 17:27:10.578674',	NULL),
(11,	'Friend replyed to your comment',	'<FRIEND> replied, REPLY on your comment, <COMMENT>',	'friend replyed to your comment',	'2018-02-28 17:27:10.578674',	NULL),
(4,	'Friend joined your spayc',	'Let''s get this party started! A friend joined your Spayc, <SpaycName>',	'friend-join-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(3,	'Blocked',	'You''ve been blocked. What did you do now?',	'blocked',	'2018-02-28 17:27:10.578674',	NULL),
(12,	'Admin asigned',	'You''ve been asigned as admin, can you handle that responsibility?',	'admin-asigned',	'2018-02-28 17:27:10.578674',	NULL),
(13,	'Kick from a spayc',	'You''ve been kicked from a spayc. Another rude comment or was it a pic?',	'kick-from-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(6,	'Friend subscribed to your spayc',	'Your friend, <USERNAME> has subscribed your Spayc, <SpaycName>. That''s what friends are for, right?',	'friend-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(7,	'User subscribed to your spayc',	'There ya go! A USER <USERNAME>, subscribed to your Spayc, <SpaycName>',	'user-subscribed-to-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(5,	'User joined your spayc',	'<USERNAME> who joined your Spayc, <SpaycName>',	'user-joined-your-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(8,	'A user liked your comment',	'<USERNAME> liked your comment, <COMMENT>. Way to say that great thing you said',	'a-user-liked-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(10,	'Someone replyed to your comment',	'<USERNAME> replied, REPLY your comment, <COMMENT>. Check it out!',	'someone-replyed-to-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(14,	'Someone commented',	'<USERNAME> has commented, <COMMENT> in your spayc, <SpaycName>',	'someone-commented',	'2018-02-28 17:27:10.578674',	NULL),
(17,	'New Spayc',	'<SpaycName> spayc has been created within <X> miles of you',	'new-spayc',	'2018-02-28 17:27:10.578674',	NULL);

