<?php require_once "../../../panel-medico/includes/header.php"; ?>
<?php require_once "../../../panel-medico/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-citas">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/citas-realizadas.png" style="width: 390px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3">
                            <label for="filtro-fecha-citas-realizadas" class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha-citas-realizadas" class="form-control">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="filtro-turno-citas-realizadas" class="etiqueta-filtro">Turno</label>
                            <select id="filtro-turno-citas-realizadas" class="form-control">
                                <option value="">Todas</option>
                                <option value="mañana">Mañana</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="filtro-paciente-realizadas" class="etiqueta-filtro">Paciente</label>
                            <input type="text" id="filtro-paciente-realizadas" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="filtro-orden-realizadas" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="filtro-orden-realizadas" class="form-control">
                                <option value="" selected disabled>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="tabla-citas-realizadas">
                    </div>
                    <div id="paginacion-citas" class="text-center mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-medico/includes/footer.php";?>
</div>