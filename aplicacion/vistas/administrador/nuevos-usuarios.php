<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Lista de Usuarios</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Usuario</label>
                            <input type="text" id="filtro-busqueda-usuarios" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Tipo de Usuario</label>
                            <select id="filtro-rol-usuarios" class="form-control">
                                <option value="">Todos</option>
                                <option value="paciente">Paciente</option>
                                <option value="medico">Médico</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Fecha de registro</label>
                            <input type="date" id="filtro-fecha-registro" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Estado</label>
                            <select id="filtro-estado-usuarios" class="form-control">
                                <option value="">Todos</option>
                                <option value="si">Habilitados</option>
                                <option value="no">No habilitados</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row justify-content-end mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <button class="btn boton-crear-usuario w-100" onclick="abrirModalCrearUsuario()">+ Crear Usuario</button>
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <button class="btn boton-crear-usuario w-100" onclick="abrirModalCrearAdmin()">+ Crear Administrador</button>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-habilitar" class="text-center mt-2">
                    </div>
                    <div id="contenedor-de-usuarios-nuevos" class="row">
                    </div>
                    <div id="paginacion-usuarios" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-crear-usuario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">Nuevo Usuario</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Nombre</label>
                            <input type="text" id="crear-nombre" class="form-control" placeholder="Introduce el nombre...">
                            <span id="error-crear-nombre" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Apellidos</label>
                            <input type="text" id="crear-apellidos" class="form-control" placeholder="Introduce los apellidos...">
                            <span id="error-crear-apellidos" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Correo electrónico</label>
                            <input type="email" id="crear-correo" class="form-control" placeholder="Introduce un correo...">
                            <span id="error-crear-correo" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Vuelve a introducir el correo</label>
                            <input type="email" id="crear-correo2" class="form-control" placeholder="Vuelve a introducir el correo...">
                            <span id="error-crear-correo2" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Teléfono</label>
                            <input type="text" id="crear-telefono" class="form-control" placeholder="Introduce un teléfono...">
                            <span id="error-crear-telefono" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Tipo de Usuario</label>
                            <select id="crear-rol" class="form-control">
                                <option value="" disabled selected>Selecciona un rol</option>
                                <option value="paciente">Paciente</option>
                                <option value="medico">Médico</option>
                            </select>
                            <span id="error-crear-rol" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Contraseña</label>
                            <input type="password" id="crear-contrasena" class="form-control" placeholder="Introduce una contraseña...">
                            <span id="error-crear-contrasena" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Vuelve a introducir la contraseña</label>
                            <input type="password" id="crear-contrasena2" class="form-control" placeholder="Vuelve a introducir la contraseña...">
                            <span id="error-crear-contrasena2" style="color: red;"></span>
                        </div>
                    </div>
                    <div id="campos-paciente-modal" style="display:none;">
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="color: #2C2C3E">Fecha de nacimiento</label>
                                <input type="date" id="crear-fecha" class="form-control">
                                <span id="error-crear-fecha" style="color: red;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="color: #2C2C3E">Dirección</label>
                                <input type="text" id="crear-direccion" class="form-control" placeholder="Introduce una dirección...">
                                <span id="error-crear-direccion" style="color: red;"></span>
                            </div>
                            <div class="col-12 mb-3">
                                <label style="color: #2C2C3E">NSS <span style="color: #2C2C3E">(opcional)</span></label>
                                <input type="text" id="crear-nss" class="form-control" placeholder="Introduce el NSS si fuera necesario...">
                                <span id="error-crear-nss" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                    <div id="campos-medico-modal" style="display:none;">
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="color: #2C2C3E">Número de colegiado</label>
                                <input type="text" id="crear-colegiado" class="form-control" placeholder="Introduce el número de colegiado...">
                                <span id="error-crear-colegiado" style="color: red;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="color: #2C2C3E">Especialidad</label>
                                <select id="crear-especialidad" class="form-control">
                                    <option value="" disabled selected>Selecciona una especialidad</option>
                                </select>
                                <span id="error-crear-especialidad" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                    <div id="mensaje-crear-usuario" class="text-center mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado" onclick="crearUsuario()">Crear usuario</button>
                    <button type="button" class="btn boton-cuadrado-eliminar" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-crear-admin">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">Nuevo Administrador</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Nombre</label>
                            <input type="text" id="admin-nombre" class="form-control" placeholder="Nombre...">
                            <span id="error-admin-nombre" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Apellidos</label>
                            <input type="text" id="admin-apellidos" class="form-control" placeholder="Apellidos...">
                            <span id="error-admin-apellidos" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Teléfono</label>
                            <input type="text" id="admin-telefono" class="form-control" placeholder="Teléfono...">
                            <span id="error-admin-telefono" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Correo electrónico</label>
                            <input type="email" id="admin-correo" class="form-control" placeholder="Correo electrónico...">
                            <span id="error-admin-correo" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Contraseña</label>
                            <input type="password" id="admin-contrasena" class="form-control" placeholder="Contraseña...">
                            <span id="error-admin-contrasena" style="color: red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="color: #2C2C3E">Vuelve a introducir la contraseña</label>
                            <input type="password" id="admin-contrasena2" class="form-control" placeholder="Vuelve a introducir la contraseña...">
                            <span id="error-admin-contrasena2" style="color: red;"></span>
                        </div>
                    </div>
                    <div id="mensaje-crear-admin" class="text-center mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado" onclick="crearAdministrador()">Crear administrador</button>
                    <button type="button" class="btn boton-cuadrado-eliminar" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-eliminar-usuario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="titulo-tarjeta2 w-100 text-center">¿Eliminar usuario?</h4>
                    <hr>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p style="color: #2C2C3E">¿Estás seguro de que quieres eliminar este usuario? Si lo haces, no podrás volver atrás.</p>
                    <input type="hidden" id="id-usuario-eliminar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn boton-cuadrado-eliminar" onclick="eliminarUsuario()">Sí, eliminar</button>
                    <button type="button" class="btn boton-cuadrado" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>