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
 * @apiParam {Date}   dob          Date of birth must in this format YYYY-MM-DD (Optional).
 * @apiParam {String} gender       Gender of user like any one (male,femal,other) (Required).
 * @apiParam {Number} phone        Phone no of user and accept upto 16 digits (Optional).
 * @apiParam {String} address      User address (Optional).
 * @apiParam {String} website_url  Website url (Optional).
 * @apiParam {String} bio_data     Bio data of user (Optional).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username":"spayc",
 *          "dob": "2000-11-12",
 *          "gender": "male|female|other",
 *          "phone": "XXXXXXXXXX",
 *          "address": "b-3 noida",
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
 *          "dob": "2000-11-12",
 *          "gender": "male|female|other",
 *          "phone": "XXXXXXXXXX",
 *          "address": "b-3 noida",
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
 * @apiParam {Date}   dob Date of birth must in in format YYYY-MM-DD (Optional).
 * @apiParam {String} gender Gender of user like any one (male,femal,other) (Required).
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
 *          "gender": "male|female|other",
 *          "phone": "7876565434",
 *          "dob": "11-12-2000",
 *          "latitude": "28.535516",
 *          "longitude": "77.391026"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Registration done successfully.
 * @apiSuccess {Object} data List of user details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
 * {
 *   "status": "success",
 *   "message": "Saved successfully.",
 *   "data": [
 *       {
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "gender": "male|female|other",
 *          "phone": "7876565434",
 *          "dob": "11-12-2000",
 *          "latitude": "28.535516",
 *          "longitude": "77.391026"
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
            "count": 6,
            "records": [
                {
                    "id": 8,
                    "name": "sbsharma1123",
                    "email": "sbsharma131@gmail.com",
                    "gender": "male",
                    "phone": null,
                    "dob": "11-12-2001",
                    "status": "Active",
                    "website_url": null,
                    "address": null,
                    "bio_data": null,
                    "created": "2018-01-18T05:56:46+00:00",
                    "modified": "2018-01-18T05:57:01+00:00",
                    "user_images": [
                        {
                            "user_id": 8,
                            "image_url": "image1.png"
                        },
                        {
                            "user_id": 8,
                            "image_url": "image2.jpg"
                        }
                    ],
                    "friend": {
                        "id": 1,
                        "requested_by": 7,
                        "requested_to": 8,
                        "requested_status": "Approved",
                        "friend_status": "Friend"
                    }
                },
                {
                    "id": 9,
                    "name": "sbsharma11243",
                    "email": "sbsharma1231@gmail.com",
                    "gender": "male",
                    "phone": null,
                    "dob": "11-12-2001",
                    "status": "Active",
                    "website_url": null,
                    "address": null,
                    "bio_data": null,
                    "created": "2018-01-18T05:59:37+00:00",
                    "modified": "2018-01-18T05:59:37+00:00",
                    "user_images": [
                        {
                            "user_id": 9,
                            "image_url": "image3.png"
                        }
                    ],
                    "friend": {
                        "id": 1,
                        "requested_by": 9,
                        "requested_to": 8,
                        "requested_status": "Approved",
                        "friend_status": "Friend"
                    }
                }
            ]
        },
        "spaycs": {
            "count": 2,
            "records": [
                {
                    "distance": "3700.66047272806",
                    "id": 2,
                    "user_id": 7,
                    "name": "spaycdev13",
                    "address": "Noida sec 16",
                    "start_date": "2019-01-11T01:02:20+00:00",
                    "end_date": "2019-01-12T01:02:20+00:00",
                    "image": "",
                    "type": "Event",
                    "group_type": "Public",
                    "status": "Active",
                    "latitude": 77.209021,
                    "longitude": 28.613939,
                    "created": "2018-01-17T15:14:50+00:00",
                    "modified": "2018-01-17T15:14:50+00:00"
                },
                {
                    "distance": "4402.89875657017",
                    "id": 1,
                    "user_id": 7,
                    "name": "spaycdev9",
                    "address": "Noida sec 15",
                    "start_date": "2019-01-11T01:02:20+00:00",
                    "end_date": "2019-01-12T01:02:20+00:00",
                    "image": "",
                    "type": "Event",
                    "group_type": "Public",
                    "status": "Active",
                    "latitude": 20.895996,
                    "longitude": 6.772989,
                    "created": "2018-01-17T14:37:02+00:00",
                    "modified": "2018-01-17T14:37:02+00:00"
                }
            ]
        },
        "hashtags": {
            "count": 2,
            "records": [
                {
                    "id": 1,
                    "name": "hash tag1",
                    "created": "2018-01-19T13:58:21+00:00",
                    "modified": "2018-01-19T13:58:21+00:00",
                    "total_space": 2
                },
                {
                    "id": 2,
                    "name": "hash tag2",
                    "created": "2018-01-19T13:58:54+00:00",
                    "modified": "2018-01-19T13:58:54+00:00",
                    "total_space": 0
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
        "username": "skumar2 aa dds",
        "email": "subhash.kumadr2aadds@kiwitech.com",
        "gender": "male",
        "dob": "2000-02-02",
        "phone": "",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "VOYANVLOXG",
        "matrix_user_id": "@skumar2_aa_dds:127.0.0.1",
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
 
  @apiParam {Number} friend_id Friend id required (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"85"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully..
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend request send successfully.",
    "data": []
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
* @apiParam  {String}   friend_status   Status in query string must be any one from the following(Requested, Accepted, 'Declined').
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully..
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend lists.",
    "data": [
        {
            "id": 8,
            "name": "sbsharma1123",
            "user_images": [
                {
                    "user_id": 8,
                    "image_url": "image1.png"
                },
                {
                    "user_id": 8,
                    "image_url": "image2.jpg"
                }
            ],
            "friend": {
                "id": 3,
                "requested_by": 7,
                "requested_to": 8,
                "requested_status": "Accepted",
                "friend_status": null
            }
        }
    ]
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
 
* @apiParam  {Number}   id       Friend id required field in body.
* @apiParam  {String}   status   Status is required field and status must be in(Accepted,Declined,Blocked,Unfriend).
   @apiExample Example usage:
 
    {
        "id":"1",
        "status":"Accepted"
    }
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend status updated successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend status updated successfully.",
    "data": []
}
 
  @apiError {String} Status is required fields and status must be in(Accepted,Declined,Blocked,Unfriend)..
  @apiUse UserErrorResponse
*/
function setFriendStatus() { return; }
