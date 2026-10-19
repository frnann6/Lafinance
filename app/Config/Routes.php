<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'LafinanceHome::index');

service('auth')->routes($routes);

$routes->get('dashboard/home', 'Dashboard::index', ['filter' => 'session']);

$routes->get(
    'dashboard/transactions',
    'Transactions::index',
    ['filter' => 'session']
);

$routes->get(
    'dashboard/transactions/create',
    'Transactions::create',
    ['filter' => 'session']
);

$routes->post(
    'dashboard/transactions/store',
    'Transactions::store',
    ['filter' => 'session']
);

$routes->post(
    'dashboard/transactions/update/(:num)',
    'Transactions::update/$1',
    ['filter' => 'session']
);

$routes->post(
    'dashboard/transactions/delete/(:num)',
    'Transactions::delete/$1',
    ['filter' => 'session']
);