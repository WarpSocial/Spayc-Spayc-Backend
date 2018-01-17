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
        $routes->fallbacks(DashedRoute::class);
    }
);
