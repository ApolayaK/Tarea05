<?php
// Incluye el modelo Categoria
require_once __DIR__ . "/../../app/models/Categoria.php";
// Crear una instancia de la clase Categoria
$categoriaModel = new Categoria();

// Obtener todas las categorías
$categorias = $categoriaModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academia App</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  
  <div class="container">

    <form action="" autocomplete="off" id="formulario-registro">
      <div class="card mt-3">
        <div class="card-header bg-primary text-light">Registro de Cursos</div>
        <div class="card-body">
          
          <!-- Selección de Categorías -->
          <div class="form-floating mb-2">
            <select name="categoria" id="categoria" class="form-select" required>
              <option value="">Seleccione una categoría</option>
              <!-- Se cargan las categorías desde la base de datos -->
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['categoria'] ?></option>
              <?php endforeach; ?>
            </select>
            <label for="categoria">Categoría</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="titulo" placeholder="Título del curso" required>
            <label for="titulo">Título del curso</label>
          </div>

          <div class="form-floating mb-2">
            <input type="number" class="form-control" id="duracionhoras" placeholder="Duración en horas" required>
            <label for="duracionhoras">Duración (horas)</label>
          </div>

          <div class="form-floating mb-2">
            <select name="nivel" id="nivel" class="form-select" required>
              <option value="Básico">Básico</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
            <label for="nivel">Nivel</label>
          </div>

          <div class="form-floating mb-2">
            <input type="number" class="form-control" id="precio" placeholder="Precio" required>
            <label for="precio">Precio</label>
          </div>

          <div class="form-floating mb-2">
            <input type="date" class="form-control" id="fechainicio" placeholder="Fecha de inicio" required>
            <label for="fechainicio">Fecha de inicio</label>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm btn-primary" type="submit">Guardar</button>
          <button class="btn btn-sm btn-secondary" type="reset">Cancelar</button>
        </div>
      </div> <!-- ./card -->
    </form>

  </div> <!-- ./container -->

  <script>
    const formulario = document.querySelector("#formulario-registro");

    function registrarCurso(){
      fetch("../../app/controllers/CursosController.php", {
        method: 'POST',
        headers: {'Content-Type' : 'application/json'},
        body: JSON.stringify({
          idcategoria  : document.querySelector("#categoria").value,
          titulo       : document.querySelector("#titulo").value,
          duracionhoras: parseInt(document.querySelector("#duracionhoras").value),
          nivel        : document.querySelector("#nivel").value,
          precio       : parseFloat(document.querySelector("#precio").value),
          fechainicio  : document.querySelector("#fechainicio").value
        })
      })
        .then(response => response.json())
        .then(data => { 
          if (data.filas > 0){
            formulario.reset();
            alert("Curso registrado correctamente");
          }
         })
        .catch(error => { console.error(error) });
    }

    formulario.addEventListener("submit", function (event){
      event.preventDefault();

      if (confirm("¿Está seguro de registrar este curso?")){
        registrarCurso();
      }
    });
  </script>

</body>
</html>
