/**
* @api {post} /users/login User login
* @apiVersion 0.0.1
* @apiName login
* @apiGroup Authentication
* @apiPermission None
*
* @apiDescription Signin user with Spayc to authenticate.
* 
* @apiParam {String} user_name       * Username registered username|email requried in body
* @apiParam {String} password        * Password is required in body.
* @apiParam {String} device_id       * Device id is required in body.

*
*
* @apiSuccess {Boolean} status true.
* @apiSuccess {String} message The request is OK.
* @apiSuccess {Object} data Provider Object contain details about provider.
*
* @apiExample Example usage:
*
*{
*   "username": "username|email",
*   "password" : "YourP@ssword",
*   "device_id":"DFS455HER45555af55af"
*}
*
*
*
* @apiSuccessExample {json} Success-Response: 
*        HTTP/1.1 success
*        {
*
* 		"status": true,
* 		"message": "The request is OK",
* 		"data": {
*   			"id": 3,
*   			"title": "Mr.",
                        "fb_id": "45545454545",
                        "user_name": "dhiru.php",
                        "first_name": "dhiru",
                        "last_name": "singh2",
                        "email": "dhiru12.php@gmail.com",
                        "password": "Dhiru@123",
                        "dob": "2000-11-12",
                        "device_id":"DFS455HER45555af55af"
*   			"created": "2016-09-01T11:01:05+00:00",
*   			"modified": null,
*   			"token": "a13d7666-dc6d-47b7-a3ed-9823f8f3be1b"
*		}
*        }
*
*
*
* @apiError {Object} Error-Response Returns a json Object.
* @apiError (Error-Response Object){Boolean} status Status.
* @apiError (Error-Response Object){String} message Message.
* @apiErrorExample Sample Error-Response:

*   
*  {
"status": false,
"message": "Method not allowed on resource."
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


