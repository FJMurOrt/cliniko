<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <?php
        if(!isset($_GET["id_medico"])){
            echo "Problema con el ID del médico.";
            exit;
        }
        $id_medico = intval($_GET["id_medico"]);
        $id_paciente = $_SESSION["id_paciente"];
        ?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/solicitar-cita.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <form id="formPago" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nombre</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION["nombre"]?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION["apellidos"]?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Correo electrónico</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION["correo"]?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION["telefono"]?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label>(Opcional) Motivo de la cita</label>
                                <textarea name="motivo" id="motivo" class="form-control" maxlength="200" placeholder="Describe el motivo de tu cita." required></textarea>
                                <span style="display: block; text-align: right;" id="contador-motivo">0 / 200</span>
                                <span class="col-md-12 mb-2" id="error-motivo" style="color: red;"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Fecha</label>
                                <select id="select-fecha" name="fecha" class="form-control" required>
                                    <option value="" selected disabled>Selecciona una fecha</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Turno</label>
                                <select id="select-turno" name="turno" class="form-control" required>
                                    <option value="" selected disabled>Selecciona un turno</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Hora</label>
                                <select id="select-hora" name="hora" class="form-control" required>
                                    <option value="" selected disabled>Selecciona una hora</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="id-medico" name="id_medico" value="<?php echo $id_medico?>">
                        <input type="hidden" name="id_paciente" value="<?php echo $id_paciente?>">
                        <button type="button" id="btn-pagar" class="btn boton-normal" disabled>Continuar al pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>