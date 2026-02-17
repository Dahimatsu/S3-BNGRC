<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\controllers\DonController;
use app\controllers\BesoinController;
use app\controllers\DashboardController;
use app\controllers\AchatController;
use app\controllers\RecapController;
use app\controllers\ResetController;
use app\controllers\VenteController;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$app = Flight::app();

$router->group('', function(Router $router) use ($app) {


	$router->get('/', function() {
	    Flight::redirect('/accueil');
    });

    $router->get('/404', function () {
        Flight::render('error/404');
    });

    Flight::map('notFound', function () {
        Flight::redirect('/404?error=PageNotFound');
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

        $router->post('/distribution', function () use ($app) {
            DonController::processDistribution($app);
        });

    });

    $router->post('/achat', function () use ($app) {
        AchatController::processAchat($app);
    });

    $router->get('/dashboard', function () use ($app) {
        DashboardController::showDashboard($app);
    });

    $router->group('/recapitulatif', function () use ($router, $app) {

        $router->get('', function () use ($app) {
            RecapController::showRecap($app);
        });

        $router->get('/ajax', function () use ($app) {
            RecapController::getRecapData($app);

        });
    });

    $router->get('/reset', function () use ($app) {
        ResetController::reset($app);
    });

    $router->group('/vente', function () use ($router, $app) {

        $router->post('', function () use ($app) {
            VenteController::processVente($app);
        });

        $router->post('/update-param', function () use ($app) {
            VenteController::updateParam($app);

        });
    });
	
}, [ SecurityHeadersMiddleware::class ]);