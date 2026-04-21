<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-contenedor-notificaciones">
                <div class="card-body">
                    <div style="text-align: center;">
                        <div style="text-align: center;">
                            <img class="mb-2" src="../../../img/notificaciones-paciente.png" style="width: 350px; max-width: 100%; height: auto;">
                        </div>
                    </div>
                    <hr>
                    <div id="contenedor-notificaciones">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>