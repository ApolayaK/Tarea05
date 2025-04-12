<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TiendaApp</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>
<body>
  
  <div class="container">

    <form action="" autocomplete="off" id="formulario-actualizar">
      <div class="card mt-3">
        <div class="card-header bg-primary text-light">Actualizar datos de productos</div>
        <div class="card-body">

          <!-- Marca -->
          <div class="form-floating mb-2">
            <select name="marcas" id="marcas" class="form-select" required>
              <option value="">Seleccione</option>
              <option value="1">Gigabyte</option>
              <option value="2">Intel</option>
              <option value="3">Epson</option>
              <option value="4">Samsung</option>
            </select>
            <label for="marcas">Marcas</label>
          </div>

          <!-- Tipo -->
          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="tipo" placeholder="Tipo producto" required>
            <label for="tipo">Tipo producto</label>
          </div>

          <!-- Descripción -->
          <div class="form-floating mb-2">
            <input type="text" class="form-control" id="descripcion" placeholder="Descripción" required>
            <label for="descripcion">Descripción</label>
          </div>

          <!-- Precio y Garantía -->
          <div class="row g-2">
            <div class="col">
              <div class="form-floating mb-2">
                <input type="number" class="form-control text-end" id="precio" placeholder="Precio" required>
                <label for="precio">Precio</label>
              </div>
            </div>
            <div class="col">
              <div class="form-floating mb-2">
                <input type="number" min="0" max="48" step="3" class="form-control text-end" id="garantia" placeholder="Garantía" required>
                <label for="garantia">Garantía</label>
              </div>
            </div>
          </div>

          <!-- Estado -->
          <div class="form-floating">
            <select name="estado" id="estado" class="form-select">
              <option value="S">Nuevo</option>
              <option value="N">Semi nuevo</option>
            </select>
            <label for="estado">Estado producto</label>
          </div>

        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
          <button class="btn btn-sm btn-secondary" type="reset">Cancelar</button>
        </div>
      </div>
    </form>

  </div>

  <script>
    const formulario = document.querySelector("#formulario-actualizar");
    let idproducto = 0; // Se definirá al cargar

    function obtenerRegistro() {
      const url = new URLSearchParams(window.location.search);
      idproducto = url.get('id');

      fetch(`../../app/controllers/ProductoController.php?task=getById&idproducto=${idproducto}`)
        .then(response => response.json())
        .then(data => {
          document.querySelector("#marcas").value = data.idmarca;
          document.querySelector("#tipo").value = data.tipo;
          document.querySelector("#descripcion").value = data.descripcion;
          document.querySelector("#precio").value = data.precio;
          document.querySelector("#garantia").value = data.garantia;
          document.querySelector("#estado").value = data.esnuevo;
        })
        .catch(error => console.error(error));
    }

    function actualizarProducto() {
      fetch(`../../app/controllers/ProductoController.php`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          idproducto  : idproducto,
          idmarca     : document.querySelector("#marcas").value,
          tipo        : document.querySelector("#tipo").value,
          descripcion : document.querySelector("#descripcion").value,
          precio      : parseFloat(document.querySelector("#precio").value),
          garantia    : parseInt(document.querySelector("#garantia").value),
          esnuevo     : document.querySelector("#estado").value
        })
      })
        .then(res => res.json())
        .then(data => {
          if (data.filas > 0) {
            alert("Producto actualizado correctamente");
            window.location.href = "index.php"; // Redirige a la lista si deseas
          }
        })
        .catch(error => console.error(error));
    }

    formulario.addEventListener("submit", function (event) {
      event.preventDefault();
      if (confirm("¿Estás seguro de actualizar el producto?")) {
        actualizarProducto();
      }
    });

    document.addEventListener("DOMContentLoaded", obtenerRegistro);
  </script>

</body>
</html>
