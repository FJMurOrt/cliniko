<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //EL REQUIRE_ONCE ES PARA QUE CUANDO CARGUE EL INDEX NO CARGUE SIN LA CABECERA.?>

<!-- SECCIÓN DONDE MUESTRO EL TÍTULO Y ALGO DE INFORMACIÓN ACERCA DE LA WEB-->
<section class="bienvenida text-center py-5" style="background-color: #F7F7F7;">
    <div class="contenedor">
        <!--METO LA IMAGEND E LA SECCIÓN A LA DERECHA CON FLOAT, DE ESTA MANERA LA IMAGEN SE MUESTRA A LA DERECHA DEL DIV QUE LO CONTIENE-->
        <img src="img/medico_paciente2.png" alt="medico_ayudando_a_paciente" style="float: right; width: 40%; margin-left: 20px;">

        <h1 class="display-4" style="color: #f0cb93ff; margin-top: 50px;">Bienvenido a Clíniko</h1>
        <p class="lead" style="color: #333333; text-align: justify;">
            ¡Bienvenido a la plataforma! La web permite conectar a pacientes y médicos de manera rápida y segura.
            En Clíniko podrás gestionar tus citas médicas, consultar tus historial médico y encontrar atención médica desde cualquier lugar.
        </p>
        <p class="lead" style="color: #333333; text-align: justify;">
            Nuestro objetivo es hacer el contacto entre pacientes y medicos mucho más fácil.
        </p>
        <p class="lead" style="color: #333333; text-align: justify;">
            Con la plataforma, estamos ofreciendo un entorno digital muy intuitivo donde todo está al alcance de un clic.
        </p>
    </div>
</section>

<hr></hr> <!--LE METO UNA BARRA HORIZONTAL PARA QUE SE VEA UNA DIVISIÓN ENTRE LA SECCIÓN DEL DONDE ESTÁ EL BOTÓN DE REGISTRARSE Y LA INFORMACIÓN DE LA PÁGINA-->

<!-- SECCIÓN BREVE DE ¿QUÉ ES CLINIKO? DE LA PAGINA DE INICIO-->
<section class="seccion-que-es text-center py-5">
    <div class="contenedor">
        <img src="img/medico_pensando.png" alt="medico_pensando" style="float: left; width: 40%; margin-left: 20px;">

        <h2 class="titulo-secundario" style="color: #f0cb93ff; margin-top: 50px;">¿Por qué Clíniko es una buena opción?</h2>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            La plataforma es ideal para quienes buscan o necesitan gestionar su salud de una manera más innovadora y rápida. Con nuestro sistema,
            podrás reservar citas con médicos espcializados y acceder a un sistema de comunicación mediante notificaciones importantes, algo que es muy importante cuando se tranta con citas médicas.
        </p>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            Por otro lado, los profesionales que se encuentren registrados en Clíniko podrán organizar su agenda, acceder a sus citas pendientes y a la información de sus pacientes.
            La plataforma está pensada para ser rápida y, sobre todo, segura. Eligir nuestra plataforma es innovar y mejorar en nuestra salud.
        </p>
    </div>
</section>

<hr></hr> <!--OTRA BARRA HORIZONTAL-->

<!-- SECCIÓN PARA ATRAER AL USUARIO PARA QUE SE REGISTRES-->
<section class="seccion-llamada-accion text-center py-5">
    <div class="contenedor">
        <img src="img/imagen_unete_ahora.png" alt="persona_rellenado_registro" style="float: right; width: 40%; margin-left: 20px;">

        <h2 class="titulo-accion" style="color: #f0cb93ff; margin-top: 50px;">¡Únete ahora!</h2>
        <p class="descripcion-accion mt-3" style="color: #333333;" >
           ¡Regístrate como paciente o médico!
        </p>
        <a href="registro.php" class="btn boton-cuadrado mt-3" style="background-color: #FF7F50; color:white;">Registrarse</a>
    </div>
</section>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?> 