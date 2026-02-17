<?php

namespace app\controllers;

use app\repositories\DashboardRepository;
use app\repositories\AchatRepository;

class DashboardController
{
    public static function showDashboard($app)
    {

        $pdo = $app->db();
        
        $dashboardRepo = new DashboardRepository($pdo);
        $dashboard = $dashboardRepo->getDashboard();

        $achatsRepo = new AchatRepository($pdo);
        $achats = $achatsRepo->getHistoriqueAchats();

        $app->render('home/layout', [
            'page' => 'dashboard',
            'title' => 'Tableau de bord',
            'achats' => $achats,
            'dashboard' => $dashboard
        ]);
    }
}
