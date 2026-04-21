<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-pacientes-recetas">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/mis-recetas.png" style="width: 300px; max-width: 100%;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-fecha" class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha" class="form-control" min="<?php echo date('Y-m-d');?>">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-medico" class="etiqueta-filtro mr-2">Médico</label>
                            <input type="text" id="filtro-medico" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="ordenar-turno" class="etiqueta-filtro">Receta</label>
                            <select id="ordenar-turno" class="form-control">
                                <option value="" selected disabled>Disponibilidad</option>
                                <option value="disponible">Disponible</option>
                                <option value="no-disponible">No disponible</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-especialidad-recetas" class="etiqueta-filtro">Especialidad</label>
                            <select id="filtro-especialidad-recetas" class="form-control">
                                <option value="">Todas</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="contenedor-citas" class="row">
                    </div>
                    <div id="paginacion" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>