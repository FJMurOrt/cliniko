<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Valoraciones</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha-valoraciones" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Puntuación</label>
                            <select id="filtro-puntuacion-valoraciones" class="form-control">
                                <option value="">Todas</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Ordenar por</label>
                            <select id="filtro-orden-valoraciones" class="form-control">
                                <option value="" disabled selected>Todas</option>
                                <option value="mejor">Mejor valoradas</option>
                                <option value="peor">Peor valoradas</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Estado</label>
                            <select id="filtro-estado-valoraciones" class="form-control">
                                <option value="">Todas</option>
                                <option value="reportada">Reportadas</option>
                                <option value="no_reportada">No reportadas</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-valoraciones-admin" class="text-center mt-2"></div>
                    <div id="contenedor-valoraciones-admin" class="row"></div>
                    <div id="paginacion-valoraciones-admin" class="text-center mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editar-valoracion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">Editar Valoración</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-valoracion-editar" value="">
                    <label style="color: #2C2C3E;">Comentario</label>
                    <textarea id="textarea-editar-valoracion" class="form-control" rows="4" maxlength="200"></textarea>
                    <span style="color: #2C2C3E;" id="contador-editar-valoracion">0/200</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado" onclick="guardarEdicionValoracion()">Guardar</button>
                    <button type="button" class="btn boton-cuadrado-eliminar" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-eliminar-valoracion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">¿Eliminar Valoración?</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="id-valoracion-eliminar" value="">
                    <p class="pregunta-modal">¿Estás seguro de que quieres eliminar esta valoración? Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado" onclick="confirmarEliminarValoracion()">Sí, eliminar</button>
                    <button type="button" class="btn boton-cuadrado-eliminar" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>