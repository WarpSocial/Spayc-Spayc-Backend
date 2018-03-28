/**
* @apiDefine UserErrorResponse
*
* @apiError {Object} Error-Response Returns a json Object.
* @apiError (Error-Response Object){Boolean} status failed.
* @apiError (Error-Response Object){String} message Message.
* @apiErrorExample Sample Error-Response:
*   
* {
*   "status": failed,
*   "message:"Method not allowed."
* }
* {
*    "status": failed,
*    "message": "Resource not found."
* }
* {
*    "status": failed,
*    "message": "Requested Parameter is not correct"
* }
*/

/**
 * @api {Put} /profile-edit.json Update User
 * @apiVersion 0.1.0
 * @apiName PutUser
 * @apiGroup User
 * @apiPermission Private User
 *
 * @apiDescription Update profile of existing user.
 * Update user own profile details with form-data option.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 *
 * @apiParam {String}  username     Username (Required).
 * @apiParam {Date}    dob          Date of birth must in this format MM-DD-YYYY (Optional).
 * @apiParam {String}  gender       Gender of user like any one (Male, Femal, Other) (Required).
 * @apiParam {String}  country_code Country code of user phone number(Optional).
 * @apiParam {Number}  phone        Phone no of user and accept upto 16 digits (Optional).
 * @apiParam {String}  address      User address (Optional).
 * @apiParam {String}  website_url  Website url (Optional).
 * @apiParam {String}  bio_data     Bio data of user (Optional).
 * @apiParam {String}  latitude   * Latitude of user address (Optional).
 * @apiParam {String}  longitude  * Longitude of user address (Optional).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username":"spayc",
 *          "dob": "12-11-2001",
 *          "gender": "Male|Female|Other",
 *          "country_code":"+91",
 *          "phone": "XXXXXXXXXX",
 *          "address": "spayc address",
 *          "website_url":"www.spayc.com",
 *          "bio_data":"your bio data",
 *          "latitude":"XX.00",
 *          "longitude":"XX.00",
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Updated successfully.
 * @apiSuccess {Object} data List of user details.
 * 
 * @apiSuccessExample {json} Success-Response: 
 *     HTTP/1.1 200 OK
 * {
 *   "status": "success",
 *   "message": "Saved successfully.",
 *   "data": [
 *       {
 *          "username":"spayc",
 *          "dob": "12-11-2001",
 *          "gender": "Male|Female|Other",
 *          "country_code":"+91",
 *          "phone": "XXXXXXXXXX",
 *          "address": "spayc address",
 *          "website_url":"www.spayc.com",
 *          "bio_data":"your bio data",
 *          "longitude": "XX.00",
 *          "latitude": "XX.00"
 *       }
 *   ]
 * }
 *
 * @apiUse UserErrorResponse
 */
function putUser() { return; }
/**
 * @api {post} /users.json Register User
 * @apiVersion 0.1.0
 * @apiName PostUser
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Create a new account.
 * Register new user with form-data option.
 *
 * @apiParam {String} username Username must be unique and size between 3-30 charecters (Required).
 * @apiParam {String} email Email of user must be unique (Required).
 * @apiParam {String} password secret password (Required).
 * @apiParam {String} confirm_password secret password (Required).
 * @apiParam {Date}   dob Date of birth must in in format MM-DD-YYYY (Optional).
 * @apiParam {String} gender Gender of user like any one (Male, Femal, Other) (Required).
 * @apiParam {String} country_code Country code of user phone number(Optional).
 * @apiParam {Number} phone Phone no of user and accept only 10 digits only (Optional).
 * @apiParam {String} latitude  * latitude of user address (Optional).
 * @apiParam {String} longitude * longitude of user address (Optional).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "password": "XXXXXXXXX",
 *          "confirm_password": "XXXXXXXXX",
 *          "gender": "Male|Female|Other",
 *          "country_code":"+91",
 *          "phone": "(XXX) (XXXXXXX)",
 *          "dob": "11-12-2000",
 *          "latitude": "XX.XXXXXX",
 *          "longitude": "XX.XXXXXX"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Registration done successfully.
 * @apiSuccess {Object} data List of user details.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 201 OK
 * {
 *   "status": "success",
 *   "message": "Saved successfully.",
 *   "data": [
 *       {
 *          "id": "35",
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "gender": "male|female|other",
 *          "country_code":"+91",
 *          "phone": "(XXX) (XXXXXXX)",
 *          "dob": "11-12-2000",
 *          "latitude": "XX.XXXXXX",
 *          "longitude": "XX.XXXXXX"
 *       }
 *   ]
 * }
 *
 * @apiUse UserErrorResponse
 */
