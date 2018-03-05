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
    longitude VARCHAR(100) DEFAULT NULL,
    latitude VARCHAR(100) DEFAULT NULL,
    current_latitude VARCHAR(100) DEFAULT NULL,
    current_longitude VARCHAR(100) DEFAULT NULL, 
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
(1,	'Friend Request Sent',	'Friend Request Sent',	'friend-request-sent',	'2018-02-28 17:27:10.578674',	NULL),
(2,	'Friend request accepted',	'Friend request accepted',	'friend-request-accepted',	'2018-02-28 17:27:10.578674',	NULL),
(3,	'Friend block',	'Friend block',	'friend-block',	'2018-02-28 17:27:10.578674',	NULL),
(4,	'Friend Join spayc',	'Friend Join spayc',	'friend-join-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(5,	'user join spayc',	'user join spayc',	'user-join-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(6,	'friend subscribe spayc',	'friend subscribe spayc',	'friend-subscribe-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(7,	'user subscribe spayc',	'user subscribe spayc',	'user-subscribe-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(8,	'user like your comment',	'user like your comment',	'user-like-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(9,	'friend like your comment',	'friend like your comment',	'friend-like-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(10,	'user reply on your comment',	'user reply on your comment',	'user-reply-on-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(11,	'friend reply on your comment',	'friend reply on your comment',	'friend-reply-on-your-comment',	'2018-02-28 17:27:10.578674',	NULL),
(12,	'you beacome admin',	'you beacome admin',	'you-beacome-admin',	'2018-02-28 17:27:10.578674',	NULL),
(13,	'kick out from spayc',	'kick out from spayc',	'kick-out-from-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(14,	'spayc active',	'spayc active',	'spayc-active',	'2018-02-28 17:27:10.578674',	NULL),
(15,	'spayc inative',	'spayc inative',	'spayc-inative',	'2018-02-28 17:27:10.578674',	NULL),
(16,	'delete spayc',	'delete spayc',	'delete-spayc',	'2018-02-28 17:27:10.578674',	NULL),
(17,	'Any new space created in 25miles',	'Any new space created in 25miles',	'any-new-space-created-in-25miles',	'2018-02-28 17:27:10.578674',	NULL);


ALTER TABLE "joined_spayc" ADD "updated_by" bigint NULL;
