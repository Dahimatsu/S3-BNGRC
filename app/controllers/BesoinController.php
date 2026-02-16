<?php

namespace app\controllers;

use app\repositories\StockRepository;
use app\repositories\BesoinRepository;

class BesoinController
{
    public static function showBesoin($app)
    {
        if (empty($_SESSION['user']) === true) {
            Flight::redirect('/login');
            return;
        }

        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);
        $ville = new BesoinRepository($pdo);

        $villes = $ville->getAllVille();
        $articles = $stockRepo->getAllArticles();

        $app->render('home/layout', [
            'page' => 'besoins',
            'title' => 'Besoins',
            'villes' => $villes,
            'articles' => $articles
        ]);
    }
}