function postUser() { return; }
/**
 * @api {get} /users.json?page=:page&limit=:limit&keyword=:keyword&latitude=:latitude&longitude=:longitude Search Users, Spaycs, Hashtags
 * @apiVersion 0.1.0
 * @apiName getUsers
 * @apiGroup User
 * @apiPermission Private User
 *
 * @apiDescription Search users|spaycs|hashtags details by requesting parameters Note: distance key not came in spayc list in case of no latitude and longitude.
 *
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
 * @apiParam {Number}      page       * Page number in query string (Optional).
 * @apiParam {Number}      limit      * Records limit in query string (Optional).
 * @apiParam {String}      type       * Type should be in (users|spaycs|hashtags|all) (Optional).
 * @apiParam {String}      keyword    * Username|Spayc name|Hashtag name in query string to be search (Optional).
 * @apiParam {String}      latitude   * Latitude of user address (Optional).
 * @apiParam {String}      longitude  * Longitude of user address (Optional).
 * 
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Search Lists.
 * @apiSuccess {Object} data List of users|spaycs|hashtags details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Search Lists.",
    "data": {
        "users": {
            "count": 26,
            "records": [
                {
                    "id": "5",
                    "username": "user1",
                    "email": "user1@domain.com",
                    "matrix_user_id": null,
                    "friend": {
                        "id": "57",
                        "requested_by": "17",
                        "requested_to": "5",
                        "requested_status": "Pending",
                        "total_friends": 0
                    },
                    "matrix_room_id": "!asfLdzLnOdGRkdd4dPZWu:localhost",
                    "image_url": ""
                },
                {
                    "id": "7",
                    "username": "user2",
                    "email": "user2@domain.com",
                    "matrix_user_id": null,
                    "friend": {
                        "total_friends": 0
                    },
                    "matrix_room_id": null,
                    "image_url": ""
                }
            ]
        },
        "spaycs": {
            "count": 22,
            "records": [
                {
                    "distance": "15.5999136892407",
                    "id": "33",
                    "name": "spaycdev13",
                    "location": "Your address",
                    "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                    "start_date": "01-11-2019 01:02:00",
                    "end_date": "01-12-2019 01:02:00",
                    "image": "",
                    "type": "Community",
                    "group_type": "Public",
                    "passcode": "",
                    "subscribed_users": 1,
                    "joined_spayc_status": null,
                    "is_joined": false,
                    "joined_users": 0,
                    "is_subscribed": false
                },
                {
                    "distance": "15.5999136892407",
                    "id": "32",
                    "name": "spaycdev13",
                    "location": "Your address",
                    "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                    "start_date": "01-11-2019 01:02:00",
                    "end_date": "01-12-2019 01:02:00",
                    "image": "",
                    "type": "Community",
                    "group_type": "Public",
                    "passcode": "",
                    "subscribed_users": 2,
                    "joined_spayc_status": null,
                    "is_joined": false,
                    "joined_users": 1,
                    "is_subscribed": false
                }
            ]
        },
        "hashtags": {
            "count": 33,
            "records": [
                {
                    "id": "59",
                    "name": "color",
                    "total_space": 1
                },
                {
                    "id": "65",
                    "name": "drink",
                    "total_space": 1
                }
            ]
        }
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }
/**
 @api {post} /login.json Login
  @apiVersion 0.1.0
  @apiName PostLogin
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription User login with user name and its password.
  User get logged in by using username and password including device_id.content-type must be in form-data
 
  @apiParam {String} email Email Registered email id (Required).
  @apiParam {String} password secret password (Required).
  @apiParam {String} device_id Device personal id (Required).
 
  @apiExample Example usage:
 
        {
           "email": "spaycdev@spayc.com",
           "password": "XXXXXXXXX",
           "device_id":"DATEOSDEVICEIP"
        }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Login done successfully.
  @apiSuccess {Object} data List of user details.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Login done successfully.",
    "data": {
        "id": "NDhxaUsvbWtGUDN3MXJ4YXJmTC9pdz09",
        "username": "spayc",
        "email": "spayc@domain.com",
        "gender": "Male",
        "dob": "2000-02-02",
        "country_code":"",
        "phone": "",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "VOYANVLOXG",
        "matrix_user_id": "@spayc:127.0.0.1",
        "token": "7f39fa7c6642666c6802f0d4e2fddf6a695fc12458733764c64ad338d6d1ca5f",
        "matrix_token": "MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMmNjaWQgdXNlcl9pZCA9IEBza3VtYXIyX2FhX2RkczoxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSA4Ok00T3VzN1h5cnlKUEBxCjAwMmZzaWduYXR1cmUg5JCNFFzLQ4N-K6MnNWqFfqQdueyPiR74U_r6qLUzrqAK",
        "user_images": [
            {
                "id": "MVpZL0tlbEp1N0JiT2JnLzhkLzB5dz09",
                "user_id": 17,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2018_02_02_12_10_56_20180206133933.png",
                "is_profile": "No",
                "order_index": null
            },
            {
                "id": "eHFzRWc1VFljdzlzdnVqSkpZL3ZYZz09",
                "user_id": 17,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_08_14_18_14_10_20180206133936.png",
                "is_profile": "No",
                "order_index": null
            }
        ]
    }
}
 
  @apiError {String} Sign in credentials ain't right, try again buddy.
  @apiUse UserErrorResponse
*/
function postLogin() { return; }

