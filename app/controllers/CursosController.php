<?php

//isset = is-set (¿está asignado?/¿existe?)
if (isset($_SERVER['REQUEST_METHOD'])){

  // El modelo contiene toda la lógica CRUD
  require_once "../models/Curso.php";
  $curso = new Curso();

  // ¿Qué operación desea realizar el usuario?
  // GET   : consultas, búsquedas
  // POST  : inserción
  // PUT   : actualización
  // DELETE: eliminación

  switch($_SERVER['REQUEST_METHOD']){
    
    case 'GET':
      // sleep(5);
      header('Content-Type: application/json; charset=utf-8');

      // Identificar si el usuario requiere LISTAR / BUSCAR
      if ($_GET['task'] == 'getAll'){
        // Obtener todos los cursos
        echo json_encode($curso->getAll());
      } else if ($_GET['task'] == 'getById'){
        // Obtener curso por ID
        echo json_encode($curso->getById($_GET['idcurso']));
      }
      break;

    case 'POST':
      // Obtener los datos enviados desde el cliente (JSON, TEXT, XML)
      $input = file_get_contents('php://input');
      $dataJSON = json_decode($input, true);

      // Crear un array asociativo con los datos del nuevo registro
      $registro = [
        'idcategoria'  => $dataJSON['idcategoria'],
        'titulo'       => $dataJSON['titulo'],
        'duracionhoras'=> $dataJSON['duracionhoras'],
        'nivel'        => $dataJSON['nivel'],
        'precio'       => $dataJSON['precio'],
        'fechainicio'  => $dataJSON['fechainicio'],
      ];

      // Obtener el número de registros afectados
      $filasAfectadas = $curso->add($registro);

      // Notificar al usuario el número de filas afectadas en formato JSON
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode(["filas" => $filasAfectadas]);
      break;

    case 'DELETE':
      header('Content-Type: application/json; charset=utf-8');

      // El usuario enviará el ID en la URL => localhost/academia-app/app/controllers/7
      // Paso 1: Obtener la URL desde el cliente
      $url = $_SERVER['REQUEST_URI'];
      // Paso 2: Convertir la URL en un array
      $arrayURL = explode('/', $url);
      // Paso 3: Obtener el ID
      $idcurso = end($arrayURL);

      $filasAfectadas = $curso->delete(['idcurso' => $idcurso]);
      echo json_encode(["filas" => $filasAfectadas]);
      break;
  }

}
