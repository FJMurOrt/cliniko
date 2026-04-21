<?php require_once "../../../panel-paciente/includes/header.php"; ?>
<?php require_once "../../../panel-paciente/includes/sidebar.php"; ?>
<?php require_once "../../controladores/info-medico-panel-pacie.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <input type="hidden" id="id-medico" value="<?php echo $id_medico?>">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-3">
                            <?php
                            if(!empty($medico["foto_perfil"])){
                                echo "<img src='../../../uploads/perfiles/" . $medico["foto_perfil"] . "' 
                                    class='img-fluid rounded-circle imagen-perfil-info'
                                    style='width:150px; height:150px; object-fit:cover;'>";
                                }
                            ?>
                        </div>
                        <div class="col-md-9">
                            <h3 class="mb-4">
                                <?php echo $medico["nombre"]." ".$medico["apellidos"];?>
                            </h3>
                            <p>
                                <b>Especialidad</b>
                                <?php 
                                if(isset($medico["especialidad"]) && $medico["especialidad"] != ""){
                                    echo $medico["especialidad"];
                                }else{
                                    echo "Aún por definir.";
                                }
                                ?>
                            </p>
                            <p>
                                <?php
                                if($total_valoraciones > 0){
                                    $media = $media_valoracion;
                                    for($i = 1; $i <= 5; $i++){
                                        if($media >= $i){
                                            echo "<i class='fas fa-star' style='color: #f4c542;'></i>";
                                        }elseif($media >= $i - 0.5){
                                            echo "<i class='fas fa-star-half-alt' style='color: #f4c542;'></i>";
                                        }else{
                                            echo "<i class='far fa-star' style='color: #f4c542;'></i>";
                                        }
                                    }
                                    echo " ".$total_valoraciones." comentario(s)";
                                }else{
                                    echo "Este médico aún no ha sido valorado.";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div style="text-align: center;">
                        <img class="mb-4" src="../../../img/dispo-med.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <div class="text-center mb-3">
                        <label class="etiqueta-filtro mr-2">Fecha</label>
                        <input type="date" id="filtro-fecha" class="form-control d-inline-block" style="width:30%;">
                        <button class="btn boton-pagina mt-2 mb-1" onclick="mostrarDisponibilidad()">Ver</button>
                        <button class="btn boton-pagina mt-2 mb-1" onclick="verTodasDisponibilidades()">Todos</button>
                    </div>
                    <hr>
                    <div id="tabla-disponibilidad">
                    </div>
                    <div id="paginacion-disponibilidad" class="text-center mt-3 mb-3">
                    </div>
                    <div class="text-center">
                        <a href="ver-medicos.php" class="btn boton-cuadrado btn-form" style="width: 100%;">Volver</a>
                    </div>
                </div>
            </div>
        </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>