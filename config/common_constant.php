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
$user_gender=array('1'=>'All','2'=>'Male','3'=>'Female','4'=>'Others');
$user_age=array('1'=>'1-13','2'=>'13-26','3'=>'26-39','4'=>'39-52','5'=>'52-65','6'=>'65-above');
define('USER_GENDER', serialize($user_gender));
define('USER_AGE', serialize($user_age));
$config =array();
$config['ERRORANDSUCCESSMSG'] = [
    1=>'You log out successfully.',
    2=>'Please enter your email.',
    3=>'Email is not correct.',
    4=>'Please enter your password.',    
    5=>'Password must contain a minimum of 8 characters and 1 number.',
    6=>'Oops! The work email or password is incorrect.',
    7=>'Please enter an email address to reset your password.',
    8=>'This email address is not associated with any account.',
    9=>'Thank you, a temporary password has been sent to your email.',
    10=>'Please enter your current password.',
    11=>'Current password and new password cannot be same.',
    12=>'Passwords do not match. Try again?',
    13=>'Password must have 8 characters and 1 number.',
    14=>'Please create a previously unused password.',
    15=>'Are you sure you want to leave this section without responding or click PROCEED WITHOUT COMPLETING THIS STAGE.',
    16=>'Oops! new password and confirm password does not match.',
    17=>'Please enter old password.',
    18=>'Please enter new password.',
    19=>'An unexpected database error occurred. Please try again later.',
    20=>'Please enter confirm password.',
    21=>'Your password reset successfully.',
    22=>'Logged out successfully.',
    23=>'No search results found.',
    24=>'Timeout, Please try once again.',
    25=>'Error in connection.',   
    26=>'Email id already exists.',   
    27=>'Your password has been changed successfully.',
    28=>'Old password does not match.',
    29=>'Please make sure to fill out all the required fields correctly',  
    30=>'Blank space not allowed.',        
    31=>'Please enter a numeric value only.', 
    32=>'Invalid email and password.',   
    33=>'Please enter your email and password.',   
    34=>'Oops! Current passwords do not match.',
    35=>'Your password has been changed successfully.',
    36=>'Account not found. Please read email carefully and try again',
    37=>'Invalid token. Please try again.',
    38=>'Invalid token, This token has been already used.',
    39=>'Password must contain 8-30 character length, at least one letter and one number.',
    40=>'System rejected to update the password.',
    41=>'Invalid user.',
    42=>'Missing required information. Please read email carefully and try again.',
    43=>'Not a registered email.',
    44=>'A link to reset your password has been sent to your work email',

];