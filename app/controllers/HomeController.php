<?php

namespace app\controllers;

use Flight;

class HomeController
{
    public static function showHome($app)
    {
        $app->render('home/layout', [
            'page' => 'home',
            'title' => 'Accueil',
            'user' => $_SESSION['user'] ?? '',
        ]);
    }
}
