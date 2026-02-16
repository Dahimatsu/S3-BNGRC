<?php

namespace app\controllers;

use Flight;

class HomeController
{
    public static function showHome($app)
    {
        if (empty($_SESSION['user']) === true) {
            Flight::redirect('/login');
            return;
        }

        $app->render('home/layout', [
            'page' => 'home',
            'title' => 'Accueil',
            'user' => $_SESSION['user'],
        ]);
    }
}