/**
 @api {post} /logout.json Logout
  @apiVersion 0.1.0
  @apiName getLogout
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription User get logout.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Logout successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Logout successfully."
}

  @apiUse UserErrorResponse
*/
function getLogout() { return; }

/**
 * @api {post} /reverification.json Send Reverification Link
 * @apiVersion 0.1.0
 * @apiName Reverification
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Send reverification link.
 *
 * @apiParam {String} email User registered email required field.
 *
 * @apiExample Example usage:
 *
 *       {
 *          "email": "spaycdev@spayc.com"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Re-verification email sent successfully.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Re-verification email sent successfully."
}
 *
 * @apiUse UserErrorResponse
 */
function postReverification() { return; }

/**
 * @api {post} /forgot-password.json Forgot Password
 * @apiVersion 0.1.0
 * @apiName forgotPassword
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Reset password link to be send at requested email.
 *
 * @apiParam {String} email User registered email required field.
 *
 * @apiExample Example usage:
 *
 *       {
 *          "email": "spaycdev@spayc.com"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Reset password link send to your email address.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Reset password link send to your email address."
}
 *
 * @apiUse UserErrorResponse
 */
function postForgotPassword() { return; }

/**
 @api {get} /user-profile/:userId.json User Profile
  @apiVersion 0.1.0
  @apiName userProfile
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription Get user profile.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
  * @apiParam {String} userId use any one either userid or matrix user id as query string in url(required).
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User profile.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "User profile.",
    "data": {
        "id": "11",
        "username": "user",
        "email": "test@domain.com",
        "gender": "Female",
        "dob": null,
        "country_code": null,
        "phone": "",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "longitude": 77.391026,
        "latitude": 28.535516,
        "matrix_user_id": null,
        "user_images": [
            {
                "id": "55",
                "user_id": 11,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180223144430.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632",
                "is_profile": "No",
                "order_index": null
            },
            {
                "id": "56",
                "user_id": 11,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073256.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632",
                "is_profile": "No",
                "order_index": null
            },
            {
                "id": "57",
                "user_id": 11,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073525.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632",
                "is_profile": "No",
                "order_index": null
            },
            {
                "id": "58",
                "user_id": 11,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073548.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632",
                "is_profile": "No",
                "order_index": null
            }
        ],
        "friend": {
            "id": "41",
            "requested_by": "10",
            "requested_to": "11",
            "requested_status": "Requested",
            "total_friends": 0
        },
        "matrix_room_id": null,
        "created_spaycs": 0,
        "joined_spaycs": 0
    }
}

  @apiUse UserErrorResponse
*/
function getUserProfile() { return; }

