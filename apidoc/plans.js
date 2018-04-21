/**
 * @api {get} /meta-data.json Meta-Data
 * @apiVersion 0.1.0
 * @apiName Meta Data
 * @apiGroup Plans
 * @apiPermission private
 *
 * @apiDescription List of categories,sub-categories,plans with details.
 * 
 * @apiHeader {String} TOKEN     token must be in header.
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