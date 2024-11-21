<?php
// Inclure les fichiers nécessaires
include_once '../Database.php';
include_once 'Absence.php';

// Créer une instance de la connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Vérifier si le code de l'enseignant a été soumis via le formulaire
$codeEnseignant = isset($_POST['codeEnseignant']) ? $_POST['codeEnseignant'] : null;

// Si un code d'enseignant a été soumis, récupérer les étudiants absents
$absents = [];
if ($codeEnseignant) {
    $absence = new Absence($db);
    $absents = $absence->getAbsentsByEnseignant($codeEnseignant);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les étudiants absents</title>
    
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Votre fichier CSS personnalisé (si nécessaire) -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Afficher les étudiants absents</h1>

        <!-- Formulaire pour entrer le code enseignant -->
        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label for="codeEnseignant" class="form-label">Entrez votre code enseignant :</label>
                <input type="text" class="form-control" id="codeEnseignant" name="codeEnseignant" required>
            </div>
            <button type="submit" class="btn btn-primary">Afficher les absents</button>
        </form>

        <?php
        if ($codeEnseignant) {
            echo "<h2>Liste des étudiants absents pour l'enseignant avec le code : $codeEnseignant</h2>";

            // Vérifier si des absents sont trouvés
            if ($absents->rowCount() > 0) {
                echo "<table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>Code Etudiant</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                            </tr>
                        </thead>
                        <tbody>";

                // Parcourir les résultats et les afficher dans le tableau
                while ($row = $absents->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['CodeEtudiant']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Prenom']) . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-info' role='alert'>Aucun étudiant absent pour cet enseignant.</div>";
            }
        }
        ?>
    </div>

    <!-- Lien vers Bootstrap JS et son bundle (inclus Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
