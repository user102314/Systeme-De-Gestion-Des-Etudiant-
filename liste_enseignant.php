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
    SELECT EN.CodeEnseignant, EN.Nom, EN.Prenom, EN.DateRecrutement, EN.Adresse, EN.Mail, EN.Tel, D.NomDepartement, G.NomGrade
    FROM T_Enseignant EN
    JOIN T_Departement D ON EN.CodeDepartement = D.CodeDepartement
    JOIN T_Grade G ON EN.CodeGrade = G.CodeGrade
    ORDER BY EN.Nom, EN.Prenom
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Enseignants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des Enseignants</h1>

        <!-- Table des enseignants -->
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de Recrutement</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Département</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($enseignants as $enseignant): ?>
                <tr>
                    <td><?= htmlspecialchars($enseignant['CodeEnseignant']) ?></td>
                    <td><?= htmlspecialchars($enseignant['Nom']) ?></td>
                    <td><?= htmlspecialchars($enseignant['Prenom']) ?></td>
                    <td><?= htmlspecialchars($enseignant['DateRecrutement']) ?></td>
                    <td><?= htmlspecialchars($enseignant['Adresse']) ?></td>
                    <td><?= htmlspecialchars($enseignant['Mail']) ?></td>
                    <td><?= htmlspecialchars($enseignant['Tel']) ?></td>
                    <td><?= htmlspecialchars($enseignant['NomDepartement']) ?></td>
                    <td><?= htmlspecialchars($enseignant['NomGrade']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                onclick="openEditModal('<?= $enseignant['CodeEnseignant'] ?>', '<?= htmlspecialchars($enseignant['Nom']) ?>', '<?= htmlspecialchars($enseignant['Prenom']) ?>', '<?= htmlspecialchars($enseignant['Adresse']) ?>', '<?= htmlspecialchars($enseignant['Mail']) ?>', '<?= htmlspecialchars($enseignant['Tel']) ?>')">
                            Éditer
                        </button>
                        <button class="btn btn-danger btn-sm" data-bs-target="#deleteModal" onclick="deleteEnseignant(<?= $enseignant       ['CodeEnseignant'] ?>)">
                                Supprimer
                        </button>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    <script>
    function openEditModal(code, nom, prenom, adresse, mail, tel) {
        document.getElementById('code').value = code;
        document.getElementById('nom').value = nom;
        document.getElementById('prenom').value = prenom;
        document.getElementById('adresse').value = adresse;
        document.getElementById('mail').value = mail;
        document.getElementById('tel').value = tel;
    }
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editForm').submit(function(event) {
            event.preventDefault();  
            var formData = $(this).serialize(); 
            $.ajax({
                type: 'POST',
                url: 'edit.php',
                data: formData,
                success: function(response) {
                    alert('Enseignant modifié avec succès!');
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Erreur AJAX : " + error);
                    alert('Une erreur est survenue : ' + xhr.responseText); 
                }
            });
        });
    });
</script>
<script>
// Define the deleteEnseignant function
function deleteEnseignant(codeEnseignant) {
    // Set the value of the hidden input field in the delete modal
    document.getElementById('deleteCode').value = codeEnseignant;
    
    // Open the delete modal
    $('#deleteModal').modal('show');
}

$(document).ready(function() {
    // Handle the delete form submission
    $('#deleteForm').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        
        var formData = $(this).serialize(); // Serialize the form data
        
        $.ajax({
            type: 'POST',
            url: 'Suprime_Ens/delete.php',  // Ensure this points to the correct PHP file that handles deletion
            data: formData,
            success: function(response) {
                alert('Enseignant supprimé avec succès!');
                $('#deleteModal').modal('hide');
                location.reload();  // Reload the page to reflect the changes
            },
            error: function(xhr, status, error) {
                console.error("Erreur AJAX : " + error);
                alert('Une erreur est survenue : ' + xhr.responseText); 
            }
        });
    });
});

</script>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Modifier Enseignant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" method="POST">
          <input type="hidden" id="code" name="code"> <!-- Champ caché pour le code de l'enseignant -->
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
          </div>
          <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
          </div>
          <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" required>
          </div>
          <div class="mb-3">
            <label for="tel" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="tel" name="tel" required>
          </div>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Suprimer Enseignant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Vous êtes sûr de vouloir supprimer cet enseignant ?</h3>
                    <form id="deleteForm">
                        <input type="hidden" name="code" id="deleteCode">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>





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

