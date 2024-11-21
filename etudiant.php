<?php
// Simuler une session d'un étudiant (vous devriez utiliser une vraie session après authentification)
session_start();
$_SESSION['username'] = 'etudiant'; // Exemples de données de session (utilisateur et rôle)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Etudiant - Lycina</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
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
            <a href="logout.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Logout</a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Block 1: Voir le nombre d'absences par matière -->
<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-header">
            <h5>Voir le nombre d'absences par matière <i class="fas fa-chart-bar"></i></h5> <!-- Symbole ajouté -->
        </div>
        <div class="card-body">
            <p>Consultez le nombre d'absences pour chaque matière selon une date choisie.</p>
            <button class="btn btn-primary" onclick="window.location.href='Tache1E.php';">Aller</button> <!-- Bouton "Aller" -->

        </div>
    </div>
</div>

<!-- Block 2: Afficher la liste des absences d'un étudiant pour une matière -->
<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-header">
            <h5>Liste des absences par matière <i class="fas fa-list"></i></h5> <!-- Symbole ajouté -->
        </div>
        <div class="card-body">
            <p>Affiche la liste des absences d'un étudiant pour la matière choisie.</p>
            <button class="btn btn-primary" onclick="window.location.href='Tache2E.php';">Aller</button> <!-- Bouton "Aller" -->
            </div>
    </div>
</div>

        </div>
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