define({ "api": [
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
    "description": "<p>User login with user name and its password. User get logged in by using username and password including device_id.content-type must be in text/html(form-data)</p>",
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
        "content": "\n{\n   \"username\": \"spaycdev\",\n   \"password\": \"XXXXXXXXX\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n}",
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
          "content": "     HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Login done successfully.\",\n      \"data\": {\n      \"id\": 2,\n      \"first_name\": null,\n      \"last_name\": null,\n       \"username\": \"skumar1\",\n       \"email\": \"subhash.kumar@kiwitech.com\",\n       \"password\": \"$2y$10$ifWTI646naw6MlKiYKfgHOWyktbYyiedGE65GUqzUJOZkFStqs/8q\",\n       \"gender\": \"male\",\n       \"dob\": \"2017-02-02T00:00:00+00:00\",\n       \"phone\": null,\n       \"status\": \"active\",\n       \"website_url\": null,\n       \"address\": null,\n       \"bio_data\": null,\n       \"timezone\": null,\n       \"token_verification\": \"fb2aa2326d1d591e4fa9b1e18c9d064a1a5cda5a\",\n       \"created\": \"2018-01-07T18:10:23+00:00\",\n       \"modified\": \"2018-01-07T18:10:23+00:00\",\n       \"matrix_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyYWNpZCB1c2VyX2lkID0gQHNrdW1hcjE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSBzRU5DbFBha1M5ODZBcmU3CjAwMmZzaWduYXR1cmUgSEoBVpO2GifQmZV6_miQMI1SmrEAin2GSQ_CO39AOKwK\",\n       \"access_token\": \"MDAxY2xvY2F0aW9uIDM1LjE2OC4xMTkuMjQ3CjAwMTNpZGVudGlmaWVyIGtleQowMDEwY2lkIGdlbiA9IDEKMDAyYWNpZCB1c2VyX2lkID0gQHNrdW1hcjE6MzUuMTY4LjExOS4yNDcKMDAxNmNpZCB0eXBlID0gYWNjZXNzCjAwMjFjaWQgbm9uY2UgPSBzRU5DbFBha1M5ODZBcmU3CjAwMmZzaWduYXR1cmUgSEoBVpO2GifQmZV6_miQMI1SmrEAin2GSQ_CO39AOKwK\", * * *\n       \"home_server\": \"35.168.119.247\",\n       \"user_id\": \"@skumar1:35.168.119.247\",\n       \"device_id\": \"XJHZZQIWEV\"\n   }\n  ]\n}",
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
            "description": "<p>login credentials..</p>"
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
    "title": "Register a User",
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
        "content": "\n{\n   \"username\": \"spaycdev\",\n   \"email\": \"spaycdev@spayc.com\",\n   \"password\": \"XXXXXXXXX\",\n   \"gender\": \"male|female|other\",\n   \"phone\": \"7876565434\",\n   \"dob\": \"2000-11-12\",\n   \"device_id\":\"DATEOSDEVICEIP\"\n}",
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
          "content": "     HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\": \"spaycdev\",\n         \"email\": \"spaycdev@spayc.com\",\n         \"password\": \"XXXXXXXXX\",\n         \"gender\": \"male|female|other\",\n         \"phone\": \"7876565434\",\n         \"dob\": \"2000-11-12\",\n         \"device_id\":\"DATEOSDEVICEIP\"\n      }\n  ]\n}",
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
    "title": "Update an user",
    "version": "0.1.0",
    "name": "PutUser",
    "group": "User",
    "permission": [
      {
        "name": "Private User"
      }
    ],
    "description": "<p>Update profile of existing user. Update user own profile details with form-data option.</p>",
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
        "content": "\n{\n   \"username\":\"spayc\",\n   \"dob\": \"2000-11-12\",\n   \"gender\": \"male|female|other\",\n   \"phone\": \"7876565434\",\n   \"address\": \"b-3 noida\",\n   \"website_url\":\"www.spayc.com\",\n   \"bio_data\":\"your bio data\",\n}",
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
          "content": "    HTTP/1.1 200 OK\n{\n  \"status\": \"success\",\n  \"message\": \"Saved successfully.\",\n  \"data\": [\n      {\n         \"username\":\"spayc\",\n         \"dob\": \"2000-11-12\",\n         \"gender\": \"male|female|other\",\n         \"phone\": \"7876565434\",\n         \"address\": \"b-3 noida\",\n         \"website_url\":\"www.spayc.com\",\n         \"bio_data\":\"your bio data\",\n      }\n  ]\n}",
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
            "field": "title",
            "description": "<ul> <li>User title (Mr.|Mrs) required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fb_id",
            "description": "<ul> <li>User facebook unique id required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username optional in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "first_name",
            "description": "<ul> <li>User first name required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "last_name",
            "description": "<ul> <li>User last name required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>User email required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password is optional in body.</li> </ul>"
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
            "type": "String",
            "optional": false,
            "field": "device_id",
            "description": "<ul> <li>Device id is required in body.</li> </ul>"
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
          "content": "       HTTP/1.1 success\n{\n    \"status\": \"success\",\n    \"message\": \"Saved successfully.\",\n    \"data\": [\n        \"ones\",\n        {\n            \"title\": \"Mr.\",\n            \"fb_id\": \"45545454545\",\n            \"username\": \"dhiru.php\",\n            \"first_name\": \"dhiru\",\n            \"last_name\": \"singh2\",\n            \"email\": \"dhiru12.php@gmail.com\",\n            \"password\": \"Dhiru@123\",\n            \"dob\": \"2000-11-12\",\n            \"device_id\":\"DFS455HER45555af55af\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"title\":\"Mr.\",\n   \"fb_id\":\"8552254552\",\n   \"username\":\"dhiru.php\",\n   \"first_name\":\"dhiru\",\n   \"last_name\":\"singh\",\n   \"email\":\"dhiru.php@gmail.com\",\n   \"password\":\"Dhiru@123\",\n   \"dob\":\"2000-11-12\",\n   \"device_id\":\"DFS455HER45555af55af\"\n}",
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
    "description": "<p>User login with user name and its password. Need to send token in header</p>",
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
          "content": "     HTTP/1.1 200 OK\n{\n    \"status\": \"success\",\n    \"message\": \"Profile details\",\n    \"data\": {\n        \"username\": \"dhiruns3\",\n        \"email\": \"dhiru3@gmail.com\",\n        \"gender\": null,\n        \"phone\": 8484839392,\n        \"dob\": \"2000-05-25\",\n        \"status\": \"active\",\n        \"website_url\": null,\n        \"address\": null,\n        \"bio_data\": null,\n        \"created\": \"2018-01-09T11:00:21+00:00\",\n        \"modified\": \"2018-01-09T11:00:21+00:00\"\n    }\n}",
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
