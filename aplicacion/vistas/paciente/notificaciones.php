<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-contenedor-notificaciones">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Notificaciones</h4>
                    <hr>
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn boton-cuadrado" onclick="marcarTodasLeidas()">Marcar todas como leídas</button>
                    </div>
                    <div id="contenedor-notificaciones">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>