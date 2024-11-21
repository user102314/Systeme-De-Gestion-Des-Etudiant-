<?php
require_once 'Database.php';

class Enseignant {
    private $pdo;

    public function __construct() {
        // Directly create the PDO connection here
        $this->pdo = (new Database())->getPDO();
    }

    public function deleteEnseignant($codeEnseignant) {
        try {
            // Sanitize the input
            $codeEnseignant = trim($codeEnseignant);
            $sql = "DELETE FROM t_enseignant WHERE 'CodeEnseignant' = ? ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$codeEnseignant]);

            if ($stmt->execute()) {
                $rowCount = $stmt->rowCount();
                return $rowCount > 0 ? "Enseignant supprimé avec succès!" : "Aucun enseignant trouvé avec ce code!";
            } else {
                return "Erreur lors de la suppression.";
            }
        } catch (PDOException $e) {
            return "Erreur lors de la suppression : " . $e->getMessage();
        }
    }
}
?>
