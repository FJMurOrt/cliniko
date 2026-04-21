<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-pacientes-recetas">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/recetas.png" style="width: 220px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-fecha-recetas-medico" class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha-recetas-medico" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="busqueda-paciente" class="etiqueta-filtro">Paciente</label>
                            <input type="text" id="busqueda-paciente" placeholder="Por nombre o apellido..." class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-receta-medico" class="etiqueta-filtro">Receta</label>
                            <select id="filtro-receta-medico" class="form-control">
                                <option value="">Todas</option>
                                <option value="disponible">Con receta</option>
                                <option value="no-disponible">Sin receta</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label for="filtro-receta-obervaciones" class="etiqueta-filtro">Por observaciones</label>
                            <select id="filtro-receta-obervaciones" class="form-control">
                                <option value="">Todas</option>
                                <option value="disponible">Con observaciones</option>
                                <option value="no-disponible">Sin observaciones</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-receta" class="text-center mt-2"></div>
                    <div id="mensaje-nota" class="text-center mt-2"></div>
                    <div id="contenedor-citas" class="row">
                    </div>
                    <div id="paginacion" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalNota" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" style='color: #D1FAE5;'>Añadir observaciones</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style='color: #D47B5E;'>X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="textarea-nota" class="form-control" rows="4" placeholder="Escribe aquí tus obervaciones para la cita..." maxlength="200"></textarea>
                     <span id="contador-nota" style='color: #D1FAE5'>0/200</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-subir-receta btn-form" onclick="guardarNota()">Guardar</button>
                    <button type="button" class="btn boton-observaciones-eliminar btn-form" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>