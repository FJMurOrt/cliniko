<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //EL REQUIRE_ONCE ES PARA QUE CUANDO CARGUE EL INDEX NO CARGUE SIN LA CABECERA.?>

<div class="contenedor_principal">
<section class="seccion-login py-5">
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
        <form id="form-nueva-contrasena" action="aplicacion/controladores/nueva-contrasena-controlador.php" method="POST" class="mt-4 area-cambiar-contrasena">
            <h2 class="titulo-principal text-center" style="color: #003366;">Cambiar Contraseña</h2>
            <hr>
              <!--EL CAMPO OCULTO CON EL QUE LE PASO CODIGO DEL TOKEN AHORA AL CONTROLADOR PARA SABER A QUE USUARIO CAMBIARLE LA CONTRASEÑA-->
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <div class="mb-3">
                <label for="contra1" class="form-label" style='color: #1C3943;'>Nueva contraseña:</label>
                <input type="password" class="form-control" id="contra1" name="contrasena1" placeholder="Introduce tu nueva contraseña" required>
                <span id="error-contrasena1" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="contra2" class="form-label" style='color: #1C3943;'>Confirmar contraseña:</label>
                <input type="password" class="form-control" id="contra2" name="contrasena2" placeholder="Introduce de nuevo tu contraseña" required>
                <span id="error-contrasena2" style="color: red;"></span>
            </div>
            <button type="submit" class="btn boton-cuadrado mt-3 d-block mx-auto">Reestablecer contraseña</button>
            <hr>
        </form>
    </div>
</section>
</div>

<!--SCRIPT PARA VALIDAR LOS DOS CAMPOS PARA CAMBIAR LA CONTRASEÑA CON JS-->
<script src="js/validar-cambiar-contrasena.js"></script>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?> 