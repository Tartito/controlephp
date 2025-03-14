<?php
session_start();
require './app/Controllers/controller.prestation.php';
require './app/Controllers/controller.user.php';
require './app/Controllers/controller.categorie.php';
require './app/Controllers/controller.tarif.php';
require './app/Controllers/controller.droits.php';
require './app/Controllers/controller.usager.php';
require './app/Controllers/controller.ticket.php';
require './app/Controllers/controller.depot.php';
require './app/Controllers/controller.achat.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><img src="/uploads/Logo.png" alt="Logo" width="35" height="25"></li>
            <li><a href="?action=home">Accueil</a></li>
            <li><a href="?action=prestation">Prestations</a></li>
            <li><a href="?action=categorie">Catégories</a></li>
            <li><a href="?action=tarif">Tarifs</a></li>
            <li><a href="?action=achat">Achat</a></li>
            <li><a href="?action=ticket">Ticket</a></li>
            <li><a href="?action=depot">Dépot</a></li>
            <li><a href="?action=usager">Usager</a></li>
            <?php if (isset($_SESSION['droits']) && $_SESSION['droits'] == 1): ?>
                <li><a href="?action=admin">Admin</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="?action=sign-out">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="?action=login">Se connecter</a></li>
                <li><a href="?action=register">S'enregistrer</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <span class="clear"></span>

    <main>
        <?php
        switch ($action) {
            case 'prestation':
                prestation();
                break;
            case 'categorie':
                categorie();
                break;
            case 'tarif':
                tarif();
                break;
            case 'droits':
                droits();
                break;
            case 'usager':
                usager();
                break;
            case 'ticket':
                ticket();
                break;
            case 'depot':
                depot();
                break;
            case 'achat':
                achat();
                break;
            case 'admin':
                if (isset($_SESSION['droits']) && $_SESSION['droits'] == 1) {
                    admin();
                } else {
                    echo "Accès refusé.";
                }
                break;
            case 'login':
                login();
                break;
            case 'register':
                register();
                break;
            case 'sign-out':
                logout();
                break;
            default:
                require './app/Views/view.home.php';
                break;
        }
        ?>
    </main>
</body>
</html>
