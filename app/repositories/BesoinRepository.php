<?php

namespace app\repositories;

use PDO;

class BesoinRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // public function create($email, $hash)
    // {
    //     $query = "INSERT INTO user(email, password)
    //   			  VALUES(?,?)";

    //     $st = $this->pdo->prepare($query);

    //     $st->execute([
    //         (string) $email,
    //         (string) $hash,
    //     ]);

    //     return $this->pdo->lastInsertId();
    // }

    public function getAllVille()
    {
        $query = "SELECT id, nom
                  FROM villes";

        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
}