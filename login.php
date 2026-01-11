<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //IGUAL QUE CON EL INDEX.PHP, PARA QUE ESTA PÁGINA NO CARGUE SIN LA CABECERA.?>

<!-- ESTO ES LA SECCIÓN DONDE HE CREADO EL FORMULARIO DE INCIO DE SESIÓN--->
<div class="contenedor_principal">
<section class="seccion-login text-center py-5" style="background-color: #F7F7F7;;">
    <div class="contenedor">
        <h2 class="titulo-principal" style="color: #f0cb93ff;">Iniciar Sesión</h2>
        <p class="descripcion-secundaria mt-3" style="color: #333333;">
            ¿Eres paciente o médico?
        </p>
<!--LOS ARCHIVOS LOGIN-CONTROLADOR.PHP Y REGISTRO.PHP LOS TENGO CREADOS EN EL LOCAL PERO VACÍOS. SOLO LOS CREÉ POR TENER LA REFERENCIA AQUÍ PUESTA PERO NO LOS HE SUBIDO PORQUE ME PARECÍA ABSURDO-->
        <form action="aplicacion/controladores/login-controlador.php" method="POST" class="mt-4" style="max-width: 400px; margin: 0 auto;">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Introduce tu contraseña" required>
            </div>
            <button type="submit" class="btn boton-cuadrado mt-3" style="background-color: #FF7F50; color:white;">Iniciar Sesión</button>
        </form>

        <p class="mt-3">
            Si no tienes cuenta, entra a este enlace <a href="registro.php" style="color: #FF7F50;">Regístrate aquí</a>
        </p>
    </div>
</section>
</div>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?>