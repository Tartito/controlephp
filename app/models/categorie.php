<?php
  class Categorie {
    private $id_categorie;
    private $libelle_categorie;

    public function id_categorie() {
      return $this->id_categorie;
    }

    public function libelle_categorie() {
      return $this->libelle_categorie;
    }

    public function setId_categorie($id) {
      $this->id_categorie = $id;
    }

    public function setLibelle_categorie($libelle) {
      $this->libelle_categorie = $libelle;
    }

    public function hydrate(array $donnees) {
      foreach ($donnees as $key => $value) {
        $method = 'set'.ucfirst($key);
        if (method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }
  }

  class CategorieManager {
    private function dbConnect() {
      try {
        $bdd = new PDO('mysql:host=localhost;dbname=bddphp;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      } catch(PDOException $e) {
        die("Erreur de connexion à la base de données: " . $e->getMessage());
      }
      return $bdd;
    }

    public function add(Categorie $categorie) {
      try {
        $req = $this->dbConnect()->prepare('INSERT INTO categorie(libelle_categorie) VALUES(:libelle_categorie)');
        $req->bindValue(':libelle_categorie', $categorie->libelle_categorie(), PDO::PARAM_STR);
        $req->execute();
      } catch(PDOException $e) {
        die("Erreur lors de l'ajout de la catégorie: " . $e->getMessage());
      }
      return $this->dbConnect()->lastInsertId();
    }

    public function delete(Categorie $categorie) {
      try {
        $req = $this->dbConnect()->prepare('DELETE FROM categorie WHERE id_categorie = :id_categorie');
        $req->bindValue(':id_categorie', $categorie->id_categorie(), PDO::PARAM_INT);
        $req->execute();
      } catch(PDOException $e) {
        die("Erreur lors de la suppression de la catégorie: " . $e->getMessage());
      }
    }

    public function get($id) {
      $id = (int) $id;
      try {
        $req = $this->dbConnect()->prepare('SELECT * FROM categorie WHERE id_categorie = ?');
        $req->execute(array($id));
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
        die("Erreur lors de la récupération des données de la catégorie: " . $e->getMessage());
      }
      $categorie = new Categorie();
      $categorie->hydrate($donnees);
      return $categorie;
    }

    public function getAll() {
      $categories = [];
      try {
        $req = $this->dbConnect()->query('SELECT * FROM categorie');
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
          $categorie = new Categorie();
          $categorie->hydrate($donnees);
          $categories[] = $categorie;
        }
      } catch(PDOException $e) {
        die("Erreur lors de la récupération des catégories: " . $e->getMessage());
      }
      return $categories;
    }

    public function update(Categorie $categorie) {
      try {
        $req = $this->dbConnect()->prepare('UPDATE categorie SET libelle_categorie = :libelle_categorie WHERE id_categorie = :id_categorie');
        $req->bindValue(':id_categorie', $categorie->id_categorie(), PDO::PARAM_INT);
        $req->bindValue(':libelle_categorie', $categorie->libelle_categorie(), PDO::PARAM_STR);
        $req->execute();
      } catch(PDOException $e) {
        die("Erreur lors de la mise à jour de la catégorie: " . $e->getMessage());
      }
    }
  }
?>
