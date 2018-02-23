<?php
return [
    'title' =>'SPAYC',
    'gender'=>['Male', 'Female', 'Other'],
    'spayctype'=>['Event', 'Community'],
    'grouptype'=>['Public', 'Private'],
    'friend_requested_status'=>['Pending', 'Accepted', 'Blocked','Unblock','Direct','Decline','Unfriend'],
    'requestMsg'=>[
        'Pending'=>'Friend Request send Successfully.',
        'Accepted'=>'Friend added successfully.',
        'Blocked'=>'User has been blocked successfully.',
        'Unblock'=>'User has been unblocked successfully.',
        'Unfriend'=>'Friend status updated successfully.',
        'Decline'=>'Friend status updated successfully.',
    ],
    //'friend_status'=>['Blocked', 'Unfriend', 'Unblock'],
    'maxupload'=>'2MB',
    'adminEmail' =>'kiwitech@gmail.com',
    'reverification_subject'=>'Re-Verifiaction',
    'forgotpassword_subject'=>'Forgot Password'
];
