<?php
class Database {
    // Paramètres de connexion à la base de données
    private $host = "localhost"; // Nom de l'hôte
    private $db_name = "lycee"; // Nom de la base de données
    private $username = "root"; // Nom d'utilisateur
    private $password = ""; // Mot de passe (laissez vide si vous n'en avez pas)
    private $conn;

    // Méthode pour établir la connexion à la base de données
    public function getConnection() {
        $this->conn = null;
        
        try {
            // Créer une connexion PDO
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            // Définir l'attribut PDO pour obtenir les erreurs
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // En cas d'erreur de connexion, afficher l'exception
            echo "Erreur de connexion à la base de données: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>
