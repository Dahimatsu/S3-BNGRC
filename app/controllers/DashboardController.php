<?php

namespace app\controllers;

class DashboardController
{
    public static function showDashboard($app)
    {
        $app->render('home/layout', [
            'page' => 'dashboard',
            'title' => 'Tableau de bord',
        ]);
    }
}
