<?php
namespace app\controllers;
use app\repositories\RecapRepository;

class RecapController
{
    public static function showRecap($app)
    {
        $app->render('home/layout', [
            'page' => 'recapitulatif',
            'title' => 'Bilan Financier'
        ]);
    }

    public static function getRecapData($app)
    {
        $repo = new RecapRepository($app->db());
        $data = $repo->getFinancialRecap();

        $response = [
            'besoinTotal' => formatNumber($data['besoinTotal'] ?? 0),
            'besoinSatisfait' => formatNumber($data['besoinSatisfait'] ?? 0),
            'donsRecus' => formatNumber($data['donsRecus'] ?? 0),
            'donsDispatches' => formatNumber($data['donsDispatches'] ?? 0)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}