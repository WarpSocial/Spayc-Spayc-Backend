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
@api {post} /spaycs.json Create Spayc
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
        "start_date": "01-11-2019 01:02:20",
        "end_date": "01-12-2019 01:02:20",
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
@api {post} /spayc-edit.json Edit Spayc|Subspayc
@apiVersion 0.1.0
@apiName PostEditSpayc
@apiGroup Spayc
@apiPermission private

@apiDescription Update spayc or subspayc.

@apiHeader {String} TOKEN           A token send by header as TOKEN

@apiParam {String} spayc_id         id either spayc id or matrix room id (Required).
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
        "spayc_id": "XXXXXXX",
        "name": "spaycdev",
        "location": "Community addrss",
        "type": "Event|Community",
        "group_type": "Public|Private",
        "start_date": "01-11-2019 01:02:20",
        "end_date": "01-12-2019 01:02:20",
        "passcode": "s5d4f87sdf4545",
        "description":"spayc creating",
        "image":"file.png",
        "longitude":"XX.00.XX",
        "latitude":"XX.00.XX",
        "invite":"@test2:35.168.119.247, @test3:35.168.119.247"
    }
 
@apiSuccess {String} status success.
@apiSuccess {String} message The spayc has been updated successfully.
@apiSuccess {Object} data Spayc details.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": "success",
    "message": "The spayc has been updated successfully.",
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
@apiError {String} Invalid spayc  id.
@apiUse errorResponse
 */
function postEditSpaycs() { return; }
/**
@api {delete} /spaycs/delete.json?id=:room_id Delete Space/Subspace
@apiVersion 0.1.0
@apiName DeleteSpace
@apiGroup Spayc
@apiPermission private

@apiDescription Delete space or subspace with room id.Matrix room also deleted.

@apiHeader {String} TOKEN          A registered token must be in header.

@apiParam {String} id        Either spayc id or matrix room id(Required).

@apiSuccess {String} status success.
@apiSuccess {String} message The spayc has been deleted.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
{
    "response": {
        "status": "success",
        "message": "The spayc has been deleted."
    }
}

@apiUse errorResponse
 */
function deleteSpace() { return; }
/**
@api {post} /create-subspace.json Create SubSpayc
@apiVersion 0.1.0
@apiName PostSubspayc
@apiGroup Spayc
@apiPermission private

@apiDescription Create a new sub SPAYC.Sub space type,start_date,end_date,longitude,latitude will same as of parent type.

@apiHeader {String} TOKEN          A registered token must be in header.

@apiParam {String} parent_matrix_room_id    Matrix parent room id (Required).
@apiParam {String} name             Title of subspace (Required).
@apiParam {String} group_type       Group type must be any one from the following Public|Private (Required).
@apiParam {String} passcode         Passcode is required in case of private group type.
@apiParam {String} description      Description for SPAYC (Optional).
@apiParam {String} image            Image size must be less than 5MB with extentions png|jpg|jpeg (Optional).
@apiParam {String} invite           Matrix user id must in comma separated if more thant one invitees(Optional).

@apiExample Example usage:
    {
        "parent_matrix_room_id": "!gERqTLZjHXyDAlCPhC:127.0.0.1",
        "name": "devsubspacePMB",
        "group_type": "Public|Private",
        "passcode": "s5d4f87sdf4545",
        "description":"spayc creating",
        "image":"file.png",
        "invite":"@test2:35.168.119.247, @test3:35.168.119.247"
    }
 
@apiSuccess {String} status success.
@apiSuccess {String} message SubSpayc DevsubspacePMB created successfully.
@apiSuccess {Object} data Spayc details.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
{
    "status": "success",
    "message": "SubSpayc DevsubspacePMB created successfully.",
    "data": {
        "parent_matrix_room_id": "!gERqTLZjHXyDAlCPhC:127.0.0.1",
        "name": "devsubspacePMB",
        "description": "devspace",
        "group_type": "Public",
        "invitee": "",
        "passcode": "",
        "image": "https://spayc-qa.s3.amazonaws.com/room/screenshot_from_2017_12_12_19_55_12_20180223142752.png",
        "status": "Active",
        "start_date": "03-11-2018 09:16:00",
        "end_date": "03-12-2018 09:23:00",
        "latitude": 53.369,
        "longitude": 25.369,
        "type": "Community",
        "matrix_token": "MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMjZjaWQgdXNlcl9pZCA9IEBkZXZ0ZXN0YToxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAmMjZfRUI9VlRTej1QblNmCjAwMmZzaWduYXR1cmUgMN05HYWhM71ysg2rTIM2cZUjWny270EnAM8EsILZ1k8K",
        "matrix_room_id": "!UoVWeZsYeLqGUHVULq:127.0.0.1"
    }
}

@apiUse errorResponse
 */
