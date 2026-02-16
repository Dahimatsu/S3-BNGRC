<?php

namespace app\controllers;

use Flight;

class DonController
{
    public static function showDon($app)
    {
        if (empty($_SESSION['user']) === true) {
            Flight::redirect('/login');
            return;
        }

        $app->render('home/layout', [
            'page' => 'dons',
            'title' => 'Dons',
            'user' => $_SESSION['user'],
        ]);
    }

    
}
