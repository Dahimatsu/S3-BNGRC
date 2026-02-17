<?php
namespace app\controllers;

use app\repositories\VenteRepository;

class VenteController
{
    public static function processVente($app)
    {
        $db = $app->db();
        $repo = new VenteRepository($db);
        $data = $app->request()->data;

        $result = $repo->effectuerVente($data->id_article, (float) $data->quantite);

        $_SESSION['flash_message'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'text' => $result['message']
        ];

        $app->redirect('/don');
    }
}