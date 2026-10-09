<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'LafinanceHome::index');

service('auth')->routes($routes);
