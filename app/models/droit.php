<?php
  class Permission {
    private $id_permission;
    private $label_permission;

    public function getIdPermission() {
      return $this->id_permission;
    }

    public function getLabelPermission() {
      return $this->label_permission;
    }

    public function setIdPermission($id) {
      $this->id_permission = $id;
    }

    public function setLabelPermission($label) {
      $this->label_permission = $label;
    }

    public function populate(array $data) {
      foreach ($data as $key => $value) {
        $method = 'set'.ucfirst($key);
        if (method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }
  }

  class PermissionManager {
    private function connectToDatabase() {
      try {
        $database = new PDO('mysql:host=localhost;dbname=bddphp;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      } catch(PDOException $e) {
        die("Error: Unable to connect to the database. " . $e->getMessage());
      }
      return $database;
    }

    public function insert(Permission $permission) {
      try {
        $query = $this->connectToDatabase()->prepare('INSERT INTO permissions(label_permission) VALUES(:label_permission)');
        $query->bindValue(':label_permission', $permission->getLabelPermission(), PDO::PARAM_STR);
        $query->execute();
      } catch(PDOException $e) {
        die("Error: Failed to add the permission. " . $e->getMessage());
      }
      return $this->connectToDatabase()->lastInsertId();
    }

    public function remove(Permission $permission) {
      try {
        $query = $this->connectToDatabase()->prepare('DELETE FROM permissions WHERE id_permission = :id_permission');
        $query->bindValue(':id_permission', $permission->getIdPermission(), PDO::PARAM_INT);
        $query->execute();
      } catch(PDOException $e) {
        die("Error: Failed to delete the permission. " . $e->getMessage());
      }
    }

    public function fetch($id) {
      $id = (int) $id;
      try {
        $query = $this->connectToDatabase()->prepare('SELECT * FROM permissions WHERE id_permission = ?');
        $query->execute(array($id));
        $data = $query->fetch(PDO::FETCH_ASSOC);
      } catch(PDOException $e) {
        die("Error: Failed to fetch data. " . $e->getMessage());
      }
      $permission = new Permission();
      $permission->populate($data);
      return $permission;
    }

    public function fetchAll() {
      $permissions = [];
      try {
        $query = $this->connectToDatabase()->query('SELECT * FROM permissions');
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
          $permission = new Permission();
          $permission->populate($data);
          $permissions[] = $permission;
        }
      } catch(PDOException $e) {
        die("Error: Failed to fetch data. " . $e->getMessage());
      }
      return $permissions;
    }

    public function modify(Permission $permission) {
      try {
        $query = $this->connectToDatabase()->prepare('UPDATE permissions SET label_permission = :label_permission WHERE id_permission = :id_permission');
        $query->bindValue(':id_permission', $permission->getIdPermission(), PDO::PARAM_INT);
        $query->bindValue(':label_permission', $permission->getLabelPermission(), PDO::PARAM_STR);
        $query->execute();
      } catch(PDOException $e) {
        die("Error: Failed to update the permission. " . $e->getMessage());
      }
    }
  }
?>