function postSubspaycs() { return; }
/**
 * @api {get} /spaycs.json?page=:page&limit=5&latitude=28.4594965&longitude=77.0266383 Spayc Lists
 * @apiVersion 0.1.0
 * @apiName getSpaycs
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Filter spayc all list, created by logged in user and joined by logged in user using list_by parameter, distance param not comes in response if lat long not provided in request.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {Number}      page            Page number in query string (Optional).
    @apiParam {Number}      limit           Limit in query string (Optional).
    @apiParam {Timestamp}   start_date      Spayc start date in query string(1515542400) (Optional).
    @apiParam {Timestamp}   end_date        Spayc end date in query string(1515715200) (Optional).
    @apiParam {String}      group_type      Group type must be any one from the following (Public|Private) (Optional).
    @apiParam {String}      type            Spayc type must be any one from the following (Event|Community) (Optional).
    @apiParam {String}      latitude        Latitude is required in query string(Optional in case of created, joined).
    @apiParam {String}      longitude       Longitude is required in query string(Optional in case of created, joined).
    @apiParam {String}      list_by         List by is optional in query string(created|joined|all).
    @apiParam {Number}      user_id         User id  of any user and if id is not available it will get the logged user data(Required).
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
        "count": 22,
        "spaycs": [
            {
                "distance": "0",
                "id": "33",
                "name": "spaycdev13",
                "location": "Your address",
                "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                "start_date": "01-11-2019 01:02:00",
                "end_date": "01-12-2019 01:02:00",
                "image": "",
                "type": "Community",
                "group_type": "Public",
                "passcode": "",
                "subscribed_users": 0,
                "friends": 0,
                "joined_spayc_status": null,
                "is_joined": false,
                "joined_users": 0,
                "is_subscribed": false,
                "total_comments": 0,
                "total_presents": 0
            },
            {
                "distance": "0",
                "id": "5",
                "name": "spaycdev13",
                "location": "Your address",
                "matrix_room_id": "!asfLdzLnOdGRkdPZWu:localhost",
                "start_date": "01-11-2019 01:02:00",
                "end_date": "01-12-2019 01:02:00",
                "image": "",
                "type": "Event",
                "group_type": "Public",
                "passcode": "s5d4f87sdf4545",
                "subscribed_users": 1,
                "friends": 0,
                "joined_spayc_status": "Pending",
                "is_joined": false,
                "joined_users": 3,
                "is_subscribed": true,
                "total_comments": 1,
                "total_presents": 0
            }
        ]
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getSpaycs() { return; }
/**
 @api {post} /subscribe-spayc.json Subscribe a Spayc
  @apiVersion 0.1.0
  @apiName subscribeSpayc
  @apiGroup Spayc
  @apiPermission Private
 
  @apiDescription User has been subscribed a spayc by providing the existing spayc id.
  
 * @apiHeader {String} TOKEN            * A token must be in header
 
  @apiParam {String} spayc_id Id either spayc id or matrix room id (Required).
 
  @apiExample Example usage:
 
    {
        "spayc_id":"XXXXX"
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
 @api {post} /unsubscribe-spayc.json UnSubscribe a Spayc
  @apiVersion 0.1.0
  @apiName postUnSubscribeSpayc
  @apiGroup Spayc
  @apiPermission Private
 
  @apiDescription User has been un-subscribed a spayc by providing the existing spayc id.
  
 * @apiHeader {String} TOKEN            * A token must be in header
 
  @apiParam {String} spayc_id Id either spayc id or matrix room id (Required).
 
  @apiExample Example usage:
 
    {
        "spayc_id":"XXXXX"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User has been unsubcribed successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response:
       HTTP/1.1 201 OK
{
    "status": "success",
    "message": "User has been unsubcribed successfully."
}
 
  @apiError {String} User has not yet subscribed.
  @apiUse UserErrorResponse
*/
function postUnSubscribeSpayc() { return; }
/**
 * @api {get} /spayc-details.json?id=:id&latitude=:lat&longitude=:long About Spayc
 * @apiVersion 0.1.0
 * @apiName spaycDetails
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Spayc details by id and latitude, longitude (distance param not comes in response if lat long not provided in request).
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {Number}      id              Spayc matrix id in query string (Required).
    @apiParam {String}      latitude        Latitude is optional in query string(Optional).
    @apiParam {String}      longitude       Longitude is optional in query string(Optional).
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
        "id": "3",
        "name": "devsubspacePMB",
        "location": "dfasdf sdf sdfsdfsd",
        "image": "https://spayc-qa.s3.amazonaws.com/room/screenshot_from_2017_12_12_19_55_12_20180223141832.png",
        "description": "devspace",
        "group_type": "Public",
        "type": "Community",
        "start_date": "03-11-2018 09:16:00",
        "end_date": "03-12-2018 09:23:00",
        "passcode": "",
        "matrix_room_id": "!AHKKnrKlWnBiewiMiB:127.0.0.1",
        "subscribed_users": 0,
        "sub_spaycs": [
            {
                "id": 45,
                "parent_id": 3,
                "name": "devsubspacePMB",
                "location": null,
                "image": null,
                "description": "devspace",
                "group_type": "Public",
                "type": "Community",
                "start_date": "2018-03-11T09:16:00+00:00",
                "end_date": "2018-03-12T09:23:00+00:00",
                "passcode": "",
                "matrix_room_id": "!gERdbhptfHdVQrcnse:127.0.0.1"
            }
        ],
        "friends": 0,
        "joined_spayc_status": "Joined",
        "joined_users": 1,
        "is_subscribed": false,
        "total_comments": 0,
        "total_presents": 0
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }

/**
@api {post} /chat-room.json One to One Room
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
/**
 * @api {get} /spayc-members.json List of Spayc Member
 * @apiVersion 0.1.0
 * @apiName getSpaycMember
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Spayc member to find the list of users associated with the room.Method must be get.In case of invalid spayc id return ivalid request
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 

    @apiParam {String}     room_id      Spayc matrix id in query string (Required).
    @apiParam {String}      status     Status of user, value must be any one from following(Pending|Joined) (Optional).
    @apiParam {Digit}      page        Page no(Optional).
    @apiParam {Digit}      limit       No of record to retrieve(Optional).
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spayc member.
 * @apiSuccess {Object} data Object of User details.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of spayc member.",
    "data": {
        "count": 4,
        "records": [
            {
                "username": "devtestAA",
                "email": "devtestAA@kiwitech.com",
                "gender": "Male                                              ",
                "dob": "02-25-2005",
                "country_code": null,
                "phone": "",
                "website_url": null,
                "address": null,
                "bio_data": null,
                "longitude": "21.253",
                "latitude": "25.256",
                "matrix_user_id": "@devtestaa:127.0.0.1",
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/4_20180220071137.png",
                "user_id": "10",
                "is_admin": 0,
                "requested_status": "Joined",
                "is_subscribed": false,
                "physically_present": false
            },
            {
                "username": "devtestAB",
                "email": "devtestAB@kiwitech.com",
                "gender": "Male                                              ",
                "dob": "02-25-2005",
                "country_code": null,
                "phone": "",
                "website_url": null,
                "address": null,
                "bio_data": null,
                "longitude": "21.253",
                "latitude": "25.256",
                "matrix_user_id": "@devtestab:127.0.0.1",
                "image_url": "",
                "user_id": "11",
                "is_admin": 0,
                "requested_status": "Joined",
                "is_subscribed": false,
                "physically_present": false
            }
        ]
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getSpaycMember() { return; }
/**
@api {post} /change-role.json Make Member As Admin
@apiVersion 0.1.0
@apiName postChangeRole
@apiGroup Spayc
@apiPermission private

@apiDescription Make existing spayc (Room) member as admin for that spayc.

* @apiHeader {String} TOKEN            * A token send by header as TOKEN
* @apiHeader {String} timezone            * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {Intger} user_id Existing User id(Required).
@apiParam {Intger} role Status must be 1 for admin or 0 for remove member from admin role(Required).

@apiExample Example usage:
{
    "spayc_id":"xx",
    "user_id":"xx",
    "role":"1"
}
 
@apiSuccess {String} status success.
@apiSuccess {String} message Role has been changed successfully.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Role has been changed successfully."
}

@apiUse errorResponse
 */
function postChangeRole() { return; }
/**
@api {post} /join-spayc.json Join spayc
@apiVersion 0.1.0
@apiName postJoinSpayc
@apiGroup Spayc
@apiPermission private

@apiDescription Join public and private spayc.For private spayc required passcode to join the spayc directly but due to some technical problem this will not work rest request will be proccessed.In case of private room if passcode is available status must be Joined else status will be Pending.

* @apiHeader {String} TOKEN            * A token send by header as TOKEN
* @apiHeader {String} timezone            * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {Intger} status Status must be any one Joined,Pending (Required).

@apiExample Example usage:
{
	"spayc_id":"66",
	"status":"Joined"
}
 
@apiSuccess {String} status success.
@apiSuccess {String} message User has been {status} successfully.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": "success",
    "message": "User has been {status} successfully."
}

@apiUse errorResponse
 */
function postJoinSpayc() { return; }

/**
@api {post} /join-sub-spayc.json Join sub spayc
@apiVersion 0.1.0
@apiName postJoinSubSpayc
@apiGroup Spayc
@apiPermission private

@apiDescription Join public and private sub spayc.For private sub spayc required passcode to join the sub spayc directly but due to some technical problem this will not work rest request will be proccessed.In case of private room if passcode is available status must be Joined else status will be Pending.

* @apiHeader {String} TOKEN            * A token send by header as TOKEN
* @apiHeader {String} timezone            * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {Intger} status Status must be any one Joined,Pending (Required).

@apiExample Example usage:
{
	"spayc_id":"66",
	"status":"Joined"
}
 
@apiSuccess {String} status success.
@apiSuccess {String} message User has been {status} successfully.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 200 OK
{
    "status": "success",
    "message": "User has been {status} successfully."
}

@apiUse errorResponse
 */
