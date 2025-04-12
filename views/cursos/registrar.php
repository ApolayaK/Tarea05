<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AcademiaApp</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

  <div class="container">

    <form action="#" autocomplete="off" id="formulario-curso">
      <div class="card mt-3">
        <div class="card-header bg-success text-light">Registro de cursos</div>
        <div class="card-body">

          <div class="form-floating mb-2">
            <select name="categoria" id="categoria" class="form-select" required>
              <option value="">Seleccione</option>
              <option value="1">Matemáticas</option>
              <option value="2">Comunicación</option>
              <option value="3">Literatura</option>
            </select>
            <label for="categoria">Categoría</label>
          </div>

          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="titulo" placeholder="Título del curso" required>
            <label for="titulo">Título</label>
          </div>

          <div class="row g-2">
            <div class="col">
              <div class="form-floating mb-2">
                <input type="number" class="form-control text-end" id="duracion" min="1" placeholder="Duración en horas" required>
                <label for="duracion">Duración (horas)</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <select name="nivel" id="nivel" class="form-select" required>
                  <option value="Básico">Básico</option>
                  <option value="Intermedio">Intermedio</option>
                  <option value="Avanzado">Avanzado</option>
                </select>
                <label for="nivel">Nivel</label>
              </div>
            </div>
          </div>

          <div class="row g-2">
            <div class="col">
              <div class="form-floating mb-2">
                <input type="text" class="form-control text-end" id="precio" placeholder="Precio" required>
                <label for="precio">Precio (S/.)</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="date" class="form-control" id="fechainicio" required>
                <label for="fechainicio">Fecha de inicio</label>
              </div>
            </div>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm btn-success" type="submit">Guardar</button>
          <button class="btn btn-sm btn-secondary" type="reset">Cancelar</button>
        </div>
      </div>
    </form>

  </div>

  <script>
    const formCurso = document.querySelector("#formulario-curso");

    function registrarCurso() {
      fetch("../../app/controllers/CursoController.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          idcategoria   : document.querySelector("#categoria").value,
          titulo        : document.querySelector("#titulo").value,
          duracionhoras : parseInt(document.querySelector("#duracion").value),
          nivel         : document.querySelector("#nivel").value,
          precio        : parseFloat(document.querySelector("#precio").value),
          fechainicio   : document.querySelector("#fechainicio").value
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.filas > 0) {
          formCurso.reset();
          alert("Curso registrado correctamente.");
        }
      })
      .catch(error => console.error("Error:", error));
    }

    formCurso.addEventListener("submit", function(event) {
      event.preventDefault();
      if (confirm("¿Deseas registrar este curso?")) {
        registrarCurso();
      }
    });
  </script>

</body>
</html>
