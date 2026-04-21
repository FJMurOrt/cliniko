<?php require_once "../../../panel-medico/includes/header.php"; ?>
<?php require_once "../../../panel-medico/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php"; ?>
        <div class="container-fluid">
            <div class="text-center">
                <img class="mb-2" src="../../../img/mi-resumen-medico.png" style="width: 250px; max-width: 100%; height: auto;">
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta1">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/proxima-cita-medico.png" style="width: 250px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="proxima-cita"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta2">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimas-notificaciones-medico.png" style="width: 320px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="notificaciones-inicio"></div>
                            <a href="mis-notificaciones.php" class="btn boton-cuadrado btn-form mt-3">Ir a Valoraciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta3">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/citas-pendientes-medico.png" style="width: 250px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="citas-pendientes"></div>
                            <a href="citas-solicitadas.php" class="btn boton-cuadrado btn-form mt-3">Ir a Citas Pendientes</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta4">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/total-pacientes-medico.png" style="width: 370px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="total-pacientes"></div>
                            <a href="historiales-medicos.php" class="btn boton-cuadrado btn-form mt-3">Ir a Pacientes Atendidos</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta5">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimo-paciente-medico.png" style="width: 360px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="ultimo-paciente"></div>
                            <a href="recetas-medicas.php" class="btn boton-cuadrado btn-form mt-3">Ir a Recetas</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta8">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/atendidas-hoy.png" style="width: 290px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="citas-hoy"></div>
                            <a href="citas-activas.php" class="btn boton-cuadrado btn-form mt-3">Ver mis Citas Activas</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta6">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/valoracion-media-medico.png" style="width: 290px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="puntuacion-media"></div>
                            <a href="mis-valoraciones.php" class="btn boton-cuadrado btn-form mt-3">Ver mis Valoraciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta7">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimas-valoraciones-medico.png" style="width: 290px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="total-valoraciones"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php"; ?>
</div>