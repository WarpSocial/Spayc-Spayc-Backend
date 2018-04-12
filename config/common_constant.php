<?php
/* Admin constant and messages */
define('ROLE_ADMIN',1);
define('SITE_TITLE','Warp');
define('PAGINATION_LIMIT',20);
define('DATEFORMAT_DISPLAY','M d, Y');
define('DATEFORMAT_SPAYC','D, d M');
define('TIMEFORMAT_SPAYC','h : i A');
define('DATEFORMAT','Y-m-d');
define('FRIEND_REQUESTED_STATUS','Accepted');
define('BLANK_COUNT',0);
define('BLANK','--');
$friend_requested_status_arr=array('accepted'=>'Accepted','decline'=>'Decline','pending'=>'Pending','blocked'=>'Blocked');
$user_gender=array('1'=>'All','2'=>'Male','3'=>'Female','4'=>'Other');
$user_age=array('1'=>'13-20','2'=>'21-30','3'=>'31-40','4'=>'41-50','5'=>'51-above');
$status_arr=array('active'=>'Active','inactive'=>'Inactive');
$spayctype_arr= array('event'=>'Event','community'=>'Community');
$grouptype_arr= array('Public'=>'Public','Private'=>'Private');
$spaycuserstatus_arr= array('1'=>'Admin','2'=>'Super Admin');
define('USER_GENDER', serialize($user_gender));
define('USER_AGE', serialize($user_age));
define('STATUS_ARR', serialize($status_arr));
define('SPAYC_TYPE_ARR', serialize($spayctype_arr));
define('GROUP_TYPE_ARR', serialize($grouptype_arr));
define('SPAYC_USER_STATUS_ARR', serialize($spaycuserstatus_arr));
define('FRIEND_REQUESTED_STATUS_ARR', serialize($friend_requested_status_arr));

$config =array();
$config['SITETITLEMESSAGE'] = [
    'ADMINPANEL'=>'Admin Panel',
    'CHANGEPASSWORD'=>'Change Password',
    'MANAGEUSER'=>'Manage Users',
    'FORGOTPASSWORD'=>'Forgot Password',
    'RESETPASSWORD'=>'Reset Password',
    'MANAGEUSER'=>'Manage Users',
    'MANAGEUSER'=>'Manage Users',    
    'WARPCREATED'=>'Warps Created',
    'WARPJOINED'=>SITE_TITLE.'s Joined',
    'WARPDETAIL'=>SITE_TITLE.' Detail',
    ];
$config['ERRORANDSUCCESSMSG'] = [
    'LOGOUTSUCCESS'=>'You have log out successfully.',
    'BLANKEMAIL'=>'Please enter email',
    'INVALIDEMAIL'=>'Invalid Email.',
    'BLANKPASS'=>'Please enter password.',    
    'BLANKCUPASS'=>'Please enter current password.',   
    'CPASSNPASSMISSMATCH'=>'Current password and new password can not be same.',
    'PASSMISSMATCH'=>'Passwords do not match, try again please?',
    'BLANKNPASS'=>'Please enter new password.', 
    'BLANKCFPASS'=>'Please enter confirm password.', 
    'PASSSUCCESS'=>'Password has been updated successfully.', 
    'INVALIDEMAILNPASS'=>'Invalid email and password.',  
    'INVALIDUSER'=>'Invalid user.', 
    'INVALIDLINK'=>'Invalid Link. Please try again.', 
    'LINKAlRUSED'=>'Invalid Link, This link has been already used.',
    'PASSERRMSG'=>'Password must contain 8-30 character length, at least one letter and one number.',
    'SYSTEMERR'=>'Oops! Something went wrong. Please try again', 
    'RESETLINKMSG'=>'A link to reset your password has been sent to your work email.',
    'BLOCKED-MSG'=>'has been Blocked.',
    'UNBLOCKED-MSG'=>'has been Unblocked.',
];