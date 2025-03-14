<?php
  class Tarif {
    private $id_prestation;
    private $id_categorie;
    private $prix;

    public function id_prestation() {return $this->id_prestation;}
    public function id_categorie() {return $this->id_categorie;}
    public function prix() {return $this->prix;}

    public function setId_prestation($id) {
      $this->id_prestation = $id;
    }
    public function setId_categorie($id) {
      $this->id_categorie = $id;
    }
    public function setPrix($prix) {
      $this->prix = $prix;
    }

    public function hydrater(array $donnees) {
      foreach ($donnees as $key => $value) {
        $methode = 'set'.ucfirst($key);
        if(method_exists($this, $methode)) {
          $this->$methode($value);
        }
      }
    }
  }

  class TarifManager {
    private function seConnecterBdd() {
      try{
        $bdd = new PDO('mysql:host=localhost;dbname=bdbphp;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      } catch(PDOException $e){ 
        die("Erreur : Impossible de se connecter à la base de données. " . $e->getMessage());
      }
      return $bdd;
    }

    public function ajouter(Tarif $tarif) {
      try{
        $req = $this->seConnecterBdd()->prepare('INSERT INTO tarif(id_prestation, id_categorie, prix) VALUES(:id_prestation, :id_categorie, :prix)');
        $req->bindValue(':id_prestation', $tarif->id_prestation(), PDO::PARAM_INT);
        $req->bindValue(':id_categorie', $tarif->id_categorie(), PDO::PARAM_INT);
        $req->bindValue(':prix', $tarif->prix(), PDO::PARAM_STR);
        $req->execute();
      } catch(PDOException $e){
        die("Erreur : L'ajout a échoué. " . $e->getMessage());
      }
      return $this->seConnecterBdd();
    }

    public function supprimer(Tarif $tarif) {
      try{
        $this->seConnecterBdd()->exec('DELETE FROM tarif WHERE id_categorie = '.$tarif->id_categorie().' AND id_prestation = '.$tarif->id_prestation());
      } catch(PDOException $e){ 
        die("Erreur : La suppression a échoué. " . $e->getMessage());
      }
    }

    public function obtenir(Tarif $tarif) {
      try{
        $req = $this->seConnecterBdd()->prepare('SELECT * FROM tarif WHERE id_categorie = :id_categorie AND id_prestation = :id_prestation');
        $req->bindValue(':id_prestation', $tarif->id_prestation(), PDO::PARAM_INT);
        $req->bindValue(':id_categorie', $tarif->id_categorie(), PDO::PARAM_INT);
        $req->execute();
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
      } catch(PDOException $e){ 
        die("Erreur : La récupération de données a échoué. " . $e->getMessage());
      }
      $tarif = new Tarif();
      $tarif->hydrater($donnees);
      return $tarif;
    }

    public function obtenirTous() {
      $tarifs = [];
      try{
        $req = $this->seConnecterBdd()->query('SELECT * FROM tarif');

        while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
          $tarif = new Tarif();
          $tarif->hydrater($donnees);
          $tarifs[] = $tarif;
        }
      } catch(PDOException $e){ 
        die("Erreur : La récupération de données a échoué. " . $e->getMessage());
      }
      return $tarifs;
    }

    public function modifier(Tarif $tarif) {
      try{
        $req = $this->seConnecterBdd()->prepare('UPDATE tarif SET prix = :prix WHERE id_categorie = :id_categorie AND id_prestation = :id_prestation');

        $req->bindValue(':id_categorie', $tarif->id_categorie(), PDO::PARAM_INT);
        $req->bindValue(':id_prestation', $tarif->id_prestation(), PDO::PARAM_INT);
        $req->bindValue(':prix', $tarif->prix(), PDO::PARAM_STR);
        $req->execute();
      } catch(PDOException $e){ 
        die("Erreur : La modification a échoué. " . $e->getMessage());
      }
    }

  }
?>
