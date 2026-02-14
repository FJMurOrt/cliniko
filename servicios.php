<?php require_once 'aplicacion/vistas/plantillas/cabecera.php'; //IGUAL QUE CON EL INDEX.PHP, PARA QUE ESTA PÁGINA NO CARGUE SIN LA CABECERA. ?> 

<!-- SECCIÓN DEL ENLANCE DE SERVICIOS DEL MENÚ PRINCIPAL-->
 <div class="contenedor_principal">
<section class="seccion-servicios py-5">
    <div class="contenedor">
        <h1 class="titulo-principal text-center" style="color: #003366;">Nuestros servicios</h1>
        <p class="descripcion-secundaria text-center mt-3" style="color: #333333;">
            En Clíniko ofrecemos servicios para que pacientes y médicos se encuentren.
        </p>
<hr></hr>
        <div class="row mt-5">
            <!-- INFORMAICÓN ACERCA DE CITAS -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center servicio" style = "background-color: #c6dbea; border-radius: 30px;">
                    <div class="card-body">
                        <img class="imagen-servicio" src="img/imagen_cita.png" alt="cita_medica" style="max-width: 100%; height: auto;">

                        <h5 class="card-titulo mt-4" style="color: #333333;">Gestión de citas</h5>
                        <p class="card-text mt-4">
                            ¡Solicita, modifica o cancela tus citas médicas!
                        </p>
                    </div>
                </div>
            </div>
            <!-- INFORMACIÓN ACERCA DE HISTORIALES MÉDICOS-->
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center servicio" style = "background-color: #c6dbea; border-radius: 30px;">
                    <div class="card-body">
                        <!--METEMOS LA IMAGEND DE LA TARJETA CON UN ACHO QUE SE ADAPTA AL 100% DEL CONTENEDOR Y SU PROPIA ALTURA, ASI EL CONTENEDEDOR CRECE EN ALTURA CON LA ALTURA DE LA IMAGEN-->
                        <img class="imagen-servicio" src="img/historiales.png" alt="historiales_apilados" style="max-width: 100%; height: auto;">
                        <h5 class="card-titulo mt-4" style="color: #333333;">Historiales médicos</h5>
                        <p class="card-text mt-4">
                            ¡Consulta historiales médicos!
                        </p>
                    </div>
                </div>
            </div>
            <!-- INFORMACIÓN ACERCA DEL CORREO-->
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center servicio" style = "background-color: #c6dbea; border-radius: 30px;">
                    <div class="card-body">
                        <img class="imagen-servicio" src="img/notificaciones.png" alt="correo_electrónico" style="max-width: 100%; height: auto;">
                        <h5 class="card-titulo mt-4" style="color: #333333;">Notificaciones por correo</h5>
                        <p class="card-text mt-4">
                            ¡Recibe avisos importantes directamente en tu correo!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<?php require_once 'aplicacion/vistas/plantillas/pie.php'; //IGUAL QUE CON EL INDEX.PHP, PARA QUE ESTA PÁGINA NO CARGUE SIN EL PIE DE PÁGINA.?>