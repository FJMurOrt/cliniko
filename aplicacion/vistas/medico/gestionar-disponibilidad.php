<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php"; ?>
        <div class="container-fluid">
            <form id="form-disponibilidad" method="POST" action="../../controladores/guardar-disponibilidad.php" class="area-gestionar-disponibilidad-medico">
                <h4 class="titulo-tarjeta2 text-center">Gestionar Disponibilidad</h4>
                <hr>
                <?php
                if(isset($_SESSION["errores_disponibilidad"])){
                    echo "<div class='text-center mb-2'>";
                    foreach($_SESSION["errores_disponibilidad"] as $error){
                        echo "<p style='color: red;'>".$error."</p>";
                    }
                    echo "</div>";
                    echo "<hr>";
                    unset($_SESSION["errores_disponibilidad"]);
                }
                ?>
                <div class="form-group">
                    <label style="color: #01497C;">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="form-control"  min="<?php echo date('Y-m-d');?>">
                    <span id="error-fecha" style="color: red;"></span>
                </div>
                <div class="form-group">
                    <label style="color: #01497C;">Turno</label>
                    <select name="turno" id="turno" class="form-control">
                        <option value="" selected disabled>Selecciona turno</option>
                        <option value="mañana">Mañana</option>
                        <option value="tarde">Tarde</option>
                    </select>
                    <span id="error-turno" style="color: red;"></span>
                </div>
                <div class="form-group">
                    <label style="color: #01497C;">Hora de inicio:</label>
                    <select name="hora_inicio" id="hora_inicio" class="form-control">
                        <option value="" selected disabled>Necesitas seleccionar un turno para ver las horas</option>
                    </select>
                    <span id="error-inicio" style="color: red;"></span>
                </div>
                <div class="form-group">
                    <label style="color: #01497C;">Hora de fin:</label>
                    <select name="hora_fin" id="hora_fin" class="form-control">
                        <option value="" selected disabled>Necesitas seleccionar un turno para ver las horas</option>
                    </select>
                    <span id="error-fin" style="color: red;"></span>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn boton-cuadrado btn-form">Guardar disponibilidad</button>
                </div>
                <p class="mt-4 text-center mensaje-gestion-dispo">¡Agrega desde aquí el día y el rango de horas que estarás disponible!</p>
                    <?php
                    if(isset($_SESSION["mensaje_disponibilidad"])){
                        echo "<div class='text-center' style='color:green;'>".$_SESSION['mensaje_disponibilidad']."</div>";
                        unset($_SESSION["mensaje_disponibilidad"]);
                    }
                    ?>
            </form>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php"; ?>
</div>
