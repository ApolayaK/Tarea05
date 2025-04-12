<?php

require_once __DIR__ . '/../config/Database.php';

class Curso {

  private $conexion;

  public function __construct() {
    $this->conexion = Database::getConexion();
  }

  public function getAll(): array {
    $sql = "SELECT * FROM vista_cursos_todos";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function add($params = []): int {
    $sql = "CALL spu_cursos_registrar(?, ?, ?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
      $params["idcategoria"],
      $params["titulo"],
      $params["duracionhoras"],
      $params["nivel"],
      $params["precio"],
      $params["fechainicio"]
    ]);

    return $stmt->rowCount();
  }

  public function getById($id): array {
    $sql = "SELECT * FROM cursos WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function filtrarPorNivel($nivel): array {
    $sql = "CALL spu_cursos_filtrar_nivel(?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$nivel]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function update($params = []): int {
    $sql = "UPDATE cursos SET 
              idcategoria = ?, 
              titulo = ?, 
              duracionhoras = ?, 
              nivel = ?, 
              precio = ?, 
              fechainicio = ?
            WHERE id = ?";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([
      $params["idcategoria"],
      $params["titulo"],
      $params["duracionhoras"],
      $params["nivel"],
      $params["precio"],
      $params["fechainicio"],
      $params["id"]
    ]);

    return $stmt->rowCount();
  }

  public function delete($params = []): int {
    $sql = "DELETE FROM cursos WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([$params["id"]]);
    return $stmt->rowCount();
  }

}
