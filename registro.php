<?php require_once "aplicacion/vistas/plantillas/cabecera.php"; //ESTO, UNA VEZ MÁS, ES PARA QUE CARGUE LA CABECERA EN LA PÁGINA?>

<?php require_once "aplicacion/modelos/especialidades.php"; //LLAMANDO AL ARCHIVO ESPECIALDIADES, EJECUTAMOS LA CONSULTA QUE NOS DEVUELVE LOS RESULTADOS QUE ENCUENTRE Y LOS GUARDAMOS EN LA VARIABLE ESPECIALIDADES.
$especialidades = buscar_especialidades($conexion);
?>

<!--FORMULARIO PARA EL REGISTRO-->
<div class=contenedor_principal>
  <section class="seccion-registro py-5">
    <div class="contenedor">
      <?php
      //PARA MOSTRAR LOS ERRORES DE LAS VALIDACIONES DEL BACKEND.
        session_start();

        if (isset($_SESSION["errores"])) {
            echo "<div class='alert alert-danger'>";
            foreach ($_SESSION["errores"] as $error) {
                echo "<p>" . htmlspecialchars($error) . "</p>";
            }
            echo "</div>";
            unset($_SESSION["errores"]);
        }
      ?>
      <form id="form-registro" action="aplicacion/controladores/registro-controlador.php" method="post" enctype="multipart/form-data" class="formulario-registro mt-4" style="max-width: 700px; margin: auto;">
        <h2 class="titulo-principal text-center mb-4" style="color: #003366;">Registrarse</h2>
        <hr>
        <div class="row">
            <div class="col-md-6 mb-3 text-start">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($_SESSION['valores']['nombre'] ?? '') ?>">
              <span id="error-nombre" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= htmlspecialchars($_SESSION['valores']['apellidos'] ?? '') ?>">
              <span id="error-apellidos" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($_SESSION['valores']['correo'] ?? '') ?>">
              <span id="error-correo" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($_SESSION['valores']['telefono'] ?? '') ?>">
              <span id="error-telefono" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="contrasena" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena">
              <span id="error-contrasena" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="contrasena" class="form-label">Vuelve a introducir la contraseña:</label>
              <input type="password" class="form-control" id="contrasena2" name="contrasena2">
              <span id="error-contrasena2" style="color: red;"></span>
            </div>
            <div class="col-md-6 mb-3 text-start">
              <label for="rol" class="form-label">Tipo de usuario</label>
              <select class="form-select" id="rol" name="rol">
                <option value="" disabled selected>Selecciona un rol</option>
                <option value="paciente">Paciente</option>
                <option value="medico">Médico</option>
              </select>
              <span id="error-rol" style="color: red;"></span>
            </div>
          </div>
          <!--PARA SUBIR UNA FOTO DE PERFIL-->
          <div class="mb-3 text-start">
              <label for="foto_perfil" class="form-label">Foto de perfil</label>
              <input type="file" class="form-control" id="foto_perfil" name="foto" accept="image/*">
          </div>
          <span id="error-foto" style="color: red;"></span>
          <!-- CAMPOS PARA EL ROL DE PACIENTE -->
          <div id="campos_paciente" style="display:none;">
            <div class="mb-3 text-start">
              <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
              <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($_SESSION['valores']['fecha_nacimiento'] ?? '') ?>">
            </div>
            <span id="error-fecha" style="color: red;"></span>
            <div class="mb-3 text-start">
              <label for="direccion" class="form-label">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($_SESSION['valores']['direccion'] ?? '') ?>">
            </div>
            <span id="error-direccion" style="color: red;"></span>
            <div class="mb-3 text-start">
              <label for="nss" class="form-label">Número de la Seguridad Social (NSS)</label>
              <input type="text" class="form-control" id="nss" name="nss" value="<?= htmlspecialchars($_SESSION['valores']['nss'] ?? '') ?>">
              <span id="error-nss" style="color: red;"></span>
            </div>
          </div>
          <!-- CAMPOS PARA EL ROL DE MÉDICO -->
          <div id="campos_medico" style="display:none;">
            <div class="mb-3 text-start">
              <label for="numero_colegiado" class="form-label">Número de colegiado</label>
              <input type="text" class="form-control" id="numero_colegiado" name="numero_colegiado" value="<?= htmlspecialchars($_SESSION['valores']['numero_colegiado'] ?? '') ?>">
              <span id="error-colegiado" style="color: red;"></span>
            </div>
            <div class="mb-3 text-start">
              <label for="id_especialidad" class="form-label">Especialidad</label>
              <select class="form-select" id="id_especialidad" name="id_especialidad">
                <option value="" disabled selected>Selecciona una especialidad</option>
                  <?php
                  //RELLENAMOS EL SELECT HACIENDOLE LA CONSULTA A LA BASE DE DATOS.
                    while ($fila = mysqli_fetch_assoc($especialidades)) {
                      echo '<option value="' . $fila['id_especialidad'] . '">' . htmlspecialchars($fila['nombre']) . '</option>';
                    }
                  ?>
              </select>
              <span id="error-especialidad" style="color: red;"></span>
            </div>
          </div>
          <div class="form-check mb-3 text-start">
            <input class="form-check-input" type="checkbox" id="acepta_politica" name="acepta_politica">
            <label class="form-check-label" for="acepta_politica">Acepto la política de privacidad</label>
            <span id="error-privacidad" style="color: red;"></span>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn boton-cuadrado" style="background-color: #FF7F50; color:white;">Registrarse</button>
          </div>
      </form>
      <?php
      //PARA CUANDO EL FORMULARIO SE ENVIE CORRECTAMENTE, QUE NO CONSERVE LOS DATOS EN LOS CAMPOS.
      unset($_SESSION['valores']);
      ?>
    </div>
  </section>
</div>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //PARA QUE VUELVA A IMPRIMIR EL PIE DE PÁGINA EN LA PÁGINA?>

<!--CON JAVASCRIPT OCULTAMOS O MOSTRAMOS PARTE DEL FORMULARIO DEPENDIENDO QUÉ ROL SELECCIONE DE LA LISTA CON EL EVENTO ONCHANGE-->
<script src = "js/mostrar-especialidades-select.js"></script>

<!--SCRIPT PARA HACER LA VALIDACIÓN FRONTEND CON LAS EXPRESIONES REGULARES DE JS-->
<script src="js/validaciones-form-registro.js"></script>