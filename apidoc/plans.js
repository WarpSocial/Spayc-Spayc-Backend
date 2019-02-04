/**
 * @api {get} /meta-data.json Meta-Data
 * @apiVersion 0.1.0
 * @apiName Meta Data
 * @apiGroup Plans
 * @apiPermission private
 *
 * @apiDescription List of categories,sub-categories,plans with details.
 * 
 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.
 *
 * @apiSuccess {String} status success.
 * @apiSuccess {String} message List of meta-data details.
 * @apiSuccess {Object} data Object of List of categories and plans.
 * @apiSuccessExample {json} Success-Response: 
 *      HTTP/1.1 200 OK
{
    "status": "success",
    "Message": "List of meta-data details.",
    "data": {
        "categories": [
            {
                "id": 1,
                "parent_id": null,
                "name": "Music",
                "slug": "music",
                "description": "Music",
                "created": "04-19-2018 21:00:59",
                "modified": "04-19-2018 21:00:59",
                "sub_categories": [
                    {
                        "id": 2,
                        "parent_id": 1,
                        "name": "Blues & Jazz",
                        "slug": "blues-jazz",
                        "description": "Blues & Jazz",
                        "created": "04-19-2018 21:02:01",
                        "modified": "04-19-2018 21:02:01"
                    }                    
                ]
            },
            {
                "id": 2,
                "parent_id": 1,
                "name": "Blues & Jazz",
                "slug": "blues-jazz",
                "description": "Blues & Jazz",
                "created": "04-19-2018 21:02:01",
                "modified": "04-19-2018 21:02:01",
                "sub_categories": []
            }
        ],
        "plans": [
            {
                "id": 1,
                "name": "Plan I",
                "slug": "plan-1",
                "amount": 1,
                "currency": "USD",
                "views": 500,
                "created": "04-20-2018 15:07:23",
                "modified": "04-20-2018 15:07:23"
            },            
            {
                "id": 4,
                "name": "Plan IV",
                "slug": "plan-4",
                "amount": 10,
                "currency": "USD",
                "views": 6000,
                "created": "04-20-2018 15:10:22",
                "modified": "04-20-2018 15:10:22"
            }
        ]
    }
}
 *
 * @apiUse UserErrorResponse
 */
function getView() { return; }
/**
@api {post} /add-promotional-spayc.json Create Promotional Spayc
@apiVersion 0.1.0
@apiName PostAddPromotionalSpayc
@apiGroup Plans
@apiPermission private

@apiDescription create spayc which you want to promote in communication center.

 * @apiHeader {String} TOKEN Token must be set in header.
 * @apiHeader {String}  timezone User current time zone ex: America/New_York.

@apiParam {Integer} spayc_promotional_id    * promotional spayc id (Required).
@apiParam {String} spayc_id     * List of selected spayc ids in comma separated (Required).
@apiParam {Integer} plan_id     * Selected plan id (Required).
@apiParam {String} receipt       Receipt details (Optional).
@apiParam {DateTime} purchase_date      * Date of purchase the plan (Required).  
@apiParam {String} platform     * Device platform details (Required).

@apiExample Example usage:
    {
	"spayc_promotional_id":"308",
	"spayc_id":"307,306,305,303",
	"plan_id":"3",
	"receipt":"resdfklsf",
	"purchase_date":"05-04-2018 04:02:20",
	"platform":"ios"
    }
 
@apiSuccess {String} status success.
@apiSuccess {String} message Promotion has been created successfully.
@apiSuccess {Object} data requested input.
@apiSuccessExample {json} Success-Response: 
    HTTP/1.1 201 OK
{
    "status": "success",
    "message": "Promotion has been created successfully.",
    "data": {
        "spayc_promotional_id": "308",
        "spayc_id": "307,306,305,303",
        "plan_id": "3",
        "receipt": "resdfklsf",
        "purchase_date": "05-04-2018 04:02:20",
        "platform": "ios"
    }
}

@apiUse errorResponse
*/
function postAddPromotionalSpayc() { return; }