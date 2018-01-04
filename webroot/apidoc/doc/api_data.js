define({ "api": [
  {
    "type": "post",
    "url": "/users/changePassword",
    "title": "Change Password",
    "version": "0.0.1",
    "name": "changePassword",
    "group": "Authentication",
    "permission": [
      {
        "name": "Consumer/Provider"
      }
    ],
    "description": "<p>User can change password</p>",
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
            "field": "old_password",
            "description": "<ul> <li>Old password required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>New password required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<ul> <li>Confirm password required in body.</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n\t\"status\": true,\n\t\"message\": \"The request is OK\",\n\t\"data\": {none}\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"old_password\":\"Old Password\",\n\t\"password\": \"New Password\",\n\t\"confirm_password\": \"Confirm Password\"\n}",
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
            "description": "<p>false.</p>"
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/change_password.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/consumerSignUp",
    "title": "Consumer Signup",
    "version": "0.0.1",
    "name": "consumerSignUp",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>Signup user with Face2Face Health system.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fname",
            "description": "<ul> <li>First Name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Last Name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username of the user (Must be unique).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Email Address of the user (Must be unique).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<ul> <li>Confirm Password.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Local time zone.</li> </ul>"
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
            "description": "<p>Consumer Object contain details about consumer.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 21,\n    \"user_type_id\": 2,\n    \"title\": \"\",\n    \"fname\": \"dhirendra\",\n    \"mname\": null,\n    \"lname\": \"singh\",\n    \"community_username\": null,\n    \"email\": \"dhirendra5.singh@kiwitech.com\",\n    \"username\": \"dhiru5\",\n    \"newsletter_subsciption_status\": \"Y\",\n    \"provider_type_id\": 0,\n    \"photo\": null,\n    \"ssn_no\": \"\",\n    \"guid\": null,\n    \"forgot_password_request_time\": null,\n    \"dob\": null,\n    \"gender\": \"\",\n    \"terms_of_use\": false,\n    \"activate_key\": null,\n    \"status\": \"Active\",\n    \"timezone\": \"Asia/Kolkata\",\n    \"stripe_customer_id\": \"\",\n    \"stripe_card_id\": null,\n    \"created\": \"2016-09-26T14:46:40+00:00\",\n    \"modified\": null,\n    \"token\": \"5a41c9b5-dd34-4f27-93fd-1a48067fc08f\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"fname\": \"Kannan\",\n  \"lname\": \"Ram\",\n  \"username\": \"kannan_kr\",\n  \"email\": \"kannan.k@kiwitech.com\",\n  \"password\": \"mypassword\",\n  \"confirm_password\": \"mypassword\",\n  \"timezone\": \"Asia/Kolkata\"\n}",
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/consumer_signup.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/forgotPassword",
    "title": "Forgot Password",
    "version": "0.0.1",
    "name": "forgotPassword",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>sent resent password link, if f2f user forgot password.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Registered username/email is required as username in body.</li> </ul>"
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
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  ['None']\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"username\" : \"test@test.com\"\n}",
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/forgot_password.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "get",
    "url": "/users/getUsernameAndEmailByGuid/XXXXXXXXXXXX",
    "title": "Get Username, Email by Guid",
    "name": "getUsernameAndEmailByGuid",
    "group": "Authentication",
    "description": "<p>Get username and email by guid send in forgot password email.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"username\": \"ds11\",\n    \"email\": \"test@gmail.com\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_username_email_by_guid.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/login",
    "title": "Provider Signin",
    "version": "0.0.1",
    "name": "login",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>Signin provider with Face2Face Health system to authenticate.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username registered username|email requried in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Local time zone.</li> </ul>"
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
            "description": "<p>Provider Object contain details about provider.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n       {\n\n\t\t\"status\": true,\n\t\t\"message\": \"The request is OK\",\n\t\t\"data\": {\n  \t\t\t\"id\": 3,\n  \t\t\t\"user_type_id\": 1,\n  \t\t\t\"title\": \"Mr.\",\n  \t\t\t\"fname\": \"Ravi\",\n  \t\t\t\"lname\": \"kumar\",\n  \t\t\t\"email\": \"ravi.kumar1@kiwitech.com\",\n  \t\t\t\"username\": \"ravi1\",\n  \t\t\t\"newsletter_subsciption_status\": \"Y\",\n  \t\t\t\"provider_type_id\": 1,\n  \t\t\t\"photo\": \"Abs.jpeg\",\n  \t\t\t\"ssn_no\": \"1123211\",\n  \t\t\t\"guid\": null,\n  \t\t\t\"forgot_password_request_time\": null,\n  \t\t\t\"dob\": \"1988-04-07T00:00:00+00:00\",\n  \t\t\t\"gender\": \"Male\",\n  \t\t\t\"timezone\" : \"Asia/Kolkata\",\n  \t\t\t\"terms_of_use\": true,\n  \t\t\t\"activate_key\": null,\n  \t\t\t\"created\": \"2016-09-01T11:01:05+00:00\",\n  \t\t\t\"modified\": null,\n  \t\t\t\"token\": \"a13d7666-dc6d-47b7-a3ed-9823f8f3be1b\"\n\t\t}\n       }",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"username\": \"username|email\",\n  \"password\" : \"YourP@ssword\",\n  \"timezone\" : \"Asia/Kolkata\"\n}",
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
          "content": "  \n {\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/provider_signin.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/resetPassword/:securitykey",
    "title": "Reset Password",
    "version": "0.0.1",
    "name": "resetPassword",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>Reset your password by forgot password link sent on your registerd email.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password field is required in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<ul> <li>Confirm password field is required in body</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n       {\n           \t\"status\": \ttrue,\n\t\t\"message\": \t\"The request is OK\"\n       }",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"password\": \"myclick06$\",\n\t\"confirm_password\": \"nyclick06$\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/reset_password.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/login",
    "title": "Consumer Signin",
    "version": "0.0.1",
    "name": "signin",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>Signin user with Face2Face Health system to authenticate.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username registered username|email requried in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "timezone",
            "description": "<ul> <li>Local time zone.</li> </ul>"
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
            "description": "<p>Consumer Object contain details about consumer.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n       {\n\n\t\t\"status\": true,\n\t\t\"message\": \"The request is OK\",\n\t\t\"data\": {\n  \t\t\t\"id\": 3,\n  \t\t\t\"user_type_id\": 1,\n  \t\t\t\"title\": \"Mr.\",\n  \t\t\t\"fname\": \"Ravi\",\n  \t\t\t\"lname\": \"kumar\",\n  \t\t\t\"email\": \"ravi.kumar1@kiwitech.com\",\n  \t\t\t\"username\": \"ravi1\",\n  \t\t\t\"newsletter_subsciption_status\": \"Y\",\n  \t\t\t\"provider_type_id\": 1,\n  \t\t\t\"photo\": \"Abs.jpeg\",\n  \t\t\t\"ssn_no\": \"1123211\",\n  \t\t\t\"guid\": null,\n  \t\t\t\"forgot_password_request_time\": null,\n  \t\t\t\"dob\": \"1988-04-07T00:00:00+00:00\",\n  \t\t\t\"gender\": \"Male\",\n  \t\t\t\"timezone\": \"Asia/Kolkata\",\n  \t\t\t\"terms_of_use\": true,\n  \t\t\t\"activate_key\": null,\n  \t\t\t\"created\": \"2016-09-01T11:01:05+00:00\",\n  \t\t\t\"modified\": null,\n  \t\t\t\"token\": \"a13d7666-dc6d-47b7-a3ed-9823f8f3be1b\"\n\t\t}\n       }",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"username\": \"username|email\",\n  \"password\" : \"YourP@ssword\",\n  \"timezone\": \"Asia/Kolkata\"\n}",
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
          "content": "  \n {\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/consumer_signin.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "post",
    "url": "/users/signUp",
    "title": "Provider Signup",
    "version": "0.0.1",
    "name": "signup",
    "group": "Authentication",
    "permission": [
      {
        "name": "None"
      }
    ],
    "description": "<p>Signup provider with Face2Face Health system.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of the User.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fname",
            "description": "<ul> <li>First name of User .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Last Name of User.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Email Address of the user (Must be unique).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": "<ul> <li>Username of the user (Must be unique).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<ul> <li>Password.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "confirm_password",
            "description": "<ul> <li>Confirm Password.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "photo",
            "description": "<ul> <li>Photo of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ssn_no",
            "description": "<ul> <li>SSN Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>Date of Birth(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>Gender(Male,Female) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "terms_of_use",
            "description": "<ul> <li>Terms of Use for the user.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "provider_license_and_insurances",
            "description": "<ul> <li>Provider License and Insurance Details</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_license_and_insurances.state_id",
            "description": "<ul> <li>State ID in which provider accepts license and insurance.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_license_and_insurances.license_number",
            "description": "<ul> <li>License Number of provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_license_and_insurances.insurance_plan_id",
            "description": "<ul> <li>Insurance Plan Id.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "provider_profile",
            "description": "<ul> <li>Provider Profile Details.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.state_id",
            "description": "<ul> <li>State ID for Provider profile Details.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.provider_type_id",
            "description": "<ul> <li>provider_type_id will be for 5 silos.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.city",
            "description": "<ul> <li>City of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.address1",
            "description": "<ul> <li>Address of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.address2",
            "description": "<ul> <li>Address of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.zip",
            "description": "<ul> <li>Zip code of the provider</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.home_phone",
            "description": "<ul> <li>Home phone number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.home_fax",
            "description": "<ul> <li>Home Fax Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.office_phone",
            "description": "<ul> <li>Office Phone Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.office_fax",
            "description": "<ul> <li>Office Fax Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.bio",
            "description": "<ul> <li>Biodata of the the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.speciality_id",
            "description": "<ul> <li>Speciality ID of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.speciality_experience",
            "description": "<ul> <li>Speciality Experience of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Enum",
            "optional": false,
            "field": "provider_profile.individual",
            "description": "<ul> <li>Provider's operation (Individual, Organization).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.organization_name",
            "description": "<ul> <li>Organization Name of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.npi_number",
            "description": "<ul> <li>NPI Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "provider_profile.npi_number_expiration",
            "description": "<ul> <li>NPI Number Expiration date(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.dea_number",
            "description": "<ul> <li>Dea Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "provider_profile.dea_number_expiration",
            "description": "<ul> <li>Dea Number Expiration date(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.contract",
            "description": "<ul> <li>Contract for the provider.</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n\t\"status\": true,\n\t\"message\": \"The request is OK\",\n\t\"data\": {none}\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n    \"title\": \"Mr.\",\n    \"fname\": \"Nikum\",\n    \"lname\": \"Sir\",\n    \"email\": \"nikum.kunj111@google.com\",\n    \"username\": \"nikum.kunj111\",\n    \"password\": \"Aa0!ravi\",\n    \"confirm_password\": \"Aa0!ravi\",\n    \"photo\": \"Abs.jpeg\",\n    \"ssn_no\": \"111-11-1111\",\n    \"dob\": \"04-07-1988\",\n    \"gender\": \"Male\",\n    \"terms_of_use\": 1,\n    \"provider_license_and_insurances\": [\n        {\n            \"state_id\": 1,\n            \"license_number\": \"123\",\n            \"insurance_plan_id\": \"1\"\n        },\n        {\n            \"state_id\": 1,\n            \"license_number\": \"123\",\n            \"insurance_plan_id\": \"1\"\n        },\n        {\n            \"state_id\": 2,\n            \"license_number\": \"123\",\n            \"insurance_plan_id\": \"1\"\n        },\n        {\n            \"state_id\": 2,\n            \"license_number\": \"123\",\n            \"insurance_plan_id\": \"1\"\n        }\n    ],\n    \"provider_profile\": {\n        \"state_id\": 1,\n        \"city\": \"NYC\",\n        \"address1\": \"NYC-2\",\n        \"address2\": \"NYC-2\",\n        \"zip\": \"NYC122\",\n        \"home_phone\": \"1234567981\",\n        \"home_fax\": \"12345679811\",\n        \"office_phone\": \"1234567981\",\n        \"office_fax\": \"12345679811\",\n        \"bio\": \"Hellow how are you?\",\n        \"provider_type_id\": 1,\n        \"speciality_id\": 1,\n        \"speciality_experience\": \"I am fine\",\n        \"individual\": \"individual\",\n        \"organization_name\": \"\",\n        \"npi_number\": \"12345645\",\n        \"npi_number_expiration\": \"08-30-2017\",\n        \"dea_number\": \"12345645\",\n        \"dea_number_expiration\": \"08-30-2017\",\n        \"contract\": \"legal_contract.jpg\"\n    }\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/provider_signup.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "get",
    "url": "/users/updateProvidersProfile",
    "title": "Update Provider Profile",
    "version": "0.0.1",
    "name": "updateProvidersProfile",
    "group": "Authentication",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Update provider profile.</p>",
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
            "field": "title",
            "description": "<ul> <li>Title of the User.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fname",
            "description": "<ul> <li>First name of User .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Last Name of User.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "photo",
            "description": "<ul> <li>Photo of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "ssn_no",
            "description": "<ul> <li>SSN Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>Date of Birth(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>Gender(Male,Female) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "terms_of_use",
            "description": "<ul> <li>Terms of Use for the user.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "provider_license_and_insurances",
            "description": "<ul> <li>Provider License and Insurance Details</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_license_and_insurances.id",
            "description": "<ul> <li>Provider ID</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_license_and_insurances.state_id",
            "description": "<ul> <li>State ID in which provider accepts license and insurance.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_license_and_insurances.license_number",
            "description": "<ul> <li>License Number of provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_license_and_insurances.insurance_plan_type_id",
            "description": "<ul> <li>Insurance Plan Type ID.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_license_and_insurances.insurance_plan_id",
            "description": "<ul> <li>Insurance Plan Id.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "provider_profile",
            "description": "<ul> <li>Provider Profile Details.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.id",
            "description": "<ul> <li>Provider ID.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.state_id",
            "description": "<ul> <li>State ID for Provider profile Details.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.city",
            "description": "<ul> <li>City of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.address1",
            "description": "<ul> <li>Address of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.address2",
            "description": "<ul> <li>Address of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.zip",
            "description": "<ul> <li>Zip code of the provider</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.home_phone",
            "description": "<ul> <li>Home phone number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.home_fax",
            "description": "<ul> <li>Home Fax Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.office_phone",
            "description": "<ul> <li>Office Phone Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.office_fax",
            "description": "<ul> <li>Office Fax Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.bio",
            "description": "<ul> <li>Biodata of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_profile.speciality_id",
            "description": "<ul> <li>Speciality ID of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.speciality_experience",
            "description": "<ul> <li>Speciality Experience of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Enum",
            "optional": false,
            "field": "provider_profile.individual",
            "description": "<ul> <li>Provider's operation (Individual, Organization).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.organization_name",
            "description": "<ul> <li>Organization Name of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.npi_number",
            "description": "<ul> <li>NPI Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "provider_profile.npi_number_expiration",
            "description": "<ul> <li>NPI Number Expiration date(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.dea_number",
            "description": "<ul> <li>Dea Number of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "provider_profile.dea_number_expiration",
            "description": "<ul> <li>Dea Number Expiration date(mm-dd-yyyy) of the provider.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_profile.contract",
            "description": "<ul> <li>Contract for the provider.</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n\t\"status\": true,\n\t\"message\": \"The request is OK\",\n\t\"data\": {none}\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"title\" : Mr.,\n  \"fname\" : Ravi,\n  \"lname\" : kumar,\n  \"photo\" : Abs.jpeg,\n  \"ssn_no\" : 111-11-1111,\n  \"dob\" : 04-07-1988,\n  \"gender\" : Male,\n  \"terms_of_use\" : 1,\n  \"provider_license_and_insurances\" : -{\n      \"0\" : -{\n          \"id\" : 63,\n          \"state_id\" : 1,\n          \"license_number\" : 123456,\n          \"insurance_plan_type_id\" : 2,\n          \"insurance_plan_id\" : 1\n      },\n      \"1\" : -{\n          \"id\" : 64,\n          \"state_id\" : 1,\n          \"license_number\" : 123456,\n          \"insurance_plan_type_id\" : 2,\n          \"insurance_plan_id\" : 1\n      },\n      \"2\" : -{\n          \"id\" : 65,\n          \"state_id\" : 2,\n          \"license_number\" : 123456,\n          \"insurance_plan_type_id\" : 2,\n          \"insurance_plan_id\" : 1\n      },\n      \"3\" : -{\n          \"id\" : 66,\n          \"state_id\" : 2,\n          \"license_number\" : 123456,\n          \"insurance_plan_type_id\" : 2,\n          \"insurance_plan_id\" : 1\n      }\n  },\n  \"provider_profile\" : -{\n      \"id\" : 8,\n      \"state_id\" : 1,\n      \"city\" : NYC,\n      \"address1\" : NYC-22,\n      \"address2\" : NYC-22,\n      \"zip\" : NYC112,\n      \"home_phone\" : 1234627892,\n      \"home_fax\" : 12346789221,\n      \"office_phone\" : 1234678922,\n      \"office_fax\" : 12346789254,\n      \"bio\" : Hellow how are you?,\n      \"speciality_id\" : 1,\n      \"speciality_experience\" : I am fine!,\n      \"individual\" : individual,\n      \"organization_name\" : ,\n      \"npi_number\" : ASDPK8786G,\n      \"npi_number_expiration\" : 04-07-1988,\n      \"dea_number\" : ASDPK,\n      \"dea_number_expiration\" : 04-07-1988,\n      \"contract\" : legal_contract.jpg\n  }\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/provider_update_profile.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/verifyNpi/:npi",
    "title": "Verify Npi Number",
    "name": "verifyNpi",
    "group": "Authentication",
    "description": "<p>Verify Npi Number.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
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
            "description": "<p>Insurance Object contain details about insurance.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"Valid NPI number.\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/validate_npi_number.js",
    "groupTitle": "Authentication"
  },
  {
    "type": "get",
    "url": "/Community",
    "title": "Get community",
    "name": "getCommunity",
    "group": "Community",
    "description": "<p>Get communities</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN is optional</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"title\": \"General Health\",\n      \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\n      \"color\": \"#ffc87b\",\n      \"topic_count\": \"5\",\n      \"comment_count\": \"0\",\n      \"last_comment_date\": null,\n      \"comment_id\": null,\n      \"is_joined\": true\n    },\n    {\n      \"id\": 2,\n      \"title\": \"Speech, Language & Motor Development\",\n      \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\\\n      \"color\": \"#63a5d4\",\n      \"topic_count\": \"21\",\n      \"comment_count\": \"8\",\n      \"last_comment_date\": \"2016-09-30 19:27:19\",\n      \"comment_id\": \"18\",\n      \"commented_by\": \"Ashutosh Agrawal\",\n      \"is_joined\": false\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getCommunity.js",
    "groupTitle": "Community"
  },
  {
    "type": "post",
    "url": "/Community/getCommunityCategory/:id",
    "title": "Get community category",
    "name": "getCommunityCategory",
    "group": "Community",
    "description": "<p>Get community category</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"title\": \"General Health\",\n    \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\n    \"color\": \"#ffc87b\",\n    \"image\": \"\",\n    \"status\": 1,\n    \"created\": \"2016-08-30T13:10:20+00:00\",\n    \"modified\": \"2016-08-30T13:10:20+00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getCommunityCateogry.js",
    "groupTitle": "Community"
  },
  {
    "type": "post",
    "url": "/Community/getCommunityTopics",
    "title": "Get community topics",
    "name": "getCommunityTopics",
    "group": "Community",
    "description": "<p>Get community topics</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN is optional</li> </ul>"
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
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sort_by",
            "description": "<ul> <li>sort_by is optional field with values &quot;Most Popular&quot;,&quot;Most Recent&quot;,&quot;Most Oldest&quot;,&quot;A-Z&quot;,&quot;Z-A&quot; in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_type_id\":\"1\",\n\t\"title\":\"title\",\n\t\"sort_by\":\"Most Popular\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"community_category\": {\n      \"status\": true,\n      \"message\": \"The request is OK\",\n      \"data\": {\n        \"id\": 1,\n        \"title\": \"General Health\",\n        \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\n        \"color\": \"#ffc87b\",\n        \"image\": \"\",\n        \"status\": 1,\n        \"created\": \"2016-08-30T13:10:20+00:00\",\n        \"modified\": \"2016-08-30T13:10:20+00:00\"\n      },\n      \"_serialize\": [\n        \"code\",\n        \"status\",\n        \"message\",\n        \"data\"\n      ]\n    },\n    \"is_joined\": true,\n    \"community_topics\": [\n      {\n        \"title\": \"1\",\n        \"description\": \"3\",\n        \"created_by\": \"2\",\n        \"created_on\": \"2016-09-29 06:18:22\",\n        \"provider_type_id\": 1,\n        \"comment_count\": \"0\",\n        \"last_comment_date\": null,\n        \"comment_id\": null,\n        \"joined_user_count\": \"1\"\n      },\n      {\n        \"title\": \"asdfsadf\",\n        \"description\": \"fdsfadsfdasf\",\n        \"created_by\": \"fasdfdasf\",\n        \"created_on\": \"2016-09-30 11:32:38\",\n        \"provider_type_id\": 1,\n        \"comment_count\": \"0\",\n        \"last_comment_date\": null,\n        \"comment_id\": null,\n        \"joined_user_count\": \"1\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n\n  {\n \"status\": false,\n \"message\": \"Method not allowed on resource.\"\n }\n {\n \"status\": false,\n \"message\": \"Resource not found.\"\n }\n {\n \"status\": false,\n \"message\": \"Requested Parameter is not correct\"\n }\n{\n  \"status\": false,\n  \"message\": \"Unauthorised, You have not joined\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getCommunityTopics\r\n.js",
    "groupTitle": "Community"
  },
  {
    "type": "post",
    "url": "/Community/joinCommunity",
    "title": "Join community",
    "name": "joinCommunity",
    "group": "Community",
    "description": "<p>To join community</p>",
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
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_type_id\":\"1\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n \"status\": false,\n \"message\": \"Method not allowed on resource.\"\n }\n {\n \"status\": false,\n \"message\": \"Resource not found.\"\n }\n {\n \"status\": false,\n \"message\": \"Requested Parameter is not correct\"\n }\n{\n  \"status\": false,\n  \"message\": \"Unauthorised, You have already joined\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/joinCommunity.js",
    "groupTitle": "Community"
  },
  {
    "type": "post",
    "url": "/Community/unJoinCommunity",
    "title": "Unjoin community",
    "name": "unJoinCommunity",
    "group": "Community",
    "description": "<p>To join community</p>",
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
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_type_id\":\"1\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n \"status\": false,\n \"message\": \"Method not allowed on resource.\"\n }\n {\n \"status\": false,\n \"message\": \"Resource not found.\"\n }\n {\n \"status\": false,\n \"message\": \"Requested Parameter is not correct\"\n }\n{\n  \"status\": false,\n  \"message\": \"Unauthorised, You have not joined\",\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/unJoinCommunity.js",
    "groupTitle": "Community"
  },
  {
    "type": "post",
    "url": "/patients/add",
    "title": "Add Patient",
    "version": "0.0.1",
    "name": "Add_Patient",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Add patient by consumer.</p>",
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
            "field": "fname",
            "description": "<ul> <li>First name of patient .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Last Name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>Date of birth(mm/dd/yyyy) of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>Gender of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "child_lives_with",
            "description": "<ul> <li>Patient lives with.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "primary_care_physician",
            "description": "<ul> <li>Primary care physician.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "release_info_authrization",
            "description": "<ul> <li>Realease information authrization.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_parent",
            "description": "<ul> <li>Patients Parent Information</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.primary_fname",
            "description": "<ul> <li>Primary first name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.primary_lname",
            "description": "<ul> <li>Primary last name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_parent.primary_dob",
            "description": "<ul> <li>Primary date of birth(mm/dd/yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.primary_ssn_no",
            "description": "<ul> <li>Primary SSN No.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.primary_address",
            "description": "<ul> <li>Primary address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.primary_cell_no",
            "description": "<ul> <li>Cell number of primary.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.primary_home_phone_no",
            "description": "<ul> <li>Home phone number of primary.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.primary_employer",
            "description": "<ul> <li>Primary employer.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.primary_work_phone_no",
            "description": "<ul> <li>Primary work phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.primary_relation",
            "description": "<ul> <li>Primary relation of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.secondary_fname",
            "description": "<ul> <li>Secondary first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.secondary_lname",
            "description": "<ul> <li>Secondary last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_parent.secondary_dob",
            "description": "<ul> <li>Secondary date of birth(mm/dd/yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.secondary_ssn_no",
            "description": "<ul> <li>Secondary SSN No.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.secondary_address",
            "description": "<ul> <li>Secondary address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.secondary_cell_no",
            "description": "<ul> <li>Secondary cell number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.secondary_home_phone_no",
            "description": "<ul> <li>Secondary home phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.secondary_employer",
            "description": "<ul> <li>Secondary employer.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.secondary_work_phone_no",
            "description": "<ul> <li>Secondary work phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.martial_status",
            "description": "<ul> <li>Marital status.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_fname",
            "description": "<ul> <li>Emergency contact first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_lname",
            "description": "<ul> <li>Emergency contact last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_address",
            "description": "<ul> <li>Emergency contact address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.emergency_contact_cell_no",
            "description": "<ul> <li>Emergency contact cell number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.emergency_contact_home_no",
            "description": "<ul> <li>Emergency contact home number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_authorization_form",
            "description": "<ul> <li>Patient Authorization Forms</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.patient_first_name",
            "description": "<ul> <li>Patient first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.patient_last_name",
            "description": "<ul> <li>Patient last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_authorization_form.patient_dob",
            "description": "<ul> <li>Patient date of birth(mm/dd/yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.name_of_person",
            "description": "<ul> <li>Name of person.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.relationship_to_patient",
            "description": "<ul> <li>Relationship to parent.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.reason_for_disclosure",
            "description": "<ul> <li>Reason for disclosure.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "patient_authorization_form.terms_and_conditions",
            "description": "<ul> <li>Terms and conditions.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_insurance",
            "description": "<ul> <li>Patients Parent Information</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_insurance.company_name",
            "description": "<ul> <li>Patient Insurance company name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_insurance.holder_name",
            "description": "<ul> <li>Patient Insurance holder name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_insurance.policy_number",
            "description": "<ul> <li>Patient Insurance policy number.</li> </ul>"
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
            "description": "<p>true/false.</p>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"fname\": \"Jack\",\n  \"lname\": \"Doe\",\n  \"dob\": \"02/02/2002\",\n  \"gender\": \"Male\",\n  \"child_lives_with\": \"Mother\",\n  \"primary_care_physician\": \"Teacher\",\n  \"release_info_authrization\": 1,\n  \"patient_parent\": {\n      \"primary_fname\": \"Ammy\",\n      \"primary_lname\": \"samsung\",\n      \"primary_dob\": \"02/02/1988\",\n      \"primary_ssn_no\": \"111-11-1111\",\n      \"primary_address\": \"NYCcircle2-400\",\n      \"primary_cell_no\": \"9540420501\",\n      \"primary_home_phone_no\": \"9876543211\",\n      \"primary_employer\": \"Google\",\n      \"primary_work_phone_no\": \"9876543211\",\n      \"primary_relation\": \"Father\",\n      \"secondary_fname\": \"Niel\",\n      \"secondary_lname\": \"jhonsan\",\n      \"secondary_dob\": \"02/02/1988\",\n      \"secondary_ssn_no\": \"222-22-2222\",\n      \"secondary_address\": \"NYCcircle2-400\",\n      \"secondary_cell_no\": \"9504435001\",\n      \"secondary_home_phone_no\": \"9876543211\",\n      \"secondary_employer\": \"Yahoo\",\n      \"secondary_work_phone_no\": \"9876543211\",\n      \"martial_status\": \"Married\",\n      \"emergency_contact_fname\": \"Ricky\",\n      \"emergency_contact_lname\": \"Bell\",\n      \"emergency_contact_address\": \"NYCcircle2-400\",\n      \"emergency_contact_cell_no\": \"9876543211\",\n      \"emergency_contact_home_no\": \"9876543211\"\n  },\n  \"patient_authorization_form\": {\n      \"patient_first_name\": \"Jack\",\n      \"patient_last_name\": \"Doe\",\n      \"patient_dob\": \"02/02/2002\",\n      \"name_of_person\": \"Ravi\",\n      \"relationship_to_patient\": \"Teacher\",\n      \"reason_for_disclosure\": \"Treatment\",\n      \"terms_and_conditions\": 1\n  },\n  \"patient_insurances\": {\n      \"0\": {\n          \"company_name\": \"ABV\",\n          \"holder_name\": \"AMSS\",\n          \"policy_number\": \"1212AASSA\"\n      },\n      \"1\": {\n          \"company_name\": \"ABV\",\n          \"holder_name\": \"AMSS\",\n          \"policy_number\": \"1212AASSA\"\n      }\n  }\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/add_patient.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "put",
    "url": "/patients/edit?patient_id=1",
    "title": "Edit Patient",
    "version": "0.0.1",
    "name": "Edit_Patient",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Edit patient by consumer.</p>",
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
            "field": "fname",
            "description": "<ul> <li>First name of patient .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Last Name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>Date of birth(mm-dd-yyyy) of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>Gender of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "child_lives_with",
            "description": "<ul> <li>Patient lives with.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "primary_care_physician",
            "description": "<ul> <li>Primary care physician.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "release_info_authrization",
            "description": "<ul> <li>Realease information authrization.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_parent",
            "description": "<ul> <li>Patients Parent Information</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.id",
            "description": "<ul> <li>Id of PatientParents table.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.mother_fname",
            "description": "<ul> <li>Mother first name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.mother_lname",
            "description": "<ul> <li>Mother last name of patient.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_parent.mother_dob",
            "description": "<ul> <li>Mothers date of birth(mm-dd-yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.mother_ssn_no",
            "description": "<ul> <li>Mothers SSN No.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.mother_address",
            "description": "<ul> <li>Mothers Address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.mother_cell_no",
            "description": "<ul> <li>Cell number of mother.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.mother_home_phone_no",
            "description": "<ul> <li>Home phone number of mother.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.mother_employer",
            "description": "<ul> <li>Mothers employer.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.mother_work_phone_no",
            "description": "<ul> <li>Mothers work phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.father_fname",
            "description": "<ul> <li>Fathers first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.father_lname",
            "description": "<ul> <li>Fathers last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_parent.father_dob",
            "description": "<ul> <li>Fathers date of birth(mm-dd-yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.father_ssn_no",
            "description": "<ul> <li>Fathers SSN No.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.father_address",
            "description": "<ul> <li>Fathers address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.father_cell_no",
            "description": "<ul> <li>Fathers cell number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.father_home_phone_no",
            "description": "<ul> <li>Fathers home phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.father_employer",
            "description": "<ul> <li>Fathers employer.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.father_work_phone_no",
            "description": "<ul> <li>Father work phone number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.martial_status",
            "description": "<ul> <li>Marital status.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_fname",
            "description": "<ul> <li>Emergency contact first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_lname",
            "description": "<ul> <li>Emergency contact last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_parent.emergency_contact_address",
            "description": "<ul> <li>Emergency contact address.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.emergency_contact_cell_no",
            "description": "<ul> <li>Emergency contact cell number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_parent.emergency_contact_home_no",
            "description": "<ul> <li>Emergency contact home number.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_authorization_form",
            "description": "<ul> <li>Patient Authorization Forms</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_authorization_form.id",
            "description": "<ul> <li>Id of Patient Authorization Forms table.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.patient_first_name",
            "description": "<ul> <li>Patient first name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.patient_last_name",
            "description": "<ul> <li>Patient last name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "patient_authorization_form.patient_dob",
            "description": "<ul> <li>Patient date of birth(mm-dd-yyyy).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.name_of_person",
            "description": "<ul> <li>Name of person.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.relationship_to_patient",
            "description": "<ul> <li>Relationship to parent.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_authorization_form.reason_for_disclosure",
            "description": "<ul> <li>Reason for disclosure.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": false,
            "field": "patient_authorization_form.terms_and_conditions",
            "description": "<ul> <li>Terms and conditions.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "patient_insurance",
            "description": "<ul> <li>Patients Parent Information</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_insurance.id",
            "description": "<ul> <li>Id of Patients Parent Information table.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_insurance.company_name",
            "description": "<ul> <li>Patient Insurance company name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "patient_insurance.holder_name",
            "description": "<ul> <li>Patient Insurance holder name.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_insurance.policy_number",
            "description": "<ul> <li>Patient Insurance policy number.</li> </ul>"
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
            "description": "<p>true/false.</p>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n  \"fname\": \"Jack\",\n  \"lname\": \"Doe\",\n  \"dob\": \"02/02/2002\",\n  \"gender\": \"Male\",\n  \"child_lives_with\": \"Mother\",\n  \"primary_care_physician\": \"Teacher\",\n  \"release_info_authrization\": 1,\n  \"patient_parent\": {\n      \"primary_fname\": \"Ammy\",\n      \"primary_lname\": \"samsung\",\n      \"primary_dob\": \"02/02/1988\",\n      \"primary_ssn_no\": \"111-11-1111\",\n      \"primary_address\": \"NYCcircle2-400\",\n      \"primary_cell_no\": \"9540420501\",\n      \"primary_home_phone_no\": \"9876543211\",\n      \"primary_employer\": \"Google\",\n      \"primary_work_phone_no\": \"9876543211\",\n      \"primary_relation\": \"Father\",\n      \"secondary_fname\": \"Niel\",\n      \"secondary_lname\": \"jhonsan\",\n      \"secondary_dob\": \"02/02/1988\",\n      \"secondary_ssn_no\": \"222-22-2222\",\n      \"secondary_address\": \"NYCcircle2-400\",\n      \"secondary_cell_no\": \"9504435001\",\n      \"secondary_home_phone_no\": \"9876543211\",\n      \"secondary_employer\": \"Yahoo\",\n      \"secondary_work_phone_no\": \"9876543211\",\n      \"martial_status\": \"Married\",\n      \"emergency_contact_fname\": \"Ricky\",\n      \"emergency_contact_lname\": \"Bell\",\n      \"emergency_contact_address\": \"NYCcircle2-400\",\n      \"emergency_contact_cell_no\": \"9876543211\",\n      \"emergency_contact_home_no\": \"9876543211\"\n  },\n  \"patient_authorization_form\": {\n      \"patient_first_name\": \"Jack\",\n      \"patient_last_name\": \"Doe\",\n      \"patient_dob\": \"02/02/2002\",\n      \"name_of_person\": \"Ravi\",\n      \"relationship_to_patient\": \"Teacher\",\n      \"reason_for_disclosure\": \"Treatment\",\n      \"terms_and_conditions\": 1\n  },\n  \"patient_insurances\": {\n      \"0\": {\n          \"company_name\": \"ABV\",\n          \"holder_name\": \"AMSS\",\n          \"policy_number\": \"1212AASSA\"\n      },\n      \"1\": {\n          \"company_name\": \"ABV\",\n          \"holder_name\": \"AMSS\",\n          \"policy_number\": \"1212AASSA\"\n      }\n  }\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/edit_patient.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getPatientAppointments/:1",
    "title": "Get Patient Appointments List scheduled or completed or all",
    "name": "Get_Patient_Appointments_List_scheduled_or_completed_or_all",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get Patient Appointments List scheduled or completed or all</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Send page number in url query string if use pagination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Required patient id in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<ul> <li>Optional &quot;Completed&quot; or &quot;Scheduled&quot; value in body</li> </ul>"
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
            "field": "Patient",
            "description": "<p>Appointments List scheduled or completed or all</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"list\": [\n      {\n        \"consult_type\": \"Scheduled\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": \"2016-09-27T00:00:00+00:00\",\n        \"consultation_end_time\": \"2016-11-10T05:23:34+00:00\",\n        \"inquiry_type\": {\n          \"name\": \"Dental\"\n        },\n        \"inquiry\": {\n          \"name\": \"Dental-1\"\n        },\n        \"provider\": {\n          \"fname\": \"Ravi\",\n          \"lname\": \"kumar\"\n        },\n        \"consumer\": {\n          \"title\": \"\",\n          \"fname\": \"Kannan\",\n          \"lname\": \"Ram\"\n        },\n        \"speciality\": {\n          \"title\": \"Pharmacists\"\n        }\n      },\n      {\n        \"consult_type\": \"On-Demand\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": null,\n        \"consultation_end_time\": \"2016-11-10T00:00:00+00:00\",\n        \"inquiry_type\": null,\n        \"inquiry\": null,\n        \"provider\": {\n          \"fname\": \"Ravi\",\n          \"lname\": \"kumar\"\n        },\n        \"consumer\": {\n          \"title\": \"\",\n          \"fname\": \"Kannan\",\n          \"lname\": \"Ram\"\n        },\n        \"speciality\": {\n          \"title\": \"Pharmacists\"\n        }\n      },\n      {\n        \"consult_type\": \"On-Demand\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": null,\n        \"consultation_end_time\": \"2016-11-10T00:00:00+00:00\",\n        \"inquiry_type\": null,\n        \"inquiry\": null,\n        \"provider\": {\n          \"fname\": \"Ravi\",\n          \"lname\": \"kumar\"\n        },\n        \"consumer\": {\n          \"title\": \"\",\n          \"fname\": \"Kannan\",\n          \"lname\": \"Ram\"\n        },\n        \"speciality\": {\n          \"title\": \"Pharmacists\"\n        }\n      }\n    ],\n    \"Page\": {\n      \"finder\": \"all\",\n      \"page\": 1,\n      \"current\": 5,\n      \"count\": 72,\n      \"perPage\": 5,\n      \"prevPage\": false,\n      \"nextPage\": true,\n      \"pageCount\": 15,\n      \"sort\": null,\n      \"direction\": false,\n      \"limit\": null,\n      \"sortDefault\": false,\n      \"directionDefault\": false,\n      \"scope\": null\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\npatients/getPatientAppointments/:1",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_appointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/coupons/applyCouponCode",
    "title": "apply coupon code",
    "name": "applyCouponCode",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Apply coupon code when consumer get appointment.</p>",
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
            "field": "coupon_code",
            "description": "<ul> <li>Coupon code is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_type",
            "description": "<ul> <li>Consult type is required field in body(schedule|on-demand|).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "speciality",
            "description": "<ul> <li>Speciality is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "amount",
            "description": "<ul> <li>Amount is required field in body.</li> </ul>"
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
            "description": "<p>Coupon Object contain details about coupon.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 3,\n    \"discount\": 10,\n    \"discount_type\": \"P\",\n    \"product\": {\n      \"id\": 5\n    },\n    \"specialities\": [\n      {\n        \"id\": 6,\n        \"_joinData\": {\n          \"coupon_id\": 3,\n          \"speciality_id\": 6\n        }\n      }\n    ],\n    \"amount\": 450\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n    \"coupon_code\":\"SCONS\",\n    \"consult_type\":\"on-demand\",\n    \"speciality\":[6,7],\n    \"amount\":\"500\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/applyCouponCode.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/Consultations/cancelConsult",
    "title": "Cancel Consultation",
    "name": "cancelConsult",
    "group": "Consumer",
    "description": "<p>To cancel scheduled consultations</p>",
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
            "field": "consult_id",
            "description": "<ul> <li>Consult id is required in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"consult_id\":\"7\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/cancelConsult.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "put",
    "url": "/consultations/consumerUpdateAppointmentStatus/:1/:Accept",
    "title": "Update Appointment Status",
    "name": "consumerUpdateAppointmentStatus",
    "group": "Consumer",
    "description": "<p>Get patient appointment by provider authentication.</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Patient id send in request by url qurey string.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "/:Accept",
            "description": "<ul> <li>Accept|Decline send in request by url qurey string.</li> </ul>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/consumerUpdateAppointmentStatus.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/consultations/endMeeting/:consultId",
    "title": "End meeting",
    "name": "endMeeting",
    "group": "Consumer",
    "description": "<p>End meeting when duration is completed</p>",
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
            "field": "consultId",
            "description": "<ul> <li>Consultation id required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/endMeeting.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/patients/getAgeGroupDropDown",
    "title": "Get age group dropdown",
    "name": "getAgeGroupDropDown",
    "group": "Consumer",
    "description": "<p>Get age group dropdown</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"age\": \"<0 Months\"\n    },\n    {\n      \"id\": 2,\n      \"age\": \"0-12 Months\"\n    },\n    {\n      \"id\": 3,\n      \"age\": \"1-3 Years\"\n    },\n    {\n      \"id\": 4,\n      \"age\": \"3-5 Years\"\n    },\n    {\n      \"id\": 5,\n      \"age\": \"5-12 Years\"\n    },\n    {\n      \"id\": 6,\n      \"age\": \"12-18 Years\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getAgeGroupDropDown.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getAppointments/:scheduled",
    "title": "Get patient appointments",
    "name": "getAppointments",
    "group": "Consumer",
    "description": "<p>Get patient appointment by provider or consumer authentication.</p>",
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
            "field": "/:scheduled",
            "description": "<ul> <li>scheduled|requested|on-demand|not-started|started|completed send in request by url qurey string.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "search",
            "description": "<ul> <li>Search option field in request body.</li> </ul>"
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
            "description": "<p>Appointment Object contain details about patient appointment.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"concierge_service\": \"N\",\n      \"id\": 316,\n      \"multi_provider\": \"No\",\n      \"accepted_first\": \"No\",\n      \"meeting_duration\": null,\n      \"consult_medium\": \"Phone\",\n      \"insurance_plan_id\": 1,\n      \"meeting_id\": null,\n      \"insurance_accepted\": \"Yes\",\n      \"request_status\": \"Accept\",\n      \"start_url\": null,\n      \"join_url\": null,\n      \"is_followed_up\": \"N\",\n      \"claim_status_send\": \"N\",\n      \"re_schedule_by\": null,\n      \"re_schedule_request_date\": null,\n      \"consultation_status\": \"Not Started\",\n      \"payment_status\": \"N\",\n      \"consult_request_date_time\": \"2016-12-24T12:51:19+00:00\",\n      \"consultation_start_date\": \"2017-01-09\",\n      \"consultation_start_time\": \"13:00:00\",\n      \"consultation_end_time\": \"14:10:00\",\n      \"speciality\": {\n        \"id\": 20,\n        \"title\": \"Occupational Therapists\",\n        \"provider_type\": {\n          \"title\": \"Speech, Language & Motor Development\",\n          \"id\": 2\n        }\n      },\n      \"insurance_plan\": {\n        \"name\": \"\"\n      },\n      \"inquiry_type\": {\n        \"name\": \"Medical Problem\"\n      },\n      \"inquiry\": {\n        \"name\": \"Medical Problem-1\"\n      },\n      \"patient_authorization_form\": {\n        \"relationship_to_patient\": \"Father\"\n      },\n      \"provider\": {\n        \"id\": 1,\n        \"title\": \"Mr.\",\n        \"fname\": \"subhash\",\n        \"lname\": \"kumar\"\n      },\n      \"consumer\": {\n        \"id\": 213,\n        \"dob\": null,\n        \"photo\": null,\n        \"photo_name\": null,\n        \"gender\": \"\",\n        \"fname\": \"dhirendra\",\n        \"lname\": \"singh\",\n        \"consumer_billing_details\": [\n          {\n            \"user_id\": 213,\n            \"type\": \"P\",\n            \"city\": \"alld\",\n            \"state_id\": 1,\n            \"state\": {\n              \"name\": \"Alaska\"\n            }\n          },\n          {\n            \"user_id\": 213,\n            \"type\": \"P\",\n            \"city\": \"ertert\",\n            \"state_id\": 1,\n            \"state\": {\n              \"name\": \"Alaska\"\n            }\n          }\n        ]\n      },\n      \"patient\": {\n        \"id\": 1,\n        \"fname\": \"anshu\",\n        \"lname\": \"ghgfjhf\",\n        \"dob\": \"2014-10-06T00:00:00+00:00\",\n        \"gender\": \"Female\"\n      },\n      \"age\": 2,\n      \"waiting_time\": \"22d \",\n      \"consult_start_status\": \"\",\n      \"start_time\": \"2017-01-09 13:00:00\",\n      \"end_time\": \"2017-01-09 14:10:00\"\n    },\n    {\n      \"total_participants\": \"3\",\n      \"concierge_service\": \"N\",\n      \"id\": 260,\n      \"multi_provider\": \"Yes\",\n      \"accepted_first\": \"Yes\",\n      \"meeting_duration\": 10,\n      \"consult_medium\": \"Phone\",\n      \"insurance_plan_id\": null,\n      \"meeting_id\": 380458237,\n      \"insurance_accepted\": \"No\",\n      \"request_status\": \"Accept\",\n      \"start_url\": \"https://zoom.us/s/380458237?zpk=oi5p-BCSfD7U2fNU1PJ7k1rasWXfVEDWYt5u2wlnvhw.AwckYTI5NzdmMmQtYTNlNy00MGJhLWI5YjktYWYwZWRlNzZhMGVlFm8xaC1kUmhjU2ZtZVN4d1p1a0RFQlEWbzFoLWRSaGNTZm1lU3h3WnVrREVCURxkaGlyZW5kcmEuc2luZ2hAa2l3aXRlY2guY29tYwB_NGlqTU5xVkxzRDZjQXVNcjZZLXpDRm91V2xRenpfanE4cjItbDF0ZmQzOC5CZ01zVmtablFXUnJkMnhCWjI5dk5USkdjVEJDTTBwd2VFNHlUM1V5VURGUE0wdFVja05xWTJkMlptVm5WVDBBQUF3elEwSkJkVzlwV1ZNemN6MAAAFk5NelhOQlRIVGktam5lNEZUaWRfNGcCAgEA\",\n      \"join_url\": \"https://zoom.us/j/380458237?pwd=tWzAHHXJzXQ%3D\",\n      \"is_followed_up\": \"N\",\n      \"claim_status_send\": \"N\",\n      \"re_schedule_by\": null,\n      \"re_schedule_request_date\": null,\n      \"consultation_status\": \"Not Started\",\n      \"payment_status\": \"N\",\n      \"consult_request_date_time\": \"2016-12-21T16:06:30+00:00\",\n      \"consultation_start_date\": \"2016-12-24\",\n      \"consultation_start_time\": \"08:01:00\",\n      \"consultation_end_time\": \"08:11:00\",\n      \"consultation_provider\": {\n        \"consultation_ids\": \"260,261,262\"\n      },\n      \"speciality\": {\n        \"id\": 1,\n        \"title\": \"Pharmacists\",\n        \"provider_type\": {\n          \"title\": \"\",\n          \"id\": 1\n        }\n      },\n      \"insurance_plan\": null,\n      \"inquiry_type\": null,\n      \"inquiry\": null,\n      \"patient_authorization_form\": {\n        \"relationship_to_patient\": \"Father\"\n      },\n      \"provider\": {\n        \"id\": 1,\n        \"title\": \"Mr.\",\n        \"fname\": \"subhash\",\n        \"lname\": \"kumar\"\n      },\n      \"consumer\": {\n        \"id\": 213,\n        \"dob\": null,\n        \"photo\": null,\n        \"photo_name\": null,\n        \"gender\": \"\",\n        \"fname\": \"dhirendra\",\n        \"lname\": \"singh\",\n        \"consumer_billing_details\": [\n          {\n            \"user_id\": 213,\n            \"type\": \"P\",\n            \"city\": \"alld\",\n            \"state_id\": 1,\n            \"state\": {\n              \"name\": \"Alaska\"\n            }\n          },\n          {\n            \"user_id\": 213,\n            \"type\": \"P\",\n            \"city\": \"ertert\",\n            \"state_id\": 1,\n            \"state\": {\n              \"name\": \"Alaska\"\n            }\n          }\n        ]\n      },\n      \"patient\": {\n        \"id\": 1,\n        \"fname\": \"anshu\",\n        \"lname\": \"ghgfjhf\",\n        \"dob\": \"2014-10-06T00:00:00+00:00\",\n        \"gender\": \"Female\"\n      },\n      \"age\": 2,\n      \"waiting_time\": \"25d \",\n      \"consult_start_status\": \"\",\n      \"start_time\": \"2016-12-24 08:01:00\",\n      \"end_time\": \"2016-12-24 08:11:00\",\n      \"total_accepted\": 0\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"search\" : \"text to be search\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getAppointments.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "Consultations/getConciergeAddress/:consultId",
    "title": "Get patient address",
    "name": "getConciergeAddress",
    "group": "Consumer",
    "description": "<p>Add patient address list.</p>",
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
            "field": "consultId",
            "description": "<ul> <li>Consultation id is required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"concierge_address_name\": \"asdfasfd\",\n    \"concierge_address1\": \"asdf\",\n    \"concierge_address2\": \"asdf\",\n    \"concierge_zip_code\": 352525,\n    \"concierge_state_id\": 1,\n    \"concierge_city\": \"asdf\",\n    \"state\": {\n      \"name\": \"Alaska\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getConciergeAddress.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/consultations/getConsultStatus",
    "title": "To check consultation accept status",
    "name": "getConsultStatus",
    "group": "Consumer",
    "description": "<p>When consumer initiat on demand consultation then on click on connect to provider button this api check provided accepted or not.</p>",
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
            "type": "Array",
            "optional": false,
            "field": "consult_ids",
            "description": "<ul> <li>Consult ids is required field in body(its contain consultation ids).</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"consult_ids\":\"1,2,3\"\n}",
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
            "description": "<p>Contain consultation, provider and consumer details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 148,\n    \"patient_authorization_form\": {\n      \"relationship_to_patient\": \"Father\"\n    },\n    \"consumer\": {\n      \"title\": \"\",\n      \"fname\": \"dhirendra\",\n      \"lname\": \"singh\",\n      \"email\": \"singh@gmail.com\",\n      \"id\": 213\n    },\n    \"provider\": {\n      \"id\": 213,\n      \"title\": \"\",\n      \"email\": \"singh@gmail.com\",\n      \"fname\": \"dhirendra\",\n      \"lname\": \"singh\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getConsultStatus.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/users/getConsumerDetails",
    "title": "Get Consumer Profile",
    "name": "getConsumerDetails",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>get consumer profile details.</p>",
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
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 213,\n    \"user_type_id\": 2,\n    \"group_id\": null,\n    \"title\": \"\",\n    \"fname\": \"dhirendra\",\n    \"mname\": null,\n    \"lname\": \"singh\",\n    \"community_username\": null,\n    \"email\": \"dhirendra.singh@kiwitech.com\",\n    \"username\": \"gau44rav123\",\n    \"newsletter_subsciption_status\": \"Y\",\n    \"photo\": null,\n    \"photo_name\": null,\n    \"ssn_no\": \"\",\n    \"guid\": null,\n    \"forgot_password_request_time\": null,\n    \"dob\": null,\n    \"gender\": \"\",\n    \"terms_of_use\": false,\n    \"activate_key\": \"f5d498a5-76db-415e-bfbb-2d13a2754531\",\n    \"status\": \"Active\",\n    \"stripe_customer_id\": \"cus_9INHHy8k4rkGxs\",\n    \"stripe_card_id\": \"card_18zmWfFspN4AvLfbXi6k9dpw\",\n    \"zoom_user_id\": \"1GG_qMJIRJ6VRdQAuPvzhw\",\n    \"created\": \"2016-11-18T08:23:59+00:00\",\n    \"modified\": \"2016-11-08T15:31:31+00:00\",\n    \"consumer_billing_details\": [\n      {\n        \"id\": 36,\n        \"user_id\": 213,\n        \"address1\": \"rytrtyrty\",\n        \"address2\": \"ertert\",\n        \"city\": \"ertert\",\n        \"state_id\": 1,\n        \"zip_code\": \"12234\",\n        \"primary_phone\": null,\n        \"secondary_phone\": null,\n        \"work_phone\": null,\n        \"fax\": null,\n        \"type\": \"B\",\n        \"created\": \"2016-10-24T09:25:27+00:00\",\n        \"modified\": \"2016-10-24T09:25:43+00:00\",\n        \"state\": {\n          \"name\": \"Alaska\"\n        }\n      },\n      {\n        \"id\": 37,\n        \"user_id\": 213,\n        \"address1\": \"rytrtyrty\",\n        \"address2\": \"ertert\",\n        \"city\": \"ertert\",\n        \"state_id\": 1,\n        \"zip_code\": \"12234\",\n        \"primary_phone\": null,\n        \"secondary_phone\": null,\n        \"work_phone\": null,\n        \"fax\": null,\n        \"type\": \"P\",\n        \"created\": \"2016-10-24T09:25:27+00:00\",\n        \"modified\": \"2016-10-24T09:25:43+00:00\",\n        \"state\": {\n          \"name\": \"Alaska\"\n        }\n      }\n    ],\n    \"stripeCard\": {\n      \"id\": \"card_18zmWfFspN4AvLfbXi6k9dpw\",\n      \"object\": \"card\",\n      \"address_city\": \"City\",\n      \"address_country\": null,\n      \"address_line1\": \"Address 1\",\n      \"address_line1_check\": \"pass\",\n      \"address_line2\": \"Address 2\",\n      \"address_state\": \"American Samoa\",\n      \"address_zip\": \"12345\",\n      \"address_zip_check\": \"pass\",\n      \"brand\": \"Visa\",\n      \"country\": \"US\",\n      \"customer\": \"cus_9INHHy8k4rkGxs\",\n      \"cvc_check\": \"pass\",\n      \"dynamic_last4\": null,\n      \"exp_month\": 4,\n      \"exp_year\": 2022,\n      \"fingerprint\": \"XNDZ0OJ9pXiBdK3J\",\n      \"funding\": \"credit\",\n      \"last4\": \"4242\",\n      \"metadata\": [],\n      \"name\": \"test\",\n      \"tokenization_method\": null\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_consumer_profile.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getList/:1",
    "title": "Patient List",
    "name": "getList",
    "group": "Consumer",
    "description": "<p>Patient list by consumer.</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Send page number in url query string if use pagination</li> </ul>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"list\": [\n      {\n        \"consult_type\": \"scheduled\",\n        \"consultation_status\": \"Completed\",\n        \"consultation_start_date_time\": \"2016-09-27T00:00:00+00:00\",\n        \"consultation_end_date_time\": \"2016-09-27T05:23:34+00:00\",\n        \"issue_type\": {\n          \"name\": \"Dental\"\n        },\n        \"issue\": {\n          \"name\": \"Dental-1\"\n        },\n        \"user\": {\n          \"title\": \"Dr.\",\n          \"fname\": \"gaurav\",\n          \"lname\": \"Provider\"\n        },\n        \"speciality\": {\n          \"title\": \"one\"\n        }\n      }\n    ],\n    \"Page\": {\n      \"finder\": \"all\",\n      \"page\": 1,\n      \"current\": 1,\n      \"count\": 1,\n      \"perPage\": 5,\n      \"prevPage\": false,\n      \"nextPage\": false,\n      \"pageCount\": 1,\n      \"sort\": null,\n      \"direction\": false,\n      \"limit\": null,\n      \"sortDefault\": false,\n      \"directionDefault\": false,\n      \"scope\": null\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/list_patient.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/consultations/getMeetingEndStatus/:consultId",
    "title": "End meeting",
    "name": "getMeetingEndStatus",
    "group": "Consumer",
    "description": "<p>End meeting when duration is completed</p>",
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
            "field": "consultId",
            "description": "<ul> <li>Consultation id required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"Completed\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getMeetingEndStatus.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/Patients/getPatientDetails/:patientId",
    "title": "Get Patient Details",
    "name": "getPatientDetails",
    "group": "Consumer",
    "description": "<p>Get Patient Details.</p>",
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n    \"status\": true,\n    \"message\": \"The request is OK\",\n    \"data\": {\n        \"id\": 1,\n        \"user_id\": 66,\n        \"fname\": \"Ronnytwo\",\n        \"lname\": \"Dawntwo\",\n        \"dob\": \"2003-02-02T00:00:00+00:00\",\n        \"gender\": \"Male\",\n        \"child_lives_with\": \"Mother\",\n        \"ssn_no\": \"\",\n        \"status\": \"Deleted\",\n        \"release_info_authrization\": true,\n        \"created\": \"2016-09-27T12:55:19+00:00\",\n        \"modified\": \"2016-09-27T12:55:19+00:00\"\n    }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_details.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/Patients/getPatientDetailsForEdit/:patientId",
    "title": "Get Patient Details For Edit",
    "name": "getPatientDetailsForEdit",
    "group": "Consumer",
    "description": "<p>Get Patient Details For Edit.</p>",
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 3,\n    \"fname\": \"Jack\",\n    \"lname\": \"Doe\",\n    \"dob\": \"2000-09-05T00:00:00+00:00\",\n    \"gender\": \"Male\",\n    \"child_lives_with\": \"Mother\",\n    \"ssn_no\": \"\",\n    \"status\": \"Active\",\n    \"release_info_authrization\": true,\n    \"created\": \"2016-09-27T10:03:38+00:00\",\n    \"modified\": \"2016-09-27T10:03:38+00:00\",\n    \"patient_insurances\": [\n      {\n        \"id\": 1,\n        \"patient_id\": 1,\n        \"company_name\": \"ABV\",\n        \"holder_name\": \"AMSS\",\n        \"policy_number\": \"11\"\n      },\n      {\n        \"id\": 2,\n        \"patient_id\": 1,\n        \"company_name\": \"ABV\",\n        \"holder_name\": \"AMSS\",\n        \"policy_number\": \"1\"\n      }\n    ],\n    \"patient_authorization_form\": {\n      \"id\": 1,\n      \"patient_id\": 1,\n      \"patient_first_name\": \"Jack\",\n      \"patient_last_name\": \"Doe\",\n      \"patient_dob\": \"2000-02-02T00:00:00+00:00\",\n      \"name_of_person\": \"Ravi\",\n      \"relationship_to_patient\": \"Teacher\",\n      \"reason_for_disclosure\": \"Treatment\",\n      \"terms_and_conditions\": true,\n      \"status\": \"Active\",\n      \"created\": \"2016-09-27T10:03:38+00:00\",\n      \"modified\": \"2016-09-27T10:03:38+00:00\"\n    },\n    \"patient_parent\": {\n      \"id\": 1,\n      \"patient_id\": 1,\n      \"mother_fname\": \"Ammy\",\n      \"mother_lname\": \"samsung\",\n      \"mother_dob\": \"1980-02-02T00:00:00+00:00\",\n      \"mother_ssn_no\": \"111-11-1111\",\n      \"mother_address\": \"NYC circle 2-400\",\n      \"mother_cell_no\": \"9540420501\",\n      \"mother_home_phone_no\": \"9876543211\",\n      \"mother_employer\": \"Google\",\n      \"mother_work_phone_no\": \"9876543211\",\n      \"father_fname\": \"Niel\",\n      \"father_lname\": \"jhonsan\",\n      \"father_dob\": \"1978-02-02T00:00:00+00:00\",\n      \"father_ssn_no\": \"222-22-2222\",\n      \"father_address\": \"NYC circle 2-400\",\n      \"father_cell_no\": \"9504435001\",\n      \"father_home_phone_no\": \"9876543211\",\n      \"father_employer\": \"Yahoo\",\n      \"father_work_phone_no\": \"9876543211\",\n      \"martial_status\": \"Married\",\n      \"emergency_contact_fname\": \"Ricky\",\n      \"emergency_contact_lname\": \"Bell\",\n      \"emergency_contact_address\": \"NYC circle 2-400\",\n      \"emergency_contact_cell_no\": \"9876543211\",\n      \"emergency_contact_home_no\": \"9876543211\",\n      \"status\": \"Active\",\n      \"created\": \"2016-09-27T10:03:38+00:00\",\n      \"modified\": \"2016-09-27T10:03:38+00:00\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_details_for_edit.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getPatientsByConsumer",
    "title": "Get patient by consumer",
    "name": "getPatientsByConsumer",
    "group": "Consumer",
    "description": "<p>Get patient details by consumer authentication.</p>",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"fname\": \"name1\",\n      \"lname\": \"lname1\"\n    },\n    {\n      \"id\": 2,\n      \"fname\": \"name2\",\n      \"lname\": \"lname2\"\n    },\n    {\n      \"id\": 3,\n      \"fname\": \"name3\",\n      \"lname\": \"lname3\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getPatientsByConsumer.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getProviderDetailsById",
    "title": "Get provider detail for schedule appointment",
    "name": "getProviderDetailsById",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get provider details by id for appointment to be scheduled.</p>",
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
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Concierge service is required in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers..</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 166,\n    \"title\": \"Doctor\",\n    \"photo\": \"https://face2face-dev.s3.amazonaws.com/profileImage/57f51cbc2bd3f.jpeg\",\n    \"fname\": \"Raj\",\n    \"lname\": \"Jhaveri\",\n    \"dob\": \"1984-01-25T00:00:00+00:00\",\n    \"gender\": \"Male\",\n    \"provider_profile\": {\n      \"city\": \"New York\",\n      \"id\": 17,\n      \"speciality\": {\n        \"id\":\"2\",\n        \"title\": \"Physicians\",\n        \"scheduled_price\": null,\n        \"concierge_price\": 200\n      },\n      \"state\": {\n        \"id\": 37,\n        \"name\": \"New York\"\n      }\n    },\n    \"provider_setting\": {\n      \"id\": 1,\n      \"scheduled_insurance_charges\": 90,\n      \"scheduled_non_insurance_charges\": 0\n    },\n    \"total_amount\": 180,\n    \"is_insurance_applied\": false\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_id\":\"166\",\n\t\"consultation_start_date\": \"11/15/2016\",\n\t\"consultation_start_time\": \"13:08:00\",\n\t\"consultation_end_time\": \"13:20:00\",\n\t\"insurance_plan_id\":\"3\",\n\t\"concierge_service\":\"Y\",\n\t\"patient_id\":\"1\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getProviderDetailsById.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getProviderDetailsByIdForMultiProvider",
    "title": "Get provider detail for multiprovider appointment",
    "name": "getProviderDetailsByIdForMultiProvider",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get provider details by id for schedule an multiprovider schedule appointment.</p>",
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
            "type": "Array",
            "optional": false,
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers..</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"list\": {\n      \"166\": {\n        \"id\": 166,\n        \"title\": \"Doctor\",\n        \"photo\": \"https://face2face-dev.s3.amazonaws.com/profileImage/57f51cbc2bd3f.jpeg\",\n        \"fname\": \"Raj\",\n        \"lname\": \"Jhaveri\",\n        \"dob\": \"1984-01-25T00:00:00+00:00\",\n        \"gender\": \"Male\",\n        \"provider_profile\": {\n          \"city\": \"New York\",\n          \"id\": 17,\n          \"speciality\": {\n            \"id\":\"4\",\n            \"title\": \"Physicians\",\n            \"scheduled_price\": 400,\n            \"concierge_price\": 200\n          },\n          \"state\": {\n            \"id\": 37,\n            \"name\": \"New York\"\n          }\n        },\n        \"provider_setting\": {\n          \"id\": 1,\n          \"scheduled_insurance_charges\": 90,\n          \"scheduled_non_insurance_charges\": 0\n        },\n        \"total_amount\": 800,\n        \"is_insurance_applied\": false\n      }\n    },\n    \"total_amount\": 800\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_id\":[166,167,168,169,170],\n\t\"insurance_plan_id\":\"3\",\n\t\"patient_id\":\"1\",\n\t\"consultation_start_time\":\"02:31:00\",\n\t\"consultation_end_time\":\"02:42:00\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getProviderDetailsByIdForMultiProvider.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getProviderDetailsByIdForOnDemand",
    "title": "Get provider detail for on demand appointment",
    "name": "getProviderDetailsByIdForOnDemand",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get provider details by id for schedule an on demand appointment.</p>",
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
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers..</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 166,\n    \"title\": \"Doctor\",\n    \"photo\": \"https://face2face-dev.s3.amazonaws.com/profileImage/57f51cbc2bd3f.jpeg\",\n    \"fname\": \"Raj\",\n    \"lname\": \"Jhaveri\",\n    \"dob\": \"1984-01-25T00:00:00+00:00\",\n    \"gender\": \"Male\",\n    \"provider_profile\": {\n      \"city\": \"New York\",\n      \"id\": 17,\n      \"speciality\": {\n        \"id\": 4,\n        \"title\": \"Physicians\",\n        \"on_demand_price\": 400,\n        \"concierge_price\": 200\n      },\n      \"state\": {\n        \"id\": 37,\n        \"name\": \"New York\"\n      }\n    },\n    \"provider_setting\": {\n      \"id\": 1,\n      \"on_demand_insurance_charges\": 90,\n      \"on_demand_non_insurance_charges\": 0\n    },\n    \"total_amount\": 180,\n    \"is_insurance_applied\": false\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"provider_id\":\"166\",\n\t\"insurance_plan_id\":\"3\",\n\t\"patient_id\":\"1\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getProviderDetailsByIdForOnDemand.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/getProvidersForScheduleAppointment",
    "title": "Search providers for schedule an appointment",
    "name": "getProvidersForScheduleAppointment",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Search providers for schedule an appointment.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "video_call",
            "description": "<ul> <li>Video call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone_call",
            "description": "<ul> <li>Phone call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Concierge service is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "multi_video_consult",
            "description": "<ul> <li>Multi video consult is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time is required field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"678\": {\n      \"id\": 113,\n      \"title\": \"Mr.\",\n      \"photo\": \"Abs.jpeg\",\n      \"fname\": \"Nikum\",\n      \"lname\": \"Sir\",\n      \"dob\": \"1988-04-07T00:00:00+00:00\",\n      \"gender\": \"Male\",\n      \"provider_profile\": {\n        \"id\": 2,\n        \"city\": \"NYC\",\n        \"zip\": \"201301\",\n        \"speciality\": {\n          \"title\": \"Dentists\",\n          \"scheduled_price\": 200,\n          \"concierge_price\": 200\n        },\n        \"state\": {\n          \"id\": 1,\n          \"name\": \"Alaska\"\n        }\n      },\n      \"provider_setting\": {\n        \"id\": 202,\n        \"scheduled_insurance_charges\": 23.99,\n        \"scheduled_non_insurance_charges\": 22.9\n      },\n      \"provider_license_and_insurances\": [\n        {\n          \"user_id\": 113,\n          \"state_id\": 1,\n          \"id\": 3\n        },\n        {\n          \"user_id\": 113,\n          \"state_id\": 1,\n          \"id\": 4\n        },\n        {\n          \"user_id\": 113,\n          \"state_id\": 2,\n          \"id\": 5\n        },\n        {\n          \"user_id\": 113,\n          \"state_id\": 2,\n          \"id\": 6\n        }\n      ],\n      \"is_insurance_applied\": false\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_type_id\":\"1\",\n\t\"video_call\":\"N\",\n\t\"phone_call\":\"N\",\n\t\"concierge_service\":\"N\",\n\t\"multi_video_consult\":\"N\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"provider_name\":\"ravi\",\n\t\"problem_description\":\"dsfa\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getProvidersForScheduleAppointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "Consultations/getSpecialityPrice/:consultationId/:minutes",
    "title": "Get Speciality Price",
    "name": "getSpecialityPrice",
    "group": "Consumer",
    "description": "<p>Get Speciality Price</p>",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "TOKEN",
            "description": "<ul> <li>A token send by header as TOKEN is optional</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"specialityPrice\": 100\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getSpecialityPrice.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/states/getStateByZipcode/99501",
    "title": "Get state by zipcode",
    "version": "0.0.1",
    "name": "getStateByZipcode",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get state by zipcode.</p>",
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
            "field": "zipcode",
            "description": "<ul> <li>Zipcode required field in url query string.</li> </ul>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"name\": \"Alaska\",\n    \"abbrev\": \"AK\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/getStateByZipcode.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "get",
    "url": "/consultations/isConsultStarted/:consultId",
    "title": "To check consultation start or not",
    "name": "isConsultStarted",
    "group": "Consumer",
    "description": "<p>To check consultation start or not</p>",
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
            "field": "consultId",
            "description": "<ul> <li>Consult id is required field in query string.</li> </ul>"
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
            "description": "<p>Contain consultation, provider and consumer details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 148,\n    \"join_url\": \"https://zoom.us/j/729811243?pwd=tWzAHHXJzXQ%3D\",\n    \"endMeeting\":\"1213131\",\n    \"speciality_id\":\"2\",\n    \"consumer\": {\n      \"fname\": \"dhirendra\",\n      \"lname\": \"singh\",\n      \"email\": \"dhirendra.singh@kiwitech.com\",\n      \"id\": 213\n    },\n    \"provider\": {\n      \"id\": 213,\n      \"email\": \"dhirendra.singh@kiwitech.com\",\n      \"fname\": \"dhirendra\",\n      \"lname\": \"singh\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/isConsultStarted.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/onDemandAppointment",
    "title": "Schedule On-Demand Appointment",
    "name": "onDemandAppointment",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Consumer can schedule on demand appointment with provider.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "video_call",
            "description": "<ul> <li>Video call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone_call",
            "description": "<ul> <li>Phone call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Concierge service is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "multi_video_consult",
            "description": "<ul> <li>Multi video consult is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_name",
            "description": "<ul> <li>Consultation name is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_lname",
            "description": "<ul> <li>Consultation last name is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_dob",
            "description": "<ul> <li>Consultation date of birth is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "provider_ids",
            "description": "<ul> <li>Provider ids is optional field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about provider.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"consult_ids\": \"153,154,155,156,157\",\n    \"provider_ids\": \"182,206,210,211,212\",\n    \"consumer\": {\n      \"dob\": \"2014-10-06T00:00:00+00:00\",\n      \"id\": 1,\n      \"patient_authorization_form\": {\n        \"relationship_to_patient\": \"Father\"\n      },\n      \"user\": {\n        \"id\": 213,\n        \"dob\": null,\n        \"fname\": \"dhirendra\",\n        \"lname\": \"singh\",\n        \"consumer_age\": \"\"\n      },\n      \"patient_age\": 2,\n      \"address\": {\n        \"address1\": \"rytrtyrty\",\n        \"address2\": \"ertert\",\n        \"city\": \"ertert\",\n        \"state\": {\n          \"name\": \"Alaska\"\n        }\n      }\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_type_id\":\"1\",\n\t\"video_call\":\"N\",\n\t\"phone_call\":\"N\",\n\t\"concierge_service\":\"N\",\n\t\"multi_video_consult\":\"N\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"problem_description\":\"dsfa\",\n\t\"consultation_name\":\"dhiru\",\n\t\"consultation_lname\":\"singh\",\n\t\"consultation_dob\":\"1990-11-07\",\n\t\"provider_ids\": \"13,43,56\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/onDemandAppointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "put",
    "url": "/patients/patientDelete/:24",
    "title": "Delete Patient",
    "name": "patientDelete",
    "group": "Consumer",
    "description": "<p>Consumer can delete the patinet.</p>",
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
            "field": "/:24",
            "description": "<ul> <li>Patient id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_patient.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/consultations/providerStrikeOnConcierge",
    "title": "Record provider strike",
    "name": "providerStrikeOnConcierge",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Record provider strike by consumer.</p>",
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
            "field": "consultation_id",
            "description": "<ul> <li>Consultation id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required field in body.</li> </ul>"
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
            "description": "<p>Null.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"Provider\": {\n      \"email\": \"subhash.kumar@kiwitech.com\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n    \"consultation_id\": \"148\",\n    \"provider_id\":\"1\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/providerStrikeOnConcierge.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "put",
    "url": "Consultations/reScheduleConsultByConsumer",
    "title": "Reschedule Consult By Consumer",
    "name": "reScheduleConsultByConsumer",
    "group": "Consumer",
    "description": "<p>Reschedule Consult By Consumer</p>",
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
            "field": "consult_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n\t\"consult_id\": 1,\n\t\"consultation_start_date\": \"2016-10-18\",\n\t\"consultation_start_time\": \"06:50:00\",\n\t\"consultation_end_time\": \"07:00:00\"\n }",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}\n{\n\"status\": false,\n\"message\": \"Consult not re-scheduled, Please try again\"\n}\n{\n\"status\": false,\n\"message\": \"Appoinment not available for selected date and time\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/reschedule_appoinment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/scheduleAnAppointment",
    "title": "Schedule An Appointment",
    "name": "scheduleAnAppointment",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>schedule an appointment.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "zip_code",
            "description": "<ul> <li>Zip code is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_name",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_lname",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_dob",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_code",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "consultation_charge",
            "description": "<ul> <li>Consultation charge is optional field in body.\\</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_charge",
            "description": "<ul> <li>Consultation speciality charge is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_type",
            "description": "<ul> <li>Consultation type is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "stripe_card_id",
            "description": "<ul> <li>Stripe card id type is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_address_name",
            "description": "<ul> <li>Concierge address name is optional field in body(required if consult type concierge).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_address1",
            "description": "<ul> <li>Concierge address1 is optional field in body(required if consult type concierge).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_address2",
            "description": "<ul> <li>Concierge address2 is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_zip_code",
            "description": "<ul> <li>Concierge zip_code is optional field in body(required if consult type concierge).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_state_id",
            "description": "<ul> <li>Concierge state id is optional field in body(required if consult type concierge).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_city",
            "description": "<ul> <li>Concierge city is optional field in body(required if consult type concierge).</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_id\":\"1\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\",\n\t\"zip_code\":\"456231\",\n\t\"consultation_name\":\"dhi\",\n\t\"consultation_lname\":\"si\",\n\t\"consultation_dob\":\"2024-11-04\",\n\t\"coupon_code\":\"CSdF\",\n\t\"consultation_charge\":\"4522\",\n\t\"speciality_charge\":\"5000\",\n\t\"consult_type\":\"Scheduled\",\n\t\"concierge_address_name\":\"card_dafsf42234\",\n\t\"concierge_address1\":\"card_dafsf42234\",\n\t\"concierge_address2\":\"card_dafsf42234\",\n\t\"concierge_zip_code\":\"card_dafsf42234\",\n\t\"concierge_state_id\":\"card_dafsf42234\",\n\t\"concierge_city\":\"card_dafsf42234\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/scheduleAnAppointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/scheduleMultiProviderAppointment",
    "title": "Schedule multi provider appointment",
    "name": "scheduleMultiProviderAppointment",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>schedule an appointment.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_id",
            "description": "<ul> <li>Provider id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Numeric",
            "optional": false,
            "field": "zip_code",
            "description": "<ul> <li>Zip code is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_name",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consultation_lname",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_dob",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_code",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "consultation_charge",
            "description": "<ul> <li>Consultation charge is optional field in body.\\</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_charge",
            "description": "<ul> <li>Consultation speciality charge is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_type",
            "description": "<ul> <li>Consultation type is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "stripe_card_id",
            "description": "<ul> <li>Stripe card id type is required field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n   \"0\":{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_id\":\"1\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\",\n\t\"zip_code\":\"456231\",\n\t\"consultation_name\":\"dhi\",\n\t\"consultation_lname\":\"si\",\n\t\"consultation_dob\":\"2024-11-04\",\n\t\"coupon_code\":\"CSdF\",\n\t\"consultation_total_charge\":\"4000\",\n\t\"speciality_unit_charge\":\"4500\",\n\t\"consult_type\":\"Scheduled\",\n\t\"stripe_card_id\":\"card_dafsf42234\"\n   },\n \"1\":{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_id\":\"1\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\",\n\t\"zip_code\":\"456231\",\n\t\"consultation_name\":\"dhi\",\n\t\"consultation_lname\":\"si\",\n\t\"consultation_dob\":\"2024-11-04\",\n\t\"coupon_code\":\"CSdF\",\n\t\"consultation_total_charge\":\"4000\",\n\t\"speciality_unit_charge\":\"4500\",\n\t\"consult_type\":\"Scheduled\",\n\t\"stripe_card_id\":\"card_dafsf42234\"\n   },\n \"3\":{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_id\":\"1\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\",\n\t\"zip_code\":\"456231\",\n\t\"consultation_name\":\"dhi\",\n\t\"consultation_lname\":\"si\",\n\t\"consultation_dob\":\"2024-11-04\",\n\t\"coupon_code\":\"CSdF\",\n\t\"consultation_total_charge\":\"4000\",\n\t\"speciality_unit_charge\":\"4500\",\n\t\"consult_type\":\"Scheduled\",\n\t\"stripe_card_id\":\"card_dafsf42234\"\n   },\n   \"provider_total_charge\":\"456231\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/scheduleMultiProviderAppointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/searchProviderForOnDemandAppointment",
    "title": "Search provider for on-demand appointment",
    "name": "searchProviderForOnDemandAppointment",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Search provider for on-demand appointment.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "video_call",
            "description": "<ul> <li>Video call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone_call",
            "description": "<ul> <li>Phone call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Concierge service is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "multi_video_consult",
            "description": "<ul> <li>Multi video consult is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about provider.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_type_id\":\"1\",\n\t\"video_call\":\"N\",\n\t\"phone_call\":\"N\",\n\t\"concierge_service\":\"N\",\n\t\"multi_video_consult\":\"N\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"problem_description\":\"dsfa\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/searchProviderForOnDemandAppointment.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/searchProvidersForMultiSchedule",
    "title": "Multi provider appointment",
    "name": "searchProvidersForMultiSchedule",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Search providers for schedule a multi provider appointment.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "video_call",
            "description": "<ul> <li>Video call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone_call",
            "description": "<ul> <li>Phone call is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Concierge service is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "multi_video_consult",
            "description": "<ul> <li>Multi video consult is optional field in body(Y|N).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consult_medium",
            "description": "<ul> <li>Consult medium is optional field in body(Phone|Video).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_type_id",
            "description": "<ul> <li>Inquiry type id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "inquiry_id",
            "description": "<ul> <li>Inquiry id is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "problem_description",
            "description": "<ul> <li>Problem description is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "consultation_start_date",
            "description": "<ul> <li>Consultation start date is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_start_time",
            "description": "<ul> <li>Consultation start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "consultation_end_time",
            "description": "<ul> <li>Consultation end time is required field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"678\": {\n      \"id\": 113,\n      \"title\": \"Mr.\",\n      \"photo\": \"Abs.jpeg\",\n      \"fname\": \"Nikum\",\n      \"lname\": \"Sir\",\n      \"dob\": \"1988-04-07T00:00:00+00:00\",\n      \"gender\": \"Male\",\n      \"provider_profile\": {\n        \"id\": 2,\n        \"city\": \"NYC\",\n        \"zip\": \"201301\",\n        \"speciality\": {\n          \"title\": \"Dentists\",\n          \"scheduled_price\": 23.99,\n          \"concierge_price\": 200\n        },\n        \"state\": {\n          \"id\": 1,\n          \"name\": \"Alaska\"\n        }\n      },\n      \"provider_setting\": {\n        \"id\": 202,\n        \"scheduled_insurance_charges\": 23.99,\n        \"scheduled_non_insurance_charges\": 22.9\n      },\n      \"provider_license_and_insurances\": [\n        {\n          \"user_id\": 113,\n          \"state_id\": 1,\n          \"id\": 3\n        },\n        {\n          \"user_id\": 113,\n          \"state_id\": 1,\n          \"id\": 4\n        }\n      ],\n      \"provider_age\": 28,\n      \"is_insurance_applied\": false\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"patient_id\":\"1\",\n\t\"speciality_id\":\"1\",\n\t\"provider_type_id\":\"3\",\n\t\"video_call\":\"N\",\n\t\"phone_call\":\"N\",\n\t\"concierge_service\":\"N\",\n\t\"multi_video_consult\":\"Y\",\n\t\"insurance_plan_id\":\"1\",\n\t\"consult_medium\":\"Phone\",\n\t\"inquiry_type_id\":\"1\",\n\t\"inquiry_id\":\"1\",\n\t\"provider_name\":\"ravi\",\n\t\"problem_description\":\"dsfa\",\n\t\"consultation_start_date\":\"2016-11-03\",\n\t\"consultation_start_time\":\"12:31:03\",\n\t\"consultation_end_time\":\"00:31:03\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/searchProvidersForMultiSchedule.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "consultations/updateAppointmentById",
    "title": "Update appointment by id",
    "name": "updateAppointmentById",
    "group": "Consumer",
    "description": "<p>Update appointment by id.</p>",
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
            "description": "<ul> <li>Appointment id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "view_issue_type",
            "description": "<p>*View issue type is required field in body (Yes|No).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "view_patient_form",
            "description": "<p>*View patient form is required field in body (Yes|No).</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "view_patient_history",
            "description": "<p>*View patient history is required field in body (Yes|No).</p>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"id\":\"148\",\n    \"view_issue_type\":\"Yes\",\n    \"view_patient_form\":\"Yes\",\n    \"view_patient_history\":\"Yes\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateAppointmentById.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/users/updateConsumerProfile",
    "title": "Update Consumer Profile",
    "name": "updateConsumerProfile",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Update consumer profile.</p>",
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
            "field": "community_username",
            "description": "<ul> <li>Consumer community username required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Consumer Suffix optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "fname",
            "description": "<ul> <li>Consumer first name required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mname",
            "description": "<ul> <li>Consumer middle name optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lname",
            "description": "<ul> <li>Consumer last name required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Consumer email required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "stripe_card_id",
            "description": "<ul> <li>Consumer card optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<ul> <li>Consumer payment failed type optional field in body(consultation|plan).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "consumer_billing_details",
            "description": "<ul> <li>Consumer Billing Detail.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.id",
            "description": "<ul> <li>Consumer delivery id required if already save field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.address1",
            "description": "<ul> <li>Consumer delivery first address required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.address2",
            "description": "<ul> <li>Consumer delivery second address required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.city",
            "description": "<ul> <li>Consumer delivery city required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.state_id",
            "description": "<ul> <li>Consumer delivery state id required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.zip_code",
            "description": "<ul> <li>Consumer delivery zip code required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.primary_phone",
            "description": "<ul> <li>Consumer delivery primary phone number required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.secondary_phone",
            "description": "<ul> <li>Consumer delivery secondary phone number required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.work_phone",
            "description": "<ul> <li>Consumer delivery work phone number required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.fax",
            "description": "<ul> <li>Consumer delivery fax number required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "consumer_billing_details.type",
            "description": "<ul> <li>Consumer address type required field in body(P|B).</li> </ul>"
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
            "description": "<p>Consumer Object contain details about consumer profile.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"community_username\": \"singh\",\n    \"title\": \"\",\n    \"fname\": \"dhirendra\",\n    \"mname\": \"\",\n    \"lname\": \"singh\",\n    \"email\": \"singh@gmail.com\",\n    \"stripe_card_id\": \"card_18zmWfFspN4AvLfbXi6k9dpw\",\n    \"consumer_billing_details\": [\n      {\n        \"id\": \"1\",\n        \"address1\": \"Agara3333\",\n        \"address2\": \"asdf\",\n        \"city\": \"alld\",\n        \"state_id\": \"1\",\n        \"zip_code\": \"125535\",\n        \"primary_phone\": \"2324253455\",\n        \"secondary_phone\": \"2324253455\",\n        \"work_phone\": \"2324253455\",\n        \"fax\": \"23242534455\",\n        \"type\": \"P\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\"community_username\":\"singha\",\n\"title\": \"Mr.\",\n\"fname\": \"dhirendra\",\n\"mname\": \"kumar\",\n\"lname\":\"singh\",\n\"email\":\"singh@gmail.com\",\n\"stripe_card_id\":\"card_18zmWfFspN4AvLfbXi6k9dpw\",\n\"type\":\"consultation|plan\",\n\"consumer_billing_details\":{\n\t\"0\":{\n\t\t\"id\":\"1\",\n\t\t\"address1\":\"sssss\",\n\t\t\"address2\":\"Dhiru\",\n\t\t\"city\":\"alld\",\n\t\t\"state_id\":\"1\",\n\t\t\"zip_code\":\"125535\",\n\t\t\"primary_phone\":\"2324253455\",\n\t\t\"secondary_phone\":\"2324253455\",\n\t\t\"work_phone\":\"2324253455\",\n\t\t\"fax\":\"23242534455\",\n\t\t\"type\":\"P\"\n\t}\n}\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/update_consumer_profile.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/patients/updateOndemandAppointmentDetails",
    "title": "Update on-demand appointment details",
    "name": "updateOndemandAppointmentDetails",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Update on-demand appointment details.</p>",
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
            "description": "<ul> <li>Id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>patint_id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_id",
            "description": "<ul> <li>Speciality id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_code",
            "description": "<ul> <li>Consultation end time is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "consultation_total_charge",
            "description": "<ul> <li>Consultation charge amount is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "speciality_unit_charge",
            "description": "<ul> <li>Speciality charge is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "stripe_card_id",
            "description": "<ul> <li>Stripe card id type is required field in body.</li> </ul>"
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
            "description": "<p>Provider Object contain details about providers.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"meeting_id\": 211314314,\n    \"start_url\": \"https://zoom.us/s/123456789?zpk=hs65q23kd9sqliy612h23k\",\n    \"join_url\": \"https://zoom.us/j/123456789\",\n    \"meeting_duration\": 10\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n    \"id\":\"1\",\n    \"patient_id\":\"2\",\n    \"speciality_id\":\"3\",\n    \"coupon_code\":\"CSdF\",\n    \"consultation_total_charge\":\"4522\",\n    \"speciality_unit_charge\":\"4000\",\n    \"stripe_card_id\":\"card_dafsf42234\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateOndemandAppointmentDetails.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/states/validateZipcodeByState",
    "title": "validate zip-code by state",
    "version": "0.0.1",
    "name": "validateZipcodeByState",
    "group": "Consumer",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Validate zip-code by state id.</p>",
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
            "field": "state_id",
            "description": "<ul> <li>State id required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "zip_code",
            "description": "<ul> <li>Zipcode required field in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"state_id\": \"1\",\n\t\"zip_code\": \"99501\"\n}",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n{\n    \"status\": true/false,\n    \"message\": \"The request is OK\",\n    \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/validateZipcodeByState.js",
    "groupTitle": "Consumer"
  },
  {
    "type": "post",
    "url": "/Comments/add",
    "title": "Add comment",
    "version": "0.0.1",
    "name": "Add_comment",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Add comments</p>",
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
            "field": "forum_id",
            "description": "<ul> <li>Forum id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<ul> <li>Description of comment.</li> </ul>"
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
            "description": "<p>true/false.</p>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"forum_id\":\"42\",\n\t\"description\":\"Test\"\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/add_comments.js",
    "groupTitle": "Forums"
  },
  {
    "type": "post",
    "url": "/Forums/add",
    "title": "Add forum",
    "version": "0.0.1",
    "name": "Add_forum",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Add forum.</p>",
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
            "field": "title",
            "description": "<ul> <li>Title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<ul> <li>Description</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "age_group_id",
            "description": "<ul> <li>Age group id</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"title\":\"Fever\",\n\t\"description\":\"Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum \",\n\t\"provider_type_id\":\"10\",\n\t\"age_group_id\":\"15\",\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n \n{\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/add_forums.js",
    "groupTitle": "Forums"
  },
  {
    "type": "put",
    "url": "/Comments/delete/:19",
    "title": "Delete comment",
    "name": "Delete_comment",
    "group": "Forums",
    "description": "<p>Consumer can delete the comment.</p>",
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
            "field": "/:24",
            "description": "<ul> <li>Comment id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_comments.js",
    "groupTitle": "Forums"
  },
  {
    "type": "put",
    "url": "Forums/delete/:41",
    "title": "Delete forums",
    "name": "Delete_forums",
    "group": "Forums",
    "description": "<p>Consumer can delete the forum.</p>",
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
            "field": "/:24",
            "description": "<ul> <li>Forum id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_forums.js",
    "groupTitle": "Forums"
  },
  {
    "type": "put",
    "url": "/Comments/edit:1",
    "title": "Edit comment",
    "version": "0.0.1",
    "name": "Edit_comment",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Edit comments</p>",
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
            "field": "/:24",
            "description": "<ul> <li>Comment id requried field in url query string</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<ul> <li>Description of comment.</li> </ul>"
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
            "description": "<p>true/false.</p>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"description\":\"Test\"\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/edit_comments.js",
    "groupTitle": "Forums"
  },
  {
    "type": "put",
    "url": "/Forums/edit:1",
    "title": "Edit forum",
    "version": "0.0.1",
    "name": "Edit_forum",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Edit forum.</p>",
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
            "field": "/:24",
            "description": "<ul> <li>Forum id requried field in url query string</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<ul> <li>Description</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "provider_type_id",
            "description": "<ul> <li>Provider type id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "age_group_id",
            "description": "<ul> <li>Age group id</li> </ul>"
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
            "description": "<p>true/false.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is OK.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n\n{\n\t\"title\":\"Fever\",\n\t\"description\":\"Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum \"\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n \n{\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/edit_forums.js",
    "groupTitle": "Forums"
  },
  {
    "type": "post",
    "url": "/Comments/reply",
    "title": "Reply",
    "version": "0.0.1",
    "name": "Reply",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Add reply by consumer.</p>",
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
            "field": "forum_id",
            "description": "<ul> <li>Forum id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "parent",
            "description": "<ul> <li>Comment id for reply</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<ul> <li>Description</li> </ul>"
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
            "description": "<p>true/false.</p>"
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
            "description": "<p>Patient Object contain details about patient.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n\t\"status\": true\n\t\"message\": \"The request is OK\"\n\t\"data\":  \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"forum_id\":\"42\",\n\t\"parent\":\"4\",\n\t\"description\":\"Testt\"\n}",
        "type": "json"
      }
    ],
    "error": {
      "fields": {
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
        ],
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "type": "Object",
            "optional": false,
            "field": "Error-Response",
            "description": "<p>Returns a json Object.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Sample Error-Response:",
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "input/add_reply.js",
    "groupTitle": "Forums"
  },
  {
    "type": "get",
    "url": "Forums/getLastcommentedBy/:42",
    "title": "Get last commented by",
    "name": "getLastcommentedBy",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Get last commented by.</p>",
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
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"created\": \"2016-12-23T14:25:36+00:00\",\n    \"count\": 6,\n    \"user\": {\n      \"id\": 280,\n      \"fname\": \"Ashutosh\",\n      \"lname\": \"Agrawal\",\n      \"community_username\": null\n    },\n    \"totalUsers\": 1\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_last_commented_by.js",
    "groupTitle": "Forums"
  },
  {
    "type": "get",
    "url": "/Forums/viewForum/42",
    "title": "View forum",
    "name": "viewForum",
    "group": "Forums",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>View Forum and comments.</p>",
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
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n    \"status\": true,\n    \"message\": \"The request is OK\",\n    \"data\": {\n        \"id\": 1,\n        \"provider_type_id\": 1,\n        \"title\": \"Fever\",\n        \"description\": \"Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum Lorem lipsum \",\n        \"topicCreated\": \"2016-12-23T11:03:28+00:00\",\n        \"commentsCount\": 6,\n        \"UserInfo\": {\n            \"fname\": \"Ashutosh\",\n            \"mname\": null,\n            \"lname\": \"Agrawal\",\n            \"community_username\": null,\n            \"photo\": null\n        },\n        \"provider_type\": {\n            \"icon_image\": \"https://face2face-dev.s3.amazonaws.com/page/17980426_caduceus_red_circle_glossy_web_icon_on_white_background_stock_photo_20161130141338.jpg\"\n        },\n        \"Comments\": {\n            \"1\": {\n                \"id\": 1,\n                \"forum_id\": 1,\n                \"parent\": 0,\n                \"description\": \"Testt\",\n                \"user_id\": 280,\n                \"status\": \"Active\",\n                \"created\": \"2016-12-23T14:25:36+00:00\",\n                \"modified\": \"2016-12-23T14:25:36+00:00\",\n                \"user\": {\n                    \"id\": 280,\n                    \"fname\": \"Ashutosh\",\n                    \"lname\": \"Agrawal\",\n                    \"community_username\": null,\n                    \"consumer_billing_details\": [\n                        {\n                            \"city\": \"City\",\n                            \"user_id\": 280,\n                            \"state\": {\n                                \"abbrev\": \"AK\"\n                            }\n                        }\n                    ]\n                },\n                \"child\": [\n                    {\n                        \"id\": 5,\n                        \"forum_id\": 1,\n                        \"parent\": 1,\n                        \"description\": \"Testt\",\n                        \"user_id\": 280,\n                        \"status\": \"Active\",\n                        \"created\": \"2016-12-23T15:08:15+00:00\",\n                        \"modified\": \"2016-12-23T15:08:15+00:00\",\n                        \"user\": {\n                            \"id\": 280,\n                            \"fname\": \"Ashutosh\",\n                            \"lname\": \"Agrawal\",\n                            \"community_username\": null,\n                            \"consumer_billing_details\": [\n                                {\n                                    \"city\": \"City\",\n                                    \"user_id\": 280,\n                                    \"state\": {\n                                        \"abbrev\": \"AK\"\n                                    }\n                                }\n                            ]\n                        }\n                    },\n                    {\n                        \"id\": 6,\n                        \"forum_id\": 1,\n                        \"parent\": 1,\n                        \"description\": \"Testt\",\n                        \"user_id\": 280,\n                        \"status\": \"Active\",\n                        \"created\": \"2016-12-23T15:08:20+00:00\",\n                        \"modified\": \"2016-12-23T15:08:20+00:00\",\n                        \"user\": {\n                            \"id\": 280,\n                            \"fname\": \"Ashutosh\",\n                            \"lname\": \"Agrawal\",\n                            \"community_username\": null,\n                            \"consumer_billing_details\": [\n                                {\n                                    \"city\": \"City\",\n                                    \"user_id\": 280,\n                                    \"state\": {\n                                        \"abbrev\": \"AK\"\n                                    }\n                                }\n                            ]\n                        }\n                    }\n                ]\n            },\n            \"2\": {\n                \"id\": 2,\n                \"forum_id\": 1,\n                \"parent\": 0,\n                \"description\": \"Testttt\",\n                \"user_id\": 280,\n                \"status\": \"Active\",\n                \"created\": \"2016-12-23T14:25:45+00:00\",\n                \"modified\": \"2016-12-23T14:25:45+00:00\",\n                \"user\": {\n                    \"id\": 280,\n                    \"fname\": \"Ashutosh\",\n                    \"lname\": \"Agrawal\",\n                    \"community_username\": null,\n                    \"consumer_billing_details\": [\n                        {\n                            \"city\": \"City\",\n                            \"user_id\": 280,\n                            \"state\": {\n                                \"abbrev\": \"AK\"\n                            }\n                        }\n                    ]\n                }\n            },\n            \"3\": {\n                \"id\": 3,\n                \"forum_id\": 1,\n                \"parent\": 0,\n                \"description\": \"Testttt Test\",\n                \"user_id\": 280,\n                \"status\": \"Active\",\n                \"created\": \"2016-12-23T14:25:51+00:00\",\n                \"modified\": \"2016-12-23T14:25:51+00:00\",\n                \"user\": {\n                    \"id\": 280,\n                    \"fname\": \"Ashutosh\",\n                    \"lname\": \"Agrawal\",\n                    \"community_username\": null,\n                    \"consumer_billing_details\": [\n                        {\n                            \"city\": \"City\",\n                            \"user_id\": 280,\n                            \"state\": {\n                                \"abbrev\": \"AK\"\n                            }\n                        }\n                    ]\n                }\n            },\n            \"4\": {\n                \"id\": 4,\n                \"forum_id\": 1,\n                \"parent\": 0,\n                \"description\": \"Testttt Test idiot\",\n                \"user_id\": 280,\n                \"status\": \"Active\",\n                \"created\": \"2016-12-23T14:25:57+00:00\",\n                \"modified\": \"2016-12-23T14:25:57+00:00\",\n                \"user\": {\n                    \"id\": 280,\n                    \"fname\": \"Ashutosh\",\n                    \"lname\": \"Agrawal\",\n                    \"community_username\": null,\n                    \"consumer_billing_details\": [\n                        {\n                            \"city\": \"City\",\n                            \"user_id\": 280,\n                            \"state\": {\n                                \"abbrev\": \"AK\"\n                            }\n                        }\n                    ]\n                }\n            }\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_forums_details.js",
    "groupTitle": "Forums"
  },
  {
    "type": "post",
    "url": "Immunizations/add",
    "title": "Add Immunizations",
    "name": "Add_Immunizations",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Add Immunizations of Patient.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Patient id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "immunization_type_id",
            "description": "<ul> <li>Immunization type id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "immunized_after_birthday",
            "description": "<ul> <li>Immunized after birthday</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dose1",
            "description": "<ul> <li>dose1</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dose2",
            "description": "<ul> <li>dose2</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "immunization_manufacturer",
            "description": "<ul> <li>Immunization manufacturer</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "immunization_lot_number",
            "description": "<ul> <li>Immunization lot number</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title_of_immunization_admin",
            "description": "<ul> <li>Title of immunization admin</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "note",
            "description": "<ul> <li>Note</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "date_immunization_statement_given",
            "description": "<ul> <li>Date immunization statement given</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "date_of_vis_statement",
            "description": "<ul> <li>Date of VIS statement</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "immunization_documents",
            "description": "<ul> <li>Immunization documents</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "document_url",
            "description": "<ul> <li>Document url</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "document_name",
            "description": "<ul> <li>Document name</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n    \"patient_id\": \"1\",\n    \"immunization_type_id\": \"1\",\n    \"immunized_after_birthday\": \"15\",\n    \"dose1\": \"1998-02-02 00:00:00\",\n    \"dose2\": \"1998-02-02 00:00:00\"\n    \"immunization_manufacturer\": \"Tetest\",\n    \"immunization_lot_number\": \"120\",\n    \"title_of_immunization_admin\": \"Test\",\n    \"note\": \" Yes tst ata  asfas\",\n    \"date_immunization_statement_given\": \"1998-02-02 00:00:00\",\n    \"date_of_vis_statement\": \"1998-02-02 00:00:00\",\n    \"immunization_documents\": [\n        {\n            \"document_url\": \"https://face2face-dev.s3.amazonaws.com/consentPdf/consent-form-Ravi%20kumar-Saini-2016-11-22%2007%3A56%3A31.pdf\",\n            \"document_name\": \"test.jpeg\"\n        },\n        {\n            \"document_url\": \"https://face2face-dev.s3.amazonaws.com/consentPdf/consent-form-Ravi%20kumar-Saini-2016-11-22%2007%3A56%3A31.pdf\",\n            \"document_name\": \"test.jpeg\"\n        }\n    ]\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_immunizations.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "put",
    "url": "/Vitals/add",
    "title": "Add Vitals",
    "name": "Add_Vitals",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Consumer can add the Vitals.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "voice_clip",
            "description": "<ul> <li>Voice clip link</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "voice_clip_name",
            "description": "<ul> <li>Voice clip name</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<ul> <li>Image</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image_name",
            "description": "<ul> <li>Image name</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data_title",
            "description": "<ul> <li>Data title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data_description",
            "description": "<ul> <li>Data description</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight_lbs",
            "description": "<ul> <li>Weight lbs</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight_kgs",
            "description": "<ul> <li>Weight kgs</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "height_inch",
            "description": "<ul> <li>Height inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "height_cm",
            "description": "<ul> <li>Height cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bp_systolic_mmgh",
            "description": "<ul> <li>Bp_systolic mmgh</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bp_diatolic_mmgh",
            "description": "<ul> <li>Bp_diatolic mmgh</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pulse_rate",
            "description": "<ul> <li>Pulse rate</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "temperature_f",
            "description": "<ul> <li>Temperature f</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "temperature_c",
            "description": "<ul> <li>Temperature c</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "temp_location",
            "description": "<ul> <li>Temp location</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "oxygen_saturation_percentage",
            "description": "<ul> <li>Oxygen saturation %</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "head_circumference_inch",
            "description": "<ul> <li>Head circumference inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "head_circumference_cm",
            "description": "<ul> <li>Head circumference cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "waist_circumference_inch",
            "description": "<ul> <li>Waist circumference inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "waist_circumference_cm",
            "description": "<ul> <li>Waist circumference cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bmi_kg_m2",
            "description": "<ul> <li>Bmi kg/m2</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bmi_status_type",
            "description": "<ul> <li>Bmi status type</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"patient_id\": \"2\",\n    \"voice_clip\": \"2\",\n    \"voice_clip_name\": \"2\",\n    \"image\": \"2\",\n    \"image_name\": \"2\",\n    \"data_title\": \"2\",\n    \"data_description\": \"2\",\n    \"weight_lbs\": \"2\",\n    \"weight_kgs\": \"2\",\n    \"height_inch\": \"5'10\",\n    \"height_cm\": \"2\",\n    \"bp_systolic_mmgh\": \"2\",\n    \"bp_diatolic_mmgh\": \"2\",\n    \"pulse_rate\": \"122\",\n    \"temperature_f\": \"2\",\n    \"temperature_c\": \"2\",\n    \"temp_location\": \"Testtt\",\n    \"oxygen_saturation_percentage\": \"2\",\n    \"head_circumference_inch\": \"5'10\",\n    \"head_circumference_cm\": \"2\",\n    \"waist_circumference_inch\": \"5'10\",\n    \"waist_circumference_cm\": \"2\",\n    \"bmi_kg_m2\": \"2\",\n    \"bmi_status_type\": \"2\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_vitals.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "put",
    "url": "/Immunizations/delete/:2",
    "title": "Delete Immunizations",
    "name": "Delete_Immunizations",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Consumer can delete the Immunizations.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Immunization id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_immunizations.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "put",
    "url": "/Vitals/delete/:2",
    "title": "Delete Vitals",
    "name": "Delete_Vitals",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Consumer can delete the Vitals.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Vital id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_vitals.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "put",
    "url": "Immunizations/edit:1",
    "title": "Edit Immunizations",
    "name": "Edit_Immunizations",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Edit Immunizations of Patient.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "patient_id",
            "description": "<ul> <li>Patient id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "immunization_type_id",
            "description": "<ul> <li>Immunization type id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "immunized_after_birthday",
            "description": "<ul> <li>Immunized after birthday</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dose1",
            "description": "<ul> <li>dose1</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dose2",
            "description": "<ul> <li>dose2</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "immunization_manufacturer",
            "description": "<ul> <li>Immunization manufacturer</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "immunization_lot_number",
            "description": "<ul> <li>Immunization lot number</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title_of_immunization_admin",
            "description": "<ul> <li>Title of immunization admin</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "note",
            "description": "<ul> <li>Note</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "date_immunization_statement_given",
            "description": "<ul> <li>Date immunization statement given</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "date_of_vis_statement",
            "description": "<ul> <li>Date of VIS statement</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Array",
            "optional": false,
            "field": "immunization_documents",
            "description": "<ul> <li>Immunization documents</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "document_url",
            "description": "<ul> <li>Document url</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "document_name",
            "description": "<ul> <li>Document name</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n    \"patient_id\": \"1\",\n    \"immunization_type_id\": \"1\",\n    \"immunized_after_birthday\": \"15\",\n    \"dose1\": \"1998-02-02 00:00:00\",\n    \"dose2\": \"1998-02-02 00:00:00\"\n    \"immunization_manufacturer\": \"Tetest\",\n    \"immunization_lot_number\": \"120\",\n    \"title_of_immunization_admin\": \"Test\",\n    \"note\": \" Yes tst ata  asfas\",\n    \"date_immunization_statement_given\": \"1998-02-02 00:00:00\",\n    \"date_of_vis_statement\": \"1998-02-02 00:00:00\",\n    \"immunization_documents\": [\n        {\n            \"document_url\": \"https://face2face-dev.s3.amazonaws.com/consentPdf/consent-form-Ravi%20kumar-Saini-2016-11-22%2007%3A56%3A31.pdf\",\n            \"document_name\": \"test.jpeg\"\n        },\n        {\n            \"document_url\": \"https://face2face-dev.s3.amazonaws.com/consentPdf/consent-form-Ravi%20kumar-Saini-2016-11-22%2007%3A56%3A31.pdf\",\n            \"document_name\": \"test.jpeg\"\n        }\n    ]\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_immunizations.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "put",
    "url": "/Vitals/edit:1",
    "title": "Edit Vitals",
    "name": "Edit_Vitals",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Consumer can edit the Vitals.</p>",
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
            "field": "voice_clip",
            "description": "<ul> <li>Voice clip link</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "voice_clip_name",
            "description": "<ul> <li>Voice clip name</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<ul> <li>Image</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image_name",
            "description": "<ul> <li>Image name</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data_title",
            "description": "<ul> <li>Data title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "data_description",
            "description": "<ul> <li>Data description</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight_lbs",
            "description": "<ul> <li>Weight lbs</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "weight_kgs",
            "description": "<ul> <li>Weight kgs</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "height_inch",
            "description": "<ul> <li>Height inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "height_cm",
            "description": "<ul> <li>Height cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bp_systolic_mmgh",
            "description": "<ul> <li>Bp_systolic mmgh</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bp_diatolic_mmgh",
            "description": "<ul> <li>Bp_diatolic mmgh</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "pulse_rate",
            "description": "<ul> <li>Pulse rate</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "temperature_f",
            "description": "<ul> <li>Temperature f</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "temperature_c",
            "description": "<ul> <li>Temperature c</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "temp_location",
            "description": "<ul> <li>Temp location</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "oxygen_saturation_percentage",
            "description": "<ul> <li>Oxygen saturation %</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "head_circumference_inch",
            "description": "<ul> <li>Head circumference inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "head_circumference_cm",
            "description": "<ul> <li>Head circumference cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "waist_circumference_inch",
            "description": "<ul> <li>Waist circumference inch</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "waist_circumference_cm",
            "description": "<ul> <li>Waist circumference cm</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bmi_kg_m2",
            "description": "<ul> <li>Bmi kg/m2</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "bmi_status_type",
            "description": "<ul> <li>Bmi status type</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"voice_clip\": \"2\",\n    \"voice_clip_name\": \"2\",\n    \"image\": \"2\",\n    \"image_name\": \"2\",\n    \"data_title\": \"2\",\n    \"data_description\": \"2\",\n    \"weight_lbs\": \"2\",\n    \"weight_kgs\": \"2\",\n    \"height_inch\": \"2\",\n    \"height_cm\": \"2\",\n    \"bp_systolic_mmgh\": \"2\",\n    \"bp_diatolic_mmgh\": \"2\",\n    \"pulse_rate\": \"122\",\n    \"temperature_f\": \"2\",\n    \"temperature_c\": \"2\",\n    \"temp_location\": \"Testtt\",\n    \"oxygen_saturation_percentage\": \"2\",\n    \"head_circumference_inch\": \"2\",\n    \"head_circumference_cm\": \"2\",\n    \"waist_circumference_inch\": \"2\",\n    \"waist_circumference_cm\": \"2\",\n    \"bmi_kg_m2\": \"2\",\n    \"bmi_status_type\": \"2\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_vitals.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "get",
    "url": "Immunizations/getImmunization:2",
    "title": "Get Immunizations",
    "name": "Get_Immunizations",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Get Immunizations Details Using Id.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Immunization id requried field in url query string</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 10,\n    \"patient_id\": 22,\n    \"tetanus_diphteria_dose1\": \"1998-02-02T00:00:00+00:00\",\n    \"immunization_manufacturer\": \"Tetestssss\",\n    \"immunization_lot_number\": \"TEsssst\",\n    \"title_of_immunization_admin\": \"Tesssst\",\n    \"note\": \" Yes tst ata  ssssasfas\",\n    \"date_immunization_statement_given\": \"Test\",\n    \"date_of_vis_statement\": \"1998-02-02T00:00:00+00:00\",\n    \"immunization_after_birthday\": \"1998-02-02T00:00:00+00:00\",\n    \"MMR_dose1\": \"1998-02-02T00:00:00+00:00\",\n    \"MMR_dose2\": \"1998-02-02T00:00:00+00:00\",\n    \"status\": \"Active\",\n    \"created\": \"2016-11-09T12:48:02+00:00\",\n    \"modified\": \"2016-11-09T12:48:45+00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_immunizations.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "get",
    "url": "Immunizations/getPatientImmunizations:2",
    "title": "Get Patient Immunizations",
    "name": "Get_Patient_Immunizations",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Get Patient Immunizations By Patient Id.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Patient id requried field in url query string</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 10,\n    \"patient_id\": 22,\n    \"tetanus_diphteria_dose1\": \"1998-02-02T00:00:00+00:00\",\n    \"immunization_manufacturer\": \"Tetestssss\",\n    \"immunization_lot_number\": \"TEsssst\",\n    \"title_of_immunization_admin\": \"Tesssst\",\n    \"note\": \" Yes tst ata  ssssasfas\",\n    \"date_immunization_statement_given\": \"Test\",\n    \"date_of_vis_statement\": \"1998-02-02T00:00:00+00:00\",\n    \"immunization_after_birthday\": \"1998-02-02T00:00:00+00:00\",\n    \"MMR_dose1\": \"1998-02-02T00:00:00+00:00\",\n    \"MMR_dose2\": \"1998-02-02T00:00:00+00:00\",\n    \"status\": \"Active\",\n    \"created\": \"2016-11-09T12:48:02+00:00\",\n    \"modified\": \"2016-11-09T12:48:45+00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_immunizations.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "get",
    "url": "Vitals/getPatientVitals:1",
    "title": "Get Patient Vitals",
    "name": "Get_Patient_Vitals",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Get Patient Vitals From Patietn Id.</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Patient id requried field in url query string</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 10,\n    \"patient_id\": 2,\n    \"voice_clip\": \"2\",\n    \"voice_clip_name\": \"3333\",\n    \"image\": \"2\",\n    \"image_name\": \"2\",\n    \"data_title\": 2,\n    \"data_description\": 2,\n    \"weight_lbs\": 2,\n    \"weight_kgs\": 2,\n    \"height_inch\": 2,\n    \"height_cm\": 2,\n    \"bp_systolic_mmgh\": 2,\n    \"bp_diatolic_mmgh\": 2,\n    \"temperature_f\": 2,\n    \"temperature_c\": 2,\n    \"temp_location\": \"Testtt\",\n    \"oxygen_saturation_percentage\": 2,\n    \"head_circumference_inch\": 2,\n    \"head_circumference_cm\": 2,\n    \"waist_circumference_inch\": 2,\n    \"waist_circumference_cm\": 2,\n    \"bmi_kg_m2\": 2,\n    \"bmi_status_type\": \"2222\",\n    \"status\": \"Active\",\n    \"created\": \"2016-11-09T12:54:03+00:00\",\n    \"modified\": \"2016-11-09T12:55:17+00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_vitals.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "get",
    "url": "Vitals/getVitals:1",
    "title": "Get Vitals",
    "name": "Get_Vitals",
    "group": "Immunizations_And_Vitals",
    "description": "<p>Get Vitals Using Id.</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Vital id requried field in url query string</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 10,\n    \"patient_id\": 2,\n    \"voice_clip\": \"2\",\n    \"voice_clip_name\": \"3333\",\n    \"image\": \"2\",\n    \"image_name\": \"2\",\n    \"data_title\": 2,\n    \"data_description\": 2,\n    \"weight_lbs\": 2,\n    \"weight_kgs\": 2,\n    \"height_inch\": 2,\n    \"height_cm\": 2,\n    \"bp_systolic_mmgh\": 2,\n    \"bp_diatolic_mmgh\": 2,\n    \"temperature_f\": 2,\n    \"temperature_c\": 2,\n    \"temp_location\": \"Testtt\",\n    \"oxygen_saturation_percentage\": 2,\n    \"head_circumference_inch\": 2,\n    \"head_circumference_cm\": 2,\n    \"waist_circumference_inch\": 2,\n    \"waist_circumference_cm\": 2,\n    \"bmi_kg_m2\": 2,\n    \"bmi_status_type\": \"2222\",\n    \"status\": \"Active\",\n    \"created\": \"2016-11-09T12:54:03+00:00\",\n    \"modified\": \"2016-11-09T12:55:17+00:00\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_vitals.js",
    "groupTitle": "Immunizations_And_Vitals"
  },
  {
    "type": "post",
    "url": "/patients/addInsurance?patient_id=1",
    "title": "Add Patient Insurance",
    "name": "addInsurance",
    "group": "Insurance",
    "description": "<p>Add patient insurance plan.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id required field in url query string.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "id",
            "description": "<ul> <li>Id optional field in body (if insurance already saved then it will required).</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "plan_type_id",
            "description": "<ul> <li>Plan type id requried field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state_id",
            "description": "<ul> <li>State id requried field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "insurance_plan_id",
            "description": "<ul> <li>Insurance plan id requried field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "subscriber_id",
            "description": "<ul> <li>Subscriber id optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "policy_number",
            "description": "<ul> <li>Policy number requried field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "group_number",
            "description": "<ul> <li>Group number optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "payer_type_display_name",
            "description": "<ul> <li>Payer type display name field optional in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "payer_id",
            "description": "<ul> <li>Payer id optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "release_of_information",
            "description": "<ul> <li>Release of information optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<ul> <li>Type optional field in body('P','S','A').</li> </ul>"
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
            "description": "<p>Insurance Object contain details about insurance.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"0\": {\n\t\t\"id\":\"1\",\n\t\t\"plan_type_id\":\"1\",\n\t\t\"state_id\":\"1\",\n\t\t\"insurance_plan_id\":\"1\",\n\t\t\"subscriber_id\":\"1\",\n\t\t\"policy_number\":\"125535\",\n\t\t\"group_number\":\"12\",\n\t\t\"payer_type_display_name\":\"sadf display\",\n\t\t\"payer_id\":\"1\",\n\t\t\"release_of_information\":\"afafds information\",\n\t\t\"type\":\"P\"\n\t},\n\t\"1\": {\n\t\t\"id\":\"2\",\n\t\t\"plan_type_id\":\"2\",\n\t\t\"state_id\":\"1\",\n\t\t\"insurance_plan_id\":\"1\",\n\t\t\"subscriber_id\":\"1\",\n\t\t\"policy_number\":\"125535\",\n\t\t\"group_number\":\"12\",\n\t\t\"payer_type_display_name\":\"test to display\",\n\t\t\"payer_id\":\"1\",\n\t\t\"release_of_information\":\"release of information\",\n\t\t\"type\":\"S\"\n\t},\n\t\"2\": {\n\t\t\"id\":\"3\",\n\t\t\"plan_type_id\":\"2\",\n\t\t\"state_id\":\"1\",\n\t\t\"insurance_plan_id\":\"4\",\n\t\t\"subscriber_id\":\"1\",\n\t\t\"policy_number\":\"125535\",\n\t\t\"group_number\":\"12\",\n\t\t\"payer_type_display_name\":\"test to display\",\n\t\t\"payer_id\":\"1\",\n\t\t\"release_of_information\":\"release of information\",\n\t\t\"type\":\"A\"\n\t}\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_patient_insurance.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "/patients/getInsuranceByPatientId/:1",
    "title": "Get patient insurance dropdown",
    "name": "getInsuranceByPatientId",
    "group": "Insurance",
    "description": "<p>Get patient isurance for dropdown</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"InsurancePlans\": {\n        \"id\": 1,\n        \"name\": \"Capital Distict Physician Health\"\n      }\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getInsuranceByPatientId.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "/patients/getInsurancePlanByTypeIdAndStateId?plane_type_id=1&state_id=2",
    "title": "Get Insurance Plan By Type and State",
    "name": "getInsurancePlanByTypeIdAndStateId",
    "group": "Insurance",
    "description": "<p>Get insurance plan by plan type id and state id.</p>",
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
            "field": "plane_type_id",
            "description": "<ul> <li>Plane type id requried field in url query string</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state_id",
            "description": "<ul> <li>State id requried field in url query string</li> </ul>"
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
            "description": "<p>Insurance plan Object contain details about insurance plan.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"name\": \"Capital Distict Physician Health\",\n      \"plan_name\": 0\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_insurance_plan_by_type_and_state.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "/patients/getPatientInsuranceByPatientId?patient_id=1",
    "title": "Get Patient Insurance",
    "name": "getPatientInsuranceByPatientId",
    "group": "Insurance",
    "description": "<p>Get insurances by patient id.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id requried field in url query string</li> </ul>"
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
            "description": "<p>Insurance Object contain details about insurance.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"patient_id\": 1,\n      \"company_name\": \"sad\",\n      \"holder_name\": \"asdf\",\n      \"policy_number\": \"125535\",\n      \"state_id\": 1,\n      \"plan_type_id\": 1,\n      \"insurance_plan_id\": 1,\n      \"subscriber_id\": 1,\n      \"group_number\": 12,\n      \"payer_type_display_name\": \"sadf display\",\n      \"payer_id\": \"1\",\n      \"assingments_of_benefits\": null,\n      \"release_of_information\": \"afafds information\",\n      \"active\": \"Y\",\n      \"type\": \"P\",\n      \"created\": \"2016-09-22T13:41:14+00:00\",\n      \"modified\": \"2016-09-22T14:39:02+00:00\"\n    },\n    {\n      \"id\": 2,\n      \"patient_id\": 1,\n      \"company_name\": \"sad\",\n      \"holder_name\": \"asdf\",\n      \"policy_number\": \"125535\",\n      \"state_id\": 1,\n      \"plan_type_id\": 2,\n      \"insurance_plan_id\": 1,\n      \"subscriber_id\": 1,\n      \"group_number\": 12,\n      \"payer_type_display_name\": \"test to display\",\n      \"payer_id\": \"1\",\n      \"assingments_of_benefits\": null,\n      \"release_of_information\": \"release of information\",\n      \"active\": \"Y\",\n      \"type\": \"P\",\n      \"created\": \"2016-09-22T13:41:14+00:00\",\n      \"modified\": \"2016-09-22T14:39:03+00:00\"\n    },\n    {\n      \"id\": 3,\n      \"patient_id\": 1,\n      \"company_name\": \"\",\n      \"holder_name\": \"\",\n      \"policy_number\": \"125535\",\n      \"state_id\": 1,\n      \"plan_type_id\": 2,\n      \"insurance_plan_id\": 4,\n      \"subscriber_id\": 1,\n      \"group_number\": 12,\n      \"payer_type_display_name\": \"test to display\",\n      \"payer_id\": \"1\",\n      \"assingments_of_benefits\": null,\n      \"release_of_information\": \"release of information\",\n      \"active\": \"Y\",\n      \"type\": \"P\",\n      \"created\": \"2016-09-22T14:25:39+00:00\",\n      \"modified\": \"2016-09-22T14:39:03+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_insurance.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "insurancePlans/getPlanByStateId/:stateId",
    "title": "Get insurance plan type by state id",
    "name": "getPlanByStateId",
    "group": "Insurance",
    "description": "<p>Get insurance plan type by state id.</p>",
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
            "field": "stateId",
            "description": "<ul> <li>State id required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 2500 HSA High, a Multi-State Plan\"\n    },\n    {\n      \"id\": 2,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Select 1500, a Multi-State Plan\"\n    },\n    {\n      \"id\": 3,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 1500, a Multi-State Plan\"\n    },\n    {\n      \"id\": 4,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Prosperous (Select)\"\n    },\n    {\n      \"id\": 5,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Equipped (Select)\"\n    },\n    {\n      \"id\": 6,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Driven (Providence)\"\n    },\n    {\n      \"id\": 7,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Mighty (HSA) (Providence)\"\n    },\n    {\n      \"id\": 8,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Mighty (HSA) (Select)\"\n    },\n    {\n      \"id\": 9,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Rugged (Select)\"\n    },\n    {\n      \"id\": 10,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 5250 HSA High, a Multi-State Plan\"\n    },\n    {\n      \"id\": 11,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Select 2000, a Multi-State Plan\"\n    },\n    {\n      \"id\": 12,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 1000, a Multi-State Plan\"\n    },\n    {\n      \"id\": 13,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 2000, a Multi-State Plan\"\n    },\n    {\n      \"id\": 14,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 5500, a Multi-State Plan\"\n    },\n    {\n      \"id\": 15,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 6350, a Multi-State Plan\"\n    },\n    {\n      \"id\": 16,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Prosperous (Select)\"\n    },\n    {\n      \"id\": 17,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Adventurous (Providence)\"\n    },\n    {\n      \"id\": 18,\n      \"state_id\": 1,\n      \"plan_name\": \"Be Adventurous (Select)\"\n    },\n    {\n      \"id\": 19,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Select 2500 HSA, a Multi-State Plan\"\n    },\n    {\n      \"id\": 20,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 1500, a Multi-State Plan\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getPlanByStateId.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "insurancePlans/getPlanTypeByStateId/:stateId",
    "title": "Get insurance plan type by state id",
    "name": "getPlanTypeByStateId",
    "group": "Insurance",
    "description": "<p>Get insurance plan type by state id.</p>",
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
            "field": "stateId",
            "description": "<ul> <li>State id required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Plus 2500 HSA High, a Multi-State Plan\",\n      \"insurance_plan_type\": {\n        \"plan_type\": \"HMO\",\n        \"id\": 1,\n        \"plan_type_name\": \"HMO\"\n      }\n    },\n    {\n      \"id\": 2,\n      \"state_id\": 1,\n      \"plan_name\": \"Blue Cross Blue Shield Select 1500, a Multi-State Plan\",\n      \"insurance_plan_type\": {\n        \"plan_type\": \"PPO\",\n        \"id\": 2,\n        \"plan_type_name\": \"PPO\"\n      }\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getPlanTypeByStateId.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "get",
    "url": "/InsurancePlans/getType",
    "title": "Get insurance plan type",
    "name": "getType",
    "group": "Insurance",
    "description": "<p>Get all insurance plan type.</p>",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"plan_type\": \"HMO\"\n    },\n    {\n      \"id\": 2,\n      \"plan_type\": \"PPO\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getType.js",
    "groupTitle": "Insurance"
  },
  {
    "type": "post",
    "url": "patientMedicalHistories/addAllergy",
    "title": "Add Allergy",
    "name": "addAllergy",
    "group": "Medical_History",
    "description": "<p>Add allergy of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_id",
            "description": "<ul> <li>Id of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "severity",
            "description": "<ul> <li>Severity</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reaction",
            "description": "<ul> <li>Reaction</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "onset",
            "description": "<ul> <li>Onset</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comments",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"patient_id\": 33,\n   \"issue_id\": 4,\n   \"issue_type_id\": 4,\n   \"title\": \"Allergy\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"severity\": \"Midium\",\n   \"reaction\": \"slow\",\n   \"onset\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"hello how are you?\",\n   \"comments\": \"am fine how are you\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_allergy.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "post",
    "url": "patientMedicalHistories/addDentalIssue",
    "title": "Add Dental Issue",
    "name": "addDentalIssue",
    "group": "Medical_History",
    "description": "<p>Add dental issue of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of Issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"patient_id\": 33,\n   \"issue_type_id\": 2,\n   \"title\": \"Dental issue\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"hello how are you?\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_dental_issue.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "post",
    "url": "patientMedicalHistories/addMedicalProblems",
    "title": "Add Medical Problems",
    "name": "addMedicalProblems",
    "group": "Medical_History",
    "description": "<p>Add medical problem of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_id",
            "description": "<ul> <li>Id of Issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of medical problem</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inquiry",
            "description": "<ul> <li>Inquiry</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inquiry_type",
            "description": "<ul> <li>Type of Inquiry</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of medical problem</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comments",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"patient_id\": 33,\n   \"issue_id\": 1,\n   \"issue_type_id\": 1,\n   \"title\": \"Medical problem\",\n   \"inquiry\": \"XYZ\",\n   \"inquiry_type\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"xyz\",\n   \"comments\": \"xyz\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_medical_problems.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "post",
    "url": "patientMedicalHistories/addMedication",
    "title": "Add Medication",
    "name": "addMedication",
    "group": "Medical_History",
    "description": "<p>Add medication of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "medication",
            "description": "<ul> <li>Medication</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of Issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dosage",
            "description": "<ul> <li>Dosage</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "dosage_occurance",
            "description": "<ul> <li>Dosage Occurance</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n    \"patient_id\": 33,\n    \"issue_type_id\": 5,\n    \"medication\": \"fever\",\n    \"title\": \"Medication\",\n    \"begin_date\": \"2016-02-02\",\n    \"end_date\": \"2016-02-02\",\n    \"dosage\":\"12\",\n    \"dosage_occurance\":\"12\",\n    \"occurance\": \"12\",\n    \"outcome\": \"12\",\n    \"referred_by\": \"nicole\",\n    \"destination\": \"XYZ\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_medication.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "post",
    "url": "patientMedicalHistories/addSurgery",
    "title": "Add Surgery",
    "name": "addSurgery",
    "group": "Medical_History",
    "description": "<p>Add surgery of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_id",
            "description": "<ul> <li>Id of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"patient_id\": 33,\n   \"issue_id\": 3,\n   \"issue_type_id\": 3,\n   \"title\": \"surgery\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"XYZ\",\n   \"destination\": \"XYZ\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_surgery.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/deleteMedicalHistory?id=33",
    "title": "Delete Patient Medical History",
    "name": "deleteMedicalHistory",
    "group": "Medical_History",
    "description": "<p>Delete medical history of Patient.</p>",
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
            "description": "<p>True.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Record has been deleted.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n   \"status\": true,\n   \"message\": \"Record has been deleted\",\n   \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n   \"status\": false,\n   \"message\": \"Method not allowed on resource.\"\n}\n{\n   \"status\": false,\n   \"message\": \"Invalid request\",\n}\n{\n   \"status\": false,\n   \"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_patient_medical_history.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/editAllergy?id=42",
    "title": "Edit Allergy",
    "name": "editAllergy",
    "group": "Medical_History",
    "description": "<p>Edit allergy of Patient.</p>",
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
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "severity",
            "description": "<ul> <li>Severity</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "reaction",
            "description": "<ul> <li>Reaction</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "onset",
            "description": "<ul> <li>Onset</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comments",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"issue_type_id\": 4,\n   \"title\": \"Allergy\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"severity\": \"Midium\",\n   \"reaction\": \"slow\",\n   \"onset\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"hello how are you?\",\n   \"comments\": \"am fine how are you\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_allergy.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/editDentalIssue?id=11",
    "title": "Edit Dental Issue",
    "name": "editDentalIssue",
    "group": "Medical_History",
    "description": "<p>Edit dental issue of Patient.</p>",
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
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of Issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"issue_type_id\": 2,\n   \"title\": \"Dental issue\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"hello how are you?\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_dental_issue.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/editMedicalProblems?id=10",
    "title": "Edit Medical Problems",
    "name": "editMedicalProblems",
    "group": "Medical_History",
    "description": "<p>Edit medical problems of Patient.</p>",
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
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of medical problem</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inquiry",
            "description": "<ul> <li>Inquiry</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "inquiry_type",
            "description": "<ul> <li>Type of Inquiry</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of medical problem</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comments",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"issue_type_id\": 1,\n   \"title\": \"Medical problem\",\n   \"inquiry\": \"XYZ\",\n   \"inquiry_type\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"nicole\",\n   \"destination\": \"xyz\",\n   \"comments\": \"xyz\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_medical_problems.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/editMedication?id=10",
    "title": "Edit Medication",
    "name": "editMedication",
    "group": "Medical_History",
    "description": "<p>Edit medication of Patient.</p>",
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
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "medication",
            "description": "<ul> <li>Medication</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of Issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "dosage",
            "description": "<ul> <li>Dosage</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "dosage_occurance",
            "description": "<ul> <li>Dosage Occurance</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n    \"issue_type_id\": 5,\n    \"medication\": \"fever\",\n    \"title\": \"Medication\",\n    \"begin_date\": \"2016-02-02\",\n    \"end_date\": \"2016-02-02\",\n    \"dosage\":\"12\",\n    \"dosage_occurance\":\"12\",\n    \"occurance\": \"12\",\n    \"outcome\": \"12\",\n    \"referred_by\": \"nicole\",\n    \"destination\": \"XYZ\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_medication.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "put",
    "url": "patientMedicalHistories/editSurgery?id=42",
    "title": "Edit Surgery",
    "name": "editSurgery",
    "group": "Medical_History",
    "description": "<p>Edit surgery of Patient.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<ul> <li>Title of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "issue_name",
            "description": "<ul> <li>Name of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "summary",
            "description": "<ul> <li>Summary of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "begin_date",
            "description": "<ul> <li>Begin date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End Date</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "occurance",
            "description": "<ul> <li>Occurance of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "outcome",
            "description": "<ul> <li>Outcome</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "referred_by",
            "description": "<ul> <li>Referred By</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "destination",
            "description": "<ul> <li>Destination</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n   \"issue_type_id\": 3,\n   \"title\": \"surgery\",\n   \"issue_name\": \"XYZ\",\n   \"summary\": \"XYZS\",\n   \"begin_date\": \"2016-02-02\",\n   \"end_date\": \"2016-02-02\",\n   \"occurance\": \"12\",\n   \"outcome\": \"12\",\n   \"referred_by\": \"XYZ\",\n   \"destination\": \"XYZ\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_surgery.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "/inquiries/getInquiries/:1",
    "title": "Get inquiries by type",
    "name": "getInquiries",
    "group": "Medical_History",
    "description": "<p>Get all inquiries by type.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 5,\n      \"name\": \"Dental-1\"\n    },\n    {\n      \"id\": 6,\n      \"name\": \"Dental-2\"\n    },\n    {\n      \"id\": 7,\n      \"name\": \"Dental-3\"\n    },\n    {\n      \"id\": 8,\n      \"name\": \"Dental-4\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getInquiries.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "/inquiryTypes/getInquiryTypes",
    "title": "Get Inquiry Types",
    "name": "getInquiryTypes",
    "group": "Medical_History",
    "description": "<p>Get all inquiries.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n   \"status\": true,\n   \"message\": \"The request is OK\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"name\": \"Medical Problem\"\n       },\n       {\n           \"id\": 2,\n           \"name\": \"Dental\"\n       },\n       {\n           \"id\": 3,\n           \"name\": \"Surgery\"\n       },\n       {\n           \"id\": 4,\n           \"name\": \"Allergy\"\n       },\n       {\n           \"id\": 5,\n           \"name\": \"Medication\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getInquiryTypes.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "IssueTypes/getIssueTypes",
    "title": "Issue Types",
    "name": "getIssueTypes",
    "group": "Medical_History",
    "description": "<p>Get all issue types.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n   \"status\": true,\n   \"message\": \"The request is OK\",\n   \"data\": [\n       {\n           \"id\": 1,\n           \"name\": \"Medical Problem\"\n       },\n       {\n           \"id\": 2,\n           \"name\": \"Dental\"\n       },\n       {\n           \"id\": 3,\n           \"name\": \"Surgery\"\n       },\n       {\n           \"id\": 4,\n           \"name\": \"Allergy\"\n       },\n       {\n           \"id\": 5,\n           \"name\": \"Medication\"\n       }\n   ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_issue_types.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "Issues/getIssuesByType",
    "title": "Get issues by type",
    "name": "getIssuesByType",
    "group": "Medical_History",
    "description": "<p>Get all issue by type.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 5,\n      \"name\": \"Dental-1\"\n    },\n    {\n      \"id\": 6,\n      \"name\": \"Dental-2\"\n    },\n    {\n      \"id\": 7,\n      \"name\": \"Dental-3\"\n    },\n    {\n      \"id\": 8,\n      \"name\": \"Dental-4\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getIssuesByType.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "patientMedicalHistories/getMedicalHistoryByIssueType?patient_id=33&issue_type_id=1",
    "title": "Patient Medical History By Issue Type",
    "name": "getMedicalHistoryByIssueType",
    "group": "Medical_History",
    "description": "<p>Get medical history of Patient by issue type.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>Object contain details about Patient Medical History.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n    \"status\": true,\n    \"message\": \"Data saved successfully\",\n    \"data\": [\n        {\n            \"id\": 47,\n            \"issue_type_id\": 4,\n            \"title\": \"Allergy\",\n            \"issue_name\": \"XYZ\",\n            \"summary\": \"XYZS\",\n            \"begin_date\": \"2016-02-02T00:00:00+00:00\",\n            \"end_date\": \"2016-02-02T00:00:00+00:00\",\n            \"occurance\": 12,\n            \"outcome\": 12,\n            \"severity\": \"Midium\",\n            \"reaction\": \"slow\",\n            \"onset\": \"12\",\n            \"referred_by\": \"nicole\",\n            \"destination\": \"hello how are you?\",\n            \"comments\": \"am fine how are you\",\n            \"patient\": {\n                \"id\": 33,\n                \"fname\": \"Jack\",\n                \"lname\": \"Doe\",\n                \"dob\": \"1998-09-15T00:00:00+00:00\"\n            }\n        },\n        {\n            \"id\": 54,\n            \"issue_type_id\": 4,\n            \"title\": \"Allergy\",\n            \"issue_name\": \"XYZ\",\n            \"summary\": \"XYZS\",\n            \"begin_date\": \"2016-02-02T00:00:00+00:00\",\n            \"end_date\": \"2016-02-02T00:00:00+00:00\",\n            \"occurance\": 12,\n            \"outcome\": 12,\n            \"severity\": \"Midium\",\n            \"reaction\": \"slow\",\n            \"onset\": \"12\",\n            \"referred_by\": \"nicole\",\n            \"destination\": \"hello how are you?\",\n            \"comments\": \"am fine how are you\",\n            \"patient\": {\n                \"id\": 33,\n                \"fname\": \"Jack\",\n                \"lname\": \"Doe\",\n                \"dob\": \"1998-09-15T00:00:00+00:00\"\n            }\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_medical_history.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "patientMedicalHistories/getPatientMedicalHistories?patient_id=33",
    "title": "Patient Medical History",
    "name": "getPatientMedicalHistories",
    "group": "Medical_History",
    "description": "<p>Get medical history of Patient.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>Object contain details about Patient Medical History.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n\"status\": true,\n\"message\": \"Data saved successfully\",\n\"data\": {\n       \"0\": {\n           \"issue_type_id\": 1,\n           \"number_of_issues\": 1,\n           \"issue_type_name\": \"Medical Problem\"\n       },\n       \"1\": {\n           \"issue_type_id\": 2,\n           \"number_of_issues\": 2,\n           \"issue_type_name\": \"Dental\"\n       },\n       \"2\": {\n           \"issue_type_id\": 3,\n           \"number_of_issues\": 1,\n           \"issue_type_name\": \"Surgery\"\n       },\n       \"3\": {\n           \"issue_type_id\": 4,\n           \"number_of_issues\": 1,\n           \"issue_type_name\": \"Allergy\"\n       },\n       \"4\": {\n           \"issue_type_id\": 5,\n           \"number_of_issues\": 1,\n           \"issue_type_name\": \"Medication\"\n       },\n       \"patient_name\": \"Jack Doe\",\n       \"patient_dob\": \"1998-09-15T00:00:00+00:00\"\n   }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/patient_medical_history.js",
    "groupTitle": "Medical_History"
  },
  {
    "type": "get",
    "url": "/Blogs/postDetail?id=:id",
    "title": "Blog Detail by blog id",
    "name": "Blog_Details_by_blog_id",
    "group": "News",
    "description": "<p>Blog Details by blog id with Tags having provider type, speciality and user type</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Blogs/newsDetail?id=11",
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
            "field": "Blog",
            "description": "<p>Details with Tags having provider type, speciality and user type</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"posts\": {\n      \"id\": 11,\n      \"title\": \"test\",\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/blog/sample_20161103095332.jpg\",\n      \"caption\": \"this is test news\",\n      \"description\": \"<p>this is test news</p>\",\n      \"published_date\": \"2016-11-04T00:00:00+00:00\",\n      \"specialities\": [\n        {\n          \"title\": \"Mental health Nurse Practitioner\",\n          \"_joinData\": {\n            \"blog_id\": 11,\n            \"speciality_id\": 14\n          },\n          \"BlogsSpecialities\": {\n            \"blog_id\": 11\n          }\n        },\n        {\n          \"title\": \"Clinical/School Psychologist (PhD)\",\n          \"_joinData\": {\n            \"blog_id\": 11,\n            \"speciality_id\": 15\n          },\n          \"BlogsSpecialities\": {\n            \"blog_id\": 11\n          }\n        }\n      ],\n      \"provider_types\": [\n        {\n          \"title\": \"Speech, Language & Motor Development\",\n          \"_joinData\": {\n            \"blog_id\": 11,\n            \"provider_type_id\": 2\n          },\n          \"BlogsProviderTypes\": {\n            \"blog_id\": 11\n          }\n        },\n        {\n          \"title\": \"Emotional & Mental Health\",\n          \"_joinData\": {\n            \"blog_id\": 11,\n            \"provider_type_id\": 3\n          },\n          \"BlogsProviderTypes\": {\n            \"blog_id\": 11\n          }\n        }\n      ]\n    },\n    \"tags\": \"Speech, Language & Motor Development, Emotional & Mental Health, Mental health Nurse Practitioner, Clinical/School Psychologist (PhD), caregivers\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/newsDetail.js",
    "groupTitle": "News"
  },
  {
    "type": "post",
    "url": "/Blogs/getPosts",
    "title": "Latest Blogs and News on Dashboard",
    "name": "Latest_Blogs_and_News_on_Dashboard",
    "group": "News",
    "description": "<p>Display Latest Blogs and News on Provider/Consumer Dashboard</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "type",
            "description": "<ul> <li>Required type in the body either of the values &quot;news&quot; or &quot;blogs&quot;</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "limit",
            "description": "<ul> <li>Required limit in the body for news or blogs</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Blogs/getPosts",
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
            "field": "List",
            "description": "<p>of news &amp; blogs</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 11,\n      \"title\": \"test\",\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/blog/sample_20161103095332.jpg\",\n      \"caption\": \"this is test news\",\n      \"description\": \"<p>this is test news</p>\",\n      \"published_date\": \"2016-11-04T00:00:00+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/latest_news.js",
    "groupTitle": "News"
  },
  {
    "type": "delete",
    "url": "patientNotesAndDocument/delete/:id/:patientId",
    "title": "Delete Notes And Documents",
    "name": "delete",
    "group": "Notes_And_Documents",
    "description": "<p>Delete Notes And Documents.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"The request is OK\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_notes_documents.js",
    "groupTitle": "Notes_And_Documents"
  },
  {
    "type": "put",
    "url": "patientNotesAndDocument/edit/:id",
    "title": "Edit Notes And Documents",
    "name": "edit",
    "group": "Notes_And_Documents",
    "description": "<p>Edit Notes And Documents.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_id",
            "description": "<ul> <li>Id of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "doc_title",
            "description": "<ul> <li>Document Title</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n\t\"patient_id\": \"1\",\n        \"issue_type_id\":\"2\",\n\t\"issue_id\":\"2\",\n\t\"doc_title\":\"Alegery Doc Title\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_notes_documents.js",
    "groupTitle": "Notes_And_Documents"
  },
  {
    "type": "get",
    "url": "patientNotesAndDocument/index/:patientId",
    "title": "List Notes And Documents",
    "name": "index",
    "group": "Notes_And_Documents",
    "description": "<p>List Notes And Documents.</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"The request is OK\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/list_notes_documents.js",
    "groupTitle": "Notes_And_Documents"
  },
  {
    "type": "post",
    "url": "patientNotesAndDocument/add",
    "title": "Add Notes And Documents",
    "name": "patientNotesAndDocument",
    "group": "Notes_And_Documents",
    "description": "<p>Add Notes And Documents.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Id of Patient</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_type_id",
            "description": "<ul> <li>Id of issue type</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "issue_id",
            "description": "<ul> <li>Id of issue</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "doc_title",
            "description": "<ul> <li>Document Title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "notes",
            "description": "<ul> <li>Notes</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n\t\"patient_id\": \"1\",\n\t\"issue_type_id\":\"1\",\n\t\"issue_id\":\"1\",\n\t\"doc_title\":\"Alegery Doc\",\n\t\"notes\":\"Notes...\"\n }",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_notes_documents.js",
    "groupTitle": "Notes_And_Documents"
  },
  {
    "type": "get",
    "url": "/Pages/about-us",
    "title": "About Us Page",
    "version": "0.0.1",
    "name": "About_Us_Page",
    "group": "Pages",
    "description": "<p>About Us Page.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/about-us",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>About Us Page.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"About Us Page\",\n      \"description\": \"Testing About us Page\",\n      \"image\": null,\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 1\n      }\n    },\n    \"about-us\": [\n      [\n        {\n          \"slug\": \"leadership-team\",\n          \"title\": \"Leadership team\",\n          \"description\": \"testing leadership team\",\n          \"image\": null,\n          \"video_link\": null\n        }\n      ],\n      [\n        {\n          \"slug\": \"advisory-board\",\n          \"title\": \"Advisory Board\",\n          \"description\": \"Testing Advisory Board\",\n          \"image\": null,\n          \"video_link\": null\n        }\n      ]\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/about-us.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/consent",
    "title": "Consent Page",
    "version": "0.0.1",
    "name": "Consent_Page",
    "group": "Pages",
    "description": "<p>Consent Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/consent",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Consent page data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"testing consent page\",\n      \"description\": \"<p>testing consent page</p>\",\n      \"image\": null,\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 11\n      }\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/consent_page.js",
    "groupTitle": "Pages"
  },
  {
    "type": "post",
    "url": "/Contacts/contactUs",
    "title": "Contact Us Form",
    "version": "0.0.1",
    "name": "Contact_Us_Form",
    "group": "Pages",
    "description": "<p>Contact Us Form.</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<ul> <li>Required Name in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Required Email in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<ul> <li>Required Phone Number in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<ul> <li>Required Message in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "news_updates",
            "description": "<ul> <li>Optional news_updates &quot;Y&quot; or &quot;N&quot; in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"name\":\"gaurav\",\n\t\"email\":\"gkv7@gmail.com\",\n\t\"phone\":\"7686786876\",\n\t\"message\":\"this is test message\",\n\t\"news_updates\":\"Y\"\n}",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>Thank you for contacting us.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Contact form data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"Thank you for contacting us\",\n  \"data\": {\n    \"name\": \"gaurav\",\n    \"email\": \"gkv7@gmail.com\",\n    \"phone\": \"7686786876\",\n    \"message\": \"this is test message\",\n    \"news_updates\": \"Y\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/contact_us.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/faqs",
    "title": "Faqs Page data",
    "version": "0.0.1",
    "name": "Faqs_Page_data",
    "group": "Pages",
    "description": "<p>Faqs Page data.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/faqs",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Faqs Page data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": [\n      {\n        \"title\": \"Faqs\",\n        \"description\": \"<p>tesing faqs</p>\",\n        \"image\": null,\n        \"video_link\": null\n      }\n    ],\n    \"faqs\": [\n      {\n        \"question\": \"test1\",\n        \"answer\": \"answer1\"\n      },\n      {\n        \"question\": \"test2\",\n        \"answer\": \"answer2\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/faqs.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/pages/getDataByProviderType/:id",
    "title": "Get Data By Provider Type",
    "name": "Get_Data_By_Provider_Type",
    "group": "Pages",
    "description": "<p>Get Data By Provider Type</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/pages/getDataByProviderType/:1",
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
            "description": "<p>True.</p>"
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
            "field": "provider",
            "description": "<p>type data by provider type id</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"title\": \"General Health\",\n      \"menu_title\": \"GENERAL HEALTH\",\n      \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\n      \"color\": \"#000000\",\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/profileImage/580f05285ebd4.png\",\n      \"icon_image\": \"https://face2face-dev.s3.amazonaws.com/profileImage/580f430ddd404.png\",\n      \"order\": 1\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getDataByProviderType.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/options/getMediaLinks",
    "title": "Get Media links like facebook, twitter",
    "name": "Get_Media_Links",
    "group": "Pages",
    "description": "<p>Get all media links like facebook, twitter</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/options/getMediaLinks",
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
            "field": "Get",
            "description": "<p>Media Links like facebook, twitter</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"key_name\": \"social\",\n      \"key_value\": {\n        \"twitter_class\": \"fa fa-twitter\",\n        \"twitter_url\": \"https://www.google.com\",\n        \"youtube_class\": \"fa fa-youtube-play\",\n        \"youtube_url\": \"\",\n        \"facebook_class\": \"fa fa-facebook\",\n        \"facebook_url\": \"https://www.facebook.com/kavish.diwan\",\n        \"linkedin_class\": \"fa fa-linkedin\",\n        \"linkedin_url\": \"https://in.linkedin.com/in/kavish-diwan-80206866\",\n        \"pinterest_class\": \"fa fa-pinterest-p\",\n        \"pinterest_url\": \"\",\n        \"googleplus_class\": \"fa fa-google-plus\",\n        \"googleplus_url\": \"\"\n      },\n      \"autoload\": 0\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_media_links.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/pages/getProviderTypes",
    "title": "Get Provider Types",
    "name": "Get_Provider_Types",
    "group": "Pages",
    "description": "<p>Get Provider Types.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/pages/getProviderTypes",
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
            "description": "<p>True.</p>"
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
            "description": "<p>List of provider types with id, title and color</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"title\": \"General Health\",\n      \"menu_title\": \"GENERAL HEALTH\",\n      \"color\": \"#000000\",\n      \"order\": 1\n    },\n    {\n      \"id\": 2,\n      \"title\": \"Speech, Language & Motor Development\",\n      \"menu_title\": \"DEVELOPMENT\",\n      \"color\": \"#63a5d4\",\n      \"order\": 2\n    },\n    {\n      \"id\": 3,\n      \"title\": \"Emotional & Mental Health\",\n      \"menu_title\": \"MENTAL HEALTH\",\n      \"color\": \"#b186ba\",\n      \"order\": 3\n    },\n    {\n      \"id\": 4,\n      \"title\": \"Mind, Body & Nutrition\",\n      \"menu_title\": \"MIND, BODY & NUTRITION\",\n      \"color\": \"#ff7878\",\n      \"order\": 5\n    },\n    {\n      \"id\": 5,\n      \"title\": \"Education, Advocacy, Tutoring & Coaching\",\n      \"menu_title\": \"EDUCATION & ADVOCACY\",\n      \"color\": \"#70d37c\",\n      \"order\": 4\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getProviderTypes.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/pages/getMenuBySlug/:slug",
    "title": "Get menu based on query string in slug",
    "name": "Get_menu_for_e_learning_and_virtual_health",
    "group": "Pages",
    "description": "<p>Get ELearning menu</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/pages/getMenuBySlug/e-learning",
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
            "description": "<p>True.</p>"
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
            "description": "<p>menu for e-learning or virtual health with id, title and slug</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 16,\n      \"title\": \"Homepage\",\n      \"slug\": \"homepage\"\n    },\n    {\n      \"id\": 17,\n      \"title\": \"What Is\",\n      \"slug\": \"what-is\"\n    },\n    {\n      \"id\": 18,\n      \"title\": \"Benefits\",\n      \"slug\": \"benefits\"\n    },\n    {\n      \"id\": 19,\n      \"title\": \"Testimonials\",\n      \"slug\": \"testimonials\"\n    },\n    {\n      \"id\": 20,\n      \"title\": \"Virtual Health\",\n      \"slug\": \"virtual-health\"\n    },\n    {\n      \"id\": 21,\n      \"title\": \"Community\",\n      \"slug\": \"community\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getMenuBySlug.js",
    "groupTitle": "Pages"
  },
  {
    "type": "post",
    "url": "/pages/getPageBySlug",
    "title": "Get pages by page_slug i.e homepage and parent_slug i.e e-learning",
    "name": "Get_pages_by_slug_i_e_homepage_and_parent_slug_i_e_e_learning",
    "group": "Pages",
    "description": "<p>Get pages by slug i.e homepage and parent slug i.e e-learning</p>",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "parent_slug",
            "description": "<ul> <li>Required parent slug either of the values &quot;e-learning&quot; or &quot;virtual-health&quot; in the body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page_slug",
            "description": "<ul> <li>Required page slug i.e. &quot;homepage&quot;,&quot;what-is&quot; in the body</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/pages/getPageBySlug",
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
            "description": "<p>True.</p>"
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
            "description": "<p>Page Data with banners and testimonials</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": [\n      {\n        \"title\": \"benifits\",\n        \"slug\": \"benifits\",\n        \"description\": \"<p>benifits</p>\",\n        \"image\": null,\n        \"icon_image\": \"https://face2face-dev.s3.amazonaws.com/page/44_80_20161221131052.gif\"\n      },\n      {\n        \"title\": \"benifits\",\n        \"slug\": \"benifits\",\n        \"description\": \"<p>benefits</p>\",\n        \"image\": null,\n        \"icon_image\": \"https://face2face-dev.s3.amazonaws.com/page/44_80_20161222081432.gif\"\n      }\n    ],\n    \"banner\": {\n      \"title\": \"benifits banner\",\n      \"caption\": \"\",\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/banner/1280_600_20161221131428.jpg\",\n      \"button_text\": null,\n      \"url\": \"\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getPageBySlug.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Menus/",
    "title": "Get main menu",
    "name": "Menus",
    "group": "Pages",
    "description": "<p>Get main menus.</p>",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"menus\": [\n      {\n        \"title\": \"Patients\",\n        \"label\": \"Patients\",\n        \"url\": \"patients\",\n        \"param\": \"\",\n        \"callback\": \"redirectToPage\",\n        \"children\": [\n          {\n            \"title\": \"Patients home\",\n            \"label\": \"Patients home\",\n            \"url\": \"patients-home\",\n            \"param\": \"main.landingPage.home\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Where to Start\",\n            \"label\": \"Where to Start\",\n            \"url\": \"where-to-start\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Signup\",\n            \"label\": \"Signup\",\n            \"url\": \"signup\",\n            \"param\": \"main.patientSignUp\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"General Health\",\n            \"label\": \"General Health\",\n            \"url\": \"general-health\",\n            \"param\": \"siloPage\",\n            \"callback\": \"commonFunc\",\n            \"children\": [\n              {\n                \"title\": \"Virtual Health\",\n                \"label\": \"Virtual Health\",\n                \"url\": \"virtual-health\",\n                \"param\": \"patientMain.conOnDemandNewIssue\",\n                \"callback\": \"consumerLinks\"\n              },\n              {\n                \"title\": \"On-Demand Appointment\",\n                \"label\": \"On-Demand Appointment\",\n                \"url\": \"on-demand-appointment\",\n                \"param\": \"main.conOnDemandNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Scheduled Appointment\",\n                \"label\": \"Scheduled Appointment\",\n                \"url\": \"scheduled-appointment\",\n                \"param\": \"main.conScheduledNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Concierge Services\",\n                \"label\": \"Concierge Services\",\n                \"url\": \"concierge-services\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"E-Learning\",\n                \"label\": \"E-Learning\",\n                \"url\": \"e-learning\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Communities\",\n                \"label\": \"Communities\",\n                \"url\": \"communities\",\n                \"param\": \"communityPage\",\n                \"callback\": \"commonFunc\"\n              }\n            ]\n          },\n          {\n            \"title\": \"Speech, Language & Motor Development\",\n            \"label\": \"Speech, Language & Motor Development\",\n            \"url\": \"speech-language-motor-development\",\n            \"param\": \"siloPage\",\n            \"callback\": \"commonFunc\",\n            \"children\": [\n              {\n                \"title\": \"Virtual Health\",\n                \"label\": \"Virtual Health\",\n                \"url\": \"virtual-health\",\n                \"param\": \"patientMain.conOnDemandNewIssue\",\n                \"callback\": \"consumerLinks\"\n              },\n              {\n                \"title\": \"On-Demand Appointment\",\n                \"label\": \"On-Demand Appointment\",\n                \"url\": \"on-demand-appointment\",\n                \"param\": \"main.conOnDemandNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Scheduled Appointment\",\n                \"label\": \"Scheduled Appointment\",\n                \"url\": \"scheduled-appointment\",\n                \"param\": \"main.conScheduledNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Concierge Services\",\n                \"label\": \"Concierge Services\",\n                \"url\": \"concierge-services\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"E-Learning\",\n                \"label\": \"E-Learning\",\n                \"url\": \"e-learning\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Communities\",\n                \"label\": \"Communities\",\n                \"url\": \"communities\",\n                \"param\": \"communityPage\",\n                \"callback\": \"commonFunc\"\n              }\n            ]\n          },\n          {\n            \"title\": \"Emotional & Mental Health\",\n            \"label\": \"Emotional & Mental Health\",\n            \"url\": \"emotional-mental-health\",\n            \"param\": \"siloPage\",\n            \"callback\": \"commonFunc\",\n            \"children\": [\n              {\n                \"title\": \"Virtual Health\",\n                \"label\": \"Virtual Health\",\n                \"url\": \"virtual-health\",\n                \"param\": \"patientMain.conOnDemandNewIssue\",\n                \"callback\": \"consumerLinks\"\n              },\n              {\n                \"title\": \"On-Demand Appointment\",\n                \"label\": \"On-Demand Appointment\",\n                \"url\": \"on-demand-appointment\",\n                \"param\": \"main.conOnDemandNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Scheduled Appointment\",\n                \"label\": \"Scheduled Appointment\",\n                \"url\": \"scheduled-appointment\",\n                \"param\": \"main.conScheduledNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Concierge Services\",\n                \"label\": \"Concierge Services\",\n                \"url\": \"concierge-services\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"E-Learning\",\n                \"label\": \"E-Learning\",\n                \"url\": \"e-learning\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Communities\",\n                \"label\": \"Communities\",\n                \"url\": \"communities\",\n                \"param\": \"communityPage\",\n                \"callback\": \"commonFunc\"\n              }\n            ]\n          },\n          {\n            \"title\": \"Mind, Body & Nutrition\",\n            \"label\": \"Mind, Body & Nutrition\",\n            \"url\": \"mind-body-nutrition\",\n            \"param\": \"siloPage\",\n            \"callback\": \"commonFunc\",\n            \"children\": [\n              {\n                \"title\": \"Virtual Health\",\n                \"label\": \"Virtual Health\",\n                \"url\": \"virtual-health\",\n                \"param\": \"patientMain.conOnDemandNewIssue\",\n                \"callback\": \"consumerLinks\"\n              },\n              {\n                \"title\": \"On-Demand Appointment\",\n                \"label\": \"On-Demand Appointment\",\n                \"url\": \"on-demand-appointment\",\n                \"param\": \"main.conOnDemandNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Scheduled Appointment\",\n                \"label\": \"Scheduled Appointment\",\n                \"url\": \"scheduled-appointment\",\n                \"param\": \"main.conScheduledNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Concierge Services\",\n                \"label\": \"Concierge Services\",\n                \"url\": \"concierge-services\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"E-Learning\",\n                \"label\": \"E-Learning\",\n                \"url\": \"e-learning\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Communities\",\n                \"label\": \"Communities\",\n                \"url\": \"communities\",\n                \"param\": \"communityPage\",\n                \"callback\": \"commonFunc\"\n              }\n            ]\n          },\n          {\n            \"title\": \"Education, Advocacy, Tutoring & Coaching\",\n            \"label\": \"Education, Advocacy, Tutoring & Coaching\",\n            \"url\": \"education-advocacy-tutoring-coaching\",\n            \"param\": \"siloPage\",\n            \"callback\": \"commonFunc\",\n            \"children\": [\n              {\n                \"title\": \"Virtual Health\",\n                \"label\": \"Virtual Health\",\n                \"url\": \"virtual-health\",\n                \"param\": \"patientMain.conOnDemandNewIssue\",\n                \"callback\": \"consumerLinks\"\n              },\n              {\n                \"title\": \"On-Demand Appointment\",\n                \"label\": \"On-Demand Appointment\",\n                \"url\": \"on-demand-appointment\",\n                \"param\": \"main.conOnDemandNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Scheduled Appointment\",\n                \"label\": \"Scheduled Appointment\",\n                \"url\": \"scheduled-appointment\",\n                \"param\": \"main.conScheduledNewUser\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Concierge Services\",\n                \"label\": \"Concierge Services\",\n                \"url\": \"concierge-services\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"E-Learning\",\n                \"label\": \"E-Learning\",\n                \"url\": \"e-learning\",\n                \"param\": \"\",\n                \"callback\": \"redirectToPage\"\n              },\n              {\n                \"title\": \"Communities\",\n                \"label\": \"Communities\",\n                \"url\": \"communities\",\n                \"param\": \"communityPage\",\n                \"callback\": \"commonFunc\"\n              }\n            ]\n          },\n          {\n            \"title\": \"Virtual Health\",\n            \"label\": \"Virtual Health\",\n            \"url\": \"virtual-health\",\n            \"param\": \"patientMain.conOnDemandNewIssue\",\n            \"callback\": \"consumerLinks\"\n          },\n          {\n            \"title\": \"E-Learning\",\n            \"label\": \"E-Learning\",\n            \"url\": \"e-learning\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Communities\",\n            \"label\": \"Communities\",\n            \"url\": \"communities\",\n            \"param\": \"main.community\",\n            \"callback\": \"redirectToPage\"\n          }\n        ]\n      },\n      {\n        \"title\": \"Providers\",\n        \"label\": \"Providers\",\n        \"url\": \"providers\",\n        \"param\": \"\",\n        \"callback\": \"redirectToPage\",\n        \"children\": [\n          {\n            \"title\": \"Home\",\n            \"label\": \"Home\",\n            \"url\": \"home\",\n            \"param\": \"main.landingPage.providerhome\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"INDIVIDUAL PROVIDERS\",\n            \"label\": \"INDIVIDUAL PROVIDERS\",\n            \"url\": \"individual-providers\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Benefits\",\n            \"label\": \"Benefits\",\n            \"url\": \"benefits\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Technology\",\n            \"label\": \"Technology\",\n            \"url\": \"technology\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Training\",\n            \"label\": \"Training\",\n            \"url\": \"training\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"PRACTICE GROUPs\",\n            \"label\": \"PRACTICE GROUPs\",\n            \"url\": \"practice-groups\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          },\n          {\n            \"title\": \"Technology\",\n            \"label\": \"Technology\",\n            \"url\": \"technology\",\n            \"param\": \"\",\n            \"callback\": \"redirectToPage\"\n          }\n        ]\n      },\n      {\n        \"title\": \"BUSINESS\",\n        \"label\": \"BUSINESS\",\n        \"url\": \"business\",\n        \"param\": \"main.businessHomePage\",\n        \"callback\": \"redirectToPage\"\n      }\n    ],\n    \"provider\": [\n      {\n        \"id\": 1,\n        \"title\": \"General Health\",\n        \"menu_title\": \"general health\",\n        \"color\": \"#6aa6ac\",\n        \"order\": 1,\n        \"slug\": \"general-health\"\n      },\n      {\n        \"id\": 2,\n        \"title\": \"Speech, Language & Motor Development\",\n        \"menu_title\": \"development\",\n        \"color\": \"#63a5d4\",\n        \"order\": 2,\n        \"slug\": \"speech-language-motor-development\"\n      },\n      {\n        \"id\": 3,\n        \"title\": \"Emotional & Mental Health\",\n        \"menu_title\": \"mental health\",\n        \"color\": \"#b186ba\",\n        \"order\": 3,\n        \"slug\": \"emotional-mental-health\"\n      },\n      {\n        \"id\": 4,\n        \"title\": \"Mind, Body & Nutrition\",\n        \"menu_title\": \"mind, body & nutrition\",\n        \"color\": \"#ff7878\",\n        \"order\": 5,\n        \"slug\": \"mind-body-nutrition\"\n      },\n      {\n        \"id\": 5,\n        \"title\": \"Education, Advocacy, Tutoring & Coaching\",\n        \"menu_title\": \"education & advocacy\",\n        \"color\": \"#70d37c\",\n        \"order\": 4,\n        \"slug\": \"education-advocacy-tutoring-coaching\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/main_menus.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/our-model",
    "title": "Our Model Page",
    "version": "0.0.1",
    "name": "Our_Model_Page",
    "group": "Pages",
    "description": "<p>Our Model Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/our-model",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Our Model page data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"model page \",\n      \"description\": \"<p>model page</p>\",\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/page/400x400_pixel_doll_wip_by_dragonspixels_d69at2t_20161222135457.png\"\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/our_model.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/patient-consent",
    "title": "Patient Consent Page",
    "version": "0.0.1",
    "name": "Patient_Consent_Page",
    "group": "Pages",
    "description": "<p>Patient Consent Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/patient-consent",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Patient Consent page data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"testing consent page\",\n      \"description\": \"<p>testing consent page</p>\",\n      \"image\": null,\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 13\n      }\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/patient_consent_page.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/patient-home",
    "title": "Patient Home Page",
    "version": "0.0.1",
    "name": "Patient_Home_Page",
    "group": "Pages",
    "description": "<p>Patient Home Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/patient-home",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Patient Home Page data with home page content, banners,features, benifits and footer</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"Home\",\n      \"description\": \"Home Page\",\n      \"image\": \"abc.jpg\",\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 7\n      }\n    },\n    \"section\": {\n      \"banners\": [\n        {\n          \"id\": 4,\n          \"title\": \"banner home\",\n          \"caption\": \"banner\",\n          \"image\": \"bannerhome1.jpg\",\n          \"url\": \"\"\n        },\n        {\n          \"id\": 5,\n          \"title\": \"home banner2\",\n          \"caption\": \"home\",\n          \"image\": \"abc.jpg\",\n          \"url\": \"\"\n        }\n      ],\n      \"features\": [\n        {\n          \"title\": \"home feature\",\n          \"name\": \"home feature\",\n          \"description\": \"home feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        },\n        {\n          \"title\": \"home 2 feature\",\n          \"name\": \"home 2 feature\",\n          \"description\": \"home 2 feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"benifits\": [\n        {\n          \"title\": \"home benifits\",\n          \"name\": \"home benifits\",\n          \"description\": \"home benifits\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"footer\": [\n        {\n          \"title\": \"home footer\",\n          \"name\": \"home footer\",\n          \"description\": \"home footer\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ]\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/home-patient.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/patient-home",
    "title": "Patient Home Page",
    "version": "0.0.1",
    "name": "Patient_Home_Page",
    "group": "Pages",
    "description": "<p>Patient Home Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/patient-home",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Patient Home Page data with home page content, banners,features, benifits and footer</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"Home\",\n      \"description\": \"Home Page\",\n      \"image\": \"abc.jpg\",\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 7\n      }\n    },\n    \"section\": {\n      \"banners\": [\n        {\n          \"id\": 4,\n          \"title\": \"banner home\",\n          \"caption\": \"banner\",\n          \"image\": \"bannerhome1.jpg\",\n          \"url\": \"\"\n        },\n        {\n          \"id\": 5,\n          \"title\": \"home banner2\",\n          \"caption\": \"home\",\n          \"image\": \"abc.jpg\",\n          \"url\": \"\"\n        }\n      ],\n      \"features\": [\n        {\n          \"title\": \"home feature\",\n          \"name\": \"home feature\",\n          \"description\": \"home feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        },\n        {\n          \"title\": \"home 2 feature\",\n          \"name\": \"home 2 feature\",\n          \"description\": \"home 2 feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"benifits\": [\n        {\n          \"title\": \"home benifits\",\n          \"name\": \"home benifits\",\n          \"description\": \"home benifits\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"footer\": [\n        {\n          \"title\": \"home footer\",\n          \"name\": \"home footer\",\n          \"description\": \"home footer\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ]\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/patient-home.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/privacy-policy",
    "title": "Privacy Policy Page",
    "version": "0.0.1",
    "name": "Privacy_Policy_Page",
    "group": "Pages",
    "description": "<p>Privacy Policy Page.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/privacy-policy",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Privacy Policy page data.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"title\": \"Privacy Policy\",\n      \"description\": \"<p>testing privacy policy</p>\",\n      \"image\": null,\n      \"video_link\": null\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/privacy_policy.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/Pages/provider-home",
    "title": "Provider Home Page",
    "version": "0.0.1",
    "name": "Provider_Home_Page",
    "group": "Pages",
    "description": "<p>Provider Home Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Pages/provider-home",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Provider Home Page data with home page content, banners,features, benifits and footer</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"page\": {\n      \"title\": \"Home\",\n      \"description\": \"Home Page\",\n      \"image\": \"abc.jpg\",\n      \"video_link\": null,\n      \"page_category\": {\n        \"id\": 7\n      }\n    },\n    \"section\": {\n      \"banners\": [\n        {\n          \"id\": 4,\n          \"title\": \"banner home\",\n          \"caption\": \"banner\",\n          \"image\": \"bannerhome1.jpg\",\n          \"url\": \"\"\n        },\n        {\n          \"id\": 5,\n          \"title\": \"home banner2\",\n          \"caption\": \"home\",\n          \"image\": \"abc.jpg\",\n          \"url\": \"\"\n        }\n      ],\n      \"features\": [\n        {\n          \"title\": \"home feature\",\n          \"name\": \"home feature\",\n          \"description\": \"home feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        },\n        {\n          \"title\": \"home 2 feature\",\n          \"name\": \"home 2 feature\",\n          \"description\": \"home 2 feature\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"benifits\": [\n        {\n          \"title\": \"home benifits\",\n          \"name\": \"home benifits\",\n          \"description\": \"home benifits\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ],\n      \"footer\": [\n        {\n          \"title\": \"home footer\",\n          \"name\": \"home footer\",\n          \"description\": \"home footer\",\n          \"image\": \"abc.jpg\",\n          \"video_link\": null\n        }\n      ]\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/home-provider.js",
    "groupTitle": "Pages"
  },
  {
    "type": "get",
    "url": "/pages/providerTypePage/:id",
    "title": "Provider Type Landing Page",
    "version": "0.0.1",
    "name": "Provider_Type_Landing_Page",
    "group": "Pages",
    "description": "<p>Provider Type Landing Page</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/pages/providerTypePage/:id",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>provider type landing page with page content, banners,features, benifits and footer</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"provider_type\": [\n        {\n          \"id\": 1,\n          \"title\": \"General Health\",\n          \"description\": \" Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \",\n          \"color\": \"#ffc87b\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/profileImage/580f05285ebd4.png\",\n          \"icon_image\": \"https://face2face-dev.s3.amazonaws.com/profileImage/580f430ddd404.png\"\n        }\n      ],\n      \"banners\": [\n        {\n          \"id\": 1,\n          \"title\": \"general health\",\n          \"caption\": \"test\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/banner/sample_20161105074715.jpg\",\n          \"url\": \"\"\n        },\n        {\n          \"id\": 2,\n          \"title\": \"banner 2\",\n          \"caption\": \"banner 2\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/banner/sample_20161105102412.jpg\",\n          \"url\": \"abc.com\"\n        }\n      ]\n    },\n    {\n      \"features\": [\n        {\n          \"title\": \"general feature\",\n          \"name\": null,\n          \"description\": \"<p>fdgdfgdg</p>\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/page/sample_20161109080454.jpg\",\n          \"video_link\": null\n        },\n        {\n          \"title\": \"speech feature\",\n          \"name\": null,\n          \"description\": \"<p>fgdfgfdgdg</p>\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/page/sample_20161109080523.jpg\",\n          \"video_link\": null\n        }\n      ]\n    },\n    {\n      \"benifits\": [\n        {\n          \"title\": \"general benifits\",\n          \"name\": null,\n          \"description\": \"<p>fddfgdfgd</p>\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/page/sample_20161109080606.jpg\",\n          \"video_link\": null\n        }\n      ]\n    },\n    {\n      \"footer\": [\n        {\n          \"title\": \"general footer\",\n          \"name\": null,\n          \"description\": \"<p>dfgdfgdfgdf</p>\",\n          \"image\": \"https://face2face-dev.s3.amazonaws.com/page/sample_20161109080629.jpg\",\n          \"video_link\": null\n        }\n      ]\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/provider_type_page.js",
    "groupTitle": "Pages"
  },
  {
    "type": "post",
    "url": "PatientAddress/add",
    "title": "Add patient address",
    "name": "PatientAddress_add",
    "group": "Patient",
    "description": "<p>Add patient address.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "state_id",
            "description": "<ul> <li>State id is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "city",
            "description": "<ul> <li>Patient city is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_name",
            "description": "<ul> <li>Address name is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address1",
            "description": "<ul> <li>Address 1 is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address2",
            "description": "<ul> <li>Address 2 is optional field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "zip_code",
            "description": "<ul> <li>Zip-code is required field in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"patient_id\":\"1\",\n    \"state_id\":\"2\",\n    \"city\":\"alld\",\n    \"address_name\":\"dhirendra\",\n    \"address1\":\"new delhi\",\n    \"address2\":\"noida\",\n    \"zip_code\":\"43456\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/PatientAddress-add.js",
    "groupTitle": "Patient"
  },
  {
    "type": "get",
    "url": "PatientAddress/getList/:patientId",
    "title": "Get patient address",
    "name": "PatientAddress_getList",
    "group": "Patient",
    "description": "<p>Add patient address list.</p>",
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
            "field": "patientId",
            "description": "<ul> <li>Patient id is required field in url query string.</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"patient_id\": 1,\n      \"state_id\": 2,\n      \"city\": \"alld\",\n      \"address_name\": \"dhirendra\",\n      \"address1\": \"new delhi\",\n      \"address2\": \"noida\",\n      \"zip_code\": 43456,\n      \"created\": \"2016-12-16T06:38:55+00:00\",\n      \"modified\": \"2016-12-16T06:38:55+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/PatientAddress-getList.js",
    "groupTitle": "Patient"
  },
  {
    "type": "put",
    "url": "PatientDevices/delete",
    "title": "Delete Patient Devices",
    "name": "Delete_Patient_Devices",
    "group": "Patient_Devices",
    "description": "<p>Delete Patient Devices</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Patient device id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_patient_devices.js",
    "groupTitle": "Patient_Devices"
  },
  {
    "type": "post",
    "url": "PatientDevices/add",
    "title": "Add Patient Devices",
    "name": "add",
    "group": "Patient_Devices",
    "description": "<p>Add Patient Devices.</p>",
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
            "field": "patient_id",
            "description": "<ul> <li>Patient id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "device_id",
            "description": "<ul> <li>Device id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "device_title",
            "description": "<ul> <li>Device title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "audio",
            "description": "<ul> <li>Audio</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<ul> <li>Image</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n\t\"patient_id\":\"1\",\n\t\"device_id\":\"1\",\n\t\"device_title\":\"Fitbit1\",\n\t\"audio\":\"\",\n\t\"image\":\"\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_patient_device.js",
    "groupTitle": "Patient_Devices"
  },
  {
    "type": "put",
    "url": "PatientDevices/edit/:1",
    "title": "Edit Patient Devices",
    "name": "edit",
    "group": "Patient_Devices",
    "description": "<p>Delete Patient Devices</p>",
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
            "field": "device_title",
            "description": "<ul> <li>Device title</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "audio",
            "description": "<ul> <li>Audio</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "image",
            "description": "<ul> <li>Image</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"device_title\":\"Fitbit11\",\n    \"audio\":\"\",\n    \"image\":\"\",\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_patient_device.js",
    "groupTitle": "Patient_Devices"
  },
  {
    "type": "get",
    "url": "PatientDevices/getPatientDevices/:1",
    "title": "Get Patient Devices",
    "name": "getPatientDevices",
    "group": "Patient_Devices",
    "description": "<p>Get Patient Devices</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 16,\n      \"user_id\": 37,\n      \"patient_id\": 1,\n      \"device_id\": 1,\n      \"device_title\": \"Fitbit1\",\n      \"audio\": \"\",\n      \"image\": \"\",\n      \"device_access_token\": \"O:8:\\\"stdClass\\\":6:{s:12:\\\"access_token\\\";s:273:\\\"eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1M0RGNUoiLCJhdWQiOiIyMjdYWTciLCJpc3MiOiJGaXRiaXQiLCJ0eXAiOiJhY2Nlc3NfdG9rZW4iLCJzY29wZXMiOiJ3aHIgd251dCB3cHJvIHdzbGUgd3dlaSB3c29jIHdzZXQgd2FjdCB3bG9jIiwiZXhwIjoxNDgwOTc3NTY4LCJpYXQiOjE0ODA5NDg3Njh9.UwQh-RMbmgRmSHpyVOfuJjCC37RV31gqDJZLQCt_GgM\\\";s:10:\\\"expires_in\\\";i:28800;s:13:\\\"refresh_token\\\";s:64:\\\"6a2d5c533a8eb937e618d347fd3739bdfda5bf6c403f2863caf46e27b6c33271\\\";s:5:\\\"scope\\\";s:74:\\\"settings weight nutrition profile activity social sleep heartrate location\\\";s:10:\\\"token_type\\\";s:6:\\\"Bearer\\\";s:7:\\\"user_id\\\";s:6:\\\"53DF5J\\\";}\",\n      \"status\": \"Active\",\n      \"created\": \"2016-12-05T14:39:04+00:00\",\n      \"modified\": \"2016-12-05T14:39:04+00:00\"\n    },\n    {\n      \"id\": 17,\n      \"user_id\": 37,\n      \"patient_id\": 1,\n      \"device_id\": 1,\n      \"device_title\": \"Fitbit1\",\n      \"audio\": \"\",\n      \"image\": \"\",\n      \"device_access_token\": \"O:8:\\\"stdClass\\\":6:{s:12:\\\"access_token\\\";s:273:\\\"eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1M0RGNUoiLCJhdWQiOiIyMjdYWTciLCJpc3MiOiJGaXRiaXQiLCJ0eXAiOiJhY2Nlc3NfdG9rZW4iLCJzY29wZXMiOiJ3aHIgd3BybyB3bnV0IHdzbGUgd3dlaSB3c29jIHdzZXQgd2FjdCB3bG9jIiwiZXhwIjoxNDgxMDMzNDY2LCJpYXQiOjE0ODEwMDQ2NjZ9.PEIxvpBDiJ-P9guJXVCbIxZWNdctmk-JxSx_-k2xlYI\\\";s:10:\\\"expires_in\\\";i:28800;s:13:\\\"refresh_token\\\";s:64:\\\"e5f209d2279929db3ac749ce68d9cfb4cbbe714e0178bf233320190022ebcee7\\\";s:5:\\\"scope\\\";s:74:\\\"profile settings heartrate activity location nutrition sleep social weight\\\";s:10:\\\"token_type\\\";s:6:\\\"Bearer\\\";s:7:\\\"user_id\\\";s:6:\\\"53DF5J\\\";}\",\n      \"status\": \"Active\",\n      \"created\": \"2016-12-06T06:09:58+00:00\",\n      \"modified\": \"2016-12-06T06:09:58+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_patient_devices.js",
    "groupTitle": "Patient_Devices"
  },
  {
    "type": "put",
    "url": "/ProviderSettings/deleteMessage",
    "title": "Delete Messages from Provider Inbox",
    "name": "Delete_Messages_from_Provider_Inbox_and_change_status_to__Deleted__and_deleted_messages_will_go_into_trash",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Delete Messages from Provider Inbox and change status to &quot;Deleted&quot; and deleted messages will go into trash</p>",
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
            "type": "array",
            "optional": false,
            "field": "deleted_ids",
            "description": "<ul> <li>Required an array with ids of messages to delete in the body</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/deleteMessage\n{\n\t\"deleted_ids\":[2,3,4]\n}",
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
            "field": "None",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_delete_messages.js",
    "groupTitle": "Provider"
  },
  {
    "type": "put",
    "url": "/ProviderSettings/deleteMessagefromTrash",
    "title": "Delete Messages from Trash on Provider Inbox",
    "name": "Delete_Messages_from_from_Trash_on_Provider_Inbox_and_change_status_to__PD__and_deleted_messages_will_not_appear_in_trash",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Delete Messages from from Trash on Provider Inbox and change status to &quot;PD&quot; and deleted messages will not appear in trash</p>",
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
            "type": "array",
            "optional": false,
            "field": "deleted_ids",
            "description": "<ul> <li>Required an array with ids of messages to delete in the body</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/deleteMessagefromTrash\n{\n\t\"deleted_ids\":[2,3,4]\n}",
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
            "field": "None",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_delete_messages_from_trash.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/getProviderAccount",
    "title": "Display Provider Account Settings Details like charges per hour and availability",
    "name": "Display_Provider_Account_Settings_Details",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Display Provider Account Settings Details</p>",
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
            "field": "Provider",
            "description": "<p>Account Setting details with charges and availabiltiy</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 3,\n    \"on_demand_insurance_charges\": 30,\n    \"on_demand_non_insurance_charges\": 20.5,\n    \"off_hours_charges\": 10,\n    \"after_hours_charges\": 5,\n    \"same_as_on_demand\": \"Y\",\n    \"scheduled_insurance_charges\": 30,\n    \"scheduled_non_insurance_charges\": 20.5,\n    \"is_temporary_available\": \"N\",\n    \"on_demand_appointment\": \"Y\",\n    \"multiprovider_scheduled_appointment\": \"N\",\n    \"concierge_service\": \"Y\",\n    \"phone_call\": \"Y\",\n    \"video_call\": \"N\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\nProviderSettings/getProviderAccount",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_provider_account_settings.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderPayments/getProviderPayment",
    "title": "Display Provider Payment Method Settings Details Banking or Cheque",
    "name": "Display_Provider_Payment_Method_Settings_Details",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Display Provider Payment method Settings Details Banking or cheque</p>",
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
            "field": "Provider",
            "description": "<p>Payment Method Setting details Banking or cheque</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"id\": 1,\n    \"user_id\": 3,\n    \"payment_method\": \"bank\",\n    \"bank_name\": \"abc\",\n    \"account_number\": \"689368264\",\n    \"routing_number\": \"648682653\",\n    \"account_type\": \"saving\",\n    \"branch_address\": \"noida\",\n    \"cheque_in_favor_off\": null,\n    \"mailing_address\": null\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\nProviderPayments/getProviderPayment",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_provider_payment_settings.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/patients/getPatientAppointmentsByProvider/:page-number",
    "title": "Get Provider's Patient Appointments List and searching",
    "name": "Get_Provider_s_Patient_Appointments_List_and_searching",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Get Provider's Patient Appointments List and searching</p>",
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
            "field": "/:page_number",
            "description": "<ul> <li>optional Send page number in url query string if use pagination</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<ul> <li>Optional &quot;Completed&quot; or &quot;Scheduled&quot; or &quot;Pending&quot; value in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "patient_name",
            "description": "<ul> <li>optional patient's first name or last name in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "inquiry_type",
            "description": "<ul> <li>optional inquiry_type id in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "gender",
            "description": "<ul> <li>optional patient's gender in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": false,
            "field": "dob",
            "description": "<ul> <li>optional patient's dob in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "date",
            "optional": false,
            "field": "appt_date",
            "description": "<ul> <li>optional patient's consultation request date  in body.</li> </ul>"
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
            "field": "Patient",
            "description": "<p>Appointments List of provider based on scheduled or completed or all other parameters</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"list\": [\n      {\n        \"patient_id\": 1,\n        \"consult_type\": \"On-Demand\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": null,\n        \"consultation_start_time\": null,\n        \"consultation_end_time\": \"2016-11-10T00:00:00+00:00\",\n        \"patient\": {\n          \"fname\": \"Jack\",\n          \"lname\": \"Doe\",\n          \"gender\": \"Male\",\n          \"dob\": \"2002-02-02T00:00:00+00:00\"\n        },\n        \"inquiry_type\": null,\n        \"inquiry\": null\n      },\n      {\n        \"patient_id\": 1,\n        \"consult_type\": \"On-Demand\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": null,\n        \"consultation_start_time\": null,\n        \"consultation_end_time\": \"2016-11-10T00:00:00+00:00\",\n        \"patient\": {\n          \"fname\": \"Jack\",\n          \"lname\": \"Doe\",\n          \"gender\": \"Male\",\n          \"dob\": \"2002-02-02T00:00:00+00:00\"\n        },\n        \"inquiry_type\": null,\n        \"inquiry\": null\n      },\n      {\n        \"patient_id\": 1,\n        \"consult_type\": \"On-Demand\",\n        \"consultation_status\": \"Not Started\",\n        \"consultation_start_date\": null,\n        \"consultation_start_time\": null,\n        \"consultation_end_time\": \"2016-11-10T00:00:00+00:00\",\n        \"patient\": {\n          \"fname\": \"Jack\",\n          \"lname\": \"Doe\",\n          \"gender\": \"Male\",\n          \"dob\": \"2002-02-02T00:00:00+00:00\"\n        },\n        \"inquiry_type\": null,\n        \"inquiry\": null\n      }\n    ],\n    \"Page\": {\n      \"finder\": \"all\",\n      \"page\": 1,\n      \"current\": 5,\n      \"count\": 7,\n      \"perPage\": 5,\n      \"prevPage\": false,\n      \"nextPage\": true,\n      \"pageCount\": 2,\n      \"sort\": null,\n      \"direction\": false,\n      \"limit\": null,\n      \"sortDefault\": false,\n      \"directionDefault\": false,\n      \"scope\": null\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\npatients/getPatientAppointmentsByProvider/:1",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_patient_appointment_list.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/ProviderSettings/inviteProvider",
    "title": "Invite provider from provider Inbox",
    "name": "Invite_provider_from_provider_Inbox",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Invite provider which is not registered on F2F Health by sending email from provider Inbox</p>",
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
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Required valid email of provider which is not registered on F2F Health</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/inviteProvider\n{\n\t\"email\":\"gaurav.agrawal@kiwitech.com\"\n}",
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
            "field": "set",
            "description": "<p>message as star with message details</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_invite_provider.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/newMessagesCount",
    "title": "New Messages count after last login",
    "name": "New_Messages_count_after_last_login",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>New Messages count after last login</p>",
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
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/newMessagesCount",
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
            "field": "New",
            "description": "<p>message count</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": 3\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_new_message_count.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/ProviderSettings/inbox/:page_number",
    "title": "Provider Inbox details with messages of email sent to provider from F2F Health",
    "name": "Provider_Inbox",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Provider Inbox, trash , important, social, promotions details with messages of email sent to provider from F2F Health with page limit or pagination</p>",
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
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<ul> <li>Required status field in the body with either of the values &quot;Important&quot;,&quot;Social&quot;,&quot;Promotions&quot;,&quot;Deleted&quot;</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "limit",
            "description": "<ul> <li>Required limit field in the body by default it is 20</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/inbox/:1\n{\n\t\"status\":\"Important\",\n\t\"limit\":20\n}",
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
            "field": "Provider",
            "description": "<p>Inbox details with messages of email sent to provider F2F Health</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"inbox\": [\n      {\n        \"id\": 67,\n        \"user_id\": 104,\n        \"from_name\": \"Face2Face Health\",\n        \"from_email\": \"support@face2face.com\",\n        \"to_email\": \"f2f_prov_dec9@yopmail.com\",\n        \"subject\": \"verify provider\",\n        \"message\": \"Welcome Face2Face Provider.\",\n        \"is_read\": \"N\",\n        \"status\": \"Active\",\n        \"mail_type\": \"Important\",\n        \"star\": \"N\",\n        \"deleted_date\": null,\n        \"invited\": \"N\",\n        \"created\": \"Dec 08\",\n        \"modified\": \"2016-12-09T06:49:45+00:00\"\n      }\n    ],\n    \"count\": 1,\n    \"page\": {\n      \"finder\": \"all\",\n      \"page\": 1,\n      \"current\": 1,\n      \"count\": 1,\n      \"perPage\": 20,\n      \"prevPage\": false,\n      \"nextPage\": false,\n      \"pageCount\": 1,\n      \"sort\": null,\n      \"direction\": false,\n      \"limit\": null,\n      \"sortDefault\": false,\n      \"directionDefault\": false,\n      \"scope\": null\n    }\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_provider_inbox.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/setMessageStatus?id=19",
    "title": "Provider Inbox Read Message and change status from unread to read",
    "name": "Read_Message_from_Provider_Inbox",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Provider Inbox Read Message and change status from unread to read where query string id is integer value of message id of provider inbox</p>",
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
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/setMessageStatus?id=67",
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
            "field": "Message",
            "description": "<p>Details from provider inbox with is_read status as &quot;Y&quot; means read</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 67,\n      \"user_id\": 104,\n      \"from_name\": \"Face2Face Health\",\n      \"from_email\": \"support@face2face.com\",\n      \"to_email\": \"f2f_prov_dec9@yopmail.com\",\n      \"subject\": \"verify provider\",\n      \"message\": \"Welcome Face2Face Provider.\",\n      \"is_read\": \"Y\",\n      \"status\": \"Active\",\n      \"mail_type\": \"Important\",\n      \"star\": \"N\",\n      \"deleted_date\": null,\n      \"invited\": \"N\",\n      \"created\": \"Dec 08\",\n      \"modified\": \"2016-12-09T06:49:45+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_read_message.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/ProviderSettings/saveProviderSettings",
    "title": "Save/edit Provider Account Settings Details like charges per hour and availability",
    "name": "Save_Edit_Provider_Account_Settings_Details",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Save/Edit Provider Account Settings Details</p>",
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
            "field": "on_demand_insurance_charges",
            "description": "<ul> <li>Required on_demand_insurance_charges in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "on_demand_non_insurance_charges",
            "description": "<ul> <li>Required on_demand_non_insurance_charges in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "off_hours_charges",
            "description": "<ul> <li>Required off_hours_charges in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "after_hours_charges",
            "description": "<ul> <li>Required after_hours_charges in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "same_as_on_demand",
            "description": "<ul> <li>Required same_as_on_demand &quot;Y&quot; or &quot;N&quot; value in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "scheduled_insurance_charges",
            "description": "<ul> <li>Optional scheduled_insurance_charges in body if &quot;Y&quot; in same_as_on_demand and required if &quot;N&quot; in same_as_on_demand\t\t\t\t\t\t        * .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "scheduled_non_insurance_charges",
            "description": "<ul> <li>Optional scheduled_non_insurance_charges in body if &quot;Y in same_as_on_demand and required if &quot;N&quot; in same_as_on_demand</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_temporary_available",
            "description": "<ul> <li>Required is_temporary_available &quot;Y&quot; or &quot;N&quot; value in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "on_demand_appointment",
            "description": "<ul> <li>Required on_demand_appointment &quot;Y&quot; or &quot;N&quot; value in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "multiprovider_scheduled_appointment",
            "description": "<ul> <li>Required multiprovider_scheduled_appointment &quot;Y&quot; or &quot;N&quot; in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "concierge_service",
            "description": "<ul> <li>Required concierge_service &quot;Y&quot; or &quot;N&quot; value in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone_call",
            "description": "<ul> <li>Required phone_call &quot;Y&quot; or &quot;N&quot; value in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "video_call",
            "description": "<ul> <li>Required video_call &quot;Y&quot; or &quot;N&quot; value in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<ul> <li>Required id taken from API &quot;get provider account settings&quot; to edit the same record.</li> </ul>"
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
            "field": "Provider",
            "description": "<p>Account Setting details with charges and availabiltiy</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{ \"status\": true, \n  \"message\": \"The request is OK\", \n  \"data\": \"None\" \n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"on_demand_insurance_charges\":30,\n\t\"on_demand_non_insurance_charges\":20.5,\n\t\"off_hours_charges\":10,\n\t\"after_hours_charges\":5,\n\t\"same_as_on_demand\":\"Y\",\n\t\"scheduled_insurance_charges\":45,\n\t\"scheduled_non_insurance_charges\":30.5,\n\t\"is_temporary_available\":\"N\",\n\t\"on_demand_appointment\":\"Y\",\n\t\"multiprovider_scheduled_appointment\":\"N\",\n\t\"concierge_service\":\"Y\",\n\t\"phone_call\":\"Y\",\n\t\"video_call\":\"N\",\n\t\"id\":23\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_account_settings.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/ProviderPayments/saveProviderPayment",
    "title": "Save/Edit Provider Payment Method \"Banking\" or \"cheque\" Settings Details.",
    "name": "Save_Edit_Provider_Payment_Method__Banking__or__cheque__Settings_Details_",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Save/Edit Provider Payment Method &quot;Banking&quot; or &quot;cheque&quot; Settings Details.</p>",
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
            "type": "string",
            "optional": false,
            "field": "payment_method",
            "description": "<ul> <li>Required payment_method value should be either &quot;bank&quot; or &quot;cheque&quot; in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_name",
            "description": "<ul> <li>Required bank_name if payment_method is bank and optional if cheque in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "account_number",
            "description": "<ul> <li>Required account_number if payment_method is bank and optional if cheque in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "routing_number",
            "description": "<ul> <li>Required routing_number if payment_method is bank and optional if cheque in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "account_type",
            "description": "<ul> <li>Required account_type if payment_method is bank and optional if cheque in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "branch_address",
            "description": "<ul> <li>Required branch_address if payment_method is bank and optional if cheque in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "cheque_in_favor_off",
            "description": "<ul> <li>Required cheque_in_favor_off if payment_method is cheque and optional if bank in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mailing_address",
            "description": "<ul> <li>Required mailing_address if payment_method is cheque and optional if bank in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "number",
            "optional": false,
            "field": "id",
            "description": "<ul> <li>Required if edit records of same provider and optional if added new record.</li> </ul>"
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
            "field": "Provider",
            "description": "<p>Account Setting details with charges and availabiltiy</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{ \"status\": true, \n  \"message\": \"The request is OK\", \n  \"data\": \"None\" \n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n   \"payment_method\": \"bank\",\n   \"bank_name\": \"abc\",\n   \"account_number\": 689368264,\n   \"routing_number\": 648682653,\n   \"account_type\": \"saving\",\n   \"branch_address\": \"noida\",\n   \"cheque_in_favor_off\":\"my cheque\",\n   \"mailing_address\":\"noida\"   \n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_payment_settings.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/setMessageStar?id=:id",
    "title": "Set Message Status to star",
    "name": "Set_Message_Status_to_star",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Set Message Status to star</p>",
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
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/setMessageStar?id=8",
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
            "field": "set",
            "description": "<p>message as star with message details</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 8,\n      \"user_id\": 91,\n      \"from_email\": null,\n      \"to_email\": \"f2f_prov_30@yopmail.com\",\n      \"subject\": \"verify provider\",\n      \"message\": \"Welcome Face2Face Provider.\",\n      \"is_read\": \"Y\",\n      \"status\": \"Active\",\n      \"mail_type\": \"Important\",\n      \"star\": \"Y\",\n      \"deleted_date\": null,\n      \"created\": \"2016-11-18T09:48:00+00:00\",\n      \"modified\": \"2016-11-18T09:48:00+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/provider_inbox_star_message.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "Calendar/addAvailability",
    "title": "Add Provider Availability",
    "name": "addAvailability",
    "group": "Provider",
    "description": "<p>Add provider availability.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "date",
            "description": "<ul> <li>Availability date is required fieled in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "start_time",
            "description": "<ul> <li>Start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "end_time",
            "description": "<ul> <li>End time is required field in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_recurring",
            "description": "<ul> <li>Recurring is required (Y|N)</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"date\":\"12-12-2016\",\n    \"start_time\":\"07:20:00\",\n    \"end_time\":\"07:50:00\",\n    \"is_recurring\":\"Y\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/addAvailability.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/ProviderSettings/changeAvailabilityStatus",
    "title": "Change Availability Status",
    "name": "changeAvailabilityStatus",
    "group": "Provider",
    "description": "<p>Get Patient Details.</p>",
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
            "field": "on_demand_appointment",
            "description": "<ul> <li>Set on demand appointment Yes and No.</li> </ul>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n \"on_demand_appointment\":\"Y\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/change_availability_status.js",
    "groupTitle": "Provider"
  },
  {
    "type": "put",
    "url": "users/changeUsernameAndEmail",
    "title": "Change Username, Email and Community Username",
    "name": "changeUsernameAndEmail",
    "group": "Provider",
    "description": "<p>Change Username, Email and Community Username.</p>",
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
            "description": "<ul> <li>Username</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<ul> <li>Email</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "community_username",
            "description": "<ul> <li>Community username</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": " {\n\t\"email\": \"nikum.kunj27@kiwitech.com\",\n        \"username\": \"nikum.kunj27\",\n        \"community_username\": \"nikum.kunj11111\"\t\n }",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/change_username_and_email.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "Calendar/getAppointmentCount",
    "title": "Get appointment count",
    "version": "0.0.1",
    "name": "getAppointmentCount",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Get appointment count.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End date required field in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"end_date\": \"2016-11-30\"\n}",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n{\n    \"status\": true,\n    \"message\": \"The request is OK\",\n    \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/getAppointmentCount.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "Calendar/getAvailabileAndScheduleTimeSlots",
    "title": "Get availability and scheduled appointment",
    "name": "getAvailabileAndScheduleTimeSlots",
    "group": "Provider",
    "description": "<p>Get provider availability and scheduled appointment between given date.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "start_date",
            "description": "<ul> <li>Start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "end_date",
            "description": "<ul> <li>End time is required field in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\t\"start_date\":\"2016-12-19\",\n\t\"end_date\":\"2016-12-12\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"schedule_list\": [\n      {\n        \"id\": 1,\n        \"re_schedule_by\": null,\n        \"re_schedule_request_date\": null,\n        \"title\": \"Raj Jhaveri\",\n        \"start\": \"2016-12-08 12:31:03\",\n        \"end\": \"2016-12-08 00:31:03\"\n      },\n      {\n        \"id\": 148,\n        \"re_schedule_by\": null,\n        \"re_schedule_request_date\": null,\n        \"title\": \"anshu ghgfjhf\",\n        \"start\": \"2016-11-19 02:31:00\",\n        \"end\": \"2016-11-19 03:31:00\"\n      },\n      {\n        \"id\": 180,\n        \"re_schedule_by\": null,\n        \"re_schedule_request_date\": null,\n        \"title\": \"anshu ghgfjhf\",\n        \"start\": \"2016-12-03 02:31:00\",\n        \"end\": \"2016-12-03 03:31:00\"\n      }\n    ],\n    \"available_list\": [\n      {\n        \"id\": 3,\n        \"user_id\": 213,\n        \"date\": \"2016-12-12T00:00:00+00:00\",\n        \"in_time\": \"2016-12-13T07:20:00+00:00\",\n        \"out_time\": \"2016-12-13T07:50:00+00:00\",\n        \"start\": \"2016-12-12 07:20:00\",\n        \"end\": \"2016-12-12 07:50:00\"\n      }\n    ]\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getAvailabileAndScheduleTimeSlots.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/ProviderSettings/getAvailabilityStatus",
    "title": "Get Availability Status",
    "name": "getAvailabilityStatus",
    "group": "Provider",
    "description": "<p>Get Patient Details.</p>",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"on_demand_appointment\": \"N\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Request method not supported\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getAvailabilityStatus.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "Calendar/getNextAppointment",
    "title": "Get next appointment",
    "version": "0.0.1",
    "name": "getNextAppointment",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Get next schedule appointment for calander availability.</p>",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "       HTTP/1.1 success\n       {\n           \t\"status\": true,\n\t\t\"message\": \"The request is OK\",\n\t\t\"data\": \"None\"\n       }",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/getNextAppointment.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "/users/getUsernameAndEmail",
    "title": "Get Username And Email",
    "name": "getUsernameAndEmail",
    "group": "Provider",
    "description": "<p>Get Username And Email.</p>",
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
            "description": "<p>Appointment Object contain details about patient appointment.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"username\": \"nikum.kunj27\",\n    \"email\": \"nikum.kunj27@kiwitech.com\",\n    \"community_username\": \"nikum.kunj11111\"\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_username_and_email.js",
    "groupTitle": "Provider"
  },
  {
    "type": "get",
    "url": "Calendar/getscheduleAppointment",
    "title": "Get schedule appointment",
    "version": "0.0.1",
    "name": "getscheduleAppointment",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Get schedule appointment for calander availability.</p>",
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [None]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "input/getscheduleAppointment.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "/Consultations/reScheduleConsult",
    "title": "Reschedule Consultation By Provider",
    "name": "reScheduleConsult",
    "group": "Provider",
    "description": "<p>To reschedule consultation by provider</p>",
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
            "field": "consult_id",
            "description": "<ul> <li>Consult id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "re_schedule_date",
            "description": "<ul> <li>Consult id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "re_schedule_start_time",
            "description": "<ul> <li>Consult id is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "re_schedule_end_time",
            "description": "<ul> <li>Consult id is required in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"consult_id\":\"7\",\n\t\"re_schedule_date\":\"2016-10-18\",\n\t\"re_schedule_start_time\":\"06:50:00\",\n\t\"re_schedule_end_time\":\"07:00:00\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/reScheduleConsult.js",
    "groupTitle": "Provider"
  },
  {
    "type": "put",
    "url": "/ProviderSettings/undoMessage",
    "title": "Undo the deleted email",
    "name": "undoMessage",
    "group": "Provider",
    "permission": [
      {
        "name": "Provider"
      }
    ],
    "description": "<p>Undo the deleted email its moved again in to inbox</p>",
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
            "type": "array",
            "optional": false,
            "field": "deleted_ids",
            "description": "<ul> <li>Required an array with ids of messages to delete in the body</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/ProviderSettings/deleteMessage\n{\n\t\"deleted_ids\":[2,3,4]\n}",
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
            "field": "None",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/undoMessage.js",
    "groupTitle": "Provider"
  },
  {
    "type": "put",
    "url": "/consultations/updateAppointmentStatus/:1/:Accept",
    "title": "Update Appointment Status",
    "name": "updateAppointmentStatus",
    "group": "Provider",
    "description": "<p>Get patient appointment by provider authentication.</p>",
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
            "field": "/:1",
            "description": "<ul> <li>Patient id send in request by url qurey string.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "/:Accept",
            "description": "<ul> <li>Accept|Decline send in request by url qurey string.</li> </ul>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateAppointmentStatus.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "Calendar/updateAvailability",
    "title": "Update Provider Availability",
    "name": "updateAvailability",
    "group": "Provider",
    "description": "<p>Add provider availability.</p>",
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
            "type": "Date",
            "optional": false,
            "field": "date",
            "description": "<ul> <li>Availability date is required fieled in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "start_time",
            "description": "<ul> <li>Start time is required field in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Time",
            "optional": false,
            "field": "end_time",
            "description": "<ul> <li>End time is required field in body</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "is_recurring",
            "description": "<ul> <li>Recurring is required (Y|N)</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n    \"date\":\"12-12-2016\",\n    \"start_time\":\"07:20:00\",\n    \"end_time\":\"07:50:00\",\n    \"is_recurring\":\"Y\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateAvailability.js",
    "groupTitle": "Provider"
  },
  {
    "type": "post",
    "url": "ProvidersRatings/add",
    "title": "Add Ratings",
    "name": "Add_Ratings",
    "group": "Ratings",
    "description": "<p>Add Ratings by consumer.</p>",
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
            "field": "provider_id",
            "description": "<ul> <li>Provider id</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<ul> <li>Ratings</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "[{\n\n\t\"provider_id\": \"2\",\n\t\"rating\": \"2\",\n\t\"comment\": \"hi this is for testing\"\n}, {\n\n\t\"provider_id\": \"2\",\n\t\"rating\": \"2\",\n\t\"comment\": \"hi this is for testing\"\n}]",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/add_ratings.js",
    "groupTitle": "Ratings"
  },
  {
    "type": "put",
    "url": "/ProvidersRatings/delete:2",
    "title": "Delete Providers Ratings",
    "name": "Delete_Providers_Ratings",
    "group": "Ratings",
    "description": "<p>Comsumner can delete Providers Ratings.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Rating id requried field in url query string</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n}\n{\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/delete_ratings.js",
    "groupTitle": "Ratings"
  },
  {
    "type": "put",
    "url": "ProvidersRatings/edit:1",
    "title": "Edit Ratings",
    "name": "Edit_Ratings",
    "group": "Ratings",
    "description": "<p>Edit ratings by consumer.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Rating id requried field in url query string</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "rating",
            "description": "<ul> <li>Ratings</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "comment",
            "description": "<ul> <li>Comments</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "{\n\n\t\"rating\": \"12\",\n\t\"comment\": \"hi th22is is for testing!!!!\"\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "HTTP/1.1 success\n{\n \"status\": true,\n \"message\": \"Data saved successfully\",\n \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/edit_ratings.js",
    "groupTitle": "Ratings"
  },
  {
    "type": "get",
    "url": "ProvidersRatings/getProvidersRatings:2",
    "title": "Get Providers Ratings",
    "name": "Get_Providers_Ratings",
    "group": "Ratings",
    "description": "<p>Get Providers Ratings using provider id.</p>",
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
            "field": "/:2",
            "description": "<ul> <li>Provider id requried field in url query string</li> </ul>"
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n {\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 3,\n      \"user_id\": 37,\n      \"provider_id\": 12,\n      \"rating\": 21,\n      \"comment\": \"hi this is for testing\",\n      \"created\": \"2016-11-22T13:53:40+00:00\"\n    },\n    {\n      \"id\": 4,\n      \"user_id\": 37,\n      \"provider_id\": 12,\n      \"rating\": 21,\n      \"comment\": \"hi this is for testing\",\n      \"created\": \"2016-11-22T13:54:24+00:00\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/get_providers_ratings.js",
    "groupTitle": "Ratings"
  },
  {
    "type": "get",
    "url": "/subscriptionPlans/addStripeCard",
    "title": "Save card on stripe",
    "name": "addStripeCard",
    "group": "Stripe",
    "description": "<p>Consumer can add new card</p>",
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
            "type": "Object",
            "optional": false,
            "field": "stripe_token",
            "description": "<ul> <li>Stripe token returned by stripe.js</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\t\"id\": \"tok_18z359A5U5jedLSh7LRPO86n\",\n\t\"object\": \"token\",\n\t\"card\": {\n \t\t\"id\": \"card_18z359A5U5jedLSh70zppYTF\",\n\t\t\"object\": \"card\",\n \t\t\"address_city\": \"tyutyu\",\n \t\t\"address_country\": null,\n \t\t\"address_line1\": \"mumbai\",\n \t\t\"address_line1_check\": \"unchecked\",\n \t\t\"address_line2\": \"tyu\",\n \t\t\"address_state\": \"CA\",\n \t\t\"address_zip\": \"12123\",\n \t\t\"address_zip_check\": \"unchecked\",\n \t\t\"brand\": \"MasterCard\",\n \t\t\"country\": \"US\",\n \t\t\"cvc_check\": \"unchecked\",\n \t\t\"dynamic_last4\": null,\n \t\t\"exp_month\": 8,\n\t\t\"exp_year\": 2016,\n \t\t\"funding\": \"credit\",\n \t\t\"last4\": \"4444\",\n \t\t\"metadata\": {},\n \t\t\"name\": \"tyut\",\n \t\t\"tokenization_method\": null\n\t},\n\t\"client_ip\": \"61.16.232.242\",\n\t\"created\": 1475149927,\n\t\"livemode\": false,\n\t\"type\": \"card\",\n\t\"used\": false\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n    \"status\": true,\n    \"message\": \"The request is OK\",\n    \"data\":None\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/addStripeCard.js",
    "groupTitle": "Stripe"
  },
  {
    "type": "get",
    "url": "/subscriptionPlans/getCardById/card_196GCiFspN4AvLfboWxdCZuD",
    "title": "Get card by card id",
    "name": "getCardById",
    "group": "Stripe",
    "description": "<p>Get card details by stripe card id</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": \"success\",\n  \"message\": \"Success\",\n  \"response\": {\n    \"id\": \"card_196GCiFspN4AvLfboWxdCZuD\",\n    \"object\": \"card\",\n    \"address_city\": \"city\",\n    \"address_country\": null,\n    \"address_line1\": \"hi hellow\",\n    \"address_line1_check\": \"pass\",\n    \"address_line2\": \"how are you\",\n    \"address_state\": \"state\",\n    \"address_zip\": \"123456\",\n    \"address_zip_check\": \"pass\",\n    \"brand\": \"Visa\",\n    \"country\": \"US\",\n    \"customer\": \"cus_9P4L6fYRdxjUGn\",\n    \"cvc_check\": \"pass\",\n    \"dynamic_last4\": null,\n    \"exp_month\": 10,\n    \"exp_year\": 2024,\n    \"fingerprint\": \"XNDZ0OJ9pXiBdK3J\",\n    \"funding\": \"credit\",\n    \"last4\": \"4242\",\n    \"metadata\": [],\n    \"name\": null,\n    \"tokenization_method\": null\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/getCardById.js",
    "groupTitle": "Stripe"
  },
  {
    "type": "get",
    "url": "/subscriptionPlans/listStripeCards",
    "title": "Card list",
    "name": "listStripeCards",
    "group": "Stripe",
    "description": "<p>Get all card list from stripe</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"stripe_card_id\": \"card_196GCiFspN4AvLfboWxdCZuD\",\n  \"data\": [\n    {\n      \"id\": \"card_196GCiFspN4AvLfboWxdCZuD\",\n      \"object\": \"card\",\n      \"address_city\": \"city\",\n      \"address_country\": null,\n      \"address_line1\": \"dhiru added\",\n      \"address_line1_check\": \"pass\",\n      \"address_line2\": \"how are you\",\n      \"address_state\": \"state\",\n      \"address_zip\": \"123456\",\n      \"address_zip_check\": \"pass\",\n      \"brand\": \"Visa\",\n      \"country\": \"US\",\n      \"customer\": \"cus_9P4L6fYRdxjUGn\",\n      \"cvc_check\": \"pass\",\n      \"dynamic_last4\": null,\n      \"exp_month\": 10,\n      \"exp_year\": 2024,\n      \"fingerprint\": \"XNDZ0OJ9pXiBdK3J\",\n      \"funding\": \"credit\",\n      \"last4\": \"4242\",\n      \"metadata\": [],\n      \"name\": null,\n      \"tokenization_method\": null\n    },\n    {\n      \"id\": \"card_196GCtFspN4AvLfbyTO3MjqU\",\n      \"object\": \"card\",\n      \"address_city\": \"city\",\n      \"address_country\": null,\n      \"address_line1\": \"address1\",\n      \"address_line1_check\": \"pass\",\n      \"address_line2\": \"address2\",\n      \"address_state\": \"state\",\n      \"address_zip\": \"123456\",\n      \"address_zip_check\": \"pass\",\n      \"brand\": \"Visa\",\n      \"country\": \"US\",\n      \"customer\": \"cus_9P4L6fYRdxjUGn\",\n      \"cvc_check\": \"pass\",\n      \"dynamic_last4\": null,\n      \"exp_month\": 8,\n      \"exp_year\": 2020,\n      \"fingerprint\": \"XNDZ0OJ9pXiBdK3J\",\n      \"funding\": \"credit\",\n      \"last4\": \"4242\",\n      \"metadata\": [],\n      \"name\": null,\n      \"tokenization_method\": null\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/listStripeCards.js",
    "groupTitle": "Stripe"
  },
  {
    "type": "get",
    "url": "/subscriptionPlans/updateDefaultCardId/card_196GCiFspN4AvLfboWxdCZuD",
    "title": "Update default card",
    "name": "updateDefaultCardId",
    "group": "Stripe",
    "description": "<p>Update default card</p>",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": \"None\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateDefaultCardId.js",
    "groupTitle": "Stripe"
  },
  {
    "type": "post",
    "url": "/subscriptionPlans/updateStripeCard",
    "title": "Update card on stripe",
    "name": "updateStripeCard",
    "group": "Stripe",
    "description": "<p>Consumer can update existing card</p>",
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
            "field": "address_city",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_country",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_line1",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_line2",
            "description": "<ul> <li>Address city is optional in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_state",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "address_zip",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "exp_month",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "exp_year",
            "description": "<ul> <li>Address city is required in body.</li> </ul>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n \t\"card_id\": \"card_196GCiFspN4AvLfboWxdCZuD\",\n \t\"address_city\": \"tyutyu\",\n \t\"address_country\": null,\n \t\"address_line1\": \"mumbai\",\n \t\"address_line2\": \"tyu\",\n \t\"address_state\": \"CA\",\n \t\"address_zip\": \"12123\",\n \t\"exp_month\": 8,\n\t\"exp_year\": 2016\n}",
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
            "description": "<p>True.</p>"
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
            "description": "<p>None.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": " HTTP/1.1 success\n{\n    \"status\": true,\n    \"message\": \"The request is OK\",\n    \"data\":None\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n\"status\": false,\n\"message\": \"Method not allowed on resource.\"\n}\n{\n\"status\": false,\n\"message\": \"Resource not found.\"\n}\n{\n\"status\": false,\n\"message\": \"Requested Parameter is not correct\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/updateStripeCard.js",
    "groupTitle": "Stripe"
  },
  {
    "type": "post",
    "url": "/SubscriptionPlans/checkCouponCode",
    "title": "Check Coupon Code based on Plan ID",
    "name": "Check_Coupon_Code_based_on_Plan_ID",
    "group": "Subscription",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Check Coupon Code based on Plan ID</p>",
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
            "field": "plan_id",
            "description": "<ul> <li>Required Subsciption Plan ID chosen by consumer 1-free plan 2-paid plan 3- paid plan.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_code",
            "description": "<ul> <li>Required Coupon Code in body .</li> </ul>"
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
            "description": "<p>Plan Object contain details Plan ID and Coupon Details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"data\": {\n    \"planID\": 2,\n    \"couponCode\": \"ffpaid\",\n    \"discount\":5,\n    \"discountType\":\"P\"\n  }\n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\"plan_id\":2,\n\"coupon_code\":\"ffpaid\"\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/check_coupon.js",
    "groupTitle": "Subscription"
  },
  {
    "type": "get",
    "url": "/SubscriptionPlans/getPlans",
    "title": "Subsciption Plans List",
    "version": "0.0.1",
    "name": "Subsciption_Plans_List",
    "group": "Subscription",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Subscription plans for consumer.</p>",
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
    "examples": [
      {
        "title": "Example usage:",
        "content": "/SubscriptionPlans/getPlans",
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
            "description": "<p>Plan list with user selected plan</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": {\n    \"plans\": [\n      {\n        \"id\": 1,\n        \"name\": \"Free\",\n        \"duration_in_months\": 0,\n        \"price\": 0,\n        \"description\": \"Free Plan\",\n        \"status\": \"Active\",\n        \"type\": \"Free\",\n        \"created\": null,\n        \"modified\": null\n      },\n      {\n        \"id\": 2,\n        \"name\": \"400\",\n        \"duration_in_months\": 3,\n        \"price\": 400,\n        \"description\": \"Paid Plan $400\",\n        \"status\": \"Active\",\n        \"type\": \"Paid\",\n        \"created\": null,\n        \"modified\": null\n      },\n      {\n        \"id\": 3,\n        \"name\": \"600\",\n        \"duration_in_months\": 6,\n        \"price\": 600,\n        \"description\": \"Paid Plan $600\",\n        \"status\": \"Active\",\n        \"type\": \"Paid\",\n        \"created\": null,\n        \"modified\": null\n      }\n    ],\n    \"selected_plan\": 2\n  }\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/subscription_plans_list.js",
    "groupTitle": "Subscription"
  },
  {
    "type": "post",
    "url": "/SubscriptionPlans/updatePlanOrders",
    "title": "Subscribe a Plan and Make Payment",
    "name": "Subscribe_Plan_and_Make_Payment",
    "group": "Subscription",
    "permission": [
      {
        "name": "Consumer"
      }
    ],
    "description": "<p>Subscribe a Plan , coupon code may be applied and make payment by consumer</p>",
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
            "field": "plan_id",
            "description": "<ul> <li>Required Subsciption Plan ID chosen by consumer 1-free plan, 2-paid plan,3-paid plan.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "coupon_code",
            "description": "<ul> <li>Optional Coupon Code in body .</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "newsletter_subsciption_status",
            "description": "<ul> <li>Required consumer Newsletter Subcription status field accepted as 'Y' in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "terms_use",
            "description": "<ul> <li>Required consumer Terms and condition status field accepted as 'Y' in body.</li> </ul>"
          },
          {
            "group": "Parameter",
            "type": "object",
            "optional": false,
            "field": "card",
            "description": "<ul> <li>Card object with token and billing details generated dynamically from stripe server.</li> </ul>"
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
            "description": "<p>Plan Object contain details about consumer billing and card details.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response-Example:",
          "content": "    HTTP/1.1 success \n{\n  \"status\": true,\n  \"message\": \"Order generated\",\n  \"data\": {\n    \"paymentStatus\": success,\n    \"order_id\": 1   \n}",
          "type": "json"
        }
      ]
    },
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n{\n\"plan_id\":2,\n\"coupon_code\":\"ffpaid\",\n\"newsletter_subsciption_status\":\"Y\",\n\"terms_use\":\"Y\",\n\"card\":{\n \"id\": \"tok_18yNTFA5U5jedLShrRkO4oXB\",\n \"object\": \"token\",\n \"card\": {}\n}",
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
          "content": "  \n {\n\t\"status\": false,\n\t\"message\": \"Method not allowed on resource.\"\n   }\n   {\n\t\"status\": false,\n\t\"message\": \"Resource not found.\"\n  }\n  {\n\t\"status\": false,\n\t\"message\": \"Requested Parameter is not correct\"\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "input/subscribe_plan.js",
    "groupTitle": "Subscription"
  },
  {
    "type": "get",
    "url": "/Webinars/getFutureWebinar",
    "title": "Get future webinar details",
    "version": "0.0.1",
    "name": "Future_Webinar",
    "group": "Webinar",
    "description": "<p>future webinar details.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Webinars/getFutureWebinar",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Future Webinar.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 20,\n      \"image\": null,\n      \"topic\": \"webinar 108\",\n      \"presenter_info\": \"hj\",\n      \"host_messaging\": \"hkj\",\n      \"start_time\": \"'January 19, 2017 7:00 am'\",\n      \"duration\": \"8:00\",\n      \"end_time\": \"2017-01-19 15:00:00\",\n      \"attendees_capacity\": \"9\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/future_webinar.js",
    "groupTitle": "Webinar"
  },
  {
    "type": "get",
    "url": "/Webinars/getPastWebinar",
    "title": "Get past webinar details",
    "version": "0.0.1",
    "name": "Past_Webinar",
    "group": "Webinar",
    "description": "<p>past webinar details.</p>",
    "examples": [
      {
        "title": "Example usage:",
        "content": "\n/Webinars/getPastWebinar",
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
            "description": "<p>true.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "message",
            "description": "<p>The request is ok.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "data",
            "description": "<p>Past Webinar.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response: ",
          "content": "{\n  \"status\": true,\n  \"message\": \"The request is OK\",\n  \"data\": [\n    {\n      \"id\": 1,\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/webinar/vela_1024x768_20161206055636.jpg\",\n      \"topic\": \"fghgfh\",\n      \"presenter_info\": \"gdgd\",\n      \"host_messaging\": \"dgdfg\",\n      \"start_time\": \"'January 1, 2017 11:00 pm'\",\n      \"duration\": \"23:00\",\n      \"end_time\": \"2017-01-02 22:00:00\",\n      \"attendees_capacity\": \"4\"\n    },\n    {\n      \"id\": 2,\n      \"image\": \"https://face2face-dev.s3.amazonaws.com/webinar/vela_1024x768_20161206090848.jpg\",\n      \"topic\": \"webinar 1\",\n      \"presenter_info\": \"presenter1\",\n      \"host_messaging\": \"messaging 1\",\n      \"start_time\": \"'January 1, 2017 11:00 am'\",\n      \"duration\": \"1:00\",\n      \"end_time\": \"2017-01-01 12:00:00\",\n      \"attendees_capacity\": \"1\"\n    }\n  ]\n}",
          "type": "json"
        }
      ]
    },
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
          "content": " \n{\n       \"status\": false,\n       \"message\": \"Method not allowed on resource.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Resource not found.\"\n   }\n   {\n       \"status\": false,\n       \"message\": \"Requested Parameter is not correct\"\n   }",
          "type": "json"
        }
      ]
    },
    "filename": "input/past_webinar.js",
    "groupTitle": "Webinar"
  }
] });
