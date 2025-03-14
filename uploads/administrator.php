<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/8688d368c4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Admin</title>
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand">
        Logo
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse menu" id="navbarScroll">
        <?php
          if(isset($_SESSION['user'])) {
        ?>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="index.php?action=prestation" class="nav-link">
                Prestation
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=categorie" class="nav-link">
                Catégorie
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=tarif" class="nav-link">
                Tarif
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=droits" class="nav-link">
                Droits
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=usager" class="nav-link">
                Clients
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=user" class="nav-link">
                Utilisateurs
              </a>
            </li>
          </ul>
        <?php
          }
        ?>
        <span class="clear"></span>
        <?php
          if(isset($_SESSION['user'])) {
        ?>
        <ul class="navbar-nav">
            <li class="nav-item">
              <a href="index.php?action=deco" class="nav-link">
                Déconnecter
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php
    require 'admin/controller.admin.php';
    admin();
    if(isset($_GET['action'])) {
      $action = $_GET['action'];
      switch ($action) {
        case 'prestation':
          user();
          break;
        case 'categorie':
          user();
          break;
        case 'tarif':
          user();
          break;
        case 'droits':
          user();
          break;
        case 'usager':
          user();
          break;
        case 'user':
          user();
          break;
        default:
          echo 'Unknown Action Admin';
          break;
      }
    }
  ?>
</body>
</html>