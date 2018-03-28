<?php
/* Admin constant and messages */
define('ROLE_ADMIN',1);
define('SITE_TITLE','spayc');
define('PAGINATION_LIMIT',20);
define('DATEFORMAT_DISPLAY','M d, Y');
define('DATEFORMAT','Y-m-d');
define('FRIEND_REQUESTED_STATUS','Accepted');
define('BLANK_COUNT',0);
define('BLANK','--');
$user_gender=array('1'=>'All','2'=>'Male','3'=>'Female','4'=>'Other');
$user_age=array('1'=>'13-20','2'=>'21-30','3'=>'31-40','4'=>'41-50','5'=>'51-above');
define('USER_GENDER', serialize($user_gender));
define('USER_AGE', serialize($user_age));
$config =array();
$config['ERRORANDSUCCESSMSG'] = [
    1=>'You log out successfully.',
    2=>'Please enter email',
    3=>'Invalid Email.',
    4=>'Please enter password.',    
    5=>'Please enter current password.',   
    6=>'Current password and new password cannot be same.',
    7=>'Passwords do not match, try again please?',
    8=>'Please enter new password.', 
    9=>'Please enter confirm password.', 
    10=>'Your password has been changed successfully.', 
    11=>'Invalid email and password.',  
    12=>'Invalid user.', 
    13=>'Invalid Link. Please try again.', 
    14=>'Invalid Link, This link has been already used.',
    15=>'Password must contain 8-30 character length, at least one letter and one number.',
    16=>'Oops! Something went wrong. Please try again', 
    17=>'A link to reset your password has been sent to your work email.',
];