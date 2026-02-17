<?php

namespace app\controllers;

use app\repositories\StockRepository;
use app\repositories\VilleRepository;
use app\repositories\ArticleRepository;

class DonController
{
    public static function showDon($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);
        $villeRepo = new VilleRepository($pdo);
        $articleRepo = new ArticleRepository($pdo);

        $flash = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);

        $articles = $articleRepo->getAllArticles();
        $globalStock = $stockRepo->getGlobalStockStatus();
        $villes = $villeRepo->getAllVille();

        $app->render('home/layout', [
            'page' => 'dons',
            'title' => 'Gestion des Dons',
            'articles' => $articles,
            'globalStock' => $globalStock,
            'flash' => $flash,
            'villes' => $villes
        ]);
    }

    public static function saveDon($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);

        $id_article = $app->request()->data->id_article;
        $quantite = $app->request()->data->quantite;
        $date_reception = $app->request()->data->date_reception;

        $stockRepo->saveDonation($id_article, $quantite, $date_reception);

        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => 'RÉCEPTION ENREGISTRÉE AVEC SUCCÈS !'
        ];

        $app->redirect('/don');
    }

    public static function processDistribution($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);

        $id_ville = $app->request()->data->id_ville;
        $id_article = $app->request()->data->id_article;
        $quantite = (float) $app->request()->data->quantite;

        $dispo = $stockRepo->getAvailableStock($id_article);

        if ($quantite > $dispo) {
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'text' => "STOCK INSUFFISANT ! IL NE RESTE QUE $dispo EN STOCK."
            ];
        } else {
            $stockRepo->saveDistribution($id_ville, $id_article, $quantite);
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'DISTRIBUTION ENREGISTRÉE !'
            ];
        }

        $app->redirect('/don');
    }
}