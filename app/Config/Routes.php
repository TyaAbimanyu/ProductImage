<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Login', 'LoginController::login');
$routes->post('/Login', 'LoginController::login');
$routes->get('/Add', 'AddProduct::Insert');
$routes->post('/Add', 'AddProduct::Insert');
$routes->get('/Checker', 'ValidateToken::validateToken');
$routes->post('/Checker', 'ValidateToken::validateToken');
$routes->get('/ShowMenu', 'ViewProduct::getProduct');
$routes->post('/ShowMenu', 'ViewProduct::getProduct');