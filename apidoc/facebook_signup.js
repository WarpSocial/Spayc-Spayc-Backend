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
    "data": [
        "ones",
        {
            "fb_id": "xxxxxxxxxxxx",
            "username": "spayc",
            "email": "spayc@gmail.com",
            "dob": "12-11-2001",
            "device_id":"xxxxxxxxxxxxxxxxxx"
        }
    ]
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
