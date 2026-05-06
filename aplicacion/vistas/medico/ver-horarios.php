<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-horarios">
                <div class="card-body">
                    <h4 class="titulo-tarjeta2 text-center">Ver Horarios</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-4 mb-2">
                            <label for="filtro-fecha-ver-horarios" class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha-ver-horarios" class="form-control">
                        </div>
                        <div class="col-12 col-md-4 mb-2">
                            <label for="filtro-turno-ver-horarios" class="etiqueta-filtro">Turno</label>
                            <select id="filtro-turno-ver-horarios" class="form-control">
                                <option value="">Todos</option>
                                <option value="mañana">Mañana</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-horarios" class="text-center mb-3"></div>
                    <div id="tabla-horarios"></div>
                    <div id="paginacion-horarios" class="text-center mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>