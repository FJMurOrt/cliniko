<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>
<?php require_once "../../controladores/informacion-paciente.php";?>
<?php
$id_paciente = $_GET["id"];
$paciente = obtenerPaciente($conexion, $id_paciente);
?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php"; ?>
        <div class="container-fluid">
            <div class="card mb-4 info-paciente">
                <div class="card-body">
                    <h4 class="titulo-tarjeta2 text-center">Información del Paciente</h4>
                    <hr>
                    <?php
                    if($paciente){
                    ?>
                        <div class="text-center">
                            <img src="../../../uploads/perfiles/<?php echo $paciente["foto_perfil"];?>" class="foto-info-paciente mb-5 ">
                        </div>
                        <p class="info-paciente-contenido"><span class="dato-info-paciente">Nombre</span> <?php echo $paciente["nombre"]." " .$paciente["apellidos"];?></p>
                        <p class="info-paciente-contenido"><span class="dato-info-paciente">Email</span> <?php echo $paciente["correo"];?></p>
                        <p class="info-paciente-contenido"><span class="dato-info-paciente">Teléfono</span> <?php echo $paciente["telefono"];?></p>
                        <p class="info-paciente-contenido"><span class="dato-info-paciente">Dirección</span> <?php echo $paciente["direccion"];?></p>
                        <p class="info-paciente-contenido"><span class="dato-info-paciente">Seguridad Social</span> <?php echo $paciente["nss"];?></p>
                    <?php
                    }else{
                    ?>
                        <p>No se ha encontrado el paciente.</p>
                    <?php
                    }
                    ?>
                    <a href="citas-activas.php" class="btn boton-cuadrado btn-form mt-3">Volver</a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>