<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Médicos Disponibles</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-busqueda-medico" class="etiqueta-filtro">Médico</label>
                            <input type="text" id="filtro-busqueda-medico" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-especialidad-citas" class="etiqueta-filtro">Especialidad</label>
                            <select id="filtro-especialidad-citas" class="form-control">
                                <option value="">Todas</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="orden-nombre-medico" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="orden-nombre-medico" class="form-control">
                                <option value="" selected disabled>Ordenar</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="tabla-medicos-citas">
                    </div>
                    <div id="paginacion-citas" class="text-center mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>