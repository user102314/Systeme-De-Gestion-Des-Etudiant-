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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

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

    <?php
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

$sql = "
    SELECT E.CodeEtudiant, E.Nom, E.Prenom, E.DateNaissance, E.NumInscription, C.NomClasse
    FROM T_Etudiant E
    JOIN T_Classe C ON E.CodeClasse = C.CodeClasse
    ORDER BY E.Nom, E.Prenom
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


    <div class="container mt-5">
        <h1 class="mb-4">Liste des Étudiants</h1>

        <!-- Table des étudiants -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Numéro d'Inscription</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="etudiantTable">
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr id="row<?= $etudiant['CodeEtudiant'] ?>">
                        <td><?= htmlspecialchars($etudiant['CodeEtudiant']) ?></td>
                        <td><?= htmlspecialchars($etudiant['Nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['Prenom']) ?></td>
                        <td>
                            <?php
                                $dateNaissance = new DateTime($etudiant['DateNaissance']);
                                $aujourdhui = new DateTime();
                                $age = $aujourdhui->diff($dateNaissance)->y;
                                echo $age;
                            ?>
                        </td>
                        <td><?= htmlspecialchars($etudiant['NumInscription']) ?></td>
                        <td><?= htmlspecialchars($etudiant['NomClasse']) ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $etudiant['CodeEtudiant'] ?>">Editer</button>
                            <button class="btn btn-danger" class="deleteBtn" data-code="<?= $etudiant['CodeEtudiant'] ?>">Supprimer</button>
                        </td>
                    </tr>

                    <div class="modal fade" id="editModal<?= $etudiant['CodeEtudiant'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Modifier l'Étudiant</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm<?= $etudiant['CodeEtudiant'] ?>">
                                        <input type="hidden" name="CodeEtudiant" value="<?= $etudiant['CodeEtudiant'] ?>">
                                        <div class="mb-3">
                                            <label for="Nom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" id="Nom" name="Nom" value="<?= htmlspecialchars($etudiant['Nom']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Prenom" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" id="Prenom" name="Prenom" value="<?= htmlspecialchars($etudiant['Prenom']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="DateNaissance" class="form-label">Date de naissance</label>
                                            <input type="date" class="form-control" id="DateNaissance" name="DateNaissance" value="<?= htmlspecialchars($etudiant['DateNaissance']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="NumInscription" class="form-label">Numéro d'Inscription</label>
                                            <input type="text" class="form-control" id="NumInscription" name="NumInscription" value="<?= htmlspecialchars($etudiant['NumInscription']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="NomClasse" class="form-label">Classe</label>
                                            <input type="text" class="form-control" id="NomClasse" name="NomClasse" value="<?= htmlspecialchars($etudiant['NomClasse']) ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Supprimer l'Étudiant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Supprimer</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Suppression d'un étudiant
        let studentToDelete = null;
        $(".deleteBtn").click(function() {
            studentToDelete = $(this).data("code");
            $("#deleteModal").modal('show');
        });

        $("#confirmDeleteBtn").click(function() {
            if (studentToDelete) {
                $.ajax({
                    url: 'delete_etudiant.php',
                    type: 'POST',
                    data: { CodeEtudiant: studentToDelete },
                    success: function(response) {
                        // Si la suppression réussit, supprimer la ligne de la table
                        $('#row' + studentToDelete).remove();
                        $("#deleteModal").modal('hide');
                    },
                    error: function() {
                        alert('Erreur lors de la suppression.');
                    }
                });
            }
        });

        // Édition d'un étudiant via AJAX
        $("form[id^='editForm']").submit(function(e) {
            e.preventDefault(); // Empêcher le rechargement de la page

            var formId = $(this).attr('id');
            var formData = $(this).serialize();

            $.ajax({
                url: 'edit_etudiant.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Mettre à jour les informations dans la table sans recharger la page
                    var codeEtudiant = $("input[name='CodeEtudiant']").val();
                    var row = $('#row' + codeEtudiant);
                    row.find('td:eq(1)').text($('#Nom').val());
                    row.find('td:eq(2)').text($('#Prenom').val());
                    row.find('td:eq(3)').text($('#DateNaissance').val());
                    row.find('td:eq(4)').text($('#NumInscription').val());
                    row.find('td:eq(5)').text($('#NomClasse').val());

                    // Fermer le modal
                    $('#' + formId).closest('.modal').modal('hide');
                },
                error: function() {
                    alert('Erreur lors de l\'édition.');
                }
            });
        });
    </script>

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


    <!-- Charger jQuery avant tout autre script -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- Puis, charger Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Les autres bibliothèques -->
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Script principal -->
<script src="js/main.js"></script>

</body>
</html>

