<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //EL REQUIRE_ONCE ES PARA QUE CUANDO CARGUE EL INDEX NO CARGUE SIN LA CABECERA.?>
<section class="py-5 contenedor_principal">
    <div class="contenedor">
        <form id="form-nueva-contrasena" action="aplicacion/controladores/nueva-contrasena-controlador.php" method="POST" class="mt-4 area-cambiar-contrasena">
            <h4 class="titulo-tarjeta text-center">Cambiar Contraseña</h4>
            <hr>
            <?php
            //PARA MOSTRAR LOS ERRORES DE LAS VALIDACIONES DEL BACKEND.
                session_start();
                if(isset($_SESSION["errores"])){
                    echo "<div class='text-center'>";
                    foreach ($_SESSION["errores"] as $error){
                        echo "<p style='color: red;'>".htmlspecialchars($error)."</p>";
                    }
                    echo "</div>";
                    echo "<hr>";
                    unset($_SESSION["errores"]);
                }
            ?>
            <!--EL CAMPO OCULTO CON EL QUE LE PASO CODIGO DEL TOKEN AHORA AL CONTROLADOR PARA SABER A QUE USUARIO CAMBIARLE LA CONTRASEÑA-->
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <div class="mb-3">
                <label for="contra1" class="form-label" style='color: #1C3943;'>Nueva contraseña:</label>
                <input type="password" class="form-control" id="contra1" name="contrasena1" placeholder="Introduce tu nueva contraseña">
                <span id="error-contrasena1" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="contra2" class="form-label" style='color: #1C3943;'>Confirmar contraseña:</label>
                <input type="password" class="form-control" id="contra2" name="contrasena2" placeholder="Introduce de nuevo tu contraseña">
                <span id="error-contrasena2" style="color: red;"></span>
            </div>
            <button type="submit" class="btn boton-cuadrado mt-3 d-block mx-auto btn-form">Reestablecer contraseña</button>
        </form>
    </div>
</section>
<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?> 