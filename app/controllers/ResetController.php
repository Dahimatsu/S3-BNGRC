<?php
namespace app\controllers;

use app\repositories\ResetRepository;

class ResetController
{
    public static function reset($app)
    {
        $pdo = $app->db();

        $repo = new ResetRepository($pdo);

        if ($repo->reinitialiserTout()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Dons et Besoins réinitialisés avec succès.'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Erreur lors de la réinitialisation.'];
        }

        $app->redirect('/dashboard');
    }
}