<?php

  require_once 'app/Models/tarif.php';
  require_once 'app/Models/prestation.php';
  require_once 'app/Models/categorie.php';

  function tarif() {
    $tarifManager = new TarifManager();
    $prestationManager = new PrestationManager();
    $categorieManager = new CategorieManager();

    $tarif = $tarifManager->getAll();

    $tabTarif = [];
    foreach ($tarif as $value) {
      $tarifFull = [
        'id_prestation' => $value->id_prestation(),
        'id_categorie' => $value->id_categorie(),
        'prestation' => $prestationManager->get($value->id_prestation())->type_prestation(),
        'categorie' => $categorieManager->get($value->id_categorie())->libelle_categorie(),
        'prix' => $value->prix(),
      ];
      $tabTarif[] = $tarifFull;
    }

    $prestation = $prestationManager->getAll();

    $tabPresta = [];
    foreach ($prestation as $value) {
      $prestaFull = [
        'id' => $value->id_prestation(),
        'libelle' => $value->type_prestation(),
      ];
      $tabPresta[] = $prestaFull;
    }

    $categorie = $categorieManager->getAll();

    $tabCategorie = [];
    foreach ($categorie as $value) {
      $categorieFull = [
        'id' => $value->id_categorie(),
        'libelle' => $value->libelle_categorie(),
      ];
      $tabCategorie[] = $categorieFull;
    }

    require 'app/Views/tarifview.php';

  }

  function createTarif() {
    $tarifManager = new TarifManager();

    if(isset($_POST['id_prestation']) && isset($_POST['id_categorie'])) {
      $post = array(
        'id_prestation'=>$_POST['id_prestation'],
        'id_categorie'=>$_POST['id_categorie'],
        'prix'=>$_POST['prix']
      );
      $tarif = new Tarif();
      $tarif->hydrate($post);
      $tar = $tarifManager->add($tarif);
    }
    tarif();

  }

  function editTarif() {
    $tarifManager = new TarifManager();

    if(isset($_POST['id_prestation']) && isset($_POST['id_categorie'])) {
      $post = array(
        'id_prestation'=>$_POST['id_prestation'],
        'id_categorie'=>$_POST['id_categorie'],
        'prix'=>$_POST['prix']
      );
      $tarif = new Tarif();
      $tarif->hydrate($post);
      $tar = $tarifManager->update($tarif);
    }
    tarif();

  }

  function deleteTarif() {
    $tarifManager = new TarifManager();

    if(isset($_POST['id_prestation']) && isset($_POST['id_categorie'])) {
      $post = array(
        'id_prestation'=>$_POST['id_prestation'],
        'id_categorie'=>$_POST['id_categorie']
      );
      $tarif = new Tarif();
      $tarif->hydrate($post);
      $tar = $tarifManager->delete($tarif);
    }
    tarif();

  }

?>
