CREATE TYPE row_status AS ENUM('Active','Inactive','Pending','Approved');
CREATE TABLE users (
    id BIGSERIAL NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
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
    longitude double precision,
    latitude double precision,
    current_latitude double precision DEFAULT NULL,
    current_longitude double precision  DEFAULT NULL,
    timezone VARCHAR(100),
    matrix_user_id VARCHAR(100),
    matrix_access_token VARCHAR(1000),
    token_verification VARCHAR(255) NULL,
    forgot_password_token VARCHAR(255) NULL,
    forgot_password_timestamp timestamp NULL,
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
    notification_type VARCHAR(20) DEFAULT NULL,
    status VARCHAR(20) DEFAULT NULL,
    message VARCHAR(200) DEFAULT NULL,
    created timestamp NOT NULL,
    modified timestamp,
    PRIMARY KEY (id,created)
);
SELECT create_hypertable('notifications', 'created');



