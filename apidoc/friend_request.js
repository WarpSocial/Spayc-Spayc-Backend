/**
* @apiDefine UserErrorResponse
*
* @apiError {Object} Error-Response Returns a json Object.
* @apiError (Error-Response Object){Boolean} status failed.
* @apiError (Error-Response Object){String} message Message.
* @apiErrorExample Sample Error-Response:
*   
* {
*   "status": failed,
*   "message:"Method not allowed."
* }
* {
*    "status": failed,
*    "message": "Resource not found."
* }
* {
*    "status": failed,
*    "message": "Requested Parameter is not correct"
* }
*/

/**
 @api {post} /add-friend.json Add Friend
  @apiVersion 0.1.0
  @apiName AddFriend
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Add new friend with pending status.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
  @apiParam {String} friend_status Friend status and status must be 'Pending' (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"10",
        "friend_status":"Pending"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
        HTTP/1.1 201 OK
        {
            "status": "success",
            "message": "Friend Request sent Successfully.",
            "data": {
                "id": "78",
                "requested_by": "11",
                "requested_to": "10",
                "requested_status": "Pending",
                "action_by": "11"
            }
        }
 
  @apiError {String} Friend request already sent status is Accepted.
  @apiUse UserErrorResponse
*/
function postFriendRequest() { return; }

/**
 @api {post} /request-accept-declined.json Friend request accept/decline
  @apiVersion 0.1.0
  @apiName RequestAcceptDeclined
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Change friend status to accepted or decline, in this case current friend status must be Pending.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
  @apiParam {String} friend_status Friend status and status must be either one from following 'Accepted', 'Decline' (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"10",
        "friend_status":"Decline"
    }
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend status updated successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
    {
        "status": "success",
        "message": "Friend status updated successfully.",
        "data": {
            "id": "77",
            "requested_by": "10",
            "requested_to": "11",
            "requested_status": "Decline",
            "action_by": "11"
        }
    }
 
  @apiError {String} Friend status must be pending, current friend status is Decline.
  @apiUse UserErrorResponse
*/
function postRequestAcceptDeclined() { return; }

/**
 @api {post} /block-friend.json Block a friend
  @apiVersion 0.1.0
  @apiName BlockFriend
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Change friend status to blocked, either friend added or not.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
  @apiParam {String} friend_status Friend status and status must be 'Blocked' (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"10",
        "friend_status":"Blocked"
    }
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User has been blocked successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
    {
        "status": "success",
        "message": "User has been blocked successfully.",
        "data": {
            "id": "78",
            "requested_by": "11",
            "requested_to": "10",
            "requested_status": "Blocked",
            "action_by": "11"
        }
    }
 
  @apiError {String} User has been already blocked.
  @apiUse UserErrorResponse
*/
function postBlockFriend() { return; }

/**
 @api {post} /unblock-friend.json Unblock a friend
  @apiVersion 0.1.0
  @apiName UnblockFriend
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Change friend status to Unblock, for unblock user friend request status must be already blocked.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
  @apiParam {String} friend_status Friend status and status must be 'Unblock' (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"10",
        "friend_status":"Unblock"
    }
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message User has been unblocked successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
    {
        "status": "success",
        "message": "User has been unblocked successfully.",
        "data": {
            "id": "78",
            "requested_by": "11",
            "requested_to": "10",
            "requested_status": "Unblock",
            "action_by": "11"
        }
    }
 
  @apiError {String} Friend status must be Blocked, current friend status is Unblock.
  @apiUse UserErrorResponse
*/
function postUnblockFriend() { return; }

/**
 @api {post} /unfriend-request.json Unfriend
  @apiVersion 0.1.0
  @apiName UnfriendRequest
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Change friend status to Unfriend, if already have friend with requested user then unfriend.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
  @apiParam {String} friend_id Friend id required (friend_id must be an user id)(Required).
  @apiParam {String} friend_status Friend status and status must be 'Unfriend' (Required).
 
  @apiExample Example usage:
 
    {
        "friend_id":"10",
        "friend_status":"Unfriend"
    }
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend status updated successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
    {
        "status": "success",
        "message": "Friend status updated successfully.",
        "data": {
            "id": "78",
            "requested_by": "11",
            "requested_to": "10",
            "requested_status": "Unfriend",
            "action_by": "11"
        }
    }
 
  @apiError {String} User has been already unfriend.
  @apiUse UserErrorResponse
*/
function postUnfriendRequest() { return; }


/**
 @api {get} /get-friends.json?page=:page&limit=:page&friend_status=:status Get Friends
  @apiVersion 0.1.0
  @apiName GetFriends
  @apiGroup Friend Request
  @apiPermission Private User
 
  @apiDescription Get Friends.
  
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 
* @apiParam  {Number}   page            Page number in query string (Optional).
* @apiParam  {Number}   limit           Records limit in query string (Optional).
* @apiParam  {String}   friend_status   Status in query string must be any one from the following(Pending, Accepted, 'Declined',Blocked, Unfriend).
* @apiParam  {Number}   user_id         User id  of any user and if id is not available it will get the logged user data(Required).
 
 
  @apiSuccess {String} status success.
  @apiSuccess {String} message Friend request send successfully.
  @apiSuccess {Object} data Null.
  @apiSuccessExample {json} Success-Response: 
       HTTP/1.1 200 OK
{
    "status": "success",
    "message": "Friend lists.",
    "data": {
        "count": 4,
        "records": [
            {
                "id": "8",
                "username": "user3",
                "matrix_user_id": null,
                "matrix_access_token": null,
                "friend": {
                    "id": "42",
                    "requested_by": "10",
                    "requested_to": "8",
                    "requested_status": "Pending"
                },
                "matrix_room_id": null,
                "image_url": ""
            },
            {
                "id": "9",
                "username": "user2",
                "matrix_user_id": null,
                "matrix_access_token": null,
                "friend": {
                    "id": "63",
                    "requested_by": "10",
                    "requested_to": "9",
                    "requested_status": "Pending"
                },
                "matrix_room_id": "!ICbUbLzaoTzIvIoEjf:35.168.119.247",
                "image_url": "https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226075827.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632"
            },
            {
                "id": "17",
                "username": "user1",
                "matrix_user_id": null,
                "matrix_access_token": null,
                "friend": {
                    "id": "1",
                    "requested_by": "10",
                    "requested_to": "17",
                    "requested_status": "Pending"
                },
                "matrix_room_id": null,
                "image_url": ""
            },
            {
                "id": "19",
                "username": "test2",
                "matrix_user_id": "@test2:35.168.119.247",
                "matrix_access_token": "MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg",
                "friend": {
                    "id": "43",
                    "requested_by": "10",
                    "requested_to": "19",
                    "requested_status": "Accepted"
                },
                "matrix_room_id": "kjljkljljll54",
                "image_url": ""
            }
        ]
    }
}
 

  @apiUse UserErrorResponse
*/
function getFriends() { return; }