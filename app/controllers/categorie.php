<?php

  require_once 'app/Models/categorie.php';

  function gererCategories() {
    $categorieManager = new CategorieManager();

    $categories = $categorieManager->getAll();

    $listeCategories = [];
    foreach ($categories as $categorie) {
      $detailsCategorie = [
        'id' => $categorie->getIdCategorie(),
        'libelle' => $categorie->getLibelleCategorie(),
      ];
      $listeCategories[] = $detailsCategorie;
    }

    require 'app/Views/categorie.php';
  }

  function ajouterCategorie() {
    $categorieManager = new CategorieManager();

    if(isset($_POST['libelle'])) {
      $donnees = array(
        'libelle_categorie' => $_POST['libelle'],
      );
      $categorie = new Categorie();
      $categorie->hydrater($donnees);
      $categorieManager->ajouter($categorie);
    }
    gererCategories();
  }

  function modifierCategorie() {
    $categorieManager = new CategorieManager();

    if(isset($_POST['id'])) {
      $donnees = array(
        'id_categorie' => $_POST['id'],
        'libelle_categorie' => $_POST['libelle'],
      );
      $categorie = new Categorie();
      $categorie->hydrater($donnees);
      $categorieManager->modifier($categorie);
    }
    gererCategories();
  }

  function supprimerCategorie() {
    $categorieManager = new CategorieManager();

    if(isset($_POST['id'])) {
      $donnees = array(
        'id_categorie' => $_POST['id'],
      );
      $categorie = new Categorie();
      $categorie->hydrater($donnees);
      $categorieManager->supprimer($categorie);
    }
    gererCategories();
  }

?>
