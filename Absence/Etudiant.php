<?php
class Etudiant {
    private $conn;
    private $table = 'T_Etudiant';  // Nom de la table des étudiants

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAbsents() {
        // Préparer la requête pour récupérer les étudiants absents
        $query = "SELECT * FROM {$this->table} WHERE statut = 'absent'";  // Remplacez 'statut' par la colonne réelle qui indique l'absence

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
