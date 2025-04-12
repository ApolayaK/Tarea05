<?php

$url = "/app/controllers/CursosController.php/5";
$arrayURL = explode("/", $url);
$id = array_pop($arrayURL);
echo "El ID extraído es: " . $id;


?>