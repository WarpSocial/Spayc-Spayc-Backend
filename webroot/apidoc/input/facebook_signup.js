/**
* @api {post} /users/facebookSignup User signup by facebook
* @apiVersion 0.0.1
* @apiName facebookSignup
* @apiGroup Authentication
* @apiPermission None
*
* @apiDescription User singup by facebook.
* 
* @apiParam {String} title           * User title (Mr.|Mrs) required in body.
* @apiParam {String} fb_id           * User facebook unique id required in body.
* @apiParam {String} user_name       * Username optional in body.
* @apiParam {String} first_name      * User first name required in body.
* @apiParam {String} last_name       * User last name required in body.
* @apiParam {String} email           * User email required in body.
* @apiParam {String} password        * Password is optional in body.
* @apiParam {String} dob             * Date of birth optional in body.
* @apiParam {String} device_id       * Device id is required in body.

*
*
* @apiSuccess {Boolean} status true.
* @apiSuccess {String} message The request is OK.
* @apiSuccess {Object} data Consumer Object contain details about user.
*
* @apiExample Example usage:
*
*{
*    "title":"Mr.",
*    "fb_id":"8552254552",
*    "user_name":"dhiru.php",
*    "first_name":"dhiru",
*    "last_name":"singh",
*    "email":"dhiru.php@gmail.com",
*    "password":"Dhiru@123",
*    "dob":"2000-11-12",
*    "device_id":"DFS455HER45555af55af"
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
            "title": "Mr.",
            "fb_id": "45545454545",
            "user_name": "dhiru.php",
            "first_name": "dhiru",
            "last_name": "singh2",
            "email": "dhiru12.php@gmail.com",
            "password": "Dhiru@123",
            "dob": "2000-11-12",
            "device_id":"DFS455HER45555af55af"
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