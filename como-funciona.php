<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //SE CARGA LA CABECERA?>

<!-- SECCIÓN DONDE SE EXPLICA LA POLÍTICA DE PRIVACIDAD-->
<section class="seccion-que-es py-5">
    <div class="contenedor">
        <!--METO UNA IMAGEN Y LE PONGO FLOAR RIGHT PARA QUE QUEDE A LA DERECHA AL INICIO Y DE TAMAÑO DE ANCHO LO PONGO AL 30%-->
        <img class="imagen-como-se-usa" src="img/como_se_usa.png" alt="candado" style="float: right; width: 30%;">
        <h1 class="titulo-principal text-center" style="color: #003366;">Cómo funciona Clíniko</h1>
        <!--AQUÍ AHORA VOY HACIENDO PARRAFOS QUE SON CADA UNO DE LOS PUNTOS DEL CONTENIDO DE ESTA PÁGINA Y METO UNA BARRA HORIZONTAL CON HR PARA SEPARAR CADA PÁRRAFO-->
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            Clíniko es una plataforma digital diseñada para facilitar la búsqueda de atención médica al momento, ofreciendo una comunicación rápida y segura. A continuación,
            explicamos cómo funciona:
        </p>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            <h4 style="color: #003366;"><u>Cíniko para pacientes</u></h4>
            <ul style = "list-style: none;">
                <li>Registro y perfil: crea tu cuenta como paciente proporcionando tus datos personales, información de contacto y una foto de perfil. Esto te permitirá
                    acceder al panel de usuario como paciente.</li>
                <li>Buscar médicos y especialidades: una vez registrado, podrás ver la lista de médicos disponibles, filtrarlos por especialdiad y consultar su información, como
                    su nombre, apellidos o especialidad.</li>
                <li>Reservar citas médicas: Escoge un médico y selecciona un horario disponible según su agenda. Podrás ver tus citas activas y pasadas en tu panel, con opción de cancelar o modificar
                    según el horario disponible.</li>
                <li>Dejar valoraciones: Después de una cita, podrás valorar al médico y dejar un comentario sobre tu experencia, ayudando a otros pacientes a tomar decisiones.</li>
                <li>Consultar historial médico: tu panel te permite acceder a tus historiales médicos, donde los médicos con los que has hayas tenido cita podrán añadir información al respecto de tu seguimiento.</li>
            </ul>
            <br><br>
        </p>
        <hr></hr>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            <h4 style="color: #003366;"><u>Cíniko para médicos</u></h4>
            Sin embargo, si eres médico:
            <br><br>
            <ul style = "list-style: none;">
                <li>Registro y perfil profesional: los médicos crean su cuenta proporcionando datos profesionales como el número de colegiado y su especialidad.</li>
                <li>Gestión de citas: Podrán habilitar sus días y horarios dipsonibles para que los pacientes reserven citas. Desde su panel, también pueden ver todas las citas activas y pasadas y
                    añadir información al historial médico de los pacientes.</li>
                <li>Valoraciones y comentarios: podrán consultar las valoraciones que reciben de sus pacientes, ayduando a mejorar la atención y calidad del servicio.</li>
                <li>Modificar información personal: pueden actualizar su perfil según sea necesario.</li>
            </ul>
        </p>
        <hr></hr>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            <h4 style="color: #003366;"><u>Seguridad y notificaciones</u></h4>
            <br><br>
            Todos los datos están protegidos y se manejan de forma segura. Además, los usuarios reciben noticiaciones automáticas por correo electrónico sobre reservas, cancelaciones y cambios de cita.
        </p>
        <hr></hr>
        <p class="descripcion-secundaria mt-3" style="color: #333333; text-align: justify;">
            <h4 style="color: #003366;"><u>¿Por qué deberías unirte?</u></h4>
            <br><br>
            <ul style = "list-style: none;">
                <li>Ahorras tiempo en la búsqueda de atención médica.</li>
                <li>Tienes un historial médico accesible.</li>
                <li>Proporcionamos una comunicación rápida y segura.</li>
                <li>El feedback hace que el servicio se encuentre en constante mejoría</li>
            </ul>
        </p>
    </div>
</section>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //SE CARGA EL FOOTER.?> 