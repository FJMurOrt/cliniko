<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Enviar Circular</h4>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label class="etiqueta-filtro">Asunto</label>
                                <input type="text" id="asunto-circular" class="form-control" placeholder="Escribe el asunto del correo..." maxlength="100">
                            </div>
                            <div class="form-group">
                                <label class="etiqueta-filtro">Mensaje</label>
                                <textarea id="mensaje-del-correo-circular" class="form-control" rows="6" placeholder="Escribe el mensaje..." maxlength="1000"></textarea>
                                <span id="contador-circular" style="color: #2C2C3E;">0/1000</span>
                            </div>
                            <div class="text-right">
                                <button class="btn boton-cuadrado" onclick="enviarCircular()">Enviar circular para todos los usuarios</button>
                            </div>
                            <div id="mensaje-al-enviar-correo" class="text-center mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>