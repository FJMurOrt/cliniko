<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-informes">
                <div class="card-body">
                    <h4 class="titulo-tarjeta text-center">Generar Informes</h4>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                <legend class="font-weight-bold w-auto etiqueta_de_informacion">Informe de Citas</legend>
                                <p style="color: #01497C;">Descarga un PDF con todas las citas del sistema.</p>
                                <div class="text-right">
                                    <button class="btn boton-cuadrado" onclick="descargarInformeCitas()">Descargar</button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                <legend class="font-weight-bold w-auto etiqueta_de_informacion">Informe de Usuarios</legend>
                                <p style="color: #01497C;">Descarga un PDF con todos los usuarios registrados.</p>
                                <div class="text-right">
                                    <button class="btn boton-cuadrado" onclick="descargarInformeUsuarios()">Descargar</button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                <legend class="font-weight-bold w-auto etiqueta_de_informacion">Informe de Valoraciones</legend>
                                <p style="color: #01497C;">Descarga un PDF con todas las valoraciones del sistema.</p>
                                <div class="text-right">
                                    <button class="btn boton-cuadrado" onclick="descargarInformeValoraciones()">Descargar</button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                <legend class="font-weight-bold w-auto etiqueta_de_informacion">Informe de Recetas</legend>
                                <p style="color: #01497C;">Descarga un PDF con todas las recetas subidas.</p>
                                <div class="text-right">
                                    <button class="btn boton-cuadrado" onclick="descargarInformeRecetas()">Descargar</button>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 mb-4">
                            <fieldset class="border p-3 rounded borde-fieldset-ajustes-perfil">
                                <legend class="font-weight-bold w-auto etiqueta_de_informacion">Informe de Historiales</legend>
                                <p style="color: #01497C;">Descarga un PDF con todos los historiales subidos.</p>
                                <div class="text-right">
                                    <button class="btn boton-cuadrado" onclick="descargarInformeHistoriales()">Descargar</button>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>