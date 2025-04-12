<?php

if (isset($_SERVER['REQUEST_METHOD'])) {

  require_once __DIR__ . '/../models/Curso.php';
  require_once __DIR__ . '/../models/Categoria.php';

  $curso = new Curso();
  $categoria = new Categoria();

  switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
      header('Content-Type: application/json; charset=utf-8');

      if ($_GET['task'] == 'getAll') {
        echo json_encode($curso->getAll());
      } 
      else if ($_GET['task'] == 'getById') {
        echo json_encode($curso->getById($_GET['id']));
      } 
      else if ($_GET['task'] == 'filtrarPorNivel') {
        echo json_encode($curso->filtrarPorNivel($_GET['nivel']));
      } 
      else if ($_GET['task'] == 'getCategorias') {
        echo json_encode($categoria->getAll());
      }
      break;

    case 'POST':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $registro = [
        'idcategoria'    => $dataJSON['idcategoria'],
        'titulo'         => $dataJSON['titulo'],
        'duracionhoras'  => $dataJSON['duracionhoras'],
        'nivel'          => $dataJSON['nivel'],
        'precio'         => $dataJSON['precio'],
        'fechainicio'    => $dataJSON['fechainicio']
      ];

      $filasAfectadas = $curso->add($registro);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case 'PUT':
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      $datos = [
        'id'             => $dataJSON['id'],
        'idcategoria'    => $dataJSON['idcategoria'],
        'titulo'         => $dataJSON['titulo'],
        'duracionhoras'  => $dataJSON['duracionhoras'],
        'nivel'          => $dataJSON['nivel'],
        'precio'         => $dataJSON['precio'],
        'fechainicio'    => $dataJSON['fechainicio']
      ];

      $filasAfectadas = $curso->update($datos);

      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case 'DELETE':
      header('Content-Type: application/json; charset=utf-8');

      $url = $_SERVER['REQUEST_URI'];
      $arrayURL = explode('/', $url);
      $id = end($arrayURL);

      $filasAfectadas = $curso->delete(['id' => $id]);
      echo json_encode(["filas" => $filasAfectadas]);
      break;
  }
}
