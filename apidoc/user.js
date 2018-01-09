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
*   "errors:{Validation errors}"
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
 * @api {Put} /profile-edit.json Update an user
 * @apiVersion 0.1.0
 * @apiName PutUser
 * @apiGroup User
 * @apiPermission Private User
 *
 * @apiDescription Update profile of existing user.
 * Update user own profile details with form-data option.
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
 *          "phone": "7876565434",
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
 *          "phone": "7876565434",
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
 * @api {post} /users.json Register a User
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
 * @apiParam {Date}   dob Date of birth must in in format YYYY-MM-DD (Optional).
 * @apiParam {String} gender Gender of user like any one (male,femal,other) (Required).
 * @apiParam {Number} phone Phone no of user and accept only 10 digits only (Optional).
 * @apiParam {String} device_id Device personal id (Required).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username": "spaycdev",
 *          "email": "spaycdev@spayc.com",
 *          "password": "XXXXXXXXX",
 *          "gender": "male|female|other",
 *          "phone": "7876565434",
 *          "dob": "2000-11-12",
 *          "device_id":"DATEOSDEVICEIP"
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
 *          "password": "XXXXXXXXX",
 *          "gender": "male|female|other",
 *          "phone": "7876565434",
 *          "dob": "2000-11-12",
 *          "device_id":"DATEOSDEVICEIP"
 *       }
 *   ]
 * }
 *
 * @apiUse UserErrorResponse
 */
function postUser() { return; }
/**
 * @api {get} /users.json View Details
 * @apiVersion 0.1.0
 * @apiName getUsers
 * @apiGroup User
 * @apiPermission Private User
 *
 * @apiDescription User login with user name and its password.
 * Need to send token in header
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Login done successfully.
 * @apiSuccess {Object} data List of user details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Profile details",
    "data": {
        "username": "dhiruns3",
        "email": "dhiru3@gmail.com",
        "gender": null,
        "phone": 8484839392,
        "dob": "2000-05-25",
        "status": "active",
        "website_url": null,
        "address": null,
        "bio_data": null,
        "created": "2018-01-09T11:00:21+00:00",
        "modified": "2018-01-09T11:00:21+00:00"
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }
/**
 * @api {post} /login.json Login
 * @apiVersion 0.1.0
 * @apiName PostLogin
 * @apiGroup User
 * @apiPermission Private User
 *
 * @apiDescription User login with user name and its password.
 * User get logged in by using username and password including device_id.content-type must be in text/html(form-data)
 *
 * @apiParam {String} username Username must be unique and size between 3-30 charecters (Required).
 * @apiParam {String} password secret password (Required).
 * @apiParam {String} device_id Device personal id (Required).
 *
 * @apiExample Example usage:
 *
 *       {
 *          "username": "spaycdev",
 *          "password": "XXXXXXXXX",
 *          "device_id":"DATEOSDEVICEIP"
 *       }
 *
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Login done successfully.
 * @apiSuccess {Object} data List of user details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
 * {
 *   "status": "success",
 *   "message": "Login done successfully.",
 *       "data": {
 *       "id": 2,
 *       "first_name": null,
 *       "last_name": null,
 *        "username": "skumar1",
 *        "email": "subhash.kumar@kiwitech.com",
 *        "password": "$2y$10$ifWTI646naw6MlKiYKfgHOWyktbYyiedGE65GUqzUJOZkFStqs/8q",
 *        "gender": "male",
 *        "dob": "2017-02-02T00:00:00+00:00",
 *        "phone": null,
 *        "status": "active",
 *        "website_url": null,
 *        "address": null,
 *        "bio_data": null,
 *        "timezone": null,
 *        "token_verification": "fb2aa2326d1d591e4fa9b1e18c9d064a1a5cda5a",
 *        "created": "2018-01-07T18:10:23+00:00",
 *        "modified": "2018-01-07T18:10:23+00:00",
 *        "matrix_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyYWNpZCB1c2VyX2lkID0gQHNrdW1hcjE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSBzRU5DbFBha1M5ODZBcmU3CjAwMmZzaWduYXR1cmUgSEoBVpO2GifQmZV6_miQMI1SmrEAin2GSQ_CO39AOKwK",
 *        "access_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyYWNpZCB1c2VyX2lkID0gQHNrdW1hcjE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSBzRU5DbFBha1M5ODZBcmU3CjAwMmZzaWduYXR1cmUgSEoBVpO2GifQmZV6_miQMI1SmrEAin2GSQ_CO39AOKwK", * * *
 *        "home_server": "35.168.119.247",
 *        "user_id": "@skumar1:35.168.119.247",
 *        "device_id": "XJHZZQIWEV"
 *    }
 *   ]
 * }
 *
 * @apiError {String} Invalid login credentials..
 * @apiUse UserErrorResponse
 */
function postLogin() { return; }
