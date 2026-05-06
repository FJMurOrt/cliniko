<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Comunicar a un Usuario</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Fecha de registro</label>
                            <input type="date" id="filtro-fecha-enviar" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Usuario</label>
                            <input type="text" id="filtro-busqueda-enviar" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Tipo de Usuario</label>
                            <select id="filtro-rol-enviar" class="form-control">
                                <option value="">Todos</option>
                                <option value="paciente">Paciente</option>
                                <option value="medico">Médico</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Estado</label>
                            <select id="filtro-estado-enviar" class="form-control">
                                <option value="">Todos</option>
                                <option value="si">Habilitados</option>
                                <option value="no">No habilitados</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-enviar-usuario" class="text-center mt-2"></div>
                    <div id="contenedor-usuarios-enviar" class="row"></div>
                    <div id="paginacion-usuarios-enviar" class="text-center mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-enviar-mensaje" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">Enviar Mensaje</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="correo-destinatario" value="">
                    <div class="form-group">
                        <label class="etiqueta-filtro">Asunto</label>
                        <input type="text" id="asunto-usuario" class="form-control" placeholder="Escribe el asunto..." maxlength="100">
                    </div>
                    <div class="form-group">
                        <label class="etiqueta-filtro">Mensaje</label>
                        <textarea id="mensaje-usuario" class="form-control" rows="5" placeholder="Escribe el mensaje..." maxlength="1000"></textarea>
                        <span id="contador-mensaje-usuario" style="color: #2C2C3E;">0/1000</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado" onclick="enviarMensajeUsuario()">Enviar</button>
                    <button type="button" class="btn boton-cuadrado-eliminar" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>