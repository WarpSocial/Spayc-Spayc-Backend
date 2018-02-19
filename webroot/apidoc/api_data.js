define({ "api": [
  {
    "type": "post",
    "url": "/chat-room.json",
    "title": "One to One Room",
    "version": "0.1.0",
    "name": "ChatRoom",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Create a new room for one to one chat.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invite",
            "description": "<p>Matrix user id is optional in query string(Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"invite\":\"@test2:35.168.119.247\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your room, spaycdev, has been created.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Spayc details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Your room, @test4:35.168.119.247-@test5:35.168.119.247, has been created.\",\n    \"data\": {\n        \"invite\": \"@test4:35.168.119.247\",\n        \"name\": \"@test4:35.168.119.247-@shubhash11:35.168.119.247\",\n        \"group_type\": \"Private\",\n        \"matrix_room_id\": \"!ICbUbLzaoTzIvIoEjf:35.168.119.247\",\n        \"matrix_room_alias\": \"#test4-35-168-119-247-shubhash11-35-168-119-247:35.168.119.247\",\n        \"user_id\": \"10\",\n        \"status\": \"Active\",\n        \"created\": \"2018-02-16T14:14:01+00:00\",\n        \"modified\": \"2018-02-16T14:14:01+00:00\",\n        \"id\": \"99\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/chat-room.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/spaycs.json",
    "title": "Create Spayc",
    "version": "0.1.0",
    "name": "PostSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Create a new SPAYC.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name title of the spayc (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "location",
            "description": "<p>Location must be alphanumeric with space (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>SPAYC type must be any one from the following Event|Community (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "group_type",
            "description": "<p>Group type must be any one from the following Public|Private (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "start_date",
            "description": "<p>Start date with time in format YYYY-MM-DD H:i:s (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "end_date",
            "description": "<p>End date with time in format YYYY-MM-DD H:i:s (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passcode",
            "description": "<p>Passcode is required in case of private group type.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>Description for SPAYC (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<p>Image size must be less than 5MB with extentions png|jpg|jpeg (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Langitude from google map (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude from google map (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "invite",
            "description": "<p>Matrix user id is optional in query string(Optional).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"name\": \"spaycdev\",\n    \"location\": \"Community addrss\",\n    \"type\": \"Event|Community\",\n    \"group_type\": \"Public|Private\",\n    \"start_date\": \"2019-01-11 01:02:20\",\n    \"end_date\": \"2019-01-12 01:02:20\",\n    \"passcode\": \"s5d4f87sdf4545\",\n    \"description\":\"spayc creating\",\n    \"image\":\"file.png\",\n    \"longitude\":\"XX.00.XX\",\n    \"latitude\":\"XX.00.XX\",\n    \"invite\":\"@test2:35.168.119.247, @test3:35.168.119.247\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Your spayc, spaycdev, has been created.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Spayc details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Your spayc, Festive, has been created.\",\n    \"data\": {\n        \"name\": \"Festive\",\n        \"location\": \"Your address\",\n        \"type\": \"Event\",\n        \"group_type\": \"Public\",\n        \"start_date\": \"2019-01-11T01:02:20+00:00\",\n        \"end_date\": \"2019-01-11T01:08:20+00:00\",\n        \"passcode\": \"\",\n        \"description\": \"Holi is a festival of color #color #festival\",\n        \"image\": \"\",\n        \"longitude\": 77.209021,\n        \"latitude\": 28.613939,\n        \"invite\": \"@test2:35.168.119.247\",\n        \"status\": \"Active\",\n        \"matrix_room_id\": \"!JqhnnrWCtlFTnWlwWL:35.168.119.247\",\n        \"matrix_room_alias\": \"#Holi13:35.168.119.247\",\n        \"user_id\": \"10\",\n        \"created\": \"2018-02-16T11:02:47+00:00\",\n        \"modified\": \"2018-02-16T11:02:47+00:00\",\n        \"id\": \"95\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spaycs.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/spaycs.json?page=:page&limit=5&latitude=28.4594965&longitude=77.0266383",
    "title": "Spayc Lists",
    "version": "0.1.0",
    "name": "getSpaycs",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Filter spayc list.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>Page number in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Timestamp",
            "optional": false,
            "field": "start_date",
            "description": "<p>Spayc start date in query string(1515542400) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Timestamp",
            "optional": false,
            "field": "end_date",
            "description": "<p>Spayc end date in query string(1515715200) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "group_type",
            "description": "<p>Group type must be any one from the following (Public|Private) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Spayc type must be any one from the following (Event|Community) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with_friends",
            "description": "<p>Allow that spayc list with friends or not (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude is required in query string(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude is required in query string(Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Spayc lists.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of spayc details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Spayc lists.\",\n    \"data\": {\n        \"count\": 4,\n        \"spaycs\": [\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": \"NDQ2NTI2NDYzMC45NQ==\",\n                \"user_id\": 51,\n                \"name\": \"Test\",\n                \"address\": \"Event address\",\n                \"start_date\": \"2018-01-10T06:00:00+00:00\",\n                \"end_date\": \"2018-01-10T06:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [\n                    {\n                        \"spayc_id\": 1,\n                        \"total_comment\": 1\n                    }\n                ],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": \"NDQ2N5I2NDY43C45NQ==\",\n                \"user_id\": 51,\n                \"name\": \"Test1\",\n                \"address\": \"Event address\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": \"NDQ2NTI2NDgfMC45NQ5g\",\n                \"user_id\": 51,\n                \"name\": \"Test12\",\n                \"address\": \"Event address\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Private\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [\n                    {\n                        \"spayc_id\": 3,\n                        \"subscribed_users\": 1\n                    }\n                ],\n                \"joined_spayc\": [\n                    {\n                        \"spayc_id\": 3,\n                        \"joined_users\": 3,\n                        \"joined_friends\": 2\n                    }\n                ]\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": \"NDsdaf2NDYzMC45NQFA\",\n                \"user_id\": 51,\n                \"name\": \"Test123\",\n                \"address\": \"Community address\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Community\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spaycs.json?page=:page&limit=5&latitude=28.4594965&longitude=77.0266383"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/spayc-details/:spaceId.json",
    "title": "Spayc Details",
    "version": "0.1.0",
    "name": "spaycDetails",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Spayc details by id.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "spaceId",
            "description": "<p>spayc id in query string (Required).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Spayc Details.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Object of Spayc details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Spayc Details.\",\n    \"data\": {\n        \"id\": \"U3kvaWlJcFREL3R2ZUh0c3RSVkZRdz09\",\n        \"name\": \"spaycdev13\",\n        \"address\": \"Your address\",\n        \"start_date\": \"2019-01-11T01:02:20+00:00\",\n        \"end_date\": \"2019-01-12T01:02:20+00:00\",\n        \"image\": \"\",\n        \"group_type\": \"Public\",\n        \"type\": \"Community\",\n        \"total_comments\": 1,\n        \"total_subscribed_users\": 2,\n        \"total_joined_users\": 1,\n        \"total_joined_friends\": 1\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spayc-details/:spaceId.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/subscribe-spayc.json",
    "title": "Subscribe Spayc",
    "version": "0.1.0",
    "name": "subscribeSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "Subscribe Spayc"
      }
    ],
    "description": "<p>Subscribe Spayc.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "spayc_id",
            "description": "<p>Spayc id is required (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"spayc_id\":\"NDIwMjYwMjAwLjU2\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User Subscribed successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "       HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User Subscribed successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "User",
            "description": "<p>already subscribed.</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/subscribe-spayc.json"
      }
    ]
  },
  {
    "type": "get",
    "url": "/facebook-friends.json?page=:page&limit=:limit",
    "title": "Get facebook friends",
    "version": "0.1.0",
    "name": "FacebookFriends",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>get facebook friend for suggetion.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>Page number is optional in query string default value 1.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit is optional in query string default value 5.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Facebook friend lists.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n \"message\": \"Facebook friend lists.\",\n \"data\": {\n        \"count\": 2,\n        \"records\": [\n            {\n                \"id\": \"7\",\n                \"username\": \"user1\",\n                \"image_url\": \"\"\n            },\n            {\n                \"id\": \"11\",\n                \"username\": \"user2\",\n                \"image_url\": \"\"\n            }\n        ]\n    }",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/facebook-friends.json?page=:page&limit=:limit"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/friend-request.json",
    "title": "Add Friend",
    "version": "0.1.0",
    "name": "FriendRequest",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Add Friend.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "friend_id",
            "description": "<p>Friend id required (friend_id must be an user id)(Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"friend_id\":\"NDIwMjYwMjAwLjU2\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Friend request send successfully..</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "        HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend request sent successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Friend",
            "description": "<p>request already sent.</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/friend-request.json"
      }
    ]
  },
  {
    "type": "get",
    "url": "/get-friends.json?page=:page&limit=:page&friend_status=:status",
    "title": "Get Friends",
    "version": "0.1.0",
    "name": "GetFriends",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Get Friends.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>Page number in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<p>Records limit in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "friend_status",
            "description": "<p>Status in query string must be any one from the following(Requested, Accepted, 'Declined',Blocked, Unfriend).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Friend request send successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend lists.\",\n    \"data\": {\n        \"count\": 4,\n        \"records\": [\n            {\n                \"id\": \"VkR0a3p4anQ2SUxScm85RGhTZTFpZz09\",\n                \"username\": \"test\",\n                \"matrix_user_id\": null,\n                \"matrix_access_token\": null,\n                \"friend\": {\n                    \"id\": \"bmRkeTJVYjhwTlQzKzdpeWJwWEMvZz09\",\n                    \"requested_by\": 10,\n                    \"requested_to\": 7,\n                    \"requested_status\": \"Requested\",\n                    \"friend_status\": null,\n                    \"matrix_room_id\": \"room:@848843444\"\n                },\n                \"image_url\": \"\"\n            },\n            {\n                \"id\": \"OWxtVWpXalVkaVdWRHVTWUR5amxuZz09\",\n                \"name\": \"test2\",\n                \"matrix_user_id\": null,\n                \"matrix_access_token\": null,\n                \"friend\": {\n                    \"id\": \"NlJpUEx0M016dXBGTjhZdWpWeThBUT09\",\n                    \"requested_by\": 10,\n                    \"requested_to\": 8,\n                    \"requested_status\": \"Requested\",\n                    \"friend_status\": null,\n                    \"matrix_room_id\": \"room:@84854843\"\n                },\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_08_14_18_14_10_20180206133936.png\"\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/get-friends.json?page=:page&limit=:page&friend_status=:status"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/login.json",
    "title": "Login",
    "version": "0.1.0",
    "name": "PostLogin",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>User login with user name and its password. User get logged in by using username and password including device_id.content-type must be in form-data</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email Registered email id (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>secret password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<p>Device personal id (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"email\": \"spaycdev@spayc.com\",\n   \"password\": \"XXXXXXXXX\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Login done successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of user details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Login done successfully.\",\n    \"data\": {\n        \"id\": \"NDhxaUsvbWtGUDN3MXJ4YXJmTC9pdz09\",\n        \"username\": \"spayc\",\n        \"email\": \"spayc@domain.com\",\n        \"gender\": \"Male\",\n        \"dob\": \"2000-02-02\",\n        \"country_code\":\"\",\n        \"phone\": \"\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"device_id\": \"VOYANVLOXG\",\n        \"matrix_user_id\": \"@spayc:127.0.0.1\",\n        \"token\": \"7f39fa7c6642666c6802f0d4e2fddf6a695fc12458733764c64ad338d6d1ca5f\",\n        \"matrix_token\": \"MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMmNjaWQgdXNlcl9pZCA9IEBza3VtYXIyX2FhX2RkczoxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSA4Ok00T3VzN1h5cnlKUEBxCjAwMmZzaWduYXR1cmUg5JCNFFzLQ4N-K6MnNWqFfqQdueyPiR74U_r6qLUzrqAK\",\n        \"user_images\": [\n            {\n                \"id\": \"MVpZL0tlbEp1N0JiT2JnLzhkLzB5dz09\",\n                \"user_id\": 17,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2018_02_02_12_10_56_20180206133933.png\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            },\n            {\n                \"id\": \"eHFzRWc1VFljdzlzdnVqSkpZL3ZYZz09\",\n                \"user_id\": 17,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_08_14_18_14_10_20180206133936.png\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Sign",
            "description": "<p>in credentials ain't right, try again buddy.</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/login.json"
      }
    ]
  },
  {
    "type": "post",
    "url": "/users.json",
    "title": "Register User",
    "version": "0.1.0",
    "name": "PostUser",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Create a new account. Register new user with form-data option.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Username must be unique and size between 3-30 charecters (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>Email of user must be unique (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>secret password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>secret password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<p>Date of birth must in in format MM-DD-YYYY (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of user like any one (Male, Femal, Other) (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "country_code",
            "description": "<p>Country code of user phone number(Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone no of user and accept only 10 digits only (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>of user address (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>of user address (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"username\": \"spaycdev\",\n   \"email\": \"spaycdev@spayc.com\",\n   \"password\": \"XXXXXXXXX\",\n   \"confirm_password\": \"XXXXXXXXX\",\n   \"gender\": \"Male|Female|Other\",\n   \"country_code\":\"+91\",\n   \"phone\": \"(XXX) (XXXXXXX)\",\n   \"dob\": \"11-12-2000\",\n   \"latitude\": \"XX.XXXXXX\",\n   \"longitude\": \"XX.XXXXXX\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Registration done successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of user details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 201 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\": \"spaycdev\",\n         \"email\": \"spaycdev@spayc.com\",\n         \"gender\": \"male|female|other\",\n         \"country_code\":\"+91\",\n         \"phone\": \"(XXX) (XXXXXXX)\",\n         \"dob\": \"11-12-2000\",\n         \"latitude\": \"XX.XXXXXX\",\n         \"longitude\": \"XX.XXXXXX\"\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/users.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "Put",
    "url": "/profile-edit.json",
    "title": "Update User",
    "version": "0.1.0",
    "name": "PutUser",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Update profile of existing user. Update user own profile details with form-data option.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<p>Username (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<p>Date of birth must in this format MM-DD-YYYY (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of user like any one (Male, Femal, Other) (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "country_code",
            "description": "<p>Country code of user phone number(Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone no of user and accept upto 16 digits (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address",
            "description": "<p>User address (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "website_url",
            "description": "<p>Website url (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bio_data",
            "description": "<p>Bio data of user (Optional).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"username\":\"spayc\",\n   \"dob\": \"12-11-2001\",\n   \"gender\": \"Male|Female|Other\",\n   \"country_code\":\"+91\",\n   \"phone\": \"XXXXXXXXXX\",\n   \"address\": \"spayc address\",\n   \"website_url\":\"www.spayc.com\",\n   \"bio_data\":\"your bio data\",\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Updated successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of user details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\":\"spayc\",\n         \"dob\": \"12-11-2001\",\n         \"gender\": \"Male|Female|Other\",\n         \"country_code\":\"+91\",\n         \"phone\": \"XXXXXXXXXX\",\n         \"address\": \"spayc address\",\n         \"website_url\":\"www.spayc.com\",\n         \"bio_data\":\"your bio data\",\n      }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/profile-edit.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/reverification.json",
    "title": "Send Reverification Link",
    "version": "0.1.0",
    "name": "Reverification",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Send reverification link.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User registered email required field.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"email\": \"spaycdev@spayc.com\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Re-verification email sent successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Re-verification email sent successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/reverification.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/change-password.json",
    "title": "Change Password",
    "version": "0.1.0",
    "name": "changePassword",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Change password request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "old_password",
            "description": "<p>User old password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>User new password (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<p>Confirm new password (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"old_password\": \"password@123\"\n   \"new_password\": \"newPassword@123\"\n   \"confirm_password\": \"newPassword@123\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Password changed successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Password changed successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/change-password.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/chat-request.json",
    "title": "Chat request",
    "version": "0.1.0",
    "name": "chatRequest",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>One ot One chat request.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "friend_id",
            "description": "<p>User id to whom you send request(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "matrix_room_id",
            "description": "<p>Matrix room id from matrix (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"friend_id\": \"anM1a0FkWGlWUXBwR1ZDUU9iR09XQT09\"\n   \"matrix_room_id\": \"room:@000123\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Friend request sent successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend request sent successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/chat-request.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/facebook-signup.json",
    "title": "Facebook Sign-up",
    "version": "0.0.1",
    "name": "facebookSignup",
    "group": "User",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>User singup by facebook.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fb_id",
            "description": "<ul> <li>Facebook user unique id required in body(Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fb_access_key",
            "description": "<ul> <li>Facebook user access key required in body(Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username optional in body(Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>User email required in body(Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image_url",
            "description": "<ul> <li>User image url optional in body(Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>Date of birth optional in body MM-DD-YYYY (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "phone",
            "description": "<ul> <li>Phone no of user and accept upto 16 digits (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>Gender of user like any one (Male, Femal, Other) (Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<ul> <li>Device id is required in body (Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<ul> <li>Latitude of user address (Required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<ul> <li>Longitude of user address (Required).</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Consumer Object contain details about user.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Saved successfully.\",\n    \"data\": {\n        \"username\": \"spayc\",\n        \"email\": \"user@domain.com\",\n        \"gender\": \"Male\",\n        \"dob\": \"11-12-2000\",\n        \"phone\": null,\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"device_id\": \"xxxxxxxxxxxxxxxxxx\",\n        \"matrix_user_id\": \"@spayc11:35.168.119.247\",\n        \"token\": \"130d5b5d52f8b283a2705d5aa45ebd15f378a0763f6b369832c2dbe338e2369b\",\n        \"matrix_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyZGNpZCB1c2VyX2lkID0gQHNic2hhcm1hMTE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAzZ2sxO1lJaDpfKzcuIzA4CjAwMmZzaWduYXR1cmUg_yk9Mt0_mur_yf6ZZT6sE7ybmtiMEID2xiDSqwQzLW\n    }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"fb_id\":\"xxxxxxxxxxxx\",\n   \"fb_access_key\":\"xxxxxxxxxxxxxxxxxxxx\",\n   \"username\":\"spayc\",\n   \"email\":\"user@domainname.com\",\n   \"image_url\":\"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2018_02_02_12_10_56_20180206133933.png\",\n   \"dob\":\"12-11-2001\",\n   \"gender\":\"Male|Female|Other\",\n   \"phone\": \"XXXXXXXXXX\",\n   \"device_id\":\"xxxxxxxxxxxxxxxxxx\",\n   \"latitude\": \"xx.xxxxx\",\n  \"longitude\": \"xx.xxxxx\"\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>Status.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\"status\": false,\n\"message\": \"Method not allowed.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/facebook_signup.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/facebook-signup.json"
      }
    ]
  },
  {
    "type": "post",
    "url": "/forgot-password.json",
    "title": "Forgot Password",
    "version": "0.1.0",
    "name": "forgotPassword",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Reset password link to be send at requested email.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>User registered email required field.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"email\": \"spaycdev@spayc.com\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Reset password link send to your email address.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Reset password link send to your email address.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/forgot-password.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/logout.json",
    "title": "Logout",
    "version": "0.1.0",
    "name": "getLogout",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>User get logout.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Logout successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Logout successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/logout.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/users.json?page=:page&limit=:limit&keyword=:keyword&latitude=:latitude&longitude=:longitude",
    "title": "Search Users, Spaycs, Hashtags",
    "version": "0.1.0",
    "name": "getUsers",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Search users|spaycs|hashtags details.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>Page number in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<p>Records limit in query string (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Type should be in (users|spaycs|hashtags|all) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keyword",
            "description": "<p>Username|Spayc name|Hashtag name in query string to be search (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "latitude",
            "description": "<p>of spayc to be search (Required in case of spayc search).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "longitude",
            "description": "<p>of spayc to be search (Required in case of spayc search).</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Search Lists.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of users|spaycs|hashtags details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Search Lists.\",\n    \"data\": {\n        \"users\": {\n            \"count\": 14,\n            \"records\": [\n                {\n                    \"id\": \"MzY3NzI3Njc1LjQ5\",\n                    \"name\": \"spayc1\",\n                    \"email\": \"spayc1@domain.com\",\n                    \"gender\": \"Male\",\n                    \"country_code\":\"+91\",\n                    \"phone\": \"(XXX) (XXXXXXX)\",\n                    \"dob\": \"12-11-2000\",\n                    \"status\": \"Active\",\n                    \"website_url\": \"www.spayc.com\",\n                    \"address\": \"spayc address\",\n                    \"bio_data\": \"your bio data\",\n                    \"matrix_user_id\": \"@test2:35.168.119.247\",\n                    \"matrix_access_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg\",\n                    \"created\": \"2018-01-17T14:09:52+00:00\",\n                    \"modified\": \"2018-01-18T07:43:46+00:00\",\n                    \"spaycs\": [\n                        {\n                            \"user_id\": 7,\n                            \"created_spaycs\": 2\n                        }\n                    ],\n                    \"joined_spayc\": [\n                        {\n                            \"user_id\": 7,\n                            \"joined_spaycs\": 2\n                        }\n                    ],\n                    \"user_images\": [],\n                    \"friend\": {\n                        \"total_friends\": 2\n                    }\n                },\n                {\n                    \"id\": \"NTI1MzI1MjUwLjc=\",\n                    \"name\": \"spayc2\",\n                    \"email\": \"spayc2@domain.com\",\n                    \"gender\": \"Male\",\n                    \"country_code\":\"+91\",\n                    \"phone\": \"(XXX) (XXXXXXX)\",\n                    \"dob\": \"11-12-2000\",\n                    \"status\": \"Active\",\n                    \"website_url\": \"www.spayc.com\",\n                    \"address\": \"your address\",\n                    \"bio_data\": \"your bio data\",\n                    \"matrix_user_id\": \"@test2:35.168.119.247\",\n                    \"matrix_access_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg\",\n                    \"created\": \"2018-01-24T13:46:10+00:00\",\n                    \"modified\": \"2018-01-29T07:30:01+00:00\",\n                    \"spaycs\": [\n                        {\n                            \"user_id\": 10,\n                            \"created_spaycs\": 32\n                        }\n                    ],\n                    \"joined_spayc\": [],\n                    \"user_images\": [],\n                    \"friend\": {\n                        \"id\": \"NTI1MzI1MjUuMDc=\",\n                        \"requested_by\": 10,\n                        \"requested_to\": 17,\n                        \"requested_status\": \"Accepted\",\n                        \"friend_status\": \"Unfriend\",\n                        \"matrix_room_id\": null,\n                        \"total_friends\": 7\n                    }\n                }\n            ]\n        },\n        \"spaycs\": {\n            \"count\": 10,\n            \"records\": [\n                {\n                    \"distance\": \"12.3020109427781\",\n                    \"id\": \"MTczMzU3MzMyNy4zMQ==\",\n                    \"user_id\": 10,\n                    \"name\": \"spaycdev3\",\n                    \"address\": \"Your address\",\n                    \"start_date\": \"2019-01-11T01:02:20+00:00\",\n                    \"end_date\": \"2019-01-12T01:02:20+00:00\",\n                    \"image\": \"\",\n                    \"type\": \"Community\",\n                    \"group_type\": \"Public\",\n                    \"status\": \"Active\",\n                    \"latitude\": 28.613939,\n                    \"longitude\": 77.209021,\n                    \"created\": \"2018-01-25T11:49:48+00:00\",\n                    \"modified\": \"2018-01-25T11:49:48+00:00\"\n                },\n                {\n                    \"distance\": \"12.3020109427781\",\n                    \"id\": \"MTY4MTA0MDgwMi4yNA==\",\n                    \"user_id\": 10,\n                    \"name\": \"spaycdev4\",\n                    \"address\": \"Your address\",\n                    \"start_date\": \"2019-01-11T01:02:20+00:00\",\n                    \"end_date\": \"2019-01-12T01:02:20+00:00\",\n                    \"image\": \"\",\n                    \"type\": \"Community\",\n                    \"group_type\": \"Public\",\n                    \"status\": \"Active\",\n                    \"latitude\": 28.613939,\n                    \"longitude\": 77.209021,\n                    \"created\": \"2018-01-25T11:40:10+00:00\",\n                    \"modified\": \"2018-01-25T11:40:10+00:00\"\n                }\n            ]\n        },\n        \"hashtags\": {\n            \"count\": 9,\n            \"records\": [\n                {\n                    \"id\": \"MjA0ODc2ODQ3Ny43Mw==\",\n                    \"name\": \"color\",\n                    \"created\": \"2018-01-31T13:54:20+00:00\",\n                    \"modified\": \"2018-01-31T13:54:20+00:00\"\n                },\n                {\n                    \"id\": \"MjEwMTMwMTAwMi44\",\n                    \"name\": \"festival\",\n                    \"created\": \"2018-01-31T13:54:20+00:00\",\n                    \"modified\": \"2018-01-31T13:54:20+00:00\"\n                }\n            ]\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/users.json?page=:page&limit=:limit&keyword=:keyword&latitude=:latitude&longitude=:longitude"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "post",
    "url": "/avatars.json",
    "title": "Upload Profile Images",
    "version": "0.1.0",
    "name": "imageUpload",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Upload up to 5 image for profile.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "images",
            "description": "<p>Images contain up to 5 image object required(index key should be order_index of image if already saved).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"images\":{\n        \"1\":{\n            \"tmp_name\":\"\\/tmp\\/phpj212j5\",\n            \"error\":0,\n            \"name\":\"Screenshot from 2017-12-26 15:18:47.png\",\n            \"type\":\"image\\/png\",\n            \"size\":154882\n        },\n        \"2\":{\n            \"tmp_name\":\"\\/tmp\\/php0yUWwr\",\n            \"error\":0,\n            \"name\":\"Screenshot from 2017-08-14 18:14:15.png\",\n            \"type\":\"image\\/png\",\n            \"size\":590333\n        },\n        \"3\":{\n            \"tmp_name\":\"\\/tmp\\/phpluwiKN\",\n            \"error\":0,\n            \"name\":\"Screenshot from 2017-04-10 17:04:21.png\",\n            \"type\":\"image\\/png\",\n            \"size\":172875\n        },\n        \"4\":{\n            \"tmp_name\":\"\\/tmp\\/phpiTiNX9\",\n            \"error\":0,\n            \"name\":\"Screenshot from 2016-07-21 17:30:37.png\",\n            \"type\":\"image\\/png\",\n            \"size\":212200\n        },\n        \"5\":{\n            \"tmp_name\":\"\\/tmp\\/phpv0ssbw\",\n            \"error\":0,\n            \"name\":\"Screenshot from 2016-06-15 18:56:02.png\",\n            \"type\":\"image\\/png\",\n            \"size\":211765\n        }\n    }\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Profile image uploaded successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Profile image uploaded successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/avatars.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/remove-avatar/:order.json",
    "title": "Remove Profile Image",
    "version": "0.1.0",
    "name": "removeAvatar",
    "group": "User",
    "permission": [
      {
        "name": "Logged in user"
      }
    ],
    "description": "<p>Remove profile image. Token must be set in header.if image is default profile image then it will also remove from matrix.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order",
            "description": "<p>Image order index in query string required.</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"status\": \"success\",\n    \"message\": \"Profile image has been removed.\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Profile image has been removed.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Profile image set as default.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/remove-avatar/:order.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "put",
    "url": "/friend-response.json",
    "title": "Set Friend Status",
    "version": "0.1.0",
    "name": "setFriendStatus",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Set Friend Status.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "id",
            "description": "<p>Friend id required field in body.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status is required field and status must be in(Accepted,Declined,Blocked, Unblock, Unfriend).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"id\":\"NDIwMjYwMjAwLjU2\",\n    \"status\":\"Accepted\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Friend status updated successfully.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend status updated successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "String",
            "optional": false,
            "field": "Status",
            "description": "<p>is required fields and status must be in(Accepted,Declined,Blocked,Unfriend)..</p>"
          },
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/friend-response.json"
      }
    ]
  },
  {
    "type": "put",
    "url": "/set-profile-image/:order.json",
    "title": "Set Profile Images",
    "version": "0.1.0",
    "name": "setProfileImage",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>Set image as default profile pic.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order",
            "description": "<p>Image order index in query string required.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Profile Profile image set as default.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Profile image set as default.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/set-profile-image/:order.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/user-profile/:userId.json",
    "title": "User Profile",
    "version": "0.1.0",
    "name": "userProfile",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Get user profile.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "userId",
            "description": "<p>User id required field in query string.</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>success.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>User profile.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User profile.\",\n    \"data\": {\n        \"id\": \"anM1a0FkWGlWUXBwR1ZDUU9iR09XQT09\",\n        \"username\": \"test2\",\n        \"email\": \"test2@gmail.com\",\n        \"gender\": \"Male\",\n        \"dob\": \"01-25-1996\",\n        \"country_code\":\"+91\",\n        \"phone\": \"(789)877878\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"longitude\": 77.391026,\n        \"latitude\": 28.535516,\n        \"matrix_user_id\": \"@test2:35.168.119.247\",\n        \"user_images\": [\n            {\n                \"user_id\": 19,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2017_12_26_15_18_47_20180206133935.png\",\n                \"is_profile\": \"No\",\n                \"order_index\": 1\n            }\n        ],\n        \"friend\": {\n            \"id\": \"MzNNbkN6V05zQ2c1N0ViMVJJeEVqZz09\",\n            \"requested_by\": 10,\n            \"requested_to\": 19,\n            \"requested_status\": \"Requested\",\n            \"friend_status\": null,\n            \"total_friends\": 2\n        },\n        \"created_spaycs\": 3,\n        \"joined_spaycs\": 1\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/user-profile/:userId.json"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ],
        "Error-Response Object": [
          {
            "group": "Error-Response Object",
            "type": "Boolean",
            "optional": false,
            "field": "status",
            "description": "<p>failed.</p>"
          },
          {
            "group": "Error-Response Object",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Message.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n{\n  \"status\": failed,\n  \"message:\"Method not allowed.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
