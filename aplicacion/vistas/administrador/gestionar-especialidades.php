<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-lista-medicos">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Especialidades</h4>
                    <hr>
                    <div class="row justify-content-center mb-4">
                        <div class="col-12 col-md-6">
                            <h5 class="text-center etiqueta-filtro">Añadir nueva especialidad</h5>
                            <div>
                                <input type="text" id="campo-para-añadir-nueva-especialidad" class="form-control" placeholder="Nombre de la especialidad...">
                                <div>
                                    <button class="btn boton-cuadrado mt-2" onclick="añadirEspecialidad()">+ Añadir</button>
                                </div>
                            </div>
                            <div id="mensaje-especialidad" class="text-center mt-2"></div>
                        </div>
                    </div>
                    <hr>
                    <div id="contenedor-especialidades" class="row"></div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>