/**
 * @api {post} /change-password.json Change Password
 * @apiVersion 0.1.0
 * @apiName changePassword
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Change password request.
 *
 * @apiParam {String} old_password      User old password (Required).
 * @apiParam {String} new_password      User new password (Required).
 * @apiParam {String} confirm_password  Confirm new password (Required).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "old_password": "password@123",
 *          "new_password": "newPassword@123",
 *          "confirm_password": "newPassword@123"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Password changed successfully.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Password changed successfully."
}
 *
 * @apiUse UserErrorResponse
 */
function postChangePassword() { return; }

/**
 * @api {post} /avatars.json Upload Profile Images
 * @apiVersion 0.1.0
 * @apiName imageUpload
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Upload up to 5 image for profile.
 *
 * @apiParam {String} images      Images contain up to 5 image object required(index key should be order_index of image if already saved).
 *
 * @apiExample Example usage:
 *
{
    "images":{
        "1":{
            "tmp_name":"\/tmp\/phpj212j5",
            "error":0,
            "name":"Screenshot from 2017-12-26 15:18:47.png",
            "type":"image\/png",
            "size":154882
        },
        "2":{
            "tmp_name":"\/tmp\/php0yUWwr",
            "error":0,
            "name":"Screenshot from 2017-08-14 18:14:15.png",
            "type":"image\/png",
            "size":590333
        },
        "3":{
            "tmp_name":"\/tmp\/phpluwiKN",
            "error":0,
            "name":"Screenshot from 2017-04-10 17:04:21.png",
            "type":"image\/png",
            "size":172875
        },
        "4":{
            "tmp_name":"\/tmp\/phpiTiNX9",
            "error":0,
            "name":"Screenshot from 2016-07-21 17:30:37.png",
            "type":"image\/png",
            "size":212200
        },
        "5":{
            "tmp_name":"\/tmp\/phpv0ssbw",
            "error":0,
            "name":"Screenshot from 2016-06-15 18:56:02.png",
            "type":"image\/png",
            "size":211765
        }
    }
}
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Profile image uploaded successfully.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Profile image uploaded successfully."
}
 *
 * @apiUse UserErrorResponse
 */
function postProfileImage() { return; }

/**
 * @api {put} /set-profile-image/:order.json Set Profile Images
 * @apiVersion 0.1.0
 * @apiName setProfileImage
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription Set image as default profile pic.
 *
 * @apiParam {String} order      Image order index in query string required.
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Profile Profile image set as default.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Profile image set as default."
}
 *
 * @apiUse UserErrorResponse
 */
function putSetProfileImage() { return; }

/**
 * @api {get} /remove-avatar/:order.json Remove Profile Image
 * @apiVersion 0.1.0
 * @apiName removeAvatar
 * @apiGroup User
 * @apiPermission Logged in user
 *
 * @apiDescription Remove profile image. Token must be set in header.if image is default profile image then it will also remove from matrix.
 *
 * @apiParam {String} order      Image order index in query string required.
 *
 * @apiExample Example usage:
 *
    {
        "status": "success",
        "message": "Profile image has been removed."
    }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Profile image has been removed.

 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Profile image set as default."
}
 *
 * @apiUse UserErrorResponse
 */

