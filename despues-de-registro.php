<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //DE NUEVO LLAMO A LA CABECERA PARA QUE CARGUE EN ESTA PÁGINA TAMBIÉN.?>

<!-- DE NUEVO, METO LA SECCIÓN PARA QUE EL USUARIO QUIERA REGISTRARSE -->
<section class="seccion-despues-de-registro text-center py-5">
    <div class="contenedor esperar-registro">
        <div style="text-align: center;">
            <img src="img/gracias-registro.png" style="width: 340px; max-width: 100%; height: auto;">
        </div>
        <div class="contenedor">
            <img class="imagen_esperar" src="img/medico_espera.png" alt="medico_y_paciente_sonriendo">
        </div>
        <p class="descripcion-accion mt-3" style="color: #333333;">
            ¡Nuestros administradores está verificando que los datos de tu cuenta sean correctos, espera y te daremos paso!
        </p>
        <a href="login.php" class="btn boton-cuadrado mt-3 brn-form" style="background-color: #FF7F50; color:white;">Inicia Sesión</a>
    </div>
</section>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //IGUALMENTE, LLAMO AL PIE DE PÁGINA PARA QUE TAMBIÉN CARGUE EN ESTA PÁGINA?>