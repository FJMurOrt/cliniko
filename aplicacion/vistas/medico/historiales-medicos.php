<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-pacientes-historiales-medicos">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/mis-pacientes.png" style="width: 340px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="busqueda-paciente-historial" class="etiqueta-filtro">Paciente</label>
                            <input type="text" id="busqueda-paciente-historial" placeholder="Buscar paciente..." class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-historial-pacientes" class="etiqueta-filtro">Historial</label>
                            <select id="filtro-historial-pacientes" class="form-control">
                                <option value="">Ver todos</option>
                                <option value="disponible">Disponible</option>
                                <option value="no-disponible">No disponible</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-orden-pacientes" class="etiqueta-filtro">Ordenar por nombre</label>
                            <select id="filtro-orden-pacientes" class="form-control">
                                <option value="" selected disabled>Ordenar por</option>
                                <option value="asc">De la A a la Z</option>
                                <option value="desc">De la Z a la A</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-edad-pacientes" class="etiqueta-filtro">Edad</label>
                            <select id="filtro-edad-pacientes" class="form-control">
                                <option value="">Ver todos</option>
                                <option value="joven">De 18 a 30 años</option>
                                <option value="adulto">De 31 a 60 años</option>
                                <option value="mayor">Mayores de 60 años</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-historial" class="text-center mt-2"></div>
                    <div id="info_del_paciente-pacientes" class="row">
                    </div>
                    <div id="paginacion-pacientes" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-medico/includes/footer.php";?>
</div>