<?php
namespace app\repositories;

use PDO;


class AchatRepository
{   
    private PDO $pdo;
    private int $idArgent;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $argentRepo = new ArgentRepository($this->pdo);
        $this->idArgent = (int) $argentRepo->getArgentId();
    }

    public function effectuerAchat($id_ville, $id_article, $quantite)
    {
        $st = $this->pdo->prepare("SELECT prix_unitaire FROM articles WHERE id = ?");
        $st->execute([$id_article]);
        $prixU = (float) $st->fetchColumn();
        $montant = $quantite * $prixU;

        $stockRepo = new StockRepository($this->pdo);
        $argentDisponible = $stockRepo->getAvailableStock($this->idArgent);

        if ($montant > $argentDisponible) {
            return [
                "success" => false,
                "message" => "Fonds insuffisants pour effectuer cet achat."
            ];
        }

        $this->pdo->beginTransaction();
        try {
            // 1. Enregistrer l'achat
            $query_achat = "INSERT INTO achats (id_ville, id_article, quantite, montant_total) VALUES (?, ?, ?, ?)";
            $stmt_achat = $this->pdo->prepare($query_achat);
            $stmt_achat->execute([$id_ville, $id_article, $quantite, $montant]);

            // 2. Déduire du cash via une distribution
            $query_deduction = "INSERT INTO distributions (id_ville, id_article, quantite_donnee) VALUES (?, ?, ?)";
            $stmt_deduction = $this->pdo->prepare($query_deduction);
            $stmt_deduction->execute([$id_ville, $this->idArgent, $montant]);

            $this->pdo->commit();

            return [
                "success" => true,
                "message" => "ACHAT RÉUSSI !"
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return [
                "success" => false,
                "message" => "ERREUR LORS DE L'ACHAT : " . $e->getMessage()
            ];
        }
    }

    public function getHistoriqueAchats($id_ville = null)
    {
        $query = "SELECT 
                ach.id, 
                v.nom as nomVille, 
                art.nom as nomArticle, 
                art.unite, 
                ach.quantite, 
                art.prix_unitaire as pu, 
                ach.montant_total, 
                ach.date_achat 
              FROM achats ach
              JOIN villes v ON ach.id_ville = v.id
              JOIN articles art ON ach.id_article = art.id";

        if ($id_ville) {
            $query .= " WHERE ach.id_ville = ? ORDER BY ach.date_achat DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id_ville]);
        } else {
            $query .= " ORDER BY ach.date_achat DESC";
            $stmt = $this->pdo->query($query);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}