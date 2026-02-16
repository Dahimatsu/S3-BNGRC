<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\controllers\DonController;
use app\controllers\BesoinController;
use app\controllers\DashboardController;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() {
	    Flight::redirect('/login');
    });

    $router->get('/login', function() use ($app) {
        AuthController::showLogin($app);
    });

    $router->post('/login', function() use ($app) {
       AuthController::postLogin($app);
    });

    $router->post('/api/validate/auth', function() use ($app) {
        AuthController::validateLoginAjax($app);
    });

    $router->get('/logout', function(){
        AuthController::logout();
    });

    $router->get('/accueil', function() use ($app) {
        HomeController::showHome($app);
    });

    $router->group('/besoin', function () use ($router, $app) {

        $router->get('', function () use ($app) {
            BesoinController::showBesoin($app);
        });

        $router->post('/save', function () use ($app) {
            BesoinController::saveBesoin($app);
        });

    });

    $router->group('/don', function () use ($router, $app) {

        $router->get('', function () use ($app) {
            DonController::showDon($app);
        });

        $router->post('/reception', function () use ($app) {
            DonController::saveDon($app);
        });

    });

    $router->get('/dashboard', function () use ($app) {
        DashboardController::showDashboard($app);
    });
    
    $router->get('/404', function(){
        Flight::render('error/404');
    });

    Flight::map('notFound', function(){
        Flight::redirect('/404?error=PageNotFound');
    });
	
}, [ SecurityHeadersMiddleware::class ]);