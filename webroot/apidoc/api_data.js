define({ "api": [
  {
    "type": "post",
    "url": "/spaycs.json",
    "title": "New SPAYC",
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
            "description": "<p>name title of the spayc (Required).</p>"
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
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"name\": \"spaycdev\",\n    \"location\": \"spaycdev@spayc.com\",\n    \"type\": \"XXXXXXXXX\",\n    \"group_type\": \"male|female|other\",\n    \"start_date\": \"2019-01-11 01:02:20\",\n    \"end_date\": \"2019-01-12 01:02:20\",\n    \"passcode\": \"s5d4f87sdf4545\",\n    \"description\":\"spayc creating\",\n    \"image\":\"file.png\",\n    \"longitude\":\"XX.00.XX\",\n    \"latitude\":\"XX.00.XX\"\n}",
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
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Your spayc, Dsfdsfdsf65esd x, has been created.\",\n    \"data\": {\n        \"name\": \"dsfdsfdsf65esd x\",\n        \"location\": \"oaksd lfjlsdasdklfdjsfdfldas\",\n        \"type\": \"Community\",\n        \"group_type\": \"Public\",\n        \"start_date\": \"2018-01-11T11:16:01+00:00\",\n        \"end_date\": \"2018-01-12T09:23:01+00:00\",\n        \"passcode\": \"\",\n        \"description\": \"asdf dsfsd fdsfasdfadfadf\",\n        \"matrix_room_id\": \"!PFzyEQEwQZuLhKCmMW:127.0.0.1\",\n        \"matrix_room_alias\": \"#dsfdsfdsf65esd-x:127.0.0.1\",\n        \"user_id\": 38,\n        \"created\": \"2018-01-11T09:31:50+00:00\",\n        \"modified\": \"2018-01-11T09:31:50+00:00\",\n        \"longitude\":\"XX.00.XX\",\n        \"latitude\":\"XX.00.XX\"\n    }\n}",
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  },
  {
    "type": "get",
    "url": "/spaycs.json?page=:page&latitude=28.4594965&longitude=77.0266383",
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
            "description": "<p>Page number in query string (Required).</p>"
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
            "description": "<p>Group type must be any one from the following Public|Private (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Spayc type must be any one from the following Event|Community (Optional).</p>"
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Spayc lists.\",\n    \"data\": {\n        \"previous\": 4,\n        \"spaycs\": [\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": 1,\n                \"user_id\": 51,\n                \"name\": \"Test\",\n                \"start_date\": \"2018-01-10T06:00:00+00:00\",\n                \"end_date\": \"2018-01-10T06:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [\n                    {\n                        \"spayc_id\": 1,\n                        \"total_comment\": 1\n                    }\n                ],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": 2,\n                \"user_id\": 51,\n                \"name\": \"Test1\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": 3,\n                \"user_id\": 51,\n                \"name\": \"Test12\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Event\",\n                \"group_type\": \"Private\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [\n                    {\n                        \"spayc_id\": 3,\n                        \"subscribed_users\": 1\n                    }\n                ],\n                \"joined_spayc\": [\n                    {\n                        \"spayc_id\": 3,\n                        \"joined_users\": 3,\n                        \"joined_friends\": 2\n                    }\n                ]\n            },\n            {\n                \"distance\": \"22.7463734587819\",\n                \"id\": 4,\n                \"user_id\": 51,\n                \"name\": \"Test123\",\n                \"start_date\": \"2018-01-10T01:00:00+00:00\",\n                \"end_date\": \"2018-01-11T11:00:00+00:00\",\n                \"image\": \"img.png\",\n                \"type\": \"Community\",\n                \"group_type\": \"Public\",\n                \"status\": \"Active\",\n                \"latitude\": 28.535516,\n                \"longitude\": 77.391026,\n                \"created\": \"2018-01-10T00:00:00+00:00\",\n                \"modified\": \"2018-01-10T00:00:00+00:00\",\n                \"comments\": [],\n                \"subscribed_users\": [],\n                \"joined_spayc\": []\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spaycs.json?page=:page&latitude=28.4594965&longitude=77.0266383"
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
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
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Login done successfully.\",\n    \"data\": {\n        \"username\": \"skumar2 aa dds\",\n        \"email\": \"subhash.kumadr2aadds@kiwitech.com\",\n        \"gender\": \"male\",\n        \"dob\": \"2000-02-02\",\n        \"phone\": \"\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"device_id\": \"VOYANVLOXG\",\n        \"matrix_user_id\": \"@skumar2_aa_dds:127.0.0.1\",\n        \"token\": \"7f39fa7c6642666c6802f0d4e2fddf6a695fc12458733764c64ad338d6d1ca5f\",\n        \"matrix_token\": \"MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMmNjaWQgdXNlcl9pZCA9IEBza3VtYXIyX2FhX2RkczoxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSA4Ok00T3VzN1h5cnlKUEBxCjAwMmZzaWduYXR1cmUg5JCNFFzLQ4N-K6MnNWqFfqQdueyPiR74U_r6qLUzrqAK\"\n    }\n}",
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
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
            "description": "<p>Date of birth must in in format YYYY-MM-DD (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of user like any one (male,femal,other) (Required).</p>"
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
        "content": "\n{\n   \"username\": \"spaycdev\",\n   \"email\": \"spaycdev@spayc.com\",\n   \"password\": \"XXXXXXXXX\",\n   \"confirm_password\": \"XXXXXXXXX\",\n   \"gender\": \"male|female|other\",\n   \"phone\": \"7876565434\",\n   \"dob\": \"11-12-2000\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n   \"dob\": \"2000-11-12\",\n   \"latitude\": \"28.535516\",\n   \"longitude\": \"77.391026\"\n}",
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
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\": \"spaycdev\",\n         \"email\": \"spaycdev@spayc.com\",\n         \"gender\": \"male|female|other\",\n         \"phone\": \"7876565434\",\n         \"dob\": \"11-12-2000\",\n         \"device_id\":\"DATEOSDEVICEIP\"\n         \"dob\": \"2000-11-12\"\n      }\n  ]\n}",
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
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
            "description": "<p>Date of birth must in this format YYYY-MM-DD (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender of user like any one (male,femal,other) (Required).</p>"
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
        "content": "\n{\n   \"username\":\"spayc\",\n   \"dob\": \"2000-11-12\",\n   \"gender\": \"male|female|other\",\n   \"phone\": \"XXXXXXXXXX\",\n   \"address\": \"b-3 noida\",\n   \"website_url\":\"www.spayc.com\",\n   \"bio_data\":\"your bio data\",\n}",
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
          "content": "    HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\":\"spayc\",\n         \"dob\": \"2000-11-12\",\n         \"gender\": \"male|female|other\",\n         \"phone\": \"XXXXXXXXXX\",\n         \"address\": \"b-3 noida\",\n         \"website_url\":\"www.spayc.com\",\n         \"bio_data\":\"your bio data\",\n      }\n  ]\n}",
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
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
            "description": "<ul> <li>User facebook unique id required in body(Required).</li> </ul>"
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
            "field": "dob",
            "description": "<ul> <li>Date of birth optional in body.</li> </ul>"
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
            "description": "<ul> <li>Gender of user like any one (male,femal,other) (Required).</li> </ul>"
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
          "content": "       HTTP/1.1 success\n{\n    \"status\": \"success\",\n    \"message\": \"Saved successfully.\",\n    \"data\": {\n        \"username\": \"spayc\",\n        \"email\": \"spayc@gmail.com\",\n        \"gender\": \"male                                              \",\n        \"dob\": \"2001-12-11\",\n        \"phone\": null,\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"device_id\": \"xxxxxxxxxxxxxxxxxx\",\n        \"matrix_user_id\": \"@sbsharma11:35.168.119.247\",\n        \"token\": \"130d5b5d52f8b283a2705d5aa45ebd15f378a0763f6b369832c2dbe338e2369b\",\n        \"matrix_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyZGNpZCB1c2VyX2lkID0gQHNic2hhcm1hMTE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAzZ2sxO1lJaDpfKzcuIzA4CjAwMmZzaWduYXR1cmUg_yk9Mt0_mur_yf6ZZT6sE7ybmtiMEID2xiDSqwQzLW\n    }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"fb_id\":\"xxxxxxxxxxxx\",\n   \"username\":\"spayc\",\n   \"email\":\"spayc@gmail.com\",\n   \"dob\":\"12-11-2001\",\n   \"gender\":\"male|female|other\",\n   \"phone\": \"XXXXXXXXXX\",\n   \"device_id\":\"xxxxxxxxxxxxxxxxxx\",\n   \"latitude\": \"28.535516\",\n  \"longitude\": \"77.391026\"\n}",
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
          "content": "  \n {\n\"status\": false,\n\"errors\": \"fb_id:Facebook id is required field.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
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
    "type": "get",
    "url": "/users.json",
    "title": "View Details",
    "version": "0.1.0",
    "name": "getUsers",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>View user details.</p>",
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
            "description": "<p>Profile details.</p>"
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Profile details\",\n    \"data\": {\n        \"username\": \"dhiruns3\",\n        \"email\": \"dhiru3@gmail.com\",\n        \"gender\": null,\n        \"phone\": 8484839392,\n        \"dob\": \"02-05-2000\",\n        \"status\": \"active\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"created\": \"2018-01-09T11:00:21+00:00\",\n        \"modified\": \"2018-01-09T11:00:21+00:00\"\n    }\n}",
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
          "content": "  \n{\n  \"status\": failed,\n  \"errors:{Validation errors}\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Resource not found.\"\n}\n{\n   \"status\": failed,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    }
  }
] });
