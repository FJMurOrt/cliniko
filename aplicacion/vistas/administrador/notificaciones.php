<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-notificaciones">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Notificaciones</h4>
                    <hr>
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn boton-cuadrado-notificaciones" onclick="marcarTodasLeidas()">Marcar todas como leídas</button>
                    </div>
                    <div id="contenedor-notificaciones" class="row"></div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>