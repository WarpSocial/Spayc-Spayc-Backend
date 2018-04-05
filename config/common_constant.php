<?php
/* Admin constant and messages */
define('ROLE_ADMIN',1);
define('SITE_TITLE','Warp');
define('PAGINATION_LIMIT',20);
define('DATEFORMAT_DISPLAY','M d, Y');
define('DATEFORMAT','Y-m-d');
define('FRIEND_REQUESTED_STATUS','Accepted');
define('BLANK_COUNT',0);
define('BLANK','--');
$user_gender=array('1'=>'All','2'=>'Male','3'=>'Female','4'=>'Other');
$user_age=array('1'=>'13-20','2'=>'21-30','3'=>'31-40','4'=>'41-50','5'=>'51-above');
$status_arr=array('active'=>'Active','inactive'=>'Inactive');
define('USER_GENDER', serialize($user_gender));
define('USER_AGE', serialize($user_age));
define('STATUS_ARR', serialize($status_arr));
$config =array();
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