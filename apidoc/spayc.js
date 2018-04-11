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
@apiHeader {String} timezone        client timezone

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
        "latitude":"XX.00.XX"
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

@apiParam {String} parent_matrix_room_id    Matrix parent room id or Spayc parent room id (Required).
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
                "joined_spayc_status": '',
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
        "is_admin": 1,
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

    @apiParam {String}     room_id      Spayc matrix room id or spayc id in query string (Required).
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
    "data": [
         {
            "id": "2",
            "username": "devuserA_1521280139",
            "display_name": "devuserA",
            "email": "devuserA@yopmail.com",
            "matrix_user_id": "@devusera_1521280139:127.0.0.1",
            "is_admin": 2,
            "matrix_room_id": "",
            "requested_status": "",
            "joined_status": "Joined",
            "physically_present": false,
            "is_subscribed": true,
            "image_url": ""
        },
        {
            "id": "5",
            "username": "devuserD_1521280167",
            "display_name": "devuserD",
            "email": "devuserD@yopmail.com",
            "matrix_user_id": "@devuserd_1521280167:127.0.0.1",
            "is_admin": 0,
            "matrix_room_id": "",
            "requested_status": "Accepted",
            "joined_status": "Joined",
            "physically_present": true,
            "is_subscribed": false,
            "image_url": ""
        },
    ]    
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

@apiDescription Join public and private spayc.For private spayc required passcode to join the spayc directly.In case of private room if passcode is available status must be Joined else status will be Pending.

* @apiHeader {String} TOKEN            * A token send by header as TOKEN
* @apiHeader {String} timezone         * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {String} status Status must be any one Joined,Pending (Required).
@apiParam {String} passcode passcode is required in case of private spayc (Optional).

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

@apiDescription Join public and private sub spayc.For private sub spayc required passcode to join the sub spayc directly.In case of private room if passcode is available status must be Joined else status will be Pending.

* @apiHeader {String} TOKEN            * A token send by header as TOKEN
* @apiHeader {String} timezone            * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {String} status Status must be any one Joined,Pending (Required).
@apiParam {String} passcode Passcode is required in case of private sub spayc (Optional).

@apiExample Example usage:
{
	"spayc_id":"66",
	"status":"Joined",
        "passcode":"code"
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
@api {post} /ban-spayc-member.json Ban/Unban Spayc Member
@apiVersion 0.1.0
@apiName postBanSpaycMember
@apiGroup Spayc
@apiPermission private

@apiDescription super admin or admin can ban or unban spayc member who has not rights of admin and super admin could ban admin privileges member too.

* @apiHeader {String} TOKEN            * Token required in header
* @apiHeader {String} timezone            * Current timezone

@apiParam {Intger} spayc_id Existing Spayc id(Required).
@apiParam {Intger} user_id  Member id of joined spayc(Required).
@apiParam {String} status Status must be any one Banned or Unbanned (Required).

@apiExample Example usage:
{
    "spayc_id":"66",
    "user_id":"9",
    "status":"Banned"
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
function postBanSpaycMember() { return; }

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
            "joined_spayc_status": '',
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
/**
 @api {get} /physical-present-spaycs.json?latitude=:latitude&longitude=:longitude Communication Center Spayces
 @apiVersion 0.1.0
 @apiName getnearAboutSpayces
 @apiGroup Spayc
 @apiPermission private

 @apiDescription Get list of spayces which user has been joined and spayces must be within 1 miles.Spaycs must not be expired.Listing will be ordered on distance and if distance will be same then on created.In absence of latitude and longitude distance will be calculated on stored latitude and longitude.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
 @apiParam {String}      latitude        Latitude of current user (Optional).
 @apiParam {String}      longitude       Longitude of current user (Optional).

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of Spaycs.
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of spaycs.",
    "data": [
        {
            "id": "xxx",
            "name": "kiwiJoshTA",
            "image": "https://spayc-qa.s3.amazonaws.com/room/5_20180330084419.png",
            "group_type": "Public",
            "type": "Event",
            "start_date": "04-15-2018 14:32:20",
            "end_date": "05-30-2018 14:32:20",
            "matrix_room_id": "!LEHgeQLltxEMrDOZgh:127.0.0.1",
            "distance": 0.32,
            "is_subscribed": true,
            "joined_status": "Joined"
        },
        {
            "id": "xxx",
            "name": "kiwiJoshLE",
            "image": null,
            "group_type": "Public",
            "type": "Community",
            "start_date": "05-28-2018 20:19:20",
            "end_date": "06-28-2018 20:26:20",
            "matrix_room_id": "!IBoaOQvLREneRQCFYy:127.0.0.1",
            "distance": 1,
            "is_subscribed": false,
            "joined_status": "Joined"
        }
    ]
}
 *
 * @apiUse UserErrorResponse
 */
function getnearAboutSpayces() { return; }
/**
 @api {get} /public-spaycs.json?page=:page&limit=:limit Advertisement Spayces
 @apiVersion 0.1.0
 @apiName getPublicSpaycs
 @apiGroup Spayc
 @apiPermission private

 @apiDescription Get list of public and joined spayces.Spaycs must not be expired according to the spayc end date.Listing will be ordered on created.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
 @apiHeader {String} timezone         * User time zone
 
 @apiParam {Number}      page            Page number in query string (Optional).
 @apiParam {Number}      limit           Limit in query string (Optional).

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of spaycs.",
    "data": [
        {
            "id": "120",
            "name": "kiwiJoshTA",
            "image": "https://spayc-qa.s3.amazonaws.com/room/5_20180330063531.png",
            "group_type": "Public",
            "type": "Community",
            "start_date": null,
            "end_date": null,
            "matrix_room_id": "!SaAsSnzeUOFGqlsKgr:127.0.0.1",
            "joined_status": "Joined"
        },
        {
            "id": "119",
            "name": "kiwiJoshTA",
            "image": "https://spayc-qa.s3.amazonaws.com/room/5_20180330061805.png",
            "group_type": "Public",
            "type": "Community",
            "start_date": null,
            "end_date": null,
            "matrix_room_id": "!cQgXksBtaXDSkAoRpk:127.0.0.1",
            "joined_status": "Joined"
        }
    ]
}
 *
 * @apiUse UserErrorResponse
 */
function getPublicSpaycs() { return; }

/**
 @api {get} /hash-tag-spaycs.json?page=:page&limit=:limit&keyword=:keyword Hashtag Spayces
 @apiVersion 0.1.0
 @apiName hashTagSpaycs
 @apiGroup Spayc
 @apiPermission private

 @apiDescription Get list of public and joined spayces.Spaycs must not be expired according to the spayc end date.Listing will be ordered on created.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
 @apiHeader {String} timezone         * User time zone
 
 @apiParam {Number}      page            Page number in query string (Optional).
 @apiParam {Number}      limit           Limit in query string (Optional).

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of spaycs.",
    "data": [
        {
            "id": "3",
            "name": "Sam Second Community Spyace",
            "user_id": 2,
            "location": "Delhi",
            "image": "https://spayc-dev.s3.amazonaws.com/room/image_20180317082917.png",
            "group_type": "Public",
            "type": "Community",
            "start_date": null,
            "end_date": null,
            "passcode": "",
            "matrix_room_id": "!MvOssNcvbePXoBUIjC:spayc-dev.kiwireader.com",
            "distance": 15.794925409093,
            "subscribed_users": 1,
            "friends": 0,
            "is_joined": false,
            "joined_spayc_status": "",
            "is_admin": "",
            "joined_users": 0,
            "is_subscribed": false,
            "total_comments": 0
        },
        {
            "id": "4",
            "name": "Community Type Sub Spyac",
            "user_id": 3,
            "location": null,
            "image": "https://spayc-dev.s3.amazonaws.com/room/image_20180317083321.png",
            "group_type": "Public",
            "type": "Community",
            "start_date": null,
            "end_date": null,
            "passcode": "",
            "matrix_room_id": "!nQPjgmlBePZsAyVvQH:spayc-dev.kiwireader.com",
            "distance": 5450.5523363982,
            "subscribed_users": 1,
            "friends": 1,
            "is_joined": false,
            "joined_spayc_status": "",
            "is_admin": "",
            "joined_users": 1,
            "is_subscribed": false,
            "total_comments": 0
        }
    ],
}
 *
 * @apiUse UserErrorResponse
 */
function hashTagSpaycs() { return; }
/**
 @api {post} /map-spaycs.json Map Spayces
 @apiVersion 0.1.0
 @apiName mapSpaycs
 @apiGroup Spayc
 @apiPermission private

 @apiDescription Get list of Map spayces & Friends.Spaycs must not be expired according to the spayc end date.Listing will be ordered on created.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
    
    
    @apiParam {String}      center_latitude            Center Screen Latitude (Required).
    @apiParam {String}      center_longitude           Center Screen Longitude (Required).
    @apiParam {String}      endpoint_latitude          Corner Screen Latitude (Required).
    @apiParam {String}      endpoint_longitude         Corner Screen Longitude (Required).

    @apiParam {String}      time                     Spayc Time (Optional).
    @apiParam {String}      spayc_type               Spayc Type (Optional).
    @apiParam {String}      group_type               Spayc Group Type (Optional).
    @apiParam {String}      wrap_with_friends        Spayc having with friends (Optional).
    @apiParam {Number}      hashtag_id               Hashtag Search Filter (Optional).
    
@apiExample Example usage:
    {
        "center_latitude": "28.6367",
        "center_longitude": "77.2748",
        "endpoint_latitude": "19.0760",
        "endpoint_longitude": "72.8777",
        
        "time": "present|past|future",
        "spayc_type": "Event|Community",
        "group_type": "Public|Private",
        "wrap_with_friends": "yes|no",
        "hashtag_id": xx
        
    }
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of Data.",
    "data": {
        "spaycs": {
            "count": 1,
            "records": [
                {
                    "id": "3",
                    "name": "Sam Second Community Spyace",
                    "matrix_room_id": "!MvOssNcvbePXoBUIjC:spayc-dev.kiwireader.com",
                    "image": "https://spayc-dev.s3.amazonaws.com/room/image_20180317082917.png",
                    "type": "Community",
                    "latitude": 28.7041,
                    "longitude": 77.1025,
                    "is_joined": true,
                    "joined_users": 3,
                    "is_subscribed": true
                }
            ]
        },
        "friends": {
            "count": 2,
            "records": [
                {
                    "id": "2",
                    "display_name": null,
                    "email": "bot@gmail.com",
                    "address": null,
                    "latitude": 28.579403737919,
                    "longitude": 77.320890067264,
                    "matrix_room_id": "!RFyqaVVqazslSfMHzO:spayc-dev.kiwireader.com"
                },
                {
                    "id": "3",
                    "display_name": "sam",
                    "email": "sam@yopmail.com",
                    "address": null,
                    "latitude": 28.7041,
                    "longitude": 77.1025,
                    "matrix_room_id": "!RFyqaVVqazslSfMHzO:spayc-dev.kiwireader.com"
                }
            ]
        }
    }
}
 *
 * @apiUse UserErrorResponse
 */
function mapSpaycs() { return; }
/**
 @api {post} /create-advertisement.json Create Advertisement
 @apiVersion 0.1.0
 @apiName createAdvertisement
 @apiGroup Advertisement
 @apiPermission private

 @apiDescription Create Advertisement.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
 
    @apiParam {String}      name            Advertisement Name (Required).
    @apiParam {Number}      price            Advertisement Price (Required).
    @apiParam {String}      url            Advertisement URL (Required).
    @apiParam {String}      description            Advertisement Description (Required).
    @apiParam {File}      image               Advertisement Image (Optional).

    @apiExample Example usage:
    {
        "name": "Space Ad",
        "price": "250",
        "description": "Test Test Test ",
        "url": "http://www.xyz.com",
        "description":"Advertisement creating",
        "image":"file.png",
        "spayc_id":"5,6"
    }

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Advertisement Created Successfully",
    "data": {
        "name": "Test",
        "price": 250,
        "description": "Test Test Test",
        "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092833.png",
        "user_id": "1",
        "created": "2018-04-02T09:28:33+00:00",
        "modified": "2018-04-02T09:28:33+00:00",
        "id": 53
    }
}
 *
 * @apiUse UserErrorResponse
 */
function createAdvertisement() { return; }


/**
 @api {post} /advertisement-edit.json Edit Advertisement
 @apiVersion 0.1.0
 @apiName editAdvertisement
 @apiGroup Advertisement
 @apiPermission private

 @apiDescription Edit Advertisement.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN

    @apiExample Example usage:
    {
        "id": XX,
        "name": "Space Ad",
        "price": "250",
        "description": "Test Test Test ",
        "url": "http://www.xyz.com",
        "description":"Advertisement creating",
        "image":"file.png",
    }

    @apiParam {Number}      id            Advertisement ID - Update by(Required).
    @apiParam {String}      name            Advertisement Name.
    @apiParam {Number}      price            Advertisement Price.
    @apiParam {String}      url            Advertisement URL.
    @apiParam {String}      description            Advertisement Description.
    @apiParam {File}      image               Advertisement Image.
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Advertisement Updated Successfully",
    "data": {
        "id": 47,
        "user_id": 1,
        "name": "New",
        "price": 255,
        "description": "description",
        "url": "www.test.com",
        "image": "https://spayc-qa.s3.amazonaws.com/room/handle_slider_20180405094347.png",
        "status": "Pending",
        "created": "2018-04-02T09:21:30+00:00",
        "modified": "2018-04-05T09:43:46+00:00"
    }
}
 *
 * @apiUse UserErrorResponse
 */
function editAdvertisement() { return; }



/**
 @api {get} /advertisement-details.json?id=:id View Advertisement
 @apiVersion 0.1.0
 @apiName viewAdvertisement
 @apiGroup Advertisement
 @apiPermission private

 @apiDescription Edit Advertisement.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN


    @apiParam {Number}      id            Advertisement ID in query string(Required).

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Advertisement Details",
    "data": {
        "id": 47,
        "name": "New",
        "image": "https://spayc-qa.s3.amazonaws.com/room/handle_slider_20180405094347.png",
        "price": 255,
        "description": "description",
        "url": "www.test.com"
        }
}
 *
 * @apiUse UserErrorResponse
 */
function viewAdvertisement() { return; }




/**
 @api {get} /user-advertisement.json?page=:page&limit=:limit User Advertisement
 @apiVersion 0.1.0
 @apiName userAdvertisement
 @apiGroup Advertisement
 @apiPermission private

 @apiDescription User Advertisement.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN

    @apiParam {Number}      page            Page number in query string (Optional).
    @apiParam {Number}      limit           Limit in query string (Optional).

 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "message": "List of Advertisement.",
    "data": [
        {
            "id": 48,
            "name": "asd",
            "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092149.png",
            "price": 250,
            "description": "asdasd",
            "url": null
        },
        {
            "id": 49,
            "name": "asd",
            "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092707.png",
            "price": 250,
            "description": "asdasd",
            "url": null
        },
        {
            "id": 50,
            "name": "asd",
            "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092717.png",
            "price": 250,
            "description": "asdasd",
            "url": null
        },
        {
            "id": 51,
            "name": "asd",
            "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092736.png",
            "price": 250,
            "description": "asdasd",
            "url": null
        },
        {
            "id": 52,
            "name": "Test",
            "image": "https://spayc-qa.s3.amazonaws.com/room/test_20180402092815.png",
            "price": 250,
            "description": "asdasd",
            "url": null
        }
    ]
}
 *
 * @apiUse UserErrorResponse
 */
function userAdvertisement() { return; }





/**
 @api {get} /advertisement-delete.json?id=:id Delete Advertisement
 @apiVersion 0.1.0
 @apiName deleteAdvertisement
 @apiGroup Advertisement
 @apiPermission private

 @apiDescription Edit Advertisement.
 
 @apiHeader {String} TOKEN            * A token send by header as TOKEN
    @apiParam {Number}      id            Advertisement ID in query string(Required).


 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of spaycs..
 * @apiSuccess {Object} data List of Spaycs.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
        "response": {
            "status": "success",
            "message": "Advertisement has been deleted."
        }
}
 *
 * @apiUse UserErrorResponse
 */
function deleteAdvertisement() { return; }
