<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //REQUIRE_ONCE PARA CUANDO CARGUE EL INDEX NO CARGUE SIN LA CABECERA.?>
<!-- SECCIÓN DONDE MUESTRO EL TÍTULO Y ALGO DE INFORMACIÓN ACERCA DE LA WEB-->
<section class="py-5 contenedor_principal" style="background-color: #dee8ed;">
    <div class="contenedor">
        <!--METO LA IMAGEND E LA SECCIÓN A LA DERECHA CON FLOAT, DE ESTA MANERA LA IMAGEN SE MUESTRA A LA DERECHA DEL DIV QUE LO CONTIENE-->
        <img class="medico_index" src="img/medica_principal.png" alt="medico_ayudando_a_paciente" style="float: right; width: 30%; margin-left: 40px;">

        <h4 class="titulo-tarjeta text-center">¡Bienvenido a Clíniko!</h4>
        <hr>
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
<!-- SECCIÓN BREVE DE ¿QUÉ ES CLINIKO? DE LA PAGINA DE INICIO-->
<section class="py-5 contenedor_principal">
    <div class="contenedor">
        <img class="medico_index" src="img/pensando.png" alt="medico_pensando" style="float: left; width: 40%; margin-right: 30px;">
        <h4 class="titulo-tarjeta text-center">¿Por qué nosotros?</h4>
        <hr>
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
<!-- SECCIÓN PARA ATRAER AL USUARIO PARA QUE SE REGISTRES-->
<section class="text-center py-5 contenedor_principal">
    <div class="contenedor">
        <h4 class="titulo-tarjeta">¿A qué esperas?</h4>
        <hr>
        <p style="color: #333333;" >
           ¡Regístrate como paciente o médico!
        </p>
        <a href="registro.php" class="btn boton-cuadrado mt-3" style="background-color: #FF7F50; color:white;">Registrarse</a>
    </div>
</section>

<!--IMAGEN BANNER ABAJO DEL TODO-->
<img class="banner_final" src="img/banner.jpg" alt="medico_de_brazos_cruzados">

<!-- EL DIV PARA LA ALERTA PARA QUE ACEPTES LAS COOKIES-->
<div class="alerta-para-que-aceptes" id="alerta-para-que-aceptes">
    En Clíniko usamos las cookies para mejorar la experiencia de cada usuario. ¡No estás obligado a aceptarlas!
    <button class="btn boton-cuadrado" id="aceptar_cookies" style="background-color: #F4825B;">Aceptar</button>
    <button class="btn boton-cuadrado" id="rechazar_cookies" style="background-color: #F4825B;">Rechazar</button>
</div>

<!-- EL BOTÓN PARA SUBIR EN LA PÁGINA HACIA ARRIBA-->
<button id="boton-para-subir" class="btn boton-subir mb-3">Subir al principio</button>
<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //LO MISMO QUE CON LA CABECERA, PARA QUE CUANDO CARGUE LA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?> 