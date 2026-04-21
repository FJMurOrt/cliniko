<?php require_once "../../../panel-paciente/includes/header.php"; ?>
<?php require_once "../../../panel-paciente/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php"; ?>
        <div class="container-fluid">
            <div class="text-center">
                <img class="mb-2" src="../../../img/mi-resumen.png" style="width: 250px; max-width: 100%; height: auto;">
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta1">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/proxima-cita.png" style="width: 250px; max-width: 100%; height: auto;">
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
                                <img class="mb-2" src="../../../img/ultimas-notificaciones.png" style="width: 350px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="notificaciones-inicio"></div>
                            <a href="notificaciones.php" class="btn boton-cuadrado btn-form mt-3">Ir a notificaciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta3">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimo-medico.png" style="width: 280px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="ultimo-medico"></div>
                            <a href="mis-valoraciones.php" class="btn boton-cuadrado btn-form">Dejar una valoración</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta4">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/medico-favorito.png" style="width: 280px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="medico-favorito"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta5">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultima-receta.png" style="width: 350px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="ultima-receta"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta6">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimo-historial.png" style="width: 350px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="ultimo-historial"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta7">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/total-citas-realizadas.png" style="width: 350px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="total-citas"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta8">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img class="mb-2" src="../../../img/ultimas-valoraciones.png" style="width: 320px; max-width: 100%; height: auto;">
                            </div>
                            <hr>
                            <div id="ultimas-valoraciones"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-paciente/includes/footer.php"; ?>
</div>