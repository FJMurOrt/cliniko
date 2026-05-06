<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Documentos</h4>
                    <hr>
                    <div class="row justify-content-center mb-3">
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Paciente</label>
                            <input type="text" id="filtro-paciente-recetas" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Médico</label>
                            <input type="text" id="filtro-medico-recetas" class="form-control" placeholder="Por nombre o apellido...">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Fecha</label>
                            <input type="date" id="filtro-fecha-recetas" class="form-control">
                        </div>
                        <div class="col-12 col-md-3 mb-2">
                            <label class="etiqueta-filtro">Tipo de Documento</label>
                            <select id="filtro-tipo-documento" class="form-control">
                                <option value="receta">Recetas</option>
                                <option value="historial">Historiales</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div id="mensaje-documentos-admin" class="text-center mt-2">
                    </div>
                    <div id="contenedor-documentos-admin" class="row">
                    </div>
                    <div id="paginacion-documentos-admin" class="text-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>