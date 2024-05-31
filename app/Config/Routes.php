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
$routes->get('/CheckerMember', 'ValidateToken::validateTokenMember');
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
$routes->get('/getProductDataMember', 'ViewProductMember::getProductDataMember');
$routes->get('/getOrder', 'ViewOrder::getOrder');
$routes->post('/insertOrder', 'AddOrder::insertOrder');
$routes->post('/registerMember', 'RegisterMember::registerMember');
$routes->post('/loginMember', 'LoginMember::loginMember');
$routes->get('/getImageDetail/(:segment)', 'ViewDetailProduct::getImageDetail/$1');
$routes->post('/AddToCartDetail', 'AddCartMember::AddToCartDetail');
$routes->post('/getDataCart', 'ViewCartMember::getDataCart');
$routes->post('/updateQuantity', 'ViewCartMember::updateQuantity');
$routes->post('/deleteDataCart', 'ViewCartMember::deleteDataCart');
$routes->post('/updateCartTotalPrice', 'ViewCartMember::updateCartTotalPrice');
$routes->get('/getDataOrder', 'GetDataCheckOut::getDataOrder');
$routes->post('/getDataOrder', 'GetDataCheckOut::getDataOrder');
$routes->post('/submitCart', 'GetDataCheckOut::submitCart');
$routes->get('/getDataSubmit', 'GetCheckOutSubmit::getDataSubmit');
$routes->put('/setConfirmOrder', 'GetCheckOutSubmit::setConfirmOrder');
$routes->get('/getDataCheck', 'GetDataConfirm::getDataCheck');
$routes->post('/paymentSubmit', 'GetDataConfirm::paymentSubmit');

$routes->group('bank', function($routes){
    $routes->get('getBankData', 'Bank\BankController::getBankData');
    $routes->post('insertBankData/', 'Bank\BankController::insertBankData');
    $routes->put('updateStatusBank/', 'Bank\BankController::updateStatus');
    $routes->get('getUpdateBank/(:segment)', 'Bank\BankController::getUpdateBank/$1');
    $routes->put('UpdateBankData/', 'Bank\BankController::UpdateBankData');
    $routes->delete('deletedBank/(:segment)', 'Bank\BankController::deletedBank/$1');

}); 

$routes->group('member', function($routes){
    $routes->get('getMemberData/', 'Member\MemberController::getMemberData');
    $routes->put('updateStatusMember/', 'Member\MemberController::updateStatus');
    $routes->get('getMemberDetailData/(:segment)', 'Member\MemberDetailController::getMemberDetailData/$1');
    $routes->get('getMemberOrderData/(:segment)', 'Member\MemberDetailController::getMemberOrderData/$1');
    $routes->delete('deleteMemberData/(:segment)', 'Member\MemberDetailController::deleteMemberData/$1');
});

$routes->group('payment', function($routes){
    $routes->get('getOrderNumber/(:segment)', 'Payment\OrderPaymentConfirmController::getOrderNumber/$1');
    $routes->put('updateStatusPayment/', 'Payment\OrderPaymentConfirmController::updateStatusPayment');
    $routes->get('getPaymentData/(:segment)', 'Payment\OrderPaymentConfirmController::getPaymentData/$1');
    $routes->get('orderData/(:segment)', 'Payment\OrderPaymentConfirmDetailController::orderData/$1');
    $routes->get('orderPaymentData/(:segment)', 'Payment\OrderPaymentConfirmDetailController::orderPaymentData/$1');
    $routes->put('updateStatusPaymentApprove/', 'Payment\OrderPaymentConfirmDetailController::updateStatusPaymentApprove');
    $routes->put('updateStatusPaymentReject/', 'Payment\OrderPaymentConfirmDetailController::updateStatusPaymentReject');
});







