CREATE TYPE row_status AS ENUM('Active','Inactive','Pending','Approved');
CREATE TABLE users (
    id BIGSERIAL NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NULL,
    password VARCHAR(255) NULL,
    gender VARCHAR(50) NULL,
    dob date NULL,
    country_code VARCHAR(10) NULL,
    phone VARCHAR(20) NULL,
    status row_status DEFAULT 'Pending'::row_status NOT NULL,
    website_url VARCHAR(150) NULL,
    address text NULL,
    bio_data text NULL,
    fb_id VARCHAR(200),
    fb_access_key  VARCHAR(1000),
    longitude double precision NULL,
    latitude double precision NULL,
    current_latitude double precision NULL,
    current_longitude double precision NULL, 
    timezone VARCHAR(100),
    matrix_user_id VARCHAR(100),
    matrix_access_token VARCHAR(1000),
    token_verification VARCHAR(255) NULL,
    forgot_password_token VARCHAR(255) NULL,
    forgot_password_timestamp timestamp NULL,
    is_notify VARCHAR(10) NULL,
    created timestamp NOT NULL,
    modified timestamp,
    primary key (id,created),
    unique (username,email,created)
);
SELECT create_hypertable('users', 'created');
CREATE TABLE user_logs (
    id BIGSERIAL NOT NULL,
    user_id bigint NOT NULL,
    token VARCHAR(255) NOT NULL,
    plain_token VARCHAR(255) NOT NULL,
    device_id VARCHAR(255),
    matrix_access_token VARCHAR(1000),
    matrix_user_id VARCHAR(255),
    login_status integer DEFAULT 0 NOT NULL,
    last_login timestamp NOT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY(id,user_id,created)
);
SELECT create_hypertable('user_logs', 'created');
CREATE TABLE comments (
    id BIGSERIAL NOT NULL,
    spayc_id BIGINT ,
    user_id BIGINT,
    comment text,
    status row_status DEFAULT 'Pending'::row_status NOT NULL,
    created timestamp NOT NULL,
    modified timestamp NOT NULL,
    PRIMARY KEY(id,spayc_id,user_id,created)
);
SELECT create_hypertable('comments', 'created');
CREATE TABLE friend_request (
    id BIGSERIAL NOT NULL,
    requested_by BIGINT,
    requested_to BIGINT,
    blocked_by BIGINT DEFAULT NULL,
    requested_status VARCHAR(15)  DEFAULT 'Requested',
    friend_status VARCHAR(15) DEFAULT NULL,
    matrix_room_id VARCHAR(100) DEFAULT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,requested_by,requested_to,created)
);
SELECT create_hypertable('friend_request', 'created');
CREATE TABLE joined_spayc (
    id BIGSERIAL NOT NULL,
    spayc_id BIGINT  NOT NULL,
    user_id BIGINT NOT NULL,
    status row_status DEFAULT 'Pending'::row_status NOT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,spayc_id,user_id,created)
);
SELECT create_hypertable('joined_spayc', 'created');
CREATE TABLE spaycs (
    id BIGSERIAL NOT NULL,
    user_id BIGINT NOT NULL,
    name VARCHAR(100) NULL,
    location VARCHAR(255) NULL,
    type VARCHAR(20) DEFAULT 'Event',
    group_type VARCHAR(20) DEFAULT 'Public',
    start_date timestamp NULL,
    end_date timestamp NULL,
    passcode VARCHAR(30) NULL,
    description text,
    image VARCHAR(255) NULL,
    longitude double precision,
    latitude double precision,    
    status row_status DEFAULT 'Inactive'::row_status,
    matrix_room_id VARCHAR(100) NULL,    
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('spaycs', 'created');
CREATE TABLE subscribed_users (
    id BIGSERIAL NOT NULL,
    spayc_id BIGINT  NOT NULL,
    user_id BIGINT NOT NULL,
    status row_status DEFAULT 'Inactive'::row_status,
    created timestamp without time zone NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,spayc_id,user_id,created)
);
SELECT create_hypertable('subscribed_users', 'created');
CREATE TABLE user_images (
    id BIGSERIAL NOT NULL,
    user_id BIGINT NOT NULL,
    image_url VARCHAR(255),
    is_profile VARCHAR(10) DEFAULT 'No',
    order_index SMALLINT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,user_id,created)
);
SELECT create_hypertable('user_images', 'created');
CREATE TABLE hashtags (
    id BIGSERIAL NOT NULL,
    name VARCHAR(255) NOT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('hashtags', 'created');
CREATE TABLE spayc_hashtags (
    id BIGSERIAL NOT NULL,
    spayc_id BIGINT NOT NULL,
    hashtag_id BIGINT NOT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('spayc_hashtags', 'created');
CREATE TABLE notifications (
    id BIGSERIAL NOT NULL,
    requested_by BIGINT NOT NULL,
    requested_to BIGINT NOT NULL,
    spayc_id BIGINT NULL,
    date_time timestamp NULL,
    notification_type VARCHAR(20) DEFAULT NULL,
    status VARCHAR(20) DEFAULT NULL,
    message VARCHAR(200) DEFAULT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('notifications', 'created');

CREATE TABLE "notification_types" (
  "id" BIGSERIAL NOT NULL,
  "type" VARCHAR(200) NULL,
  "message" text NULL,
  "slug" VARCHAR(200) NULL,
  "created" timestamp NOT NULL,
  "modified" timestamp NULL
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


ALTER TABLE "joined_spayc" ADD "updated_by" bigint NULL;
ALTER TABLE "spaycs" ADD "parent_id" bigint NULL;
ALTER TABLE "joined_spayc" ADD "is_admin" smallint NOT NULL DEFAULT '0';
