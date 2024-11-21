<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'lycee';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Vérifier si un étudiant est à supprimer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CodeEtudiant = $_POST['CodeEtudiant'];

    // Supprimer l'étudiant de la base de données
    $sql = "DELETE FROM T_Etudiant WHERE CodeEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$CodeEtudiant]);

    // Rediriger après la suppression
    header("Location: liste_etudiant.php");
    exit;
}
?>
