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

    <form action="" autocomplete="off" id="formulario-actualizar">
      <div class="card mt-3">
        <div class="card-header bg-primary text-light">Actualizar datos de curso</div>
        <div class="card-body">
          
          <div class="form-floating mb-2">
            <select name="categorias" id="categorias" class="form-select" required>
              <option value="">Seleccione</option>
              <!-- Las categorías serán cargadas dinámicamente -->
            </select>
            <label for="categorias">Categoría</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="titulo" placeholder="Título del curso" required>
            <label for="titulo">Título del curso</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="descripcion" placeholder="Descripción" required>
            <label for="descripcion">Descripción</label>
          </div>

          <!-- Compartir fila -->
          <div class="row g-2">

            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control text-end" id="precio" placeholder="Precio" required>
                <label for="precio">Precio</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="number" value="6" min="0" max="48" step="3" class="form-control text-end" id="duracion" placeholder="Duración (horas)" required>
                <label for="duracion">Duración (horas)</label>
              </div>
            </div>

          </div>
          <!-- Fin compartir fila -->

          <div class="form-floating">
            <select name="nivel" id="nivel" class="form-select">
              <option value="Básico" selected>Básico</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
            <label for="nivel">Nivel</label>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
          <button class="btn btn-sm btn-secondary" type="reset">Cancelar</button>
        </div>
      </div> <!-- ./card -->
    </form>

  </div> <!-- ./container -->

  <script>
    document.addEventListener("DOMContentLoaded", () => {

      // Obtener el ID del curso desde la URL
      const URL = new URLSearchParams(window.location.search);
      const idCurso = URL.get('id');

      // Obtener las categorías para el select (esto debería venir de tu controlador de categorías)
      fetch('../../app/controllers/CategoriasController.php?task=getAll')
        .then(response => response.json())
        .then(data => {
          const categoriasSelect = document.querySelector("#categorias");
          data.forEach(categoria => {
            categoriasSelect.innerHTML += `<option value="${categoria.id}">${categoria.nombre}</option>`;
          });
        })
        .catch(error => { console.error("Error cargando categorías:", error); });

      // Función para obtener los datos del curso
      function obtenerCurso() {
        fetch(`../../app/controllers/CursosController.php?task=getById&idcurso=${idCurso}`)
          .then(response => response.json())
          .then(data => {
            if (data) {
              // Rellenar los campos del formulario con los datos del curso
              document.querySelector("#categorias").value = data.categoria_id;
              document.querySelector("#titulo").value = data.titulo;
              document.querySelector("#descripcion").value = data.descripcion;
              document.querySelector("#precio").value = data.precio;
              document.querySelector("#duracion").value = data.duracionhoras;
              document.querySelector("#nivel").value = data.nivel;
            }
          })
          .catch(error => { console.error("Error obteniendo el curso:", error); });
      }

      // Obtener los datos del curso
      obtenerCurso();

      // Llamar a la función para actualizar el curso
      const formulario = document.querySelector("#formulario-actualizar");
      formulario.addEventListener("submit", function (event) {
        event.preventDefault();

        if (confirm("¿Está seguro de actualizar los datos del curso?")) {
          fetch(`../../app/controllers/CursosController.php`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              id: idCurso,
              categoria_id: document.querySelector("#categorias").value,
              titulo: document.querySelector("#titulo").value,
              descripcion: document.querySelector("#descripcion").value,
              precio: parseFloat(document.querySelector("#precio").value),
              duracionhoras: parseInt(document.querySelector("#duracion").value),
              nivel: document.querySelector("#nivel").value
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Curso actualizado correctamente.");
              window.location.href = 'listar.php'; // Redirigir a la lista de cursos
            }
          })
          .catch(error => console.error("Error al actualizar el curso:", error));
        }
      });

    });
  </script>

</body>
</html>
