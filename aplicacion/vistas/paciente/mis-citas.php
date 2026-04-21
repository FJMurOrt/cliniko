<?php require_once "../../../panel-paciente/includes/header.php"; ?>
<?php require_once "../../../panel-paciente/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php"; ?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/mis-citas.png" style="width: 230px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-fecha" class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha" class="form-control" min="<?php echo date('Y-m-d');?>">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-estado" class="etiqueta-filtro">Estado</label>
                            <select id="filtro-estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="realizada">Atendida</option>
                                <option value="no_atendida">No atendida</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="orden-nombre-miscitas" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="orden-nombre-miscitas" class="form-control">
                                <option value="" selected disabled>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="ordenar-turno" class="etiqueta-filtro">Turno</label>
                            <select id="ordenar-turno" class="form-control">
                                <option value="" selected disabled>Todos</option>
                                <option value="mañana">Mañana</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-citas" class="text-center mt-2"></div>
                    <div id="tabla-mis-citas"></div>
                    <div id="paginacion-citas" class="text-center mt-3"></div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>