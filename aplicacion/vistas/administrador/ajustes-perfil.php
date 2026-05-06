<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-ajustes-perfil">
                <div class="card-body">
                    <h4 class="titulo-tarjeta2 text-center">Ajustes de Perfil</h4>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-12 mb-4">
                            <form id="form-foto" method="POST" action="../../controladores/cambiar-foto-admin.php" enctype="multipart/form-data">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto tipo_usuario">Foto de Perfil</legend>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Nueva foto</label>
                                        <input id="cambiar-foto" type="file" name="foto" class="form-control" accept="image/*">
                                    </div>
                                    <?php if(isset($_SESSION["foto_cambiada"])){ ?>
                                        <p style="color: green;"><?php 
                                        echo $_SESSION["foto_cambiada"]; 
                                        unset($_SESSION["foto_cambiada"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_foto"])){ ?>
                                        <p style="color: red;"><?php 
                                        echo $_SESSION["error_foto"]; 
                                        unset($_SESSION["error_foto"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <span id="error-cambiar-foto" style='color: red;'></span>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado-ajustes">Cambiar foto de perfil</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-correo" method="POST" action="../../controladores/cambiar-correo-admin.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto tipo_usuario">Correo Electrónico</legend>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Nuevo correo</label>
                                        <input id="correo1" type="email" name="correo" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Repetir correo</label>
                                        <input id="correo2" type="email" name="correo_repetido" class="form-control">
                                    </div>
                                    <?php if(isset($_SESSION["correo_cambiado"])){ ?>
                                        <p style="color: green;"><?php 
                                        echo $_SESSION["correo_cambiado"]; 
                                        unset($_SESSION["correo_cambiado"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_correo"])){ ?>
                                        <p style="color: red;"><?php 
                                        echo $_SESSION["error_correo"]; 
                                        unset($_SESSION["error_correo"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <span id="error-cambiar-correo" style='color: red;'></span>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado-ajustes">Cambiar correo</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-telef" method="POST" action="../../controladores/cambiar-telefono-admin.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto tipo_usuario">Teléfono</legend>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Nuevo teléfono</label>
                                        <input id="telef1" type="text" name="telefono" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Repetir teléfono</label>
                                        <input id="telef2" type="text" name="telefono_repetido" class="form-control">
                                    </div>
                                    <?php if(isset($_SESSION["telefono_cambiado"])){ ?>
                                        <p style="color: green;"><?php 
                                        echo $_SESSION["telefono_cambiado"]; 
                                        unset($_SESSION["telefono_cambiado"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_telef"])){ ?>
                                        <p style="color: red;"><?php 
                                        echo $_SESSION["error_telef"]; 
                                        unset($_SESSION["error_telef"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <span id="error-cambiar-telef" style='color: red;'></span>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado-ajustes">Cambiar teléfono</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-12 mb-4">
                            <form id="form-contra" method="POST" action="../../controladores/cambiar-contrasena-admin.php">
                                <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                    <legend class="font-weight-bold w-auto tipo_usuario">Contraseña</legend>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Nueva contraseña</label>
                                        <input id="contra1" type="password" name="contrasena_nueva" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class='etiqueta-filtro'>Repetir nueva contraseña</label>
                                        <input id="contra2" type="password" name="contrasena_nueva_repetida" class="form-control">
                                    </div>
                                    <?php if(isset($_SESSION["contra_cambiada"])){?>
                                        <p style="color: green;"><?php 
                                        echo $_SESSION["contra_cambiada"]; 
                                        unset($_SESSION["contra_cambiada"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <?php if(isset($_SESSION["error_contra"])){ ?>
                                        <p style="color: red;"><?php 
                                        echo $_SESSION["error_contra"]; 
                                        unset($_SESSION["error_contra"]); 
                                        ?>
                                        </p>
                                    <?php }?>
                                    <span id="error-cambiar-contra" style='color: red;'></span>
                                    <div class="text-right">
                                        <button type="submit" class="btn boton-cuadrado-ajustes">Cambiar contraseña</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>