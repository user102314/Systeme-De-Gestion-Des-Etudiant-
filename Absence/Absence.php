<?php
class Absence {
    private $conn;
    private $table_fiche_absence = 'T_FicheAbsence';
    private $table_ligne_fiche_absence = 'T_LigneFicheAbsence';
    private $table_etudiant = 'T_Etudiant';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fonction pour récupérer les étudiants absents d'un enseignant
    public function getAbsentsByEnseignant($codeEnseignant) {
        $query = "
            SELECT e.CodeEtudiant, e.Nom, e.Prenom 
            FROM {$this->table_ligne_fiche_absence} lfa
            JOIN {$this->table_etudiant} e ON lfa.CodeEtudiant = e.CodeEtudiant
            JOIN {$this->table_fiche_absence} fa ON lfa.CodeFicheAbsence = fa.CodeFicheAbsence
            WHERE fa.CodeEnseignant = :codeEnseignant
        ";

        // Préparation de la requête SQL
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codeEnseignant', $codeEnseignant);
        $stmt->execute();
        return $stmt;
    }
}
?>
