<?php

namespace app\controllers;

use app\repositories\StockRepository;

class DonController
{
    public static function showDon($app)
    {
        $pdo = $app->db();

        $stockRepo = new StockRepository($pdo);
        
        $articles = $stockRepo->getAllArticles();
        $globalStock = $stockRepo->getGlobalStockStatus();

        $app->render('home/layout', [
            'page' => 'dons',
            'title' => 'Dons',
            'articles' => $articles,
            'globalStock' => $globalStock
        ]);
    }

    public static function saveDon($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);

        $id_article = $app->request()->data->id_article;
        $quantite = $app->request()->data->quantite;
        $date_reception = $app->request()->data->date_reception;

        try {
            $stockRepo->saveDonation($id_article, $quantite, $date_reception);
            $app->redirect('/don');
        } catch (\Exception $e) {

            echo "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}
