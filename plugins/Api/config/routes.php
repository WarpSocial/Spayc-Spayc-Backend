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
        $routes->connect('/login',['controller'=>'Users','action'=>'login']);
        $routes->connect('/doc',['controller'=>'ApiDoc','action'=>'apiList','ext'=>'html']);
        $routes->connect('/verify/:token/:email', ['controller' => 'Users', 'action' => 'verifyAccount','ext'=>'html'], ['pass' => ['token', 'email']]);
      
        $routes->fallbacks(DashedRoute::class);
    }
);
