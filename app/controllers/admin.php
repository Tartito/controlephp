<?php
require_once 'app/Models/user.php';

function afficherAdmin() {
    $gestionUtilisateur = new UserManager();
    $listeUtilisateurs = $gestionUtilisateur->getAll();
    require 'admin/view/adminview.php';
}

function gererUtilisateur() {
    $gestionUtilisateur = new UserManager();

    $donneesUtilisateur = [
        'id'       => $_POST['id_users'],
        'pseudo'   => $_POST['pseudo'],
        'email'    => $_POST['mail'],
        'motDePasse' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];

    $utilisateur = new User();
    $utilisateur->hydrate($donneesUtilisateur);

    if ($_POST['actionUtilisateur'] === 'modifier') {
        $gestionUtilisateur->update($utilisateur);
    } elseif ($_POST['actionUtilisateur'] === 'supprimer' && $_SESSION['user'] != $_POST['id_users']) {
        $gestionUtilisateur->delete($utilisateur);
    } else {
        echo 'Action non reconnue.';
    }

    echo "<script>window.location.href = 'admin.php#collapseTwo';</script>";
}
?>
