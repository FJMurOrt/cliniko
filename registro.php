<?php require_once "aplicacion/vistas/plantillas/cabecera.php"; //ESTO, UNA VEZ MÁS, ES PARA QUE CARGUE LA CABECERA EN LA PÁGINA?>

<?php require_once "aplicacion/modelos/especialidades.php"; //LLAMANDO AL ARCHIVO ESPECIALDIADES, EJECUTAMOS LA CONSULTA QUE NOS DEVUELVE LOS RESULTADOS QUE ENCUENTRE Y LOS GUARDAMOS EN LA VARIABLE ESPECIALIDADES.
$especialidades = buscar_especialidades($conexion);
?>

<!--FORMULARIO PARA EL REGISTRO-->
<div class=contenedor_principal>
<section class="seccion-registro py-5">
  <div class="contenedor">

    <h2 class="titulo-principal text-center" style="color: #f0cb93ff;">Registro de usuario</h2>

    <form id="form-registro" action="aplicacion/controladores/registro-controlador.php" method="post" enctype="multipart/form-data" class="formulario-registro mt-4" style="max-width: 700px; margin: auto;">
      <div class="row">
        <div class="col-md-6 mb-3 text-start">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
          <div id="error_nombre" class="error-text"></div>
        </div>
        <div class="col-md-6 mb-3 text-start">
          <label for="apellidos" class="form-label">Apellidos</label>
          <input type="text" class="form-control" id="apellidos" name="apellidos" required>
          <div id="error_apellidos" class="error-text"></div>
        </div>

        <div class="col-md-6 mb-3 text-start">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo" required>
          <div id="error_correo" class="error-text"></div>
        </div>
        <div class="col-md-6 mb-3 text-start">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="tel" class="form-control" id="telefono" name="telefono" required>
          <div id="error_telefono" class="error-text"></div>
        </div>

        <div class="col-md-6 mb-3 text-start">
          <label for="contrasena" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="contrasena" name="contrasena" required>
          <div id="error_contrasenia" class="error-text"></div>
        </div>
        <div class="col-md-6 mb-3 text-start">
          <label for="rol" class="form-label">Tipo de usuario</label>
          <select class="form-select" id="rol" name="rol" required>
            <option value="" disabled selected>Selecciona un rol</option>
            <option value="paciente">Paciente</option>
            <option value="medico">Médico</option>
          </select>
          <div id="error_rol" class="error-text"></div>
        </div>
      </div>

      <!--PARA SUBIR UNA FOTO DE PERFIL-->
      <div class="mb-3 text-start">
          <label for="foto_perfil" class="form-label">Foto de perfil</label>
          <input type="file" class="form-control" id="foto_perfil" name="foto" accept="image/*" required>
          <div id="error_foto" class="error-text"></div>
      </div>

      <!-- CAMPOS PARA EL ROL DE PACIENTE -->
      <div id="campos_paciente" style="display:none;">
        <div class="mb-3 text-start">
          <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
          <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
          <div id="error_fecha" class="error-text"></div>
        </div>
        <div class="mb-3 text-start">
          <label for="direccion" class="form-label">Dirección</label>
          <input type="text" class="form-control" id="direccion" name="direccion">
          <div id="error_direccion" class="error-text"></div>
        </div>
        <div class="mb-3 text-start">
          <label for="nss" class="form-label">Número de la Seguridad Social (NSS)</label>
          <input type="text" class="form-control" id="nss" name="nss">
          <div id="error_nss" class="error-text"></div>
        </div>
      </div>

      <!-- CAMPOS PARA EL ROL DE MÉDICO -->
      <div id="campos_medico" style="display:none;">
        <div class="mb-3 text-start">
          <label for="numero_colegiado" class="form-label">Número de colegiado</label>
          <input type="text" class="form-control" id="numero_colegiado" name="numero_colegiado">
          <div id="error_colegiado" class="error-text"></div>
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
          <div id="error_especialidad" class="error-text"></div>
        </div>
      </div>

      <div class="form-check mb-3 text-start">
        <input class="form-check-input" type="checkbox" id="acepta_politica" name="acepta_politica" required>
        <label class="form-check-label" for="acepta_politica">Acepto la política de privacidad</label>
        <div id="error_politica" class="error-text"></div>
      </div>

      <button type="submit" class="btn boton-cuadrado" style="background-color: #FF7F50; color:white;">Registrarse</button>
    </form>
  </div>
</section>
</div>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //PARA QUE VUELVA A IMPRIMIR EL PIE DE PÁGINA EN LA PÁGINA?>

<!--CON JAVASCRIPT OCULTAMOS O MOSTRAMOS PARTE DEL FORMULARIO DEPENDIENDO QUÉ ROL SELECCIONE DE LA LISTA CON EL EVENTO ONCHANGE-->
<script src = "js/mostrar-especialidades-select.js"></script>
<!--ESTE ES OTRO CÓDIGO JAVASCRIPT DONDE HE HECHO VALIDACIONES FRONTEND CON EXPRESIONES REGULARES CON EL OBJETO REGEXP DE JAVASCRIPT-->
<script src = "js/validaciones-registro.js"></script>
<!--CÓDIGO AJAX JAVASCRIPT PARA COMPROBAR SI EL CORREO, EL NSS O EL NUM DE COLEGIADO EXISTE-->
<script src = "js/comprobar-existe.js"></script>