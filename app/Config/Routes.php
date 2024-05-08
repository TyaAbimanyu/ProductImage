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
$routes->get('/StatusUpdate', 'ViewProduct::updateStatus');
$routes->put('/StatusUpdate', 'ViewProduct::updateStatus');
$routes->put('/Update', 'ViewProduct::UpdateData');
$routes->post('/AddImage', 'AddImage::InserImg');
$routes->get('/getImage/(:segment)', 'ViewImage::getImage/$1');
$routes->put('/statusUpdateImage', 'ViewImage::statusUpdateImage');
$routes->delete('/deleteImage/(:segment)', 'ViewImage::deleteImage/$1');
$routes->delete('/deletedData/(:segment)', 'ViewProduct::deletedData/$1');
$routes->delete('/deletedOrder/(:segment)', 'ViewOrder::deletedOrder/$1');
$routes->get('/getUpdateData/(:segment)', 'ViewProduct::getUpdateProduct/$1');
$routes->post('/getUpdateData/(:segment)', 'ViewProduct::getUpdateProduct/$1');
$routes->get('/SearchOrder/(:segment)', 'AddOrder::SearchOrder/$1');
$routes->get('/getProductData', 'AddOrder::getProductData');
$routes->get('/getOrder', 'ViewOrder::getOrder');
$routes->post('/insertOrder', 'AddOrder::insertOrder');

