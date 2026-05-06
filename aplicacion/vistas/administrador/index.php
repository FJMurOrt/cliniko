<?php require_once "../../../panel-admin/includes/header.php"; ?>
<?php require_once "../../../panel-admin/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php"; ?>
        <div class="container-fluid">
            <h4 class="titulo-tarjeta-inicio text-center">Mi Resumen</h4>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta1">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Total de Usuarios</h4>
                            <hr>
                            <canvas id="grafica-pacientes"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta7">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Últimas Notificaciones</h4>
                            <hr>
                            <div id="ultimas-notificaciones"></div>
                            <a href="notificaciones.php" class="btn boton-cuadrado btn-form mt-3">Ir a notificaciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta4">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Valoraciones Reportadas</h4>
                            <hr>
                            <div id="total-reportadas"></div>
                            <a href="lista-valoraciones.php" class="btn boton-cuadrado btn-form mt-3">Ir a valoraciones</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta3">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Citas por Estado</h4>
                            <hr>
                            <canvas id="grafica-citas-estado"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta6">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Documentos Subidos Hoy</h4>
                            <hr>
                            <canvas id="grafica-documentos"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="card h-100 tarjeta-inicio tarjeta7">
                        <div class="card-body text-center">
                            <h4 class="titulo-tarjeta text-center">Valoraciones por Estrellas</h4>
                            <hr>
                            <canvas id="grafica-estrellas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php"; ?>
</div>