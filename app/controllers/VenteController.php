<?php
namespace app\controllers;

use app\repositories\VenteRepository;
use app\repositories\ArticleRepository;

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

    public static function updateParam($app)
    {
        $db = $app->db();
        $data = $app->request()->data;

        $id_article = (int) $data->id_article;
        $nouveau_pourcentage = (float) $data->pourcentage;

        $repo = new ArticleRepository($db);

        $success = $repo->updatePourcentage($id_article, $nouveau_pourcentage);

        $_SESSION['flash_message'] = [
            'type' => $success ? 'success' : 'error',
            'text' => $success ? 'Paramètre mis à jour avec succès !' : 'Erreur lors de la modification.'
        ];

        $app->redirect('/don');
    }
}