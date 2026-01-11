<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clíniko</title>

  <!-- DIRECCIÓN PARA ACCEDER A LA FUENTE DE GOOGLE DE POPPINS, MONTSERRAT Y RBOTO -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">


  <!-- EL ENLACE PARA EL FUNCIONAMIENTO DE BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- UN ENLACE A UNA HOJA DE ESTILOS CSS PROPIA PARA ESTILOS PERSONALES-->
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
  <!-- BARRA DEL MENÚ PRINCIPAL-->
<nav class="navbar navbar-expand-lg" style="background-color: #76b7ecff; border-bottom: 4px solid #f0cb93ff">
    <div class="container">
        <a class="navbar-brand text-white" href="index.php">
          <img src="img/logo2.png" alt="Logo Clíniko" style="width: 120px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link text-white" href="que-es-cliniko.php">¿Qué es Clíniko?</a></li>
              <li class="nav-item"><a class="nav-link text-white" href="servicios.php">Servicios</a></li>
              <li class="nav-item">
                <a class="btn boton-cuadrado me-2" style="background-color: #FF7F50; color:white;" href="registro.php">Registrarse</a>
              </li>
              <li class="nav-item">
                <a class="btn boton-cuadrado" style="background-color: #FF7F50; color:white;" href="login.php">Iniciar sesión</a>
              </li>
            </ul>
        </div>
    </div>
</nav>
<!--SCRIPT DE BOOTSTRAP PARA QUE FUNCIONE EL DESPLEGABLE DEL RESPONSIVE-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>