<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
    <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-de-ajustes-perfil">
                <div class="card-body">
                    <div style="text-align: center;">
                        <img class="mb-2" src="../../../img/ajustes-perfil.png" style="width: 350px; max-width: 100%; height: auto;">
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-12 mb-4">
                            <form id="form-foto" method="POST" action="../../controladores/cambiar-foto-paciente.php" enctype="multipart/form-data">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto espe-tabla">Foto de Perfil</legend>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Nueva foto</label>
                                        <input id="cambiar-foto" type="file" name="foto" class="form-control" accept="image/*">
                                    </div>
                                    <span id="error-cambiar-foto" style="color: red;"></span>
                                    <?php if(isset($_SESSION["foto_cambiada"])){?>
                                        <p style="color: green;"><?php echo $_SESSION["foto_cambiada"]; unset($_SESSION["foto_cambiada"]); ?></p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_foto"])){?>
                                        <p style="color: red;"><?php echo $_SESSION["error_foto"]; unset($_SESSION["error_foto"]); ?></p>
                                    <?php }?>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado">Cambiar foto de perfil</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-correo" method="POST" action="../../controladores/cambiar-correo-paciente.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto espe-tabla">Correo Electrónico</legend>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Nuevo correo</label>
                                        <input id="correo1" type="email" name="correo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Repetir correo</label>
                                        <input id="correo2" type="email" name="correo_repetido" class="form-control">
                                    </div>
                                    <span id="error-cambiar-correo" style="color: red;"></span>
                                    <?php if(isset($_SESSION["correo_cambiado"])){?>
                                        <p style="color: green;"><?php echo $_SESSION["correo_cambiado"]; unset($_SESSION["correo_cambiado"]); ?></p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_correo"])){?>
                                        <p style="color: red;"><?php echo $_SESSION["error_correo"]; unset($_SESSION["error_correo"]); ?></p>
                                    <?php }?>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado">Cambiar correo</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-telef" method="POST" action="../../controladores/cambiar-telefono-paciente.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto espe-tabla">Teléfono</legend>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Nuevo teléfono</label>
                                        <input id="telef1" type="text" name="telefono" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Repetir teléfono</label>
                                        <input id="telef2" type="text" name="telefono_repetido" class="form-control">
                                    </div>
                                    <span id="error-cambiar-telef" style="color: red;"></span>
                                    <?php if(isset($_SESSION["telefono_cambiado"])){?>
                                        <p style="color: green;"><?php echo $_SESSION["telefono_cambiado"]; unset($_SESSION["telefono_cambiado"]); ?></p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_telef"])){?>
                                        <p style="color: red;"><?php echo $_SESSION["error_telef"]; unset($_SESSION["error_telef"]); ?></p>
                                    <?php }?>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado">Cambiar teléfono</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-contra" method="POST" action="../../controladores/cambiar-contrasena-paciente.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto espe-tabla">Contraseña</legend>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Nueva contraseña</label>
                                        <input id="contra1" type="password" name="contrasena_nueva" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="etiqueta-filtro">Repetir nueva contraseña</label>
                                        <input id="contra2" type="password" name="contrasena_nueva_repetida" class="form-control">
                                    </div>
                                    <span id="error-cambiar-contra" style="color: red;"></span>
                                    <?php if(isset($_SESSION["contra_cambiada"])){?>
                                        <p style="color: green;"><?php echo $_SESSION["contra_cambiada"]; unset($_SESSION["contra_cambiada"]); ?></p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_contra"])){?>
                                        <p style="color: red;"><?php echo $_SESSION["error_contra"]; unset($_SESSION["error_contra"]); ?></p>
                                    <?php }?>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado">Cambiar contraseña</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil-eliminar">
                                <legend class="font-weight-bold w-auto titulo-ajustes-perfil-eliminar">Eliminar mi cuenta</legend>
                                <p>Al eliminar tu cuenta, todos tus datos serán eliminados de manera permanente y no podrás volver a poder acceder a ella.</p>
                                <div class="text-right">
                                    <button type="button" class="btn boton-eliminar-cuenta" onclick="confirmarEliminarCuenta()">Eliminar cuenta</button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEliminarCuenta">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" style="color: #CAAAE3;">¿Eliminar cuenta?</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span style="color: #D47B5E">X</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p style="color: #CAAAE3;">¿Estás seguro de que quieres eliminar tu cuenta? Una vez aceptes, no podrás deshacerlo.</p>
                </div>
                <div class="modal-footer">
                    <a href="../../controladores/eliminar-cuenta.php" class="btn boton-eliminar-cuenta">Sí, eliminar</a>
                    <button type="button" class="btn boton-cuadrado" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
<?php require_once "../../../panel-paciente/includes/footer.php";?>