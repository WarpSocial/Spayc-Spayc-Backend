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
define('DATE_TIME_FORMAT','Y-m-d H:i:s');
define('DISTANCEINMETER','100');
define('SCRAPERCOMMONDATEFILTER','date');
define('SCRAPERGROUPFILTER','group');
define('SCRAPERUNIQUEFILTER','unique');
$friend_requested_status_arr=array('accepted'=>'Accepted','decline'=>'Decline','pending'=>'Pending','blocked'=>'Blocked');
$user_gender=array('1'=>'All','2'=>'Male','3'=>'Female','4'=>'Other');
$user_age=array('1'=>'13-20','2'=>'21-30','3'=>'31-40','4'=>'41-50','5'=>'51-above');
$status_arr=array('active'=>'Active','inactive'=>'Inactive');
$spayctype_arr= array('event'=>'Event','community'=>'Community');
$grouptype_arr= array('Public'=>'Public','Private'=>'Private');
$spaycuserstatus_arr= array('1'=>'Admin','2'=>'Super Admin');
$push_notification_admin_slug= array('blocked'=>'blocked-by-admin','unblocked'=>'unblocked-by-admin');
$txt_massage= array('block'=>'Blocked','unblock'=>'Unblocked');
$scraperStates = array('New York','NY','NEW YORK','new york','ny','New York City','new york city'); 
$scraperCountries = array('US','us','United States','united states','United States of America','USA'); 
define('USER_GENDER', serialize($user_gender));
define('USER_AGE', serialize($user_age));
define('STATUS_ARR', serialize($status_arr));
define('SPAYC_TYPE_ARR', serialize($spayctype_arr));
define('GROUP_TYPE_ARR', serialize($grouptype_arr));
define('SPAYC_USER_STATUS_ARR', serialize($spaycuserstatus_arr));
define('FRIEND_REQUESTED_STATUS_ARR', serialize($friend_requested_status_arr));
define('PUSH_NOTIFICATION_ADMIN_SLUG', serialize($push_notification_admin_slug));
define('SCRAPERSTATES', serialize($scraperStates));
define('SCRAPERCOUNTRIES', serialize($scraperCountries));
define('TEXT_MASSAGE', serialize($txt_massage));
define('TODAY_DATE', date('Y-m-d'));
define('AFTER14DAYS_DATE', date('Y-m-d', strtotime(' +14 day')));


$scraperRootUrl=array('eventbriteurl'=> 'https://www.eventbriteapi.com/v3/',
    'ticketmasterurl'=> 'https://app.ticketmaster.com/discovery/v2/events.json',
    'stubhuburl'=> 'https://api.stubhub.com/search/catalog/events/v3/',
    );
$scraperRootUrlToken = array('eventbritetoken'=> 'JRTJ7FHW3TG7F5U535RN',
    'ticketmastertoken'=> 'FGCdJbUpn9mAmyE9Rlqdi8CYfdhNQMsa',
    'stubhubtoken'=> 'c4ef9246-56c6-3024-a5ba-32f737a1c2b4',
    );
$scraperWebSite = array('eventbrite'=>'1','ticketmaster'=>'2','stubhub'=>'3');
define('SCRAPER_WEBSITE', serialize($scraperWebSite));
define('SCRAPER_ROOT_URL', serialize($scraperRootUrl));
define('SCRAPER_ROOT_URL_TOKEN', serialize($scraperRootUrlToken));
define('SCRAPER_EMAIL', 'ankur.indiacp@gmail.com');

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