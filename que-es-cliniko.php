<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //DE NUEVO LLAMO A LA CABECERA PARA QUE CARGUE EN ESTA PÁGINA TAMBIÉN.?>

<!-- SECCIÓN DONDE SE EXPLICA BREVEMENTE QUÉ ES CLÍNIKO-->
<section class="seccion-que-es py-5">
    <div class="contenedor">
        <h1 class="titulo-principal text-center" style="color: #003366;">¿Qué es Clíniko?</h1>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            Nuestra plataforma fue diseñada con el objeto de facilitar el encuentro entre personas que buscan asistencia médica y personas que puedan ofrecer dicha asistencia,
            todo esto, bajo un entorno sencillo, intuitivo y seguro donde los usarios puedan organizar sus agendas sin necesidad de ningún tipo de proceso complejo o lento.
        </p>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            ¿Que podrás hacer? Podrás registrarte como paciente o médico. Como paciente, gestionarás tu propio perfil, consultar y gestionar tus citas médicas y acceder a historiales médicos que los médicos que adjunten
            de una manera muy cómoda y rápida. Además, podrás visualizar información acerca de la disponibilidad del médico que busques y su especialidad, reduciendo así tu tiempo de espera.
        </p>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            Si por otro lado, te registras como profesional sanitario, como médico, podrás administrar tu propio horario para que las personas que te necesiten puedan ver tu disponibilidad y demandar tu servicio.
            También podrás consultar información de tus pacientes con los que has tenido previamente citas y dejarles su historial medico adjuntado si así fuera.
        </p>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            Además, toda asistencia médica que haya sido ofrecida o demandada podrá ser valorada por parte del paciente. De esta manera, habilitamos también un feedback para que médicos saber en todo momento que piensan
            sus pacientes sobre ellos y si necesitan mejorar o no la atención que estan dando en nuestra plataforma.
        </p>
        <img class="imagen_abrazados" src="img/abrazados.png" alt="medico_y_paciente_sonriendo" style="width: 40%; display: block; margin: 0 auto;">
    </div>
</section>

<hr></hr>

<!-- DE NUEVO, METO LA SECCIÓN PARA QUE EL USUARIO QUIERA REGISTRARSE -->
<section class="seccion-para-llamar-al-registro text-center py-5">
    <div class="contenedor">
        <h2 class="titulo-accion" style="color: #003366;">¡Únete ahora!</h2>
        <p class="descripcion-accion mt-3" style="color: #333333;">
            ¡Si necesitas atención o la puedas dar, puedes registrarte ya!
        </p>
        <a href="registro.php" class="btn boton-cuadrado mt-3" style="background-color: #FF7F50; color:white;">Registrarse</a>
    </div>
</section>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //IGUALMENTE, LLAMO AL PIE DE PÁGINA PARA QUE TAMBIÉN CARGUE EN ESTA PÁGINA?>