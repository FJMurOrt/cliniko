<?php require_once "../../../panel-medico/includes/header.php";?>
<?php require_once "../../../panel-medico/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-medico/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-pacientes-recetas">
                <div class="card-body">
                    <h4 class="titulo-tarjeta2 text-center">Recetas</h4>
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
                    <div id="contenedor-citas" class="row">
                    </div>
                    <div id="paginacion" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-agregar-nota">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta-modal w-100 text-center">Agregar Nota</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style='color: #D47B5E;'>X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-cita-nota" value="">
                    <textarea id="textarea-nota" class="form-control" rows="4" placeholder="Escribe aquí información adicional para la cita..." maxlength="200"></textarea>
                     <span id="contador-nota" style="color: rgba(255, 255, 255, 0.80);">0/200</span>
                     <div id="mensaje-nota" class="text-center mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado2 btn-form" onclick="guardarNota()">Guardar</button>
                    <button type="button" class="btn boton-cuadrado-eliminar btn-form" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-generar-receta">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="titulo-tarjeta-modal text-center w-100">Generar Receta</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id-cita-receta-pdf">
                    <div class="form-group">
                        <label style="color: rgba(255, 255, 255, 0.80);">Medicamento</label>
                        <input type="text" id="medicamento-receta" class="form-control" placeholder="Nombre del medicamento recetado">
                    </div>
                    <div class="form-group">
                        <label style="color: rgba(255, 255, 255, 0.80);">Dosis</label>
                        <input type="text" id="dosis-receta" class="form-control" placeholder="Medicamento de 1g, 500mg, 600mg, etc.">
                    </div>
                    <div class="form-group">
                        <label style="color: rgba(255, 255, 255, 0.80);">Frecuencia</label>
                        <input type="text" id="frecuencia-receta" class="form-control" placeholder="¿Cada cuánto tiempo se tomará?">
                    </div>
                    <div class="form-group">
                        <label style="color: rgba(255, 255, 255, 0.80);">Duración del tratamiento</label>
                        <input type="text" id="duracion-receta" class="form-control" placeholder="¿Durante cuánto tiempo se tomará?">
                    </div>
                    <div class="form-group">
                        <label style="color: rgba(255, 255, 255, 0.80);">Observaciones <span style="color: rgba(255, 255, 255, 0.80);">(opcional)</span></label>
                        <textarea id="observaciones-receta" class="form-control" rows="3" placeholder="Observaciones que quieras dejar por escrito..."></textarea>
                    </div>
                </div>
                <div id="mensaje-generar-receta" class="text-center mt-2"></div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado2 btn-form" onclick="generarRecetaPDF()">Generar</button>
                    <button type="button" class="btn boton-cuadrado-eliminar btn-form" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-medico/includes/footer.php";?>
</div>