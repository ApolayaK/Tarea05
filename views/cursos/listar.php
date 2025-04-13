<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academia App</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body>
  
  <div class="container">
    <!-- Alerta si se eliminó correctamente -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'eliminado') : ?>
      <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        Curso eliminado correctamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <div class="card mt-3">
      <div class="card-header">Lista de Cursos</div>
      <div class="card-body">
        <table class="table table-striped table-sm" id="tabla-cursos">
          <colgroup>
            <col style="width: 4%;">  <!-- ID -->
            <col style="width: 18%;"> <!-- Categoría -->
            <col style="width: 17%;"> <!-- Título -->
            <col style="width: 27%;"> <!-- Descripción -->
            <col style="width: 10%;"> <!-- Precio -->
            <col style="width: 7%;">  <!-- Duración -->
            <col style="width: 7%;">  <!-- Nivel -->
            <col style="width: 10%;"> <!-- Acciones -->
          </colgroup>
          <thead>
            <tr>
              <th>ID</th>
              <th>Categoría</th>
              <th>Título</th>
              <th>Precio</th>
              <th>Duración</th>
              <th>Nivel</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Contenido de forma dinámica -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Botón Volver -->
    <div class="mt-3 text-center">
      <a href="../../index.html" class="btn btn-secondary">Volver</a>
    </div>

  </div>

  <script>
    const tabla = document.querySelector("#tabla-cursos tbody");

    function obtenerDatos() {
      fetch("../../app/controllers/CursosController.php?task=getAll")
        .then(response => response.json())
        .then(data => { 
          tabla.innerHTML = '';

          data.forEach(element => {
            tabla.innerHTML += `
              <tr>
                <td>${element.id}</td>
                <td>${element.categoria}</td>
                <td>${element.titulo}</td>
                <td>${element.precio}</td>
                <td>${element.duracionhoras} horas</td>
                <td>${element.nivel}</td>
                <td>
                  <a href='editar.php?id=${element.id}' title='Editar' class='btn btn-info btn-sm'>
                    <i class="fa-solid fa-pen"></i>
                  </a>
                  <a href='eliminar.php?id=${element.id}' title='Eliminar' class='btn btn-danger btn-sm' onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
            `;
          });
        })
        .catch(error => { console.error(error); });
    }

    document.addEventListener("DOMContentLoaded", obtenerDatos);
  </script>

  <!-- Bootstrap JS (para alertas y botones) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
