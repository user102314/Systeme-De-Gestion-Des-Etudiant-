<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'lycee';
    $username = 'root';
    $password = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des données envoyées par AJAX
        $code = $_POST['code'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $adresse = $_POST['adresse'];
        $mail = $_POST['mail'];
        $tel = $_POST['tel'];

        // Mise à jour des données de l'enseignant dans la base de données
        $sql = "UPDATE T_Enseignant SET Nom = ?, Prenom = ?, Adresse = ?, Mail = ?, Tel = ? WHERE CodeEnseignant = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $adresse, $mail, $tel, $code]);

        // Réponse pour indiquer que l'édition a été réussie
        echo "Enseignant modifié avec succès!";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
