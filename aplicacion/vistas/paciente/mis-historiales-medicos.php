<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-pacientes-historiales-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Mis Historiales Médicos</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-especialidades-historiales" class="etiqueta-filtro">Especialidad</label>
                            <select id="filtro-especialidades-historiales" class="form-control">
                                <option value="">Todas</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-historial-medico" class="etiqueta-filtro">Historial</label>
                            <select id="filtro-historial-medico" class="form-control">
                                <option value="">Todos</option>
                                <option value="disponible">Disponible</option>
                                <option value="no-disponible">No disponible</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="buscador-medicos" class="etiqueta-filtro">Médico</label>
                            <input type="text" id="buscador-medicos" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-orden-historiales" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="filtro-orden-historiales" class="form-control">
                                <option value="" disabled selected>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="info_del_medico" class="row">
                    </div>
                    <div id="paginacion-medicos" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>