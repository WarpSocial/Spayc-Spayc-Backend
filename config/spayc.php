<?php
return [
    'title' =>'SPAYC',
    'gender'=>['Male', 'Female', 'Other'],
    'spayctype'=>['Event', 'Community'],
    'grouptype'=>['Public', 'Private'],
    'pagelimit'=>5,
    'miles'=>1,
    'friend_requested_status'=>['Pending', 'Accepted', 'Blocked','Unblock','is_direct','Decline','Unfriend'],
    'add_friend'=>['Pending'],
    'accept_decline_status'=>['Accepted', 'Decline'],
    'block_status'=>['Blocked'],
    'unblock_status'=>['Unblock'],
    'unfriend_status'=>['Unfriend'],
    'requestMsg'=>[
        'Pending'=>'Friend Request sent Successfully.',
        'Accepted'=>'Friend added successfully.',
        'Blocked'=>'User has been blocked successfully.',
        'Unblock'=>'User has been unblocked successfully.',
        'Unfriend'=>'Friend status updated successfully.',
        'Decline'=>'Friend status updated successfully.',
    ],
    'is_notify'=>['On', 'Off'],
    //'friend_status'=>['Blocked', 'Unfriend', 'Unblock'],
    'maxupload'=>'5MB',
    'adminEmail' =>'kiwitech@gmail.com',
    'reverification_subject'=>'Re-Verifiaction',
    'forgotpassword_subject'=>'Forgot Password'
];
