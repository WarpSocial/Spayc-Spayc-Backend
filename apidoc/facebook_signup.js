/**
* @api {post} /facebook-signup.json Facebook Sign-up
* @apiVersion 0.0.1
* @apiName facebookSignup
* @apiGroup User
* @apiPermission None
*
* @apiDescription User singup by facebook.
* 
* @apiParam {String} fb_id              * User facebook unique id required in body(Required).
* @apiParam {String} username           * Username optional in body(Required).
* @apiParam {String} email              * User email required in body(Required).
* @apiParam {String} dob                * Date of birth optional in body MM-DD-YYYY (Optional).
* @apiParam {Number} phone              * Phone no of user and accept upto 16 digits (Optional).
* @apiParam {String} gender             * Gender of user like any one (male,femal,other) (Required).
* @apiParam {String} device_id          * Device id is required in body (Required).
* @apiParam {Number} latitude           * Latitude of user address (Required).
* @apiParam {Number} longitude          * Longitude of user address (Required).

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
*    "device_id":"xxxxxxxxxxxxxxxxxx",
*    "latitude": "28.535516",
 *   "longitude": "77.391026"
*}
*
*
* 
* @apiSuccessExample {json} Success-Response: 
*        HTTP/1.1 201 OK
{
    "status": "success",
    "message": "Saved successfully.",
    "data": {
        "username": "spayc",
        "email": "spayc@gmail.com",
        "gender": "Male",
        "dob": "11-12-2000",
        "phone": null,
        "website_url": null,
        "address": null,
        "bio_data": null,
        "device_id": "xxxxxxxxxxxxxxxxxx",
        "matrix_user_id": "@sbsharma11:35.168.119.247",
        "token": "130d5b5d52f8b283a2705d5aa45ebd15f378a0763f6b369832c2dbe338e2369b",
        "matrix_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyZGNpZCB1c2VyX2lkID0gQHNic2hhcm1hMTE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAzZ2sxO1lJaDpfKzcuIzA4CjAwMmZzaWduYXR1cmUg_yk9Mt0_mur_yf6ZZT6sE7ybmtiMEID2xiDSqwQzLW
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
"message": "Method not allowed."
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
