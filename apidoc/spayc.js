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

@apiParam {String} name             Name title of the spayc (Required).
@apiParam {String} location         Location must be alphanumeric with space (Required).
@apiParam {String} type             SPAYC type must be any one from the following Event|Community (Required).
@apiParam {String} group_type       Group type must be any one from the following Public|Private (Required).
@apiParam {Datetime} start_date     Start date with time in format YYYY-MM-DD H:i:s (Required).
@apiParam {Datetime} end_date       End date with time in format YYYY-MM-DD H:i:s (Required).
@apiParam {String} passcode         Passcode is required in case of private group type.
@apiParam {String} description      Description for SPAYC (Optional).
@apiParam {String} image            Image size must be less than 5MB with extentions png|jpg|jpeg (Optional).
@apiParam {String} longitude        Langitude from google map (Required).
@apiParam {String} latitude         Latitude from google map (Required).
@apiParam {String} invite           Matrix user id is optional in query string(Optional).

@apiExample Example usage:
    {
        "name": "spaycdev",
        "location": "Community addrss",
        "type": "Event|Community",
        "group_type": "Public|Private",
        "start_date": "2019-01-11 01:02:20",
        "end_date": "2019-01-12 01:02:20",
        "passcode": "s5d4f87sdf4545",
        "description":"spayc creating",
        "image":"file.png",
        "longitude":"XX.00.XX",
        "latitude":"XX.00.XX",
        "invite":"@test2:35.168.119.247, @test3:35.168.119.247"
    }
 
@apiSuccess {String} status success.
@apiSuccess {String} message Your spayc, spaycdev, has been created.
@apiSuccess {Object} data Spayc details.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
{
    "status": "success",
    "message": "Your spayc, Festive, has been created.",
    "data": {
        "name": "Festive",
        "location": "Your address",
        "type": "Event",
        "group_type": "Public",
        "start_date": "2019-01-11T01:02:20+00:00",
        "end_date": "2019-01-11T01:08:20+00:00",
        "passcode": "",
        "description": "Holi is a festival of color #color #festival",
        "image": "",
        "longitude": 77.209021,
        "latitude": 28.613939,
        "invite": "@test2:35.168.119.247",
        "status": "Active",
        "matrix_room_id": "!JqhnnrWCtlFTnWlwWL:35.168.119.247",
        "matrix_room_alias": "#Holi13:35.168.119.247",
        "user_id": "10",
        "created": "2018-02-16T11:02:47+00:00",
        "modified": "2018-02-16T11:02:47+00:00",
        "id": "95"
    }
}

@apiUse errorResponse
 */
function postSpaycs() { return; }
/**
 * @api {get} /spaycs.json?page=:page&limit=5&latitude=28.4594965&longitude=77.0266383 Spayc Lists
 * @apiVersion 0.1.0
 * @apiName getSpaycs
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Filter spayc list.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {Number}      page            Page number in query string (Optional).
    @apiParam {Number}      limit           Limit in query string (Optional).
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
                "id": "NDQ2NTI2NDYzMC45NQ==",
                "user_id": 51,
                "name": "Test",
                "address": "Event address",
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
                "id": "NDQ2N5I2NDY43C45NQ==",
                "user_id": 51,
                "name": "Test1",
                "address": "Event address",
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
                "id": "NDQ2NTI2NDgfMC45NQ5g",
                "user_id": 51,
                "name": "Test12",
                "address": "Event address",
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
                "id": "NDsdaf2NDYzMC45NQFA",
                "user_id": 51,
                "name": "Test123",
                "address": "Community address",
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
function getSpaycs() { return; }

/**
 @api {post} /subscribe-spayc.json Subscribe Spayc
  @apiVersion 0.1.0
  @apiName subscribeSpayc
  @apiGroup Spayc
  @apiPermission Subscribe Spayc
 
  @apiDescription Subscribe Spayc.
  
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
  @apiParam {String} spayc_id Spayc id is required (Required).
 
  @apiExample Example usage:
 
    {
        "spayc_id":"NDIwMjYwMjAwLjU2"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User Subscribed successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response:
       HTTP/1.1 201 OK
{
    "status": "success",
    "message": "User Subscribed successfully."
}
 
  @apiError {String} User already subscribed.
  @apiUse UserErrorResponse
*/
function postSubscribeSpayc() { return; }

/**
 * @api {get} /spayc-details/:spaceId.json Spayc Details
 * @apiVersion 0.1.0
 * @apiName spaycDetails
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Spayc details by id.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {String}      spaceId     spayc id in query string (Required).
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message Spayc Details.
 * @apiSuccess {Object} data Object of Spayc details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Spayc Details.",
    "data": {
        "id": "U3kvaWlJcFREL3R2ZUh0c3RSVkZRdz09",
        "name": "spaycdev13",
        "address": "Your address",
        "start_date": "2019-01-11T01:02:20+00:00",
        "end_date": "2019-01-12T01:02:20+00:00",
        "image": "",
        "group_type": "Public",
        "type": "Community",
        "total_comments": 1,
        "total_subscribed_users": 2,
        "total_joined_users": 1,
        "total_joined_friends": 1
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }

/**
@api {post} /chat-room.json Create Room
@apiVersion 0.1.0
@apiName ChatRoom
@apiGroup Spayc
@apiPermission private

@apiDescription Create a new room for one to one chat.

 * @apiHeader {String} TOKEN            * A token send by header as TOKEN

@apiParam {String} invite           Matrix user id is optional in query string(Required).

@apiExample Example usage:
{
    "invite":"@test2:35.168.119.247"
}
 
@apiSuccess {String} status success.
@apiSuccess {String} message Your room, spaycdev, has been created.
@apiSuccess {Object} data Spayc details.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
{
    "status": "success",
    "message": "Your room, @test4:35.168.119.247-@test5:35.168.119.247, has been created.",
    "data": {
        "invite": "@test4:35.168.119.247",
        "name": "@test4:35.168.119.247-@shubhash11:35.168.119.247",
        "group_type": "Private",
        "matrix_room_id": "!ICbUbLzaoTzIvIoEjf:35.168.119.247",
        "matrix_room_alias": "#test4-35-168-119-247-shubhash11-35-168-119-247:35.168.119.247",
        "user_id": "10",
        "status": "Active",
        "created": "2018-02-16T14:14:01+00:00",
        "modified": "2018-02-16T14:14:01+00:00",
        "id": "99"
    }
}

@apiUse errorResponse
 */
function postChatRoom() { return; }