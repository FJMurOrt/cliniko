<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <?php require_once "../../controladores/listar-horarios.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-horarios">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/horarios.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <form method="GET">
                            <div class="text-center mb-3">
                                <label for="fecha" class="etiqueta-filtro">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control d-inline-block" style="width: 150px; max-width: 100%;">

                                <button type="submit" class="btn boton-cuadrado ml-2" style="max-width: 100%;">Ver</button>
                            </div>
                    </form>
                    <hr>
                    <?php
                    if(!empty($horarios)) {
                        echo "<div class='table-responsive tabla-horarios'>
                                <table class='table table-borderless'>
                                    <thead>
                                        <tr>
                                            <th>Fecha de la disponibilidad</th>
                                            <th>Turno</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>¿Qué quieres hacer?</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        
                        $hoy = date("Y-m-d");
                        foreach($horarios as $horario){
                            $fecha_horario = $horario["fecha"];
                            echo "<tr><td colspan='5'><hr></td></tr>";
                            echo "<tr style='color: #1D4635;'>
                                    <td>".date("d/m/Y", strtotime($horario["fecha"]))."</td>
                                    <td>".ucfirst($horario["turno"])."</td>
                                    <td>".date("H:i", strtotime($horario["hora_inicio"]))."</td>
                                    <td>".date("H:i", strtotime($horario["hora_fin"]))."</td>
                                    <td>";
                            if($fecha_horario >= $hoy){
                                echo "<a href='editar-horario.php?id=" . $horario['id_disponibilidad'] . "' class='btn boton-cuadrado-editar btn-form mb-3'>Editar</a>";
                            }
                            echo "<a href='../../controladores/eliminar-horario.php?id=" . $horario['id_disponibilidad'] . "' class='btn boton-cuadrado-eliminar btn-form'>Eliminar</a>";
                            echo '</td></tr>';
                        }
                        echo "      </tbody>
                                </table>
                            </div>";
                    }else{
                        echo "<div class='text-center py-4 mensaje-no-dispo'>
                                No hay disponibilidades agregadas.
                            </div>";
                    }
                    ?>
                    <?php
                    if(isset($_SESSION["errores"])){
                        echo "<div class='text-center'>";
                        foreach($_SESSION["errores"] as $error){
                            echo "<p style='color: red;'>".$error."</p>";
                        }
                        echo "</div>";
                        unset($_SESSION["errores"]);
                    }
                    ?>
                    <?php
                    if(isset($_SESSION["eliminada"])){
                        echo "<div class='text-center' style='color:green;'>".$_SESSION['eliminada']."</div>";
                        unset($_SESSION["eliminada"]);
                    }
                    ?>
                    <?php
                    if(!empty($_SESSION["actualizado"])){
                        echo "<div class='text-center' style='color: green;'>".$_SESSION['actualizado']."</div>";
                        unset($_SESSION["actualizado"]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>
