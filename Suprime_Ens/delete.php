<?php
require_once 'Database.php';

require_once 'Enseignant.php';

if (isset($_POST['code'])) {
    $codeEnseignant = trim($_POST['code']);

    // Create an Enseignant instance and attempt to delete
    $enseignant = new Enseignant();
    $message = $enseignant->deleteEnseignant($codeEnseignant);

    echo $message;
}
?>
