<?php require_once "../../../panel-admin/includes/header.php";?>
<?php require_once "../../../panel-admin/includes/sidebar.php";?>
<?php
//PARA PODER RECOGER EL ID DEL USUARIO QUE VAMOS A VER Y LUEGO LO VUELVO A PASAR CON UN INPUT HIDDEN AL JS QUE MUESTRA LA INFORMACIÓN
$id = 0;
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
}
?>
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php";?>
        <div class="container-fluid">
            <div class="card mb-4 tarjeta-ver-mas-datos">
                <div class="card-body">
                    <div id="contenedor-datos-usuario"></div>
                    <div class="text-center mt-3">
                        <a href="nuevos-usuarios.php" class="btn boton-cuadrado">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php";?>
</div>
<input type="hidden" id="id-usuario" value="<?php echo $id;?>">