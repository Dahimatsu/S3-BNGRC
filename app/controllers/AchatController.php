<?php

namespace app\controllers;

use app\repositories\AchatRepository;

class AchatController
{
    public static function processAchat($app)
    {
        $db = $app->db();
        $repo = new AchatRepository($db);

        $data = $app->request()->data;
        $id_ville = $data->id_ville;
        $id_article = $data->id_article;
        $quantite = (float) $data->quantite;

        $result = $repo->effectuerAchat($id_ville, $id_article, $quantite);

        $_SESSION['flash_message'] = [
            'type' => $result['success'] ? 'success' : 'error',
            'text' => $result['message']
        ];

        $app->redirect('/don');
    }

}