<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //IGUAL QUE CON EL INDEX.PHP, PARA QUE ESTA PÁGINA NO CARGUE SIN LA CABECERA.?>

<!--FORMULARIO DE INCIO DE SESIÓN--->
<div class="contenedor_principal">
<section class="seccion-login py-5" style="background-color: #AED0DE;;">
    <div class="contenedor" style="max-width: 400px; margin: 0 auto;">
        <form action="aplicacion/controladores/login-controlador.php" method="POST" id="form-login" class="formulario-login mt-4" style="max-width: 400px; margin: 0 auto;">
            <div style="text-align: center;">
                <img src="img/inicio-sesion.png" style="width: 340px; max-width: 100%; height: auto;">
            </div>
            <hr>
            <?php
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
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="text" class="form-control" id="correo" name="correo" placeholder="Introduce tu correo">
                <span id="error-correo" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Introduce tu contraseña">
                <span id="error-contrasena" style="color: red;"></span>          
            </div>
            <button type="submit" class="btn boton-cuadrado mt-3 btn-form" style="background-color: #FF7F50; color:white;">Iniciar Sesión</button>
            <hr>
            <div class="text-center mt-3">
                <span><a href="registro.php" style="color: #FF7F50;">Crear cuenta</a></span><span style="margin-left: 30px;"><a href="recuperar-contrasena.php" style="color: #FF7F50;">Recuperar contraseña</a></span>
            </div>
        </form>
    </div>
</section>
</div>

<!---SCRIPT PARA VALIDAR LOS CAMPOS DESDE EL FRONTEND CON JS-->
<script src="js/validacion-inicio-sesion.js"></script>
<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?>