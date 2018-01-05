/**
* @api {post} /users/edit/:id.json Update user details
* @apiVersion 0.0.1
* @apiName userEdit
* @apiGroup Authentication
* @apiPermission None
*
* @apiDescription Update user details.
* 
* @apiParam {String} title           * User title (Mr.|Mrs.) required in body.
* @apiParam {String} user_name       * Username required in body.
* @apiParam {String} first_name      * User first name required in body.
* @apiParam {String} last_name       * User last name required in body.
* @apiParam {String} email           * User email required in body.
* @apiParam {String} password        * Password is optional in body.
* @apiParam {String} dob             * Date of birth optional in body.
* @apiParam {String} device_id       * Device id is required in body.
* @apiParam {File} images          * Multiple images upload from users.

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
*    "device_id":"DFS455HER45555af55af",
*    "images":"Multiple File Obj"
*}
*
*
* 
* @apiSuccessExample {json} Success-Response: 
*        HTTP/1.1 success
{
    "status": "success",
    "message": "Updated successfully.",
    "data": {
        "title": "Mr.",
        "fb_id": "45545454545",
        "user_name": "dhiru.php",
        "first_name": "dhiru",
        "last_name": "singh2",
        "email": "dhiru12.php@gmail.com",
        "password": "Dhiru@123",
        "dob": "2000-11-12",
        "device_id":"DFS455HER45555af55af",
        "images": [
            {
                "tmp_name": "/tmp/phpDch9hZ",
                "error": 0,
                "name": "Screenshot from 2017-04-10 17:04:21.png",
                "type": "image/png",
                "size": 172875
            },
            {
                "tmp_name": "/tmp/phpPDCzkV",
                "error": 0,
                "name": "Screenshot from 2017-02-28 21:07:31.png",
                "type": "image/png",
                "size": 274141
            },
            {
                "tmp_name": "/tmp/phpnaHfnR",
                "error": 0,
                "name": "Screenshot from 2016-12-29 17:10:31.png",
                "type": "image/png",
                "size": 166057
            },
            {
                "tmp_name": "/tmp/phpPbk5pN",
                "error": 0,
                "name": "Screenshot from 2016-10-25 17:11:16.png",
                "type": "image/png",
                "size": 231172
            }
        ]
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
    "password:Password must be between 4-8 charecters length."
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