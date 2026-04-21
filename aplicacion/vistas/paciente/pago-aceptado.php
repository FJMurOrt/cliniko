<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos" style="max-width: 500px; margin: 0 auto;">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-4" src="../../../img/pago-realizado.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div style="text-align: center;">
                        <img class="mb-4 medico-contento" src="../../../img/medico-contento.png" style="width: 240px; max-width: 100%; height: auto;">
                    </div>
                    <p class="text-center">
                        Recuerda que si, llegada la hora, tu médico no confirma esta cita, recibirás un reembolso del 100% del pago realizado.
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>