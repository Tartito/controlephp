<?php

class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $motDePasse;
    private $photo;
    private $role;

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getMotDePasse() { return $this->motDePasse; }
    public function getPhoto() { return $this->photo; }
    public function getRole() { return $this->role; }

    public function setId($val) { $this->id = $val; }
    public function setNom($val) { $this->nom = $val; }
    public function setPrenom($val) { $this->prenom = $val; }
    public function setEmail($val) { $this->email = $val; }
    public function setMotDePasse($val) { $this->motDePasse = $val; }
    public function setPhoto($val) { $this->photo = $val; }
    public function setRole($val) { $this->role = $val; }

    public function remplir(array $donnees) {
        foreach ($donnees as $cle => $valeur) {
            $methode = 'set' . ucfirst($cle);
            if (method_exists($this, $methode)) {
                $this->$methode($valeur);
            }
        }
    }
}

class GestionUtilisateur {
    private function connexionBDD() {
        return new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function ajouter(Utilisateur $utilisateur) {
        $query = $this->connexionBDD()->prepare('INSERT INTO utilisateurs (nom, prenom, email, motDePasse, photo, role) VALUES (:nom, :prenom, :email, :motDePasse, :photo, :role)');
        $query->execute([
            ':nom' => $utilisateur->getNom(),
            ':prenom' => $utilisateur->getPrenom(),
            ':email' => $utilisateur->getEmail(),
            ':motDePasse' => $utilisateur->getMotDePasse(),
            ':photo' => $utilisateur->getPhoto(),
            ':role' => $utilisateur->getRole()
        ]);
        return $this->connexionBDD()->lastInsertId();
    }

    public function supprimer(Utilisateur $utilisateur) {
        $this->connexionBDD()->prepare('DELETE FROM utilisateurs WHERE id = ?')->execute([$utilisateur->getId()]);
    }

    public function obtenir($id) {
        $query = $this->connexionBDD()->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $query->execute([$id]);
        $donnees = $query->fetch(PDO::FETCH_ASSOC);
        $utilisateur = new Utilisateur();
        $utilisateur->remplir($donnees);
        return $utilisateur;
    }

    public function obtenirTous() {
        $listeUtilisateurs = [];
        $query = $this->connexionBDD()->query('SELECT * FROM utilisateurs');
        while ($donnees = $query->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur = new Utilisateur();
            $utilisateur->remplir($donnees);
            $listeUtilisateurs[] = $utilisateur;
        }
        return $listeUtilisateurs;
    }

    public function modifier(Utilisateur $utilisateur) {
        $query = $this->connexionBDD()->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, motDePasse = :motDePasse, photo = :photo, role = :role WHERE id = :id');
        $query->execute([
            ':id' => $utilisateur->getId(),
            ':nom' => $utilisateur->getNom(),
            ':prenom' => $utilisateur->getPrenom(),
            ':email' => $utilisateur->getEmail(),
            ':motDePasse' => $utilisateur->getMotDePasse(),
            ':photo' => $utilisateur->getPhoto(),
            ':role' => $utilisateur->getRole()
        ]);
    }

    public function connexion($email) {
        $query = $this->connexionBDD()->prepare('SELECT * FROM utilisateurs WHERE email = ?');
        $query->execute([$email]);
        $donnees = $query->fetch(PDO::FETCH_ASSOC);
        if ($donnees) {
            $utilisateur = new Utilisateur();
            $utilisateur->remplir($donnees);
            return $utilisateur;
        }
        return false;
    }
}

?>
