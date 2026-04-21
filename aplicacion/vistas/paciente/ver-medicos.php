<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-4" src="../../../img/ver-medicos.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-4 mb-2">
                            <label for="filtro-especialidad-ver-medicos" class="etiqueta-filtro">Especialidad</label>
                            <select id="filtro-especialidad-ver-medicos" class="form-control">
                                <option value="">Todas</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label for="orden-nombre" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="orden-nombre" class="form-control">
                                <option value="" selected disabled>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="tabla-medicos">
                    </div>
                    <div id="paginacion" class="text-center mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>