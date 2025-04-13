<?php
// eliminar.php

require_once __DIR__ . '/../../app/models/Curso.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $curso = new Curso();
  $curso->delete(['id' => $id]);

  // Redirecciona a listar con un mensaje
  header("Location: listar.php?msg=eliminado");
  exit;
} else {
  // Si no hay ID, redirige sin hacer nada
  header("Location: listar.php");
  exit;
}
