<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Api',
    ['path' => '/api'],
    function (RouteBuilder $routes) {
        $routes->setExtensions(['json','html']);
        $routes->resources('Users');
        $routes->resources('Spaycs');
        $routes->connect('/avatars',['controller'=>'Users','action'=>'avatars']);
        $routes->connect('/login',['controller'=>'Users','action'=>'login']);
        $routes->connect('/logout',['controller'=>'Users','action'=>'Logout']);
        $routes->connect('/facebook-signup',['controller'=>'Users', 'action'=>'facebookSignup']);
        $routes->connect('/profile-edit',['controller'=>'Users', 'action'=>'edit']);
        $routes->connect('/doc',['controller'=>'ApiDoc','action'=>'apiList','ext'=>'html']);
        $routes->connect('/verify/:token/:email', ['controller' => 'Users', 'action' => 'verifyAccount','ext'=>'html'], ['pass' => ['token', 'email']]);
        $routes->connect('/get-friends', ['controller' => 'Users', 'action' => 'getFriends']);
        $routes->connect('/friend-request', ['controller' => 'Users', 'action' => 'friendRequest']);
        $routes->connect('/add-friend', ['controller' => 'Users', 'action' => 'addFriend']);
        $routes->connect('/request-accept-declined', ['controller' => 'Users', 'action' => 'requestAcceptDeclined']);
        $routes->connect('/block-friend', ['controller' => 'Users', 'action' => 'blockFriend']);
        $routes->connect('/unblock-friend', ['controller' => 'Users', 'action' => 'unblockFriend']);
        $routes->connect('/unfriend-request', ['controller' => 'Users', 'action' => 'unfriendRequest']);
        $routes->connect('/friend-response', ['controller' => 'Users', 'action' => 'setFriendResponse']);
        $routes->connect('/update-user-status', ['controller' => 'Users', 'action' => 'userCurrentStatus']);
        $routes->connect('/facebook-friends', ['controller' => 'Users', 'action' => 'getFacebookFriends']);
        $routes->connect('/reverification', ['controller' => 'Users', 'action' => 'reverification']);
        $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
        $routes->connect('/reset-password/:token/:email', ['controller' => 'Users', 'action' => 'resetPassword', 'ext'=>'html'], ['pass' => ['token', 'email']]);
        $routes->connect('/user-profile/:id', ['controller' => 'Users', 'action' => 'viewProfile'], ['pass'=>['id']]);
        $routes->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
        $routes->connect('/update-device-token', ['controller'=>'Users', 'action'=>'updateDeviceToken']);
        $routes->connect('/change-role', ['controller'=>'Users', 'action'=>'changeRole']);
        
        $routes->connect('/set-profile-image/:id', ['controller' => 'Users', 'action' => 'setProfileImage'], ['pass'=>['id']]);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect('/remove-avatar/:order', ['controller' => 'Users', 'action' => 'removeAvatar'],['pass'=>['order']]);
        $routes->connect('/get-notifications',['controller'=>'Users', 'action'=>'getNotifications']);
        $routes->connect('/update-device-token', ['controller'=>'Users', 'action'=>'updateDeviceToken']);
        $routes->connect('/change-role', ['controller'=>'Users', 'action'=>'changeRole']);
        
        $routes->connect('/subscribe-spayc', ['controller' => 'Spaycs', 'action' => 'subscribeSpayc']);
        $routes->connect('/unsubscribe-spayc', ['controller' => 'Spaycs', 'action' => 'unSubscribeSpayc']);
        $routes->connect('/spayc-details', ['controller' => 'Spaycs', 'action' => 'view']);        
        $routes->connect('/chat-room', ['controller' => 'Spaycs', 'action' => 'createChatRoom']);
        $routes->connect('/create-subspace', ['controller' => 'Spaycs', 'action' => 'createSubSpace']);
        $routes->connect('/spayc-edit',['controller'=>'Spaycs', 'action'=>'edit']);
        $routes->connect('/spayc-members',['controller'=>'Spaycs', 'action'=>'spaycMembers']);
        $routes->connect('/subspaycs', ['controller'=>'Spaycs', 'action'=>'viewSubSpaycs']);
        $routes->connect('/physical-present-spaycs', ['controller'=>'Spaycs', 'action'=>'physicalyPresentSpaycs']);
        $routes->connect('/public-spaycs', ['controller'=>'Spaycs', 'action'=>'publicSpayc']);
        $routes->connect('/hash-tag-spaycs', ['controller'=>'Spaycs', 'action'=>'hashTagSpayc']);
        $routes->connect('/map-spaycs', ['controller'=>'Spaycs', 'action'=>'mapSpayc']);
        
        $routes->connect('/create-advertisement', ['controller' => 'Advertisement', 'action' => 'createAdvertisement']);
        $routes->connect('/advertisement-details', ['controller' => 'Advertisement', 'action' => 'viewAdvertisement']);
        $routes->connect('/user-advertisement', ['controller' => 'Advertisement', 'action' => 'userAdvertisement']);
        $routes->connect('/advertisement-edit', ['controller' => 'Advertisement', 'action' => 'edit']);
        $routes->connect('/advertisement-delete', ['controller' => 'Advertisement', 'action' => 'delete']);
        
        $routes->connect('/unread-notification', ['controller' => 'Users', 'action' => 'unreadNotification']);
        
        $routes->connect('/join-spayc', ['controller'=>'JoinSpaycs', 'action'=>'joinSpayc']);
        $routes->connect('/accept-join-request', ['controller'=>'JoinSpaycs', 'action'=>'acceptJoinedRequest']);
        $routes->connect('/join-sub-spayc', ['controller'=>'JoinSpaycs', 'action'=>'joinSubSpayc']);
        $routes->connect('/ban-spayc-member', ['controller'=>'JoinSpaycs', 'action'=>'banSpaycMember']);
        $routes->connect('/read-notifications', ['controller' => 'Users', 'action' => 'readNotification']);
        $routes->connect('/transactions/:id', ['controller' => 'Spaycs', 'action' => 'matrixApplicationService'],['pass'=>['id']]);
        
        $routes->fallbacks(DashedRoute::class);
    }
);
