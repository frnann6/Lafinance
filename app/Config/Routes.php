<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'LafinanceHome::index');

service('auth')->routes($routes);

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'session']);

$routes->get(
    'transactions',
    'Transactions::index',
    ['filter' => 'session']
);

$routes->get(
    'transactions/create',
    'Transactions::create',
    ['filter' => 'session']
);

$routes->post(
    'transactions/store',
    'Transactions::store',
    ['filter' => 'session']
);