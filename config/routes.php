<?php
use Cake\Routing\Router;

Router::plugin('ContactManager', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
