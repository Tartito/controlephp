<?php
  class Service {
    private $serviceId;
    private $serviceType;

    public function getServiceId() { return $this->serviceId; }
    public function getServiceType() { return $this->serviceType; }

    public function setServiceId($id) {
      $this->serviceId = $id;
    }

    public function setServiceType($type) {
      $this->serviceType = $type;
    }

    public function populateFromArray(array $data) {
      foreach ($data as $key => $value) {
        $method = 'set' . ucfirst($key);
        if(method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }
  }

  class ServiceManager {
    private function connectToDatabase() {
      try{
        $db = new PDO('mysql:host=localhost;dbname=bddphp;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      } catch(PDOException $e){ 
        die("Error: Unable to connect to the database. " . $e->getMessage());
      }
      return $db;
    }

    public function addService(Service $service) {
      try{
        $query = $this->connectToDatabase()->prepare('INSERT INTO services(service_type) VALUES(:service_type)');
        $query->bindValue(':service_type', $service->getServiceType(), PDO::PARAM_STR);
        $query->execute();
      } catch(PDOException $e){
        die("Error: The addition failed. " . $e->getMessage());
      }
      return $this->connectToDatabase()->lastInsertId();
    }

    public function removeService(Service $service) {
      try{
        $this->connectToDatabase()->exec('DELETE FROM services WHERE service_id = '.$service->getServiceId());
      } catch(PDOException $e){ 
        die("Error: Deletion failed. " . $e->getMessage());
      }
    }

    public function getServiceById($id) {
      $id = (int) $id;
      try{
        $query = $this->connectToDatabase()->prepare('SELECT * FROM services WHERE service_id = ?');
        $query->execute(array($id));
        $data = $query->fetch(PDO::FETCH_ASSOC);
      } catch(PDOException $e){ 
        die("Error: Data retrieval failed. " . $e->getMessage());
      }
      $service = new Service();
      $service->populateFromArray($data);
      return $service;
    }

    public function getAllServices() {
      $services = [];
      try{
        $query = $this->connectToDatabase()->query('SELECT * FROM services');

        while($data = $query->fetch(PDO::FETCH_ASSOC)) {
          $service = new Service();
          $service->populateFromArray($data);
          $services[] = $service;
        }
      } catch(PDOException $e){ 
        die("Error: Data retrieval failed. " . $e->getMessage());
      }
      return $services;
    }

    public function updateService(Service $service) {
      try{
        $query = $this->connectToDatabase()->prepare('UPDATE services SET service_type = :service_type WHERE service_id = :service_id');

        $query->bindValue(':service_id', $service->getServiceId(), PDO::PARAM_INT);
        $query->bindValue(':service_type', $service->getServiceType(), PDO::PARAM_STR);

        $query->execute();
      } catch(PDOException $e){ 
        die("Error: Update failed. " . $e->getMessage());
      }
    }
  }
?>
