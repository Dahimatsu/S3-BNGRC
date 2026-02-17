<?php

namespace app\controllers;

class HomeController
{
    public static function showHome($app)
    {
        $app->render('home/layout', [
            'page' => 'home',
            'title' => 'Accueil',
        ]);
    }
}
