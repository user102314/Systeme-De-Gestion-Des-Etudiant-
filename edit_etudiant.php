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

// Vérifier si les données sont envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CodeEtudiant = $_POST['CodeEtudiant'];
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $DateNaissance = $_POST['DateNaissance'];
    $NumInscription = $_POST['NumInscription'];
    $NomClasse = $_POST['NomClasse'];

    // Mettre à jour les informations de l'étudiant dans la base de données
    $sql = "UPDATE T_Etudiant SET Nom = ?, Prenom = ?, DateNaissance = ?, NumInscription = ?, NomClasse = ? WHERE CodeEtudiant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$Nom, $Prenom, $DateNaissance, $NumInscription, $NomClasse, $CodeEtudiant]);

    // Rediriger après la mise à jour
    header("Location: liste_etudiant.php");
    exit;
}
?>
