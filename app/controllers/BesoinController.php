<?php

namespace app\controllers;

use app\repositories\StockRepository;
use app\repositories\BesoinRepository;

class BesoinController
{
    public static function showBesoin($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);
        $ville = new BesoinRepository($pdo);
        $besoinRepo = new BesoinRepository($pdo);        
        
        $villes = $ville->getAllVille();
        $articles = $stockRepo->getAllArticles();
        $besoins = $besoinRepo->getBesoinsGroupesParVille();

        $app->render('home/layout', [
            'page' => 'besoins',
            'title' => 'Besoins',
            'villes' => $villes,
            'articles' => $articles,
            'besoins' => $besoins
        ]);
    }

    public static function saveBesoin($app)
    {
        $pdo = $app->db();
        $stockRepo = new StockRepository($pdo);
        $villeRepo = new BesoinRepository($pdo);
        $id_ville = $app->request()->data->id_ville;
        $id_article = $app->request()->data->id_article;
        $quantite = $app->request()->data->quantite;

        try{
            $villeRepo->createBesoin($id_ville, $id_article, $quantite);
            $app->redirect('/besoin');
        } catch (\Exception $e) {
            echo "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}