function postJoinSubSpayc() { return; }

/**
* @api {get} /subspaycs.json?spayc_id=:id&page=:page&limit=:limit&latitude=:latitude&longitude=:longitude Sub-Spayc Lists
 * @apiVersion 0.1.0
 * @apiName getSubSpaycs
 * @apiGroup Spayc
 * @apiPermission private
 *
 * @apiDescription Get all sub spaycs for spayc.If user_id key is not available then proccess will be mapped with logged user id.Argument will be as query string.
 * 
 * @apiHeader {String} TOKEN            * A token send by header as TOKEN
 * 
    @apiParam {String}      spayc_id        Parent spayc id either spayc id or matrix room id (Required).
    @apiParam {Number}      page            Page number in query string (Optional).
    @apiParam {Number}      limit           Limit in query string (Optional).
    @apiParam {String}      latitude        Latitude of current user (Optional).
    @apiParam {String}      longitude       Longitude of current user (Optional).
    @apiParam {Number}      user_id         If user id is not available, logged user id will used to proccess the request(Optional).
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of subspayc.
 * @apiSuccess {Object} data List of subspayc.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of subspayc.",
    "data": [
        {
            "id": "95",
            "name": "My Sub 8 March",
            "location": null,
            "matrix_room_id": "!xLfsiKaFDCBlLNyuAi:spayc-dev.kiwireader.com",
            "start_date": "03-07-2018 18:32:16",
            "end_date": "04-07-2018 18:32:34",
            "image": null,
            "type": "Event",
            "group_type": "Public",
            "passcode": "",
            "user_id": 6,
            "distance": "8266.679",
            "subscribed_users": 0,
            "friends": 0,
            "joined_spayc_status": null,
            "is_joined": false,
            "joined_users": 0,
            "is_subscribed": false,
            "total_comments": 0
        }
    ]
}
 *
 * @apiUse UserErrorResponse
 */
function getSubSpaycs() { return; }
