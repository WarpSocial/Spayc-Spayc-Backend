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
 * @api {Put} /profile-edit.json Update User
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
 * @apiParam {String} device_id Device personal id (Required).
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
 *          "dob": "11-12-2000",
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
        "dob": "02-05-2000",
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
 {
    "status": "success",
    "message": "Login done successfully.",
    "data": {
        "username": "dhiruns1227841",
        "email": "dhiru12971341@gmail.com",
        "gender": "male",
        "dob": "2000-02-05",
        "phone": 8484839392,
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "skdf44838dkkd",
        "matrix_user_id": "@dhiruns_______:35.168.119.247",
        "token": "40faf755c8e278527aa1e7b7050bf97be3ca550c208bfa7382bbf910660c7c96"
    }
}
 *
 * @apiError {String} Invalid login credentials..
 * @apiUse UserErrorResponse
 */
function postLogin() { return; }
