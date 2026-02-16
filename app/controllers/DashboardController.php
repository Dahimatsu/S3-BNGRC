<?php

namespace app\controllers;

use app\repositories\DashboardRepository;

class DashboardController
{
    public static function showDashboard($app)
    {

        $pdo = $app->db();
        
        $dashboardRepo = new DashboardRepository($pdo);
        $dashboard = $dashboardRepo->getDashboard();

        $app->render('home/layout', [
            'page' => 'dashboard',
            'title' => 'Tableau de bord',
            'dashboard' => $dashboard
        ]);
    }
}
