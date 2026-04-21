<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-notificaciones">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/notificaciones-medico.png" style="width: 360px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div id="contenedor-notificaciones" class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>