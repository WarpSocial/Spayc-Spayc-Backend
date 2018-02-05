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
        $routes->connect('/friend-response', ['controller' => 'Users', 'action' => 'setFriendResponse']);
        $routes->connect('/subscribe-spayc', ['controller' => 'Spaycs', 'action' => 'subscribeSpayc']);
        $routes->connect('/spayc-details/:id', ['controller' => 'Spaycs', 'action' => 'view'], ['pass'=>['id']]);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect('/as', ['controller' => 'Spaycs', 'action' => 'matrixApplicationService']);
        $routes->fallbacks(DashedRoute::class);
    }
);
