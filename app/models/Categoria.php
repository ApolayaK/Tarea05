<?php

require_once __DIR__ . '/../config/Database.php';

class Categoria {

  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }

  public function getAll(): array {
    $sql = "SELECT * FROM categorias";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
