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
    "type": "delete",
    "url": "/spaycs/delete.json?id=:room_id",
    "title": "Delete Space/Subspace",
    "version": "0.1.0",
    "name": "DeleteSpace",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Delete space or subspace with room id.Matrix room also deleted.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<p>A registered token must be in header.</p>"
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
            "description": "<p>Either spayc id or matrix room id(Required).</p>"
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
            "description": "<p>The spayc has been deleted.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 201 OK\n{\n    \"response\": {\n        \"status\": \"success\",\n        \"message\": \"The spayc has been deleted.\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spaycs/delete.json?id=:room_id"
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
    "url": "/spayc-edit.json",
    "title": "Edit Spayc|Subspayc",
    "version": "0.1.0",
    "name": "PostEditSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Update spayc or subspayc.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<p>A token send by header as TOKEN</p>"
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
            "description": "<p>id either spayc id or matrix room id (Required).</p>"
          },
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
        "content": "{\n    \"spayc_id\": \"XXXXXXX\",\n    \"name\": \"spaycdev\",\n    \"location\": \"Community addrss\",\n    \"type\": \"Event|Community\",\n    \"group_type\": \"Public|Private\",\n    \"start_date\": \"01-11-2019 01:02:20\",\n    \"end_date\": \"01-12-2019 01:02:20\",\n    \"passcode\": \"s5d4f87sdf4545\",\n    \"description\":\"spayc creating\",\n    \"image\":\"file.png\",\n    \"longitude\":\"XX.00.XX\",\n    \"latitude\":\"XX.00.XX\",\n    \"invite\":\"@test2:35.168.119.247, @test3:35.168.119.247\"\n}",
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
            "description": "<p>The spayc has been updated successfully.</p>"
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
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"The spayc has been updated successfully.\",\n    \"data\": {\n        \"name\": \"Festive\",\n        \"location\": \"Your address\",\n        \"type\": \"Event\",\n        \"group_type\": \"Public\",\n        \"start_date\": \"2019-01-11T01:02:20+00:00\",\n        \"end_date\": \"2019-01-11T01:08:20+00:00\",\n        \"passcode\": \"\",\n        \"description\": \"Holi is a festival of color #color #festival\",\n        \"image\": \"\",\n        \"longitude\": 77.209021,\n        \"latitude\": 28.613939,\n        \"invite\": \"@test2:35.168.119.247\",\n        \"status\": \"Active\",\n        \"matrix_room_id\": \"!JqhnnrWCtlFTnWlwWL:35.168.119.247\",\n        \"matrix_room_alias\": \"#Holi13:35.168.119.247\",\n        \"user_id\": \"10\",\n        \"created\": \"2018-02-16T11:02:47+00:00\",\n        \"modified\": \"2018-02-16T11:02:47+00:00\",\n        \"id\": \"95\"\n    }\n}",
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
            "field": "Invalid",
            "description": "<p>spayc  id.</p>"
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
        "url": "http://spayc.com/api/spayc-edit.json"
      }
    ]
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
        "content": "{\n    \"name\": \"spaycdev\",\n    \"location\": \"Community addrss\",\n    \"type\": \"Event|Community\",\n    \"group_type\": \"Public|Private\",\n    \"start_date\": \"01-11-2019 01:02:20\",\n    \"end_date\": \"01-12-2019 01:02:20\",\n    \"passcode\": \"s5d4f87sdf4545\",\n    \"description\":\"spayc creating\",\n    \"image\":\"file.png\",\n    \"longitude\":\"XX.00.XX\",\n    \"latitude\":\"XX.00.XX\",\n    \"invite\":\"@test2:35.168.119.247, @test3:35.168.119.247\"\n}",
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
    "type": "post",
    "url": "/create-subspace.json",
    "title": "Create SubSpayc",
    "version": "0.1.0",
    "name": "PostSubspayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Create a new sub SPAYC.Sub space type,start_date,end_date,longitude,latitude will same as of parent type.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<p>A registered token must be in header.</p>"
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
            "field": "parent_matrix_room_id",
            "description": "<p>Matrix parent room id (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Title of subspace (Required).</p>"
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
            "field": "invite",
            "description": "<p>Matrix user id must in comma separated if more thant one invitees(Optional).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"parent_matrix_room_id\": \"!gERqTLZjHXyDAlCPhC:127.0.0.1\",\n    \"name\": \"devsubspacePMB\",\n    \"group_type\": \"Public|Private\",\n    \"passcode\": \"s5d4f87sdf4545\",\n    \"description\":\"spayc creating\",\n    \"image\":\"file.png\",\n    \"invite\":\"@test2:35.168.119.247, @test3:35.168.119.247\"\n}",
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
            "description": "<p>SubSpayc DevsubspacePMB created successfully.</p>"
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
          "content": "    HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"SubSpayc DevsubspacePMB created successfully.\",\n    \"data\": {\n        \"parent_matrix_room_id\": \"!gERqTLZjHXyDAlCPhC:127.0.0.1\",\n        \"name\": \"devsubspacePMB\",\n        \"description\": \"devspace\",\n        \"group_type\": \"Public\",\n        \"invitee\": \"\",\n        \"passcode\": \"\",\n        \"image\": \"https://spayc-qa.s3.amazonaws.com/room/screenshot_from_2017_12_12_19_55_12_20180223142752.png\",\n        \"status\": \"Active\",\n        \"start_date\": \"03-11-2018 09:16:00\",\n        \"end_date\": \"03-12-2018 09:23:00\",\n        \"latitude\": 53.369,\n        \"longitude\": 25.369,\n        \"type\": \"Community\",\n        \"matrix_token\": \"MDAxN2xvY2F0aW9uIDEyNy4wLjAuMQowMDEzaWRlbnRpZmllciBrZXkKMDAxMGNpZCBnZW4gPSAxCjAwMjZjaWQgdXNlcl9pZCA9IEBkZXZ0ZXN0YToxMjcuMC4wLjEKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAmMjZfRUI9VlRTej1QblNmCjAwMmZzaWduYXR1cmUgMN05HYWhM71ysg2rTIM2cZUjWny270EnAM8EsILZ1k8K\",\n        \"matrix_room_id\": \"!UoVWeZsYeLqGUHVULq:127.0.0.1\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/create-subspace.json"
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
    "url": "/spayc-members.json",
    "title": "List of Spayc Member",
    "version": "0.1.0",
    "name": "getSpaycMember",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Spayc member to find the list of users associated with the room.Method must be get.In case of invalid spayc id return ivalid request</p>",
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
            "field": "room_id",
            "description": "<p>Spayc matrix id in query string (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status of user, value must be any one from following(Pending|Joined) (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Digit",
            "optional": false,
            "field": "page",
            "description": "<p>Page no(Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Digit",
            "optional": false,
            "field": "limit",
            "description": "<p>No of record to retrieve(Optional).</p>"
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
            "description": "<p>List of spayc member.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Object of User details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"List of spayc member.\",\n    \"data\": {\n        \"count\": 4,\n        \"records\": [\n            {\n                \"username\": \"devtestAA\",\n                \"email\": \"devtestAA@kiwitech.com\",\n                \"gender\": \"Male                                              \",\n                \"dob\": \"02-25-2005\",\n                \"country_code\": null,\n                \"phone\": \"\",\n                \"website_url\": null,\n                \"address\": null,\n                \"bio_data\": null,\n                \"longitude\": \"21.253\",\n                \"latitude\": \"25.256\",\n                \"matrix_user_id\": \"@devtestaa:127.0.0.1\",\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/4_20180220071137.png\",\n                \"user_id\": \"10\",\n                \"is_admin\": 0,\n                \"requested_status\": \"Joined\",\n                \"is_subscribed\": false,\n                \"physically_present\": false\n            },\n            {\n                \"username\": \"devtestAB\",\n                \"email\": \"devtestAB@kiwitech.com\",\n                \"gender\": \"Male                                              \",\n                \"dob\": \"02-25-2005\",\n                \"country_code\": null,\n                \"phone\": \"\",\n                \"website_url\": null,\n                \"address\": null,\n                \"bio_data\": null,\n                \"longitude\": \"21.253\",\n                \"latitude\": \"25.256\",\n                \"matrix_user_id\": \"@devtestab:127.0.0.1\",\n                \"image_url\": \"\",\n                \"user_id\": \"11\",\n                \"is_admin\": 0,\n                \"requested_status\": \"Joined\",\n                \"is_subscribed\": false,\n                \"physically_present\": false\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spayc-members.json"
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
    "description": "<p>Filter spayc all list, created by logged in user and joined by logged in user using list_by parameter, distance param not comes in response if lat long not provided in request.</p>",
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
            "field": "latitude",
            "description": "<p>Latitude is required in query string(Optional in case of created, joined).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude is required in query string(Optional in case of created, joined).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "list_by",
            "description": "<p>List by is optional in query string(created|joined|all).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id  of any user and if id is not available it will get the logged user data(Required).</p>"
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Spayc lists.\",\n    \"data\": {\n        \"count\": 22,\n        \"spaycs\": [\n            {\n                \"distance\": \"0\",\n                \"id\": \"33\",\n                \"name\": \"spaycdev13\",\n                \"location\": \"Your address\",\n                \"matrix_room_id\": \"!asfLdzLnOdGRkdPZWu:localhost\",\n                \"start_date\": \"01-11-2019 01:02:00\",\n                \"end_date\": \"01-12-2019 01:02:00\",\n                \"image\": \"\",\n                \"type\": \"Community\",\n                \"group_type\": \"Public\",\n                \"passcode\": \"\",\n                \"subscribed_users\": 0,\n                \"friends\": 0,\n                \"joined_spayc_status\": null,\n                \"is_joined\": false,\n                \"joined_users\": 0,\n                \"is_subscribed\": false,\n                \"total_comments\": 0,\n                \"total_presents\": 0\n            },\n            {\n                \"distance\": \"0\",\n                \"id\": \"5\",\n                \"name\": \"spaycdev13\",\n                \"location\": \"Your address\",\n                \"matrix_room_id\": \"!asfLdzLnOdGRkdPZWu:localhost\",\n                \"start_date\": \"01-11-2019 01:02:00\",\n                \"end_date\": \"01-12-2019 01:02:00\",\n                \"image\": \"\",\n                \"type\": \"Event\",\n                \"group_type\": \"Public\",\n                \"passcode\": \"s5d4f87sdf4545\",\n                \"subscribed_users\": 1,\n                \"friends\": 0,\n                \"joined_spayc_status\": \"Pending\",\n                \"is_joined\": false,\n                \"joined_users\": 3,\n                \"is_subscribed\": true,\n                \"total_comments\": 1,\n                \"total_presents\": 0\n            }\n        ]\n    }\n}",
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
    "url": "/subspaycs.json?spayc_id=:id&page=:page&limit=:limit&latitude=:latitude&longitude=:longitude",
    "title": "Sub-Spayc Lists",
    "version": "0.1.0",
    "name": "getSubSpaycs",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Get all sub spaycs for spayc.If user_id key is not available then proccess will be mapped with logged user id.Argument will be as query string.</p>",
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
            "description": "<p>Parent spayc id either spayc id or matrix room id (Required).</p>"
          },
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
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude of current user (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude of current user (Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>If user id is not available, logged user id will used to proccess the request(Optional).</p>"
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
            "description": "<p>List of subspayc.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>List of subspayc.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"List of subspayc.\",\n    \"data\": [\n        {\n            \"id\": \"95\",\n            \"name\": \"My Sub 8 March\",\n            \"location\": null,\n            \"matrix_room_id\": \"!xLfsiKaFDCBlLNyuAi:spayc-dev.kiwireader.com\",\n            \"start_date\": \"03-07-2018 18:32:16\",\n            \"end_date\": \"04-07-2018 18:32:34\",\n            \"image\": null,\n            \"type\": \"Event\",\n            \"group_type\": \"Public\",\n            \"passcode\": \"\",\n            \"user_id\": 6,\n            \"distance\": \"8266.679\",\n            \"subscribed_users\": 0,\n            \"friends\": 0,\n            \"joined_spayc_status\": null,\n            \"is_joined\": false,\n            \"joined_users\": 0,\n            \"is_subscribed\": false,\n            \"total_comments\": 0\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/subspaycs.json?spayc_id=:id&page=:page&limit=:limit&latitude=:latitude&longitude=:longitude"
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
    "url": "/ban-spayc-member.json",
    "title": "Ban Spayc Member",
    "version": "0.1.0",
    "name": "postBanSpaycMember",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Admin can ban spayc joined member and super admin can ban admin and spayc member also.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Current timezone</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "spayc_id",
            "description": "<p>Existing Spayc id(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "user_id",
            "description": "<p>Member id of joined spayc(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status must be any one Banned (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"spayc_id\":\"66\",\n    \"user_id\":\"9\",\n    \"status\":\"Joined\"\n}",
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
            "description": "<p>User has been {status} successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User has been {status} successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/ban-spayc-member.json"
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
    "url": "/change-role.json",
    "title": "Make Member As Admin",
    "version": "0.1.0",
    "name": "postChangeRole",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Make existing spayc (Room) member as admin for that spayc.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Current timezone</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "spayc_id",
            "description": "<p>Existing Spayc id(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "user_id",
            "description": "<p>Existing User id(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "role",
            "description": "<p>Status must be 1 for admin or 0 for remove member from admin role(Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"spayc_id\":\"xx\",\n    \"user_id\":\"xx\",\n    \"role\":\"1\"\n}",
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
            "description": "<p>Role has been changed successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Role has been changed successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/change-role.json"
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
    "url": "/join-spayc.json",
    "title": "Join spayc",
    "version": "0.1.0",
    "name": "postJoinSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Join public and private spayc.For private spayc required passcode to join the spayc directly but due to some technical problem this will not work rest request will be proccessed.In case of private room if passcode is available status must be Joined else status will be Pending.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Current timezone</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "spayc_id",
            "description": "<p>Existing Spayc id(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status must be any one Joined,Pending (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passcode",
            "description": "<p>passcode is required in case of private spayc (Optional).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\t\"spayc_id\":\"66\",\n\t\"status\":\"Joined\"\n}",
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
            "description": "<p>User has been {status} successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User has been {status} successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/join-spayc.json"
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
    "url": "/join-sub-spayc.json",
    "title": "Join sub spayc",
    "version": "0.1.0",
    "name": "postJoinSubSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Join public and private sub spayc.For private sub spayc required passcode to join the sub spayc directly but due to some technical problem this will not work rest request will be proccessed.In case of private room if passcode is available status must be Joined else status will be Pending.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN</li> </ul>"
          },
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Current timezone</li> </ul>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Intger",
            "optional": false,
            "field": "spayc_id",
            "description": "<p>Existing Spayc id(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Status must be any one Joined,Pending (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "passcode",
            "description": "<p>Passcode is required in case of private sub spayc (Optional).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\t\"spayc_id\":\"66\",\n\t\"status\":\"Joined\",\n        \"passcode\":\"code\"\n}",
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
            "description": "<p>User has been {status} successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "    HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User has been {status} successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/join-sub-spayc.json"
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
    "url": "/unsubscribe-spayc.json",
    "title": "UnSubscribe a Spayc",
    "version": "0.1.0",
    "name": "postUnSubscribeSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "Private"
      }
    ],
    "description": "<p>User has been un-subscribed a spayc by providing the existing spayc id.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token must be in header</li> </ul>"
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
            "description": "<p>Id either spayc id or matrix room id (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"spayc_id\":\"XXXXX\"\n}",
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
            "description": "<p>User has been unsubcribed successfully.</p>"
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
          "content": "       HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User has been unsubcribed successfully.\"\n}",
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
            "description": "<p>has not yet subscribed.</p>"
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
        "url": "http://spayc.com/api/unsubscribe-spayc.json"
      }
    ]
  },
  {
    "type": "get",
    "url": "/spayc-details.json?id=:id&latitude=:lat&longitude=:long",
    "title": "About Spayc",
    "version": "0.1.0",
    "name": "spaycDetails",
    "group": "Spayc",
    "permission": [
      {
        "name": "private"
      }
    ],
    "description": "<p>Spayc details by id and latitude, longitude (distance param not comes in response if lat long not provided in request).</p>",
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
            "field": "id",
            "description": "<p>Spayc matrix id in query string (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<p>Latitude is optional in query string(Optional).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Longitude is optional in query string(Optional).</p>"
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Spayc Details.\",\n    \"data\": {\n        \"id\": \"3\",\n        \"name\": \"devsubspacePMB\",\n        \"location\": \"dfasdf sdf sdfsdfsd\",\n        \"image\": \"https://spayc-qa.s3.amazonaws.com/room/screenshot_from_2017_12_12_19_55_12_20180223141832.png\",\n        \"description\": \"devspace\",\n        \"group_type\": \"Public\",\n        \"type\": \"Community\",\n        \"start_date\": \"03-11-2018 09:16:00\",\n        \"end_date\": \"03-12-2018 09:23:00\",\n        \"passcode\": \"\",\n        \"matrix_room_id\": \"!AHKKnrKlWnBiewiMiB:127.0.0.1\",\n        \"subscribed_users\": 0,\n        \"sub_spaycs\": [\n            {\n                \"id\": 45,\n                \"parent_id\": 3,\n                \"name\": \"devsubspacePMB\",\n                \"location\": null,\n                \"image\": null,\n                \"description\": \"devspace\",\n                \"group_type\": \"Public\",\n                \"type\": \"Community\",\n                \"start_date\": \"2018-03-11T09:16:00+00:00\",\n                \"end_date\": \"2018-03-12T09:23:00+00:00\",\n                \"passcode\": \"\",\n                \"matrix_room_id\": \"!gERdbhptfHdVQrcnse:127.0.0.1\"\n            }\n        ],\n        \"friends\": 0,\n        \"joined_spayc_status\": \"Joined\",\n        \"joined_users\": 1,\n        \"is_subscribed\": false,\n        \"total_comments\": 0,\n        \"total_presents\": 0\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/spayc.js",
    "groupTitle": "Spayc",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/spayc-details.json?id=:id&latitude=:lat&longitude=:long"
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
    "title": "Subscribe a Spayc",
    "version": "0.1.0",
    "name": "subscribeSpayc",
    "group": "Spayc",
    "permission": [
      {
        "name": "Private"
      }
    ],
    "description": "<p>User has been subscribed a spayc by providing the existing spayc id.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token must be in header</li> </ul>"
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
            "description": "<p>Id either spayc id or matrix room id (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"spayc_id\":\"XXXXX\"\n}",
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
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "friend_status",
            "description": "<p>Friend status and status must be either one from following 'Pending', 'Accepted', 'Blocked','is_direct','Decline','Unfriend' (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"friend_id\":\"NDIwMjYwMjAwLjU2\",\n    \"friend_status\":\"Pending\"\n}",
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
          "content": "HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend request send successfully.\",\n    \"data\": {\n        \"id\": \"9\",\n        \"requested_by\": 2,\n        \"requested_to\": 3,\n        \"requested_status\": \"Blocked\",\n        \"action_by\": \"2\"\n    }\n}",
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
            "description": "<p>Status in query string must be any one from the following(Pending, Accepted, 'Declined',Blocked, Unfriend).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>User id  of any user and if id is not available it will get the logged user data(Required).</p>"
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
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Friend lists.\",\n    \"data\": {\n        \"count\": 4,\n        \"records\": [\n            {\n                \"id\": \"8\",\n                \"username\": \"user3\",\n                \"matrix_user_id\": null,\n                \"matrix_access_token\": null,\n                \"friend\": {\n                    \"id\": \"42\",\n                    \"requested_by\": \"10\",\n                    \"requested_to\": \"8\",\n                    \"requested_status\": \"Pending\"\n                },\n                \"matrix_room_id\": null,\n                \"image_url\": \"\"\n            },\n            {\n                \"id\": \"9\",\n                \"username\": \"user2\",\n                \"matrix_user_id\": null,\n                \"matrix_access_token\": null,\n                \"friend\": {\n                    \"id\": \"63\",\n                    \"requested_by\": \"10\",\n                    \"requested_to\": \"9\",\n                    \"requested_status\": \"Pending\"\n                },\n                \"matrix_room_id\": \"!ICbUbLzaoTzIvIoEjf:35.168.119.247\",\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226075827.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\"\n            },\n            {\n                \"id\": \"17\",\n                \"username\": \"user1\",\n                \"matrix_user_id\": null,\n                \"matrix_access_token\": null,\n                \"friend\": {\n                    \"id\": \"1\",\n                    \"requested_by\": \"10\",\n                    \"requested_to\": \"17\",\n                    \"requested_status\": \"Pending\"\n                },\n                \"matrix_room_id\": null,\n                \"image_url\": \"\"\n            },\n            {\n                \"id\": \"19\",\n                \"username\": \"test2\",\n                \"matrix_user_id\": \"@test2:35.168.119.247\",\n                \"matrix_access_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyOGNpZCB1c2VyX2lkID0gQHRlc3QyOjM1LjE2OC4xMTkuMjQ3CjAwMTZjaWQgdHlwZSA9IGFjY2VzcwowMDIxY2lkIG5vbmNlID0gMVJKXjJSTEs3Klc9LmhyQAowMDJmc2lnbmF0dXJlIMyd1A3UtgJZEWcmvehB84AboRIZrFb46AqHTrn4Y2reCg\",\n                \"friend\": {\n                    \"id\": \"43\",\n                    \"requested_by\": \"10\",\n                    \"requested_to\": \"19\",\n                    \"requested_status\": \"Accepted\"\n                },\n                \"matrix_room_id\": \"kjljkljljll54\",\n                \"image_url\": \"\"\n            }\n        ]\n    }\n}",
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
    "url": "/update-user-status.json",
    "title": "Update User Physical Presence",
    "version": "0.1.0",
    "name": "PostUpdateUserStatus",
    "group": "User",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Update physical presence of user.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be set in header.</p>"
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
            "field": "latitude",
            "description": "<p>Current user location latitude.(Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<p>Current user location longitude.(Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"latitude\":\"45.25895656565656\",\n    \"longitude\":\"25.265656565656\"\n}",
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
            "description": "<p>Request has been updated successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Request has been updated successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/update-user-status.json"
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
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<ul> <li>latitude of user address (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<ul> <li>longitude of user address (Optional).</li> </ul>"
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
          "content": "     HTTP/1.1 201 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"id\": \"35\",\n         \"username\": \"spaycdev\",\n         \"email\": \"spaycdev@spayc.com\",\n         \"gender\": \"male|female|other\",\n         \"country_code\":\"+91\",\n         \"phone\": \"(XXX) (XXXXXXX)\",\n         \"dob\": \"11-12-2000\",\n         \"latitude\": \"XX.XXXXXX\",\n         \"longitude\": \"XX.XXXXXX\"\n      }\n  ]\n}",
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
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<ul> <li>Latitude of user address (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<ul> <li>Longitude of user address (Optional).</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"username\":\"spayc\",\n   \"dob\": \"12-11-2001\",\n   \"gender\": \"Male|Female|Other\",\n   \"country_code\":\"+91\",\n   \"phone\": \"XXXXXXXXXX\",\n   \"address\": \"spayc address\",\n   \"website_url\":\"www.spayc.com\",\n   \"bio_data\":\"your bio data\",\n   \"latitude\":\"XX.00\",\n   \"longitude\":\"XX.00\",\n}",
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
          "content": "    HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\":\"spayc\",\n         \"dob\": \"12-11-2001\",\n         \"gender\": \"Male|Female|Other\",\n         \"country_code\":\"+91\",\n         \"phone\": \"XXXXXXXXXX\",\n         \"address\": \"spayc address\",\n         \"website_url\":\"www.spayc.com\",\n         \"bio_data\":\"your bio data\",\n         \"longitude\": \"XX.00\",\n         \"latitude\": \"XX.00\"\n      }\n  ]\n}",
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
        "content": "\n{\n   \"old_password\": \"password@123\",\n   \"new_password\": \"newPassword@123\",\n   \"confirm_password\": \"newPassword@123\"\n}",
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
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<ul> <li>latitude of user address (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<ul> <li>longitude of user address (Optional).</li> </ul>"
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
          "content": "       HTTP/1.1 201 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Saved successfully.\",\n    \"data\": {\n        \"id\": \"25\",\n        \"username\": \"spayc\",\n        \"email\": \"user@domain.com\",\n        \"gender\": \"Male\",\n        \"dob\": \"11-12-2000\",\n        \"phone\": null,\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"device_id\": \"xxxxxxxxxxxxxxxxxx\",\n        \"matrix_user_id\": \"@spayc11:35.168.119.247\",\n        \"token\": \"130d5b5d52f8b283a2705d5aa45ebd15f378a0763f6b369832c2dbe338e2369b\",\n        \"matrix_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyZGNpZCB1c2VyX2lkID0gQHNic2hhcm1hMTE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSAzZ2sxO1lJaDpfKzcuIzA4CjAwMmZzaWduYXR1cmUg_yk9Mt0_mur_yf6ZZT6sE7ybmtiMEID2xiDSqwQzLW\n    }\n}",
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
    "url": "/get-notifications.json?page=:page&limit=:limit",
    "title": "Get Notifications",
    "version": "0.1.0",
    "name": "getNotifications",
    "group": "User",
    "permission": [
      {
        "name": "none"
      }
    ],
    "description": "<p>get all notifications received by loggin user.</p>",
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
            "description": "<p>Notification Lists..</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Notification Lists.\",\n    \"data\": {\n        \"count\": 3,\n        \"notification\": [\n            {\n                \"id\": \"3\",\n                \"date_time\": \"03-01-2018 18:44:52\",\n                \"message\": \"Friend Request Sent\",\n                \"notification_type\": \"Friend Request Sent\",\n                \"space_name\": null,\n                \"room_id\": null,\n                \"spayc_image\": null,\n                \"username\": \"dhir\",\n                \"user_id\": \"10\",\n                \"user_image\": \"https://spayc-qa.s3.amazonaws.com/profile/screenshot_from_2018_02_02_12_10_56_20180207100523_20180301064300.png\",\n                \"is_unread\": true\n            },\n            {\n                \"id\": \"1\",\n                \"date_time\": \"02-28-2018 20:51:41\",\n                \"message\": \"you are added a friend\",\n                \"notification_type\": \"request accepted\",\n                \"space_name\": \"spaycdev9\",\n                \"room_id\": \"@matrixdeeee\",\n                \"spayc_image\": \"abc.png\",\n                \"username\": \"sbsharma11243\",\n                \"user_id\": \"9\",\n                \"user_image\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226075827.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\",\n                \"is_unread\": true\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/get-notifications.json?page=:page&limit=:limit"
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
    "description": "<p>Search users|spaycs|hashtags details by requesting parameters Note: distance key not came in spayc list in case of no latitude and longitude.</p>",
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
            "description": "<ul> <li>Page number in query string (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "limit",
            "description": "<ul> <li>Records limit in query string (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<ul> <li>Type should be in (users|spaycs|hashtags|all) (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keyword",
            "description": "<ul> <li>Username|Spayc name|Hashtag name in query string to be search (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "latitude",
            "description": "<ul> <li>Latitude of user address (Optional).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "longitude",
            "description": "<ul> <li>Longitude of user address (Optional).</li> </ul>"
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Search Lists.\",\n    \"data\": {\n        \"users\": {\n            \"count\": 26,\n            \"records\": [\n                {\n                    \"id\": \"5\",\n                    \"username\": \"user1\",\n                    \"email\": \"user1@domain.com\",\n                    \"matrix_user_id\": null,\n                    \"friend\": {\n                        \"id\": \"57\",\n                        \"requested_by\": \"17\",\n                        \"requested_to\": \"5\",\n                        \"requested_status\": \"Pending\",\n                        \"total_friends\": 0\n                    },\n                    \"matrix_room_id\": \"!asfLdzLnOdGRkdd4dPZWu:localhost\",\n                    \"image_url\": \"\"\n                },\n                {\n                    \"id\": \"7\",\n                    \"username\": \"user2\",\n                    \"email\": \"user2@domain.com\",\n                    \"matrix_user_id\": null,\n                    \"friend\": {\n                        \"total_friends\": 0\n                    },\n                    \"matrix_room_id\": null,\n                    \"image_url\": \"\"\n                }\n            ]\n        },\n        \"spaycs\": {\n            \"count\": 22,\n            \"records\": [\n                {\n                    \"distance\": \"15.5999136892407\",\n                    \"id\": \"33\",\n                    \"name\": \"spaycdev13\",\n                    \"location\": \"Your address\",\n                    \"matrix_room_id\": \"!asfLdzLnOdGRkdPZWu:localhost\",\n                    \"start_date\": \"01-11-2019 01:02:00\",\n                    \"end_date\": \"01-12-2019 01:02:00\",\n                    \"image\": \"\",\n                    \"type\": \"Community\",\n                    \"group_type\": \"Public\",\n                    \"passcode\": \"\",\n                    \"subscribed_users\": 1,\n                    \"joined_spayc_status\": null,\n                    \"is_joined\": false,\n                    \"joined_users\": 0,\n                    \"is_subscribed\": false\n                },\n                {\n                    \"distance\": \"15.5999136892407\",\n                    \"id\": \"32\",\n                    \"name\": \"spaycdev13\",\n                    \"location\": \"Your address\",\n                    \"matrix_room_id\": \"!asfLdzLnOdGRkdPZWu:localhost\",\n                    \"start_date\": \"01-11-2019 01:02:00\",\n                    \"end_date\": \"01-12-2019 01:02:00\",\n                    \"image\": \"\",\n                    \"type\": \"Community\",\n                    \"group_type\": \"Public\",\n                    \"passcode\": \"\",\n                    \"subscribed_users\": 2,\n                    \"joined_spayc_status\": null,\n                    \"is_joined\": false,\n                    \"joined_users\": 1,\n                    \"is_subscribed\": false\n                }\n            ]\n        },\n        \"hashtags\": {\n            \"count\": 33,\n            \"records\": [\n                {\n                    \"id\": \"59\",\n                    \"name\": \"color\",\n                    \"total_space\": 1\n                },\n                {\n                    \"id\": \"65\",\n                    \"name\": \"drink\",\n                    \"total_space\": 1\n                }\n            ]\n        }\n    }\n}",
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
            "field": "friend_id",
            "description": "<p>Requested friend id (Required).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "friend_status",
            "description": "<p>Friend status must any one from following list 'Pending', 'Accepted', 'Blocked','is_direct','Decline','Unfriend' (Required).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n    \"friend_id\":\"NDIwMjYwMjAwLjU2\",\n    \"friend_status\":\"Accepted\"\n}",
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
          "content": "HTTP/1.1 200 OK\n {\n     \"status\": \"success\",\n     \"message\": \"Friend status updated successfully.\",\n     \"data\": {\n         \"id\": \"9\",\n         \"requested_by\": 2,\n         \"requested_to\": 3,\n         \"requested_status\": \"Accepted\",\n         \"action_by\": \"3\"\n     }\n }",
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
    "type": "post",
    "url": "/update-device-token.json",
    "title": "Update device token",
    "version": "0.1.0",
    "name": "updateDeviceToken",
    "group": "User",
    "permission": [
      {
        "name": "required"
      }
    ],
    "description": "<p>Update user device token if push notification turn on and off.</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Token must be set in header.</p>"
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
            "field": "device_token",
            "description": "<p>Device token required field if is_notify is On</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_notify",
            "description": "<p>Is notify is required field possible values(On, Off)</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"device_token\":\"666dc243b1ee08bb68cebe64d0875d9f54bab2be090d456a90e0dac608c12ecf\",\n    \"is_notify\":\"On\"\n}",
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
            "description": "<p>Request has been updated successfully.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Device token updated successfully.\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "apidoc/user.js",
    "groupTitle": "User",
    "sampleRequest": [
      {
        "url": "http://spayc.com/api/update-device-token.json"
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
            "description": "<p>use any one either userid or matrix user id as query string in url(required).</p>"
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
          "content": "       HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"User profile.\",\n    \"data\": {\n        \"id\": \"11\",\n        \"username\": \"user\",\n        \"email\": \"test@domain.com\",\n        \"gender\": \"Female\",\n        \"dob\": null,\n        \"country_code\": null,\n        \"phone\": \"\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"longitude\": 77.391026,\n        \"latitude\": 28.535516,\n        \"matrix_user_id\": null,\n        \"user_images\": [\n            {\n                \"id\": \"55\",\n                \"user_id\": 11,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180223144430.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            },\n            {\n                \"id\": \"56\",\n                \"user_id\": 11,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073256.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            },\n            {\n                \"id\": \"57\",\n                \"user_id\": 11,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073525.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            },\n            {\n                \"id\": \"58\",\n                \"user_id\": 11,\n                \"image_url\": \"https://spayc-qa.s3.amazonaws.com/profile/10394525_777976492246161_2483475814558228669_n_20180226073548.jpg%3Foh%3D5707b76dd66818c461cd37a661184274%26oe%3D5b1e0632\",\n                \"is_profile\": \"No\",\n                \"order_index\": null\n            }\n        ],\n        \"friend\": {\n            \"id\": \"41\",\n            \"requested_by\": \"10\",\n            \"requested_to\": \"11\",\n            \"requested_status\": \"Requested\",\n            \"total_friends\": 0\n        },\n        \"matrix_room_id\": null,\n        \"created_spaycs\": 0,\n        \"joined_spaycs\": 0\n    }\n}",
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
