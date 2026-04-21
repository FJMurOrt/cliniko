<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-medicos-valoraciones">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/mis-valoraciones.png" style="width: 400px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-especialidad-valoraciones" class="etiqueta-filtro">Especialidad</label>
                            <select id="filtro-especialidad-valoraciones" class="form-control">
                                <option value="">Todas</option>
                            </select>
                        </div>
                            <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-medico-valoraciones" class="etiqueta-filtro">Médico</label>
                            <input type="text" id="filtro-medico-valoraciones" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-orden-valoraciones" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="filtro-orden-valoraciones" class="form-control">
                                <option value="" disabled selected>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-valoracion" class="etiqueta-filtro">Valoración</label>
                            <select id="filtro-valoracion-mejores" class="form-control">
                                <option value="" disabled selected>Ordenar por</option>
                                <option value="mejor">Mejor valorados</option>
                                <option value="peor">Peor valorados</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-valoracion" class="text-center mt-2">
                    </div>
                    <div id="lista-medicos-valoraciones" class="row">
                    </div>
                    <div id="lista-medicos-valoraciones" class="row">
                    </div>
                    <div id="paginacion-valoraciones" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>
