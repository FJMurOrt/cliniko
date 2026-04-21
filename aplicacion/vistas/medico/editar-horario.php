<?php require_once "../../../panel-medico/includes/header.php"; ?>
<?php require_once "../../../panel-medico/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <?php require_once "../../controladores/obtener-horario.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-editar">
                <div class="card-body">
                    <form action="../../controladores/actualizar-horario-medico.php" method="post">
                        <div style="text-align: center;">
                            <img class="mb-2" src="../../../img/editar.png" style="width: 340px; max-width: 100%; height: auto;">
                        </div>
                        <hr>
                        <?php
                        if(!empty($_SESSION["errores"])){
                            echo "<div class='text-center mt-3'>";
                            foreach($_SESSION["errores"] as $error){
                                echo "<p style='color: red;'>"."$error"."</p";
                            }
                            echo "</div>";
                            echo "<hr>";
                            unset($_SESSION["errores"]);
                        }
                        ?>
                        <input type="hidden" name="id_disponibilidad" value="<?php echo $horario['id_disponibilidad']?>">
                        <div class="mb-3">
                            <label>Fecha</label>
                            <input type="date" class="form-control" value="<?php echo $horario['fecha']?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label>Turno del día:</label>
                            <input type="text" class="form-control" value="<?php echo ucfirst($horario['turno'])?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label>Hora de inicio:</label>
                            <select name="hora_inicio" class="form-control" required>
                                <?php
                                foreach($horas as $hora) {
                                    echo "<option value='".$hora."'";
                                    if($hora === $horario["hora_inicio"]){
                                        echo " selected";
                                    }
                                    echo ">".$hora."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Hora de finalización:</label>
                            <select name="hora_fin" class="form-control" required>
                                <?php 
                                foreach($horas as $hora){
                                    echo "<option value='".$hora."'";
                                    if($hora === $horario["hora_fin"]){
                                        echo " selected";
                                    }
                                    echo ">".$hora."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn boton-actualizar-horario mr-3 btn-form">Actualizar</button>
                            <a href="ver-horarios.php" class="btn boton-cuadrado-eliminar btn-form">Volver</a>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php"; ?>
</div>