<?php require_once "../../../panel-paciente/includes/header.php"; ?>
<?php require_once "../../../panel-paciente/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php"; ?>
        <div class="container-fluid">
            <h4 class="titulo-tarjeta text-center">Mi Resumen</h4>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta1">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">¡Tu Próxima Cita!</h4>
                            <hr>
                            <div id="proxima-cita"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta2">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Últimas Notificaciones</h4>
                            <hr>
                            <div id="notificaciones-inicio"></div>
                            <a href="notificaciones.php" class="btn boton-cuadrado btn-form mt-3">Ir a notificaciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta3">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Último Médico Visto</h4>
                            <hr>
                            <div id="ultimo-medico"></div>
                            <a href="mis-valoraciones.php" class="btn boton-cuadrado btn-form">Dejar una valoración</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta4">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Tu Médico Favorito</h4>
                            <hr>
                            <div id="medico-favorito"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta5">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Tu Última Receta</h4>
                            <hr>
                            <div id="ultima-receta"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta6">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Tú Último Historial Médico</h4>
                            <hr>
                            <div id="ultimo-historial"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta7">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Total de Citas Realizadas</h4>
                            <hr>
                            <div id="total-citas"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta8">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta2 text-center">Últimas Valoraciones Realizadas</h4>
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