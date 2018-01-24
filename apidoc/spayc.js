/**
 @apiDefine errorResponse

 @apiError {Object} Error-Response Returns a json Object.
 @apiError (Error-Response Object){Boolean} status failed.
 @apiError (Error-Response Object){String} message Message.
 @apiErrorExample Sample Error-Response:
   
 {
   "status": failed,
   "message:"Method not allowed."
 }
 {
    "status": failed,
    "message": "Resource not found."
 }
 {
    "status": failed,
    "message": "Requested Parameter is not correct"
 }
*/

/**
@api {post} /spaycs.json New SPAYC
@apiVersion 0.1.0
@apiName PostSpayc
@apiGroup Spayc
@apiPermission private

@apiDescription Create a new SPAYC.

 * @apiHeader {String} TOKEN            * A token send by header as TOKEN

@apiParam {String} name name title of the spayc (Required).
@apiParam {String} location Location must be alphanumeric with space (Required).
@apiParam {String} type SPAYC type must be any one from the following Event|Community (Required).
@apiParam {String} group_type Group type must be any one from the following Public|Private (Required).
@apiParam {Datetime} start_date Start date with time in format YYYY-MM-DD H:i:s (Required).
@apiParam {Datetime} end_date End date with time in format YYYY-MM-DD H:i:s (Required).
@apiParam {String} passcode Passcode is required in case of private group type.
@apiParam {String} description Description for SPAYC (Optional).
@apiParam {String} image Image size must be less than 5MB with extentions png|jpg|jpeg (Optional).
@apiParam {String} longitude Langitude from google map (Required).
@apiParam {String} latitude Latitude from google map (Required).

@apiExample Example usage:
    {
        "name": "spaycdev",
        "location": "spaycdev@spayc.com",
        "type": "XXXXXXXXX",
        "group_type": "male|female|other",
        "start_date": "2019-01-11 01:02:20",
        "end_date": "2019-01-12 01:02:20",
        "passcode": "s5d4f87sdf4545",
        "description":"spayc creating",
        "image":"file.png",
        "longitude":"XX.00.XX",
        "latitude":"XX.00.XX"
    }
 
@apiSuccess {String} status success.
@apiSuccess {String} message Registration done successfully.
@apiSuccess {Object} data List of user details.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Your spayc, Dsfdsfdsf65esd x, has been created.",
    "data": {
        "name": "dsfdsfdsf65esd x",
        "location": "oaksd lfjlsdasdklfdjsfdfldas",
        "type": "Community",
        "group_type": "Public",
        "start_date": "2018-01-11T11:16:01+00:00",
        "end_date": "2018-01-12T09:23:01+00:00",
        "passcode": "",
        "description": "asdf dsfsd fdsfasdfadfadf",
        "image": "",
        "matrix_room_id": "!PFzyEQEwQZuLhKCmMW:127.0.0.1",
        "matrix_room_alias": "#dsfdsfdsf65esd-x:127.0.0.1",
        "user_id": 38,
        "created": "2018-01-11T09:31:50+00:00",
        "modified": "2018-01-11T09:31:50+00:00",
        "longitude":"XX.00.XX",
        "latitude":"XX.00.XX",
        "id": 1
    }
}

@apiUse errorResponse
 */
function postSpaycs() { return; }
/**
 * @api {get} /spaycs.json?page=:page&latitude=28.4594965&longitude=77.0266383 Spayc Lists
 * @apiVersion 0.1.0
 * @apiName getSpaycs
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Filter spayc list.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {Number}      page            Page number in query string (Required).
    @apiParam {Timestamp}   start_date      Spayc start date in query string(1515542400) (Optional).
    @apiParam {Timestamp}   end_date        Spayc end date in query string(1515715200) (Optional).
    @apiParam {String}      group_type      Group type must be any one from the following (Public|Private) (Optional).
    @apiParam {String}      type            Spayc type must be any one from the following (Event|Community) (Optional).
    @apiParam {String}      with_friends    Allow that spayc list with friends or not (Optional).
    @apiParam {String}      latitude        Latitude is required in query string(Required).
    @apiParam {String}      longitude       Longitude is required in query string(Required).
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Spayc lists.
 * @apiSuccess {Object} data List of spayc details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Spayc lists.",
    "data": {
        "count": 4,
        "spaycs": [
            {
                "distance": "22.7463734587819",
                "id": 1,
                "user_id": 51,
                "name": "Test",
                "address": "Noida sec 16",
                "start_date": "2018-01-10T06:00:00+00:00",
                "end_date": "2018-01-10T06:00:00+00:00",
                "image": "img.png",
                "type": "Event",
                "group_type": "Public",
                "status": "Active",
                "latitude": 28.535516,
                "longitude": 77.391026,
                "created": "2018-01-10T00:00:00+00:00",
                "modified": "2018-01-10T00:00:00+00:00",
                "comments": [
                    {
                        "spayc_id": 1,
                        "total_comment": 1
                    }
                ],
                "subscribed_users": [],
                "joined_spayc": []
            },
            {
                "distance": "22.7463734587819",
                "id": 2,
                "user_id": 51,
                "name": "Test1",
                "address": "Noida sec 15",
                "start_date": "2018-01-10T01:00:00+00:00",
                "end_date": "2018-01-11T11:00:00+00:00",
                "image": "img.png",
                "type": "Event",
                "group_type": "Public",
                "status": "Active",
                "latitude": 28.535516,
                "longitude": 77.391026,
                "created": "2018-01-10T00:00:00+00:00",
                "modified": "2018-01-10T00:00:00+00:00",
                "comments": [],
                "subscribed_users": [],
                "joined_spayc": []
            },
            {
                "distance": "22.7463734587819",
                "id": 3,
                "user_id": 51,
                "name": "Test12",
                "address": "Noida sec 18",
                "start_date": "2018-01-10T01:00:00+00:00",
                "end_date": "2018-01-11T11:00:00+00:00",
                "image": "img.png",
                "type": "Event",
                "group_type": "Private",
                "status": "Active",
                "latitude": 28.535516,
                "longitude": 77.391026,
                "created": "2018-01-10T00:00:00+00:00",
                "modified": "2018-01-10T00:00:00+00:00",
                "comments": [],
                "subscribed_users": [
                    {
                        "spayc_id": 3,
                        "subscribed_users": 1
                    }
                ],
                "joined_spayc": [
                    {
                        "spayc_id": 3,
                        "joined_users": 3,
                        "joined_friends": 2
                    }
                ]
            },
            {
                "distance": "22.7463734587819",
                "id": 4,
                "user_id": 51,
                "name": "Test123",
                "address": "Noida sec 16",
                "start_date": "2018-01-10T01:00:00+00:00",
                "end_date": "2018-01-11T11:00:00+00:00",
                "image": "img.png",
                "type": "Community",
                "group_type": "Public",
                "status": "Active",
                "latitude": 28.535516,
                "longitude": 77.391026,
                "created": "2018-01-10T00:00:00+00:00",
                "modified": "2018-01-10T00:00:00+00:00",
                "comments": [],
                "subscribed_users": [],
                "joined_spayc": []
            }
        ]
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }