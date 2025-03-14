<?php

  require_once 'app/Models/prestation.php';

  // Fonction pour afficher toutes les prestations
  function afficherPrestations() {
    $gestionPrestation = new PrestationManager();

    $prestations = $gestionPrestation->getAll();

    $prestationsListe = [];
    foreach ($prestations as $prestation) {
      $prestationDetails = [
        'id' => $prestation->id_prestation(),
        'libelle' => $prestation->type_prestation(),
      ];
      $prestationsListe[] = $prestationDetails;
    }

    require 'app/Views/prestationview.php';
  }

  // Fonction pour créer une nouvelle prestation
  function ajouterPrestation() {
    $gestionPrestation = new PrestationManager();

    if (isset($_POST['libelle'])) {
      $data = array(
        'type_prestation' => $_POST['libelle'],
      );
      $nouvellePrestation = new Prestation();
      $nouvellePrestation->hydrate($data);
      $ajout = $gestionPrestation->add($nouvellePrestation);
    }
    afficherPrestations();
  }

  // Fonction pour modifier une prestation existante
  function modifierPrestation() {
    $gestionPrestation = new PrestationManager();

    if (isset($_POST['id'])) {
      $data = array(
        'id_prestation' => $_POST['id'],
        'type_prestation' => $_POST['libelle'],
      );
      $prestationToUpdate = new Prestation();
      $prestationToUpdate->hydrate($data);
      $modification = $gestionPrestation->update($prestationToUpdate);
    }
    afficherPrestations();
  }

  // Fonction pour supprimer une prestation
  function supprimerPrestation() {
    $gestionPrestation = new PrestationManager();

    if (isset($_POST['id'])) {
      $data = array(
        'id_prestation' => $_POST['id'],
      );
      $prestationASupprimer = new Prestation();
      $prestationASupprimer->hydrate($data);
      $suppression = $gestionPrestation->delete($prestationASupprimer);
    }
    afficherPrestations();
  }

?>
