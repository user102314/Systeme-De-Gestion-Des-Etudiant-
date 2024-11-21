<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Lycina</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle with Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Lycina</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->


<?php
// Connexion à la base de données
$host = 'localhost';  // Le serveur MySQL
$dbname = 'lycee';  // Le nom de la base de données
$username = 'root';  // Votre nom d'utilisateur MySQL
$password = '';  // Votre mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Traitement du formulaire
if (isset($_POST['rechercher'])) {
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $classe = $_POST['classe'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Préparer la requête SQL pour obtenir les absences des étudiants
    $sql = "
        SELECT E.Nom AS NomEtudiant, E.Prenom AS PrenomEtudiant, COUNT(L.CodeFicheAbsence) AS NombreAbsences
        FROM T_Etudiant E
        JOIN T_LigneFicheAbsence L ON E.CodeEtudiant = L.CodeEtudiant
        JOIN T_FicheAbsence F ON L.CodeFicheAbsence = F.CodeFicheAbsence
        WHERE F.DateJour BETWEEN :date_debut AND :date_fin
        AND E.CodeClasse = :classe
        AND E.Nom LIKE :nom
        AND E.Prenom LIKE :prenom
        GROUP BY E.CodeEtudiant
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin,
        ':classe' => $classe,
        ':nom' => "%$nom%",
        ':prenom' => "%$prenom%"
    ]);

    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<div class="container mt-5">
        <h1 class="mb-4">Suivi des Absences des Étudiants</h1>

        <!-- Formulaire de recherche -->
        <form method="POST" action="Tache1E.php" class="mb-4">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="date_debut" class="form-label">Date de début :</label>
                    <input type="date" name="date_debut" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="date_fin" class="form-label">Date de fin :</label>
                    <input type="date" name="date_fin" class="form-control" required>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="classe" class="form-label">Classe :</label>
                    <input type="text" name="classe" class="form-control" required>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" name="nom" class="form-control">
                </div>

                <div class="col-md-2 mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" name="prenom" class="form-control">
                </div>
            </div>

            <button type="submit" name="rechercher" class="btn btn-primary">Rechercher</button>
        </form>

        <!-- Affichage des résultats -->
        <?php if (isset($resultats)): ?>
            <h2>Résultats de la Recherche :</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Nombre d'absences</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultats as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['NomEtudiant']) ?></td>
                            <td><?= htmlspecialchars($row['PrenomEtudiant']) ?></td>
                            <td><?= htmlspecialchars($row['NombreAbsences']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

 <!-- Footer Start -->
 <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="#about">About Us</a>
                    <a class="btn btn-link" href="#contact">Contact Us</a>
                    <a class="btn btn-link" href="Terms & Condition">Privacy Policy</a>
                    <a class="btn btn-link" href="Terms & Condition">Terms & Condition</a>
                    <a class="btn btn-link" href="Terms & Condition">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Iset mahdia Tunis</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+216 44 321 987</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>oussemakaria@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Lycena</a>, All Right Reserved.

                        Designed By <a class="border-bottom" href="https://htmlcodex.com">Oussema karia</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="Terms & Condition">Cookies</a>
                            <a href="Terms & Condition">Help</a>
                            <a href="Terms & Condition">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>