function getRemoveAvatar() { return; }
/**
 * @api {get} /facebook-friends.json?page=:page&limit=:limit Get facebook friends
 * @apiVersion 0.1.0
 * @apiName FacebookFriends
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription get facebook friend for suggetion.
 *
 * @apiParam {Number} page      Page number is optional in query string default value 1.
 * @apiParam {Number} limit     Limit is optional in query string default value 5.
 *
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Facebook friend lists.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
 "message": "Facebook friend lists.",
 "data": {
        "count": 2,
        "records": [
            {
                "id": "7",
                "username": "user1",
                "image_url": ""
            },
            {
                "id": "11",
                "username": "user2",
                "image_url": ""
            }
        ]
    }
 *
 * @apiUse UserErrorResponse
 */
 function getFacebookFriends() { return; }
 /**
 * @api {post} /update-user-status.json Update User Physical Presence
 * @apiVersion 0.1.0
 * @apiName PostUpdateUserStatus
 * @apiGroup User
 * @apiPermission required
 *
 * @apiDescription Update physical presence of user.
 * 
 * @apiHeader {String} token Token must be set in header.
 *
 * @apiParam {String} latitude  Current user location latitude.(Required).
 * @apiParam {String} longitude Current user location longitude.(Required).
 *
 * @apiExample Example usage:
    {
        "latitude":"45.25895656565656",
        "longitude":"25.265656565656"
    }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Request has been updated successfully.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
    {
        "status": "success",
        "message": "Request has been updated successfully."
    }
 *
 * @apiUse UserErrorResponse
 */
function postUpdateUserStatus() { return; }

/**
 * @api {get} /get-notifications.json?page=:page&limit=:limit Get Notifications
 * @apiVersion 0.1.0
 * @apiName getNotifications
 * @apiGroup User
 * @apiPermission none
 *
 * @apiDescription get all notifications received by loggin user.
 *
 * @apiParam {Number} page      Page number is optional in query string default value 1.
 * @apiParam {Number} limit     Limit is optional in query string default value 5.
 *
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Notification Lists..
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Notification Lists.",
    "data": {
        "count": 3,
        "notification": [
            {
                "id": "3",
                "date_time": "03-01-2018 18:44:52",
                "message": "Friend Request Sent",
                "notification_type": "Friend Request Sent",
                "space_name": null,
                "room_id": null,
                "spayc_image": null,
                "username": "dhir",
                "user_id": "10",
                "user_image": "https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2018_02_02_12_10_56_20180207100523_20180301064300.png",
                "is_unread": true
            },
            {
                "id": "1",
                "date_time": "02-28-2018 20:51:41",
                "message": "you are added a friend",
                "notification_type": "request accepted",
                "space_name": "spaycdev9",
                "room_id": "@matrixdeeee",
                "spayc_image": "abc.png",
                "username": "sbsharma11243",
                "user_id": "9",
                "user_image": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226075827.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632",
                "is_unread": true
            }
        ]
    }
}
 *
 * @apiUse UserErrorResponse
 */
 function getNotification() { return; }
 
 /**
 * @api {post} /update-device-token.json Update device token
 * @apiVersion 0.1.0
 * @apiName updateDeviceToken
 * @apiGroup User
 * @apiPermission required
 *
 * @apiDescription Update user device token if push notification turn on and off.
 * 
 * @apiHeader {String} token Token must be set in header.
 *
 * @apiParam {String} device_token  Device token required field if is_notify is On
 * @apiParam {String} is_notify     Is notify is required field possible values(On, Off)
 *
 * @apiExample Example usage:
    {
        "device_token":"666dc243b1ee08bb68cebe64d0875d9f54bab2be090d456a90e0dac608c12ecf",
        "is_notify":"On"
    }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Request has been updated successfully.
 * @apiSuccessExample {json} Success-Response:
 *      HTTP/1.1 200 OK
    {
        "status": "success",
        "message": "Device token updated successfully."
    }
 *
 * @apiUse UserErrorResponse
 */
function postUpdateUserStatus() { return; }