/**
* @api {post} /facebook-signup.json Facebook Sign-up
* @apiVersion 0.0.1
* @apiName facebookSignup
* @apiGroup User
* @apiPermission None
*
* @apiDescription User singup by facebook.
* 
* @apiParam {String} fb_id              * User facebook unique id required in body.
* @apiParam {String} username           * Username optional in body.
* @apiParam {String} email              * User email required in body.
* @apiParam {String} dob                * Date of birth optional in body.
* @apiParam {Number} phone              * Phone no of user and accept upto 16 digits (Optional).
* @apiParam {String} gender             * Gender of user like any one (male,femal,other) (Required).
* @apiParam {String} device_id          * Device id is required in body.

*
*
* @apiSuccess {Boolean} status true.
* @apiSuccess {String} message The request is OK.
* @apiSuccess {Object} data Consumer Object contain details about user.
*
* @apiExample Example usage:
*
*{
*    "fb_id":"xxxxxxxxxxxx",
*    "username":"spayc",
*    "email":"spayc@gmail.com",
*    "dob":"12-11-2001",
*    "gender":"male|female|other",
*    "phone": "XXXXXXXXXX",
*    "device_id":"xxxxxxxxxxxxxxxxxx"
*}
*
*
* 
* @apiSuccessExample {json} Success-Response: 
*        HTTP/1.1 success
{
    "status": "success",
    "message": "Saved successfully.",
    "data": {
        "username": "sbsharma",
        "email": "sbsharma@gmail.com",
        "gender": "male",
        "dob": "2001-12-11",
        "phone": null,
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "DFS455HER45555adf55af444",
        "matrix_user_id": "@sbsharma:35.168.119.247",
        "token": "3511fd4e28134e2c0cc44edf8609c576392a86494b4740783e55901662969d34"
    }
}
*
*
* @apiError {Object} Error-Response Returns a json Object.
* @apiError (Error-Response Object){Boolean} status Status.
* @apiError (Error-Response Object){String} message Message.
* @apiErrorExample Sample Error-Response:

*   
*  {
"status": false,
"errors": "fb_id:Facebook id is required field."
}
{
"status": false,
"message": "Resource not found."
}
{
"status": false,
"message": "Requested Parameter is not correct"
}
*/
