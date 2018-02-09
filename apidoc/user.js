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
 * @apiParam {String} username     Username (Required).
 * @apiParam {Date}   dob          Date of birth must in this format MM-DD-YYYY (Optional).
 * @apiParam {String} gender       Gender of user like any one (Male, Femal, Other) (Required).
 * @apiParam {Number} phone        Phone no of user and accept upto 16 digits (Optional).
 * @apiParam {String} address      User address (Optional).
 * @apiParam {String} website_url  Website url (Optional).
 * @apiParam {String} bio_data     Bio data of user (Optional).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username":"spayc",
 *          "dob": "12-11-2001",
 *          "gender": "Male|Female|Other",
 *          "phone": "XXXXXXXXXX",
 *          "address": "spayc address",
 *          "website_url":"www.spayc.com",
 *          "bio_data":"your bio data",
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
 *          "phone": "XXXXXXXXXX",
 *          "address": "spayc address",
 *          "website_url":"www.spayc.com",
 *          "bio_data":"your bio data",
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
 * @apiParam {Number} phone Phone no of user and accept only 10 digits only (Optional).
 * @apiParam {Number} latitude of user address (Required).
 * @apiParam {Number} longitude of user address (Required).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "password": "XXXXXXXXX",
 *          "confirm_password": "XXXXXXXXX",
 *          "gender": "Male|Female|Other",
 *          "phone": "+91 (XXX) (XXXXXXX)",
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
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "gender": "male|female|other",
 *          "phone": "+91 (XXX) (XXXXXXX)",
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
 * @apiDescription Search users|spaycs|hashtags details.
 *
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
 * @apiParam {Number}      page     Page number in query string (Optional).
 * @apiParam {Number}      limit    Records limit in query string (Optional).
 * @apiParam {String}      type     Type should be in (users|spaycs|hashtags|all) (Optional).
 * @apiParam {String}      keyword  Username|Spayc name|Hashtag name in query string to be search (Optional).
 * @apiParam {Number}      latitude of spayc to be search (Required in case of spayc search).
 * @apiParam {Number}      longitude of spayc to be search (Required in case of spayc search).
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
            "count": 14,
            "records": [
                {
                    "id": "MzY3NzI3Njc1LjQ5",
                    "name": "spayc1",
                    "email": "spayc1@domain.com",
                    "gender": "Male",
                    "phone": "+91 (XXX) (XXXXXXX)",
                    "dob": "12-11-2000",
                    "status": "Active",
                    "website_url": "www.spayc.com",
                    "address": "spayc address",
                    "bio_data": "your bio data",
                    "matrix_user_id": "@test2:35.168.119.247",
                    "matrix_access_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg",
                    "created": "2018-01-17T14:09:52+00:00",
                    "modified": "2018-01-18T07:43:46+00:00",
                    "spaycs": [
                        {
                            "user_id": 7,
                            "created_spaycs": 2
                        }
                    ],
                    "joined_spayc": [
                        {
                            "user_id": 7,
                            "joined_spaycs": 2
                        }
                    ],
                    "user_images": [],
                    "friend": {
                        "total_friends": 2
                    }
                },
                {
                    "id": "NTI1MzI1MjUwLjc=",
                    "name": "spayc2",
                    "email": "spayc2@domain.com",
                    "gender": "Male",
                    "phone": "+91 (XXX) (XXXXXXX)",
                    "dob": "11-12-2000",
                    "status": "Active",
                    "website_url": "www.spayc.com",
                    "address": "your address",
                    "bio_data": "your bio data",
                    "matrix_user_id": "@test2:35.168.119.247",
                    "matrix_access_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg",
                    "created": "2018-01-24T13:46:10+00:00",
                    "modified": "2018-01-29T07:30:01+00:00",
                    "spaycs": [
                        {
                            "user_id": 10,
                            "created_spaycs": 32
                        }
                    ],
                    "joined_spayc": [],
                    "user_images": [],
                    "friend": {
                        "id": "NTI1MzI1MjUuMDc=",
                        "requested_by": 10,
                        "requested_to": 17,
                        "requested_status": "Accepted",
                        "friend_status": "Unfriend",
                        "total_friends": 7
                    }
                }
            ]
        },
        "spaycs": {
            "count": 10,
            "records": [
                {
                    "distance": "12.3020109427781",
                    "id": "MTczMzU3MzMyNy4zMQ==",
                    "user_id": 10,
                    "name": "spaycdev3",
                    "address": "Your address",
                    "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                    "start_date": "2019-01-11T01:02:20+00:00",
                    "end_date": "2019-01-12T01:02:20+00:00",
                    "image": "",
                    "type": "Community",
                    "group_type": "Public",
                    "status": "Active",
                    "latitude": 28.613939,
                    "longitude": 77.209021,
                    "created": "2018-01-25T11:49:48+00:00",
                    "modified": "2018-01-25T11:49:48+00:00"
                },
                {
                    "distance": "12.3020109427781",
                    "id": "MTY4MTA0MDgwMi4yNA==",
                    "user_id": 10,
                    "name": "spaycdev4",
                    "address": "Your address",
                    "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                    "start_date": "2019-01-11T01:02:20+00:00",
                    "end_date": "2019-01-12T01:02:20+00:00",
                    "image": "",
                    "type": "Community",
                    "group_type": "Public",
                    "status": "Active",
                    "latitude": 28.613939,
                    "longitude": 77.209021,
                    "created": "2018-01-25T11:40:10+00:00",
                    "modified": "2018-01-25T11:40:10+00:00"
                }
            ]
        },
        "hashtags": {
            "count": 9,
            "records": [
                {
                    "id": "MjA0ODc2ODQ3Ny43Mw==",
                    "name": "color",
                    "created": "2018-01-31T13:54:20+00:00",
                    "modified": "2018-01-31T13:54:20+00:00"
                },
                {
                    "id": "MjEwMTMwMTAwMi44",
                    "name": "festival",
                    "created": "2018-01-31T13:54:20+00:00",
                    "modified": "2018-01-31T13:54:20+00:00"
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
        "username": "spayc",
        "email": "spayc@domain.com",
        "gender": "Male",
        "dob": "2000-02-02",
        "phone": "",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "VOYANVLOXG",
        "matrix_user_id": "@spayc:127.0.0.1",
        "token": "7f39fa7c6642666c6802f0d4e2fddf6a695fc12458733764c64ad338d6d1ca5f",
        "matrix_token": "MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMmNjaWQgdXNlcl9pZCA9IEBza3VtYXIyX2FhX2RkczoxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSA4Ok00T3VzN1h5cnlKUEBxCjAwMmZzaWduYXR1cmUg5JCNFFzLQ4N-K6MnNWqFfqQdueyPiR74U_r6qLUzrqAK"
    }
}
 
  @apiError {String} Sign in credentials ain't right, try again buddy.
  @apiUse UserErrorResponse
*/
function postLogin() { return; }

/**
 @api {post} /friend-request.json Add Friend
  @apiVersion 0.1.0
  @apiName FriendRequest
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription Add Friend.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"NDIwMjYwMjAwLjU2"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully..
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
        HTTP/1.1 201 OK
{
    "status": "success",
    "message": "Friend request sent successfully."
}
 
  @apiError {String} Friend request already sent.
  @apiUse UserErrorResponse
*/
function postFriendRequest() { return; }

/**
 @api {get} /get-friends.json?page=:page&limit=:page&friend_status=:status Get Friends
  @apiVersion 0.1.0
  @apiName GetFriends
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription Get Friends.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
* @apiParam  {Number}   page            Page number in query string (Optional).
* @apiParam  {Number}   limit           Records limit in query string (Optional).
* @apiParam  {String}   friend_status   Status in query string must be any one from the following(Requested, Accepted, 'Declined',Blocked, Unfriend).
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend lists.",
    "data": {
        "count": 4,
        "records": [
            {
                "id": "VkR0a3p4anQ2SUxScm85RGhTZTFpZz09",
                "name": "test",
                "matrix_user_id": null,
                "matrix_access_token": null,
                "friend": {
                    "id": "bmRkeTJVYjhwTlQzKzdpeWJwWEMvZz09",
                    "requested_by": 10,
                    "requested_to": 7,
                    "requested_status": "Requested",
                    "friend_status": null
                },
                "image_url": ""
            },
            {
                "id": "OWxtVWpXalVkaVdWRHVTWUR5amxuZz09",
                "name": "test2",
                "matrix_user_id": null,
                "matrix_access_token": null,
                "friend": {
                    "id": "NlJpUEx0M016dXBGTjhZdWpWeThBUT09",
                    "requested_by": 10,
                    "requested_to": 8,
                    "requested_status": "Requested",
                    "friend_status": null
                },
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_08_14_18_14_10_20180206133936.png"
            }
        ]
    }
}
 

  @apiUse UserErrorResponse
*/
function getFriends() { return; }

/**
 @api {put} /friend-response.json Set Friend Status
  @apiVersion 0.1.0
  @apiName setFriendStatus
  @apiGroup User
  @apiPermission Private User
 
  @apiDescription Set Friend Status.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
* @apiParam  {String}   id       Friend id required field in body.
* @apiParam  {String}   status   Status is required field and status must be in(Accepted,Declined,Blocked, Unblock, Unfriend).
   @apiExample Example usage:
 
    {
        "id":"NDIwMjYwMjAwLjU2",
        "status":"Accepted"
    }
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend status updated successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend status updated successfully."
}
 
  @apiError {String} Status is required fields and status must be in(Accepted,Declined,Blocked,Unfriend)..
  @apiUse UserErrorResponse
*/
function setFriendStatus() { return; }

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
  * @apiParam {String} userId User id required field in query string.
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User profile.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "User profile.",
    "data": {
        "id": "anM1a0FkWGlWUXBwR1ZDUU9iR09XQT09",
        "username": "test2",
        "email": "test2@gmail.com",
        "gender": "Male",
        "dob": "01-25-1996",
        "phone": "(789)877878",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "longitude": 77.391026,
        "latitude": 28.535516,
        "matrix_user_id": "@test2:35.168.119.247",
        "user_images": [
            {
                "user_id": 19,
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_12_26_15_18_47_20180206133935.png"
            }
        ],
        "friend": {
            "id": "MzNNbkN6V05zQ2c1N0ViMVJJeEVqZz09",
            "requested_by": 10,
            "requested_to": 19,
            "requested_status": "Requested",
            "friend_status": null
        }
    }
}

  @apiUse UserErrorResponse
*/
function getUserProfile() { return; }
