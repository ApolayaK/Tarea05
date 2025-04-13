<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academia App - Editar Curso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            </select>
            <label for="categorias">Categoría</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="titulo" placeholder="Título del curso" required>
            <label for="titulo">Título del curso</label>
          </div>

          <div class="form-floating mb-2">
            <input type="number" step="0.01" class="form-control" id="precio" placeholder="Precio" required>
            <label for="precio">Precio</label>
          </div>

          <div class="form-floating mb-2">
            <input type="number" min="0" max="48" step="1" class="form-control" id="duracion" placeholder="Duración (horas)" required>
            <label for="duracion">Duración (horas)</label>
          </div>

          <div class="form-floating mb-3">
            <select name="nivel" id="nivel" class="form-select">
              <option value="Básico">Básico</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
            <label for="nivel">Nivel</label>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
          <button class="btn btn-sm btn-secondary" type="button" id="cancelar">Cancelar</button>
        </div>
      </div>
    </form>
    
    <!-- Botón Volver -->
    <div class="mt-3 text-center">
      <a href="listar.php" class="btn btn-secondary">Volver</a>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const URL = new URLSearchParams(window.location.search);
      const idCurso = URL.get('id');

      let categoriaSeleccionada = null;

      // Primero obtenemos los datos del curso
      fetch(`../../app/controllers/CursosController.php?task=getById&id=${idCurso}`)
        .then(res => res.json())
        .then(data => {
          categoriaSeleccionada = data.idcategoria;
          document.querySelector("#titulo").value = data.titulo;
          document.querySelector("#precio").value = data.precio;
          document.querySelector("#duracion").value = data.duracionhoras;
          document.querySelector("#nivel").value = data.nivel;

          // Luego cargamos las categorías y seleccionamos la correcta
          fetch('../../app/controllers/CursosController.php?task=getCategorias')
            .then(res => res.json())
            .then(categorias => {
              const select = document.querySelector("#categorias");
              select.innerHTML = '<option value="">Seleccione</option>'; // Limpiamos las opciones previas

              categorias.forEach(cat => {
                // Verifica que el ID de la categoría coincide con el de curso
                const selected = (cat.id == categoriaSeleccionada) ? 'selected' : '';
                select.innerHTML += `<option value="${cat.id}" ${selected}>${cat.categoria}</option>`;
              });
            })
            .catch(error => console.log('Error al cargar las categorías:', error));
        })
        .catch(error => console.log('Error al obtener los datos del curso:', error));

      // Enviar actualización
      document.querySelector("#formulario-actualizar").addEventListener("submit", (e) => {
        e.preventDefault();

        if (confirm("¿Está seguro de actualizar los datos del curso?")) {
          fetch('../../app/controllers/CursosController.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              id: idCurso,
              idcategoria: document.querySelector("#categorias").value,
              titulo: document.querySelector("#titulo").value,
              duracionhoras: parseInt(document.querySelector("#duracion").value),
              nivel: document.querySelector("#nivel").value,
              precio: parseFloat(document.querySelector("#precio").value),
              fechainicio: "2025-01-01"
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.filas > 0) {
              alert("Curso actualizado correctamente.");
              window.location.href = 'listar.php';
            } else {
              alert("No se realizaron cambios.");
            }
          })
          .catch(error => console.log('Error al actualizar el curso:', error));
        }
      });

      // Funcionalidad del botón Cancelar: limpiar los campos
      document.querySelector("#cancelar").addEventListener("click", () => {
        if (confirm("¿Está seguro de cancelar y limpiar los campos?")) {
          document.querySelector("#formulario-actualizar").reset(); // Limpia todos los campos del formulario
        }
      });
    });
  </script>

</body>
</html>
