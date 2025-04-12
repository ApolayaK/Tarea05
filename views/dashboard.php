<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Academia Virtual</title>

  <!-- Hojas de estilo -->
  <link rel="stylesheet" href="css/estilos.css" />
  <!-- Puedes agregar fuentes o frameworks como Bootstrap si lo deseas -->
</head>
<body>

  <div class="container">

    <!-- Encabezado o barra de navegación -->
    <header>
      <nav class="navbar">
        <h1>Academia Virtual</h1>
        <ul class="nav-menu">
          <li><a href="index.php">Inicio</a></li>
          <li><a href="cursos.php">Cursos</a></li>
          <li><a href="categorias.php">Categorías</a></li>
          <li><a href="contacto.php">Contacto</a></li>
        </ul>
      </nav>
    </header>

    <!-- Contenido principal dinámico -->
    <main>
      <section class="contenido">
        <?php
        // Aquí se cargará el contenido dinámico según la página
        ?>
      </section>
    </main>

    <!-- Pie de página -->
    <footer>
      <p>&copy; <?php echo date("Y"); ?> Academia Virtual. Todos los derechos reservados.</p>
    </footer>

  </div>

  <!-- Archivos JS -->
  <script src="js/app.js"></script>
</body>
</html>
