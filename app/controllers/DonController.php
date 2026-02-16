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
}
