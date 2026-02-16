<?php

namespace app\controllers;

use Flight;

class BesoinController
{
    public static function showBesoin($app)
    {
        if (empty($_SESSION['user']) === true) {
            Flight::redirect('/login');
            return;
        }

        $app->render('home/layout', [
            'page' => 'besoins',
            'title' => 'Besoins',
            'user' => $_SESSION['user'],
        ]);
    }
}
