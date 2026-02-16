<?php

namespace app\controllers;

class DonController
{
    public static function showDon($app)
    {
        $app->render('home/layout', [
            'page' => 'dons',
            'title' => 'Dons',
        ]);
    }
}
