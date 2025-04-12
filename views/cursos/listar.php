<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AcademiaApp</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body>
  
  <div class="container">
    <div class="card mt-3">
      <div class="card-header bg-dark text-white">Lista de cursos</div>
      <div class="card-body">
        <table class="table table-striped table-sm" id="tabla-cursos">
          <colgroup>
            <col style="width: 4%;">
            <col style="width: 20%;">
            <col style="width: 20%;">
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: 16%;">
            <col style="width: 10%;">
          </colgroup>
          <thead>
            <tr>
              <th>ID</th>
              <th>Categoría</th>
              <th>Título</th>
              <th>Duración</th>
              <th>Nivel</th>
              <th>Precio</th>
              <th>Fecha inicio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- Cargado dinámicamente -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const tabla = document.querySelector("#tabla-cursos tbody");

    function obtenerCursos() {
      fetch(`../../app/controllers/CursoController.php?task=getAll`, {
        method: 'GET'
      })
        .then(response => response.json())
        .then(data => {
          tabla.innerHTML = ``;
          data.forEach(curso => {
            tabla.innerHTML += `
              <tr>
                <td>${curso.id}</td>
                <td>${curso.categoria}</td>
                <td>${curso.titulo}</td>
                <td>${curso.duracionhoras} h</td>
                <td>${curso.nivel}</td>
                <td>S/ ${curso.precio}</td>
                <td>${curso.fechainicio}</td>
                <td>
                  <a href='editar.php?id=${curso.id}' class='btn btn-info btn-sm' title='Editar'><i class='fa-solid fa-pen'></i></a>
                  <a href='#' data-idcurso='${curso.id}' class='btn btn-danger btn-sm delete' title='Eliminar'><i class='fa-solid fa-trash'></i></a>
                </td>
              </tr>
            `;
          });
        })
        .catch(error => console.error(error));
    }

    document.addEventListener("DOMContentLoaded", () => {
      obtenerCursos();

      tabla.addEventListener("click", (event) => {
        const enlace = event.target.closest('a');
        if (enlace && enlace.classList.contains('delete')) {
          event.preventDefault();
          const idcurso = enlace.getAttribute('data-idcurso');

          if (confirm("¿Estás seguro de eliminar este curso?")) {
            fetch(`../../app/controllers/CursoController.php/${idcurso}`, {
              method: 'DELETE'
            })
              .then(res => res.json())
              .then(data => {
                if (data.filas > 0) {
                  enlace.closest('tr').remove();
                }
              })
              .catch(err => console.error(err));
          }
        }
      });
    });
  </script>

</body>
</html>
