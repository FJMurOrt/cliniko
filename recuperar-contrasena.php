<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //EL REQUIRE_ONCE ES PARA QUE CUANDO CARGUE EL INDEX NO CARGUE SIN LA CABECERA.?>

<div class="contenedor_principal">
<section class="seccion-login py-5">
    <div class="contenedor">
        <?php
        //PARA MOSTRAR LOS ERRORES DEL CONTROLADOR DE RECUPERAR LA CONTRASEÑA
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
        <form id="form-recuperar" action="aplicacion/controladores/recuperar-controlador.php" method="POST" class="mt-4 area-recuperar-contrasena">
            <h2 class="titulo-principal text-center" style="color: #003366;">Recuperar Contraseña</h2>
            <hr>
                <div class="mb-3">
                    <label for="correo" class="form-label" style='color: #1C3943;'>Introduce tu correo:</label>
                    <input type="correo" class="form-control" id="correo" name="correo" placeholder="Introduce tu correo electrónico">
                    <span id="error-correo" style="color: red;"></span>
                </div>
                <button type="submit" class="btn boton-cuadrado mt-3 d-block mx-auto">Solicitar cambio de contraseña</button>
                <hr>
        </form>
    </div>
</section>
</div>

<!--JS PARA VALIDAR EL CAMPO DEL FORMULARIO-->
<script src="js/validar-formulario-recuperar-contrasena.js"></script>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?> 