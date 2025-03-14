<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
      <?php
        if (!isset($_SESSION['user'])) {
          $titre = "Accès limité";
          $message = "Vous consultez actuellement ce site en tant que visiteur. Certaines fonctionnalités ne sont accessibles qu'aux utilisateurs enregistrés.<br>
          Découvrez notre établissement et nos services en naviguant sur les pages publiques du site.";
        } elseif (isset($_SESSION['droits']) && $_SESSION['droits'] == 1) {
          $titre = "Espace administrateur";
          $message = "Bienvenue dans l'interface d'administration. Ici, vous avez la possibilité de gérer les utilisateurs, les contenus et bien plus encore.";
        } else {
          $titre = "Espace utilisateur";
          $message = "Vous êtes connecté à votre espace personnel. Accédez aux fonctionnalités qui vous sont dédiées via le menu de navigation.";
        }
      ?>
      <h1><?= htmlspecialchars($titre) ?></h1><br>
      <img src="/uploads/header.png" alt="Illustration du site" width="500" height="500">

      <h2>Bienvenue sur notre plateforme</h2>
      <p class="text-justify"><?= htmlspecialchars($message) ?></p>
    </div>
  </div>
</div>
