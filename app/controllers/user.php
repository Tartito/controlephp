<?php

require_once 'app/Models/UserModel.php';
require_once 'app/Models/AccessControl.php';

function afficherUtilisateurs() {
    $gestionUtilisateurs = new UserModel();
    $gestionAcces = new AccessControl();

    $listeUtilisateurs = $gestionUtilisateurs->recupererTous();
    $listeDroits = $gestionAcces->recupererTous();

    $utilisateurs = [];
    foreach ($listeUtilisateurs as $element) {
        $utilisateurs[] = [
            'id' => $element->getId(),
            'nom' => $element->getNom(),
            'prenom' => $element->getPrenom(),
            'email' => $element->getEmail(),
            'avatar' => $element->getAvatar(),
            'droits' => $gestionAcces->recuperer($element->getDroits())->getLibelle()
        ];
    }

    require 'app/Views/utilisateurs.php';
}

function inscription() {
    $gestionUtilisateurs = new UserModel();
    
    if(isset($_POST['inscription'])) { 
        if (!isset($_POST['email'], $_POST['nom'], $_POST['prenom'], $_POST['password'], $_POST['avatar'])) {
            echo "Tous les champs sont requis.";
            return;
        }

        if ($_POST['password'] !== $_POST['confirmPassword']) {
            header('Location:index.php?action=inscription&erreur=mdp');
            return;
        }

        $extensionsValides = ['jpg', 'jpeg', 'png'];
        $image = $_FILES['avatar'];
        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionsValides) || $image['error'] !== 0 || $image['size'] > 1000000) {
            echo "Problème avec l'image téléchargée.";
            return;
        }

        $nomImage = uniqid('', true) . "." . $extension;
        $cheminImage = 'uploads/' . $nomImage;
        move_uploaded_file($image['tmp_name'], $cheminImage);

        $droits = $_POST['droits'] ?? 1;
        
        $nouvelUtilisateur = new Utilisateur([
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'droits' => $droits,
            'avatar' => $cheminImage,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);
        
        $id = $gestionUtilisateurs->ajouter($nouvelUtilisateur);
        
        if ($_SESSION['droits'] == 1) {
            afficherUtilisateurs();
        } else {
            $_SESSION = [
                'utilisateur' => $id,
                'nom' => $nouvelUtilisateur->getNom(),
                'prenom' => $nouvelUtilisateur->getPrenom(),
                'email' => $nouvelUtilisateur->getEmail(),
                'avatar' => $nouvelUtilisateur->getAvatar(),
                'droits' => $nouvelUtilisateur->getDroits()
            ];
            header('Location: index.php');
        }
    } else {
        require 'app/Views/enregistrerview.php';
    }
}

function connexion() {
    $gestionUtilisateurs = new UserModel();
    if(isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $mdp = $_POST['password'];
        $utilisateur = $gestionUtilisateurs->verifierConnexion($email);

        if ($utilisateur && password_verify($mdp, $utilisateur->getPassword())) {
            $_SESSION = [
                'utilisateur' => $utilisateur->getId(),
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'email' => $utilisateur->getEmail(),
                'avatar' => $utilisateur->getAvatar(),
                'droits' => $utilisateur->getDroits()
            ];
            header('Location: ' . ($_SESSION['droits'] == 1 ? 'admin.php' : 'index.php'));
        } else {
            header('Location: index.php?action=connexion&erreur=identifiants');
        }
    } else {
        require 'app/Views/connexion.php';
    }
}

function deconnexion() {
    session_destroy();
    header('Location: index.php');
}

?>
