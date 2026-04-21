<?php
//VARIABLE PARA EL NOMBRE COMPLETO
$nombre_completo = $_SESSION["nombre"] . " " . $_SESSION["apellidos"];

//VARIABLE EL NOMBRE DE LA FOTO
if(isset($_SESSION["foto_perfil"])){
    $foto = $_SESSION["foto_perfil"];
}else{
    $foto = "por_defecto.png";
}

$ruta_foto = "../../../uploads/perfiles/" . $foto;

//EN CASO DE QUE LA FOTO DE PROBLEMAS O NO SE ENCUENTRE POR ALGÚN MOTIVO, QUE UTILICE UNA POR DEFECTO.
if(!file_exists($ruta_foto)){
    $ruta_foto = "../../../uploads/perfiles/por_defecto.png";
}

if(isset($_SESSION["id_medico"])){
    $id_medico = $_SESSION["id_medico"];
}else{
    $id_medico = null;
}
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!--UN RELOJ PARA MOSTRAR LA HORA CONSTANTEMENTE-->
    <div class="reloj">
        <li class="nav-item no-arrow mx-2 d-flex align-items-center">
            <span id="reloj" class="text-white-600 medium font-weight-bold"></span>
        </li>
    </div>
    
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="nombre-usuario mr-2 d-none d-lg-inline small font-weight-bold"><?php echo $nombre_completo;?></span>
                <div class="barra-divide-foto topbar-divider d-none d-sm-block"></div>
                <img class="img-profile rounded-circle ml-3" src="<?php echo $ruta_foto;?>">
            </a>
            <div class="opcion-cerrar-sesion dropdown-menu dropdown-menu-right shadow animated--grow-in menu-foto" aria-labelledby="userDropdown">
                <a class="enlace-cerrar-sesion dropdown-item menu-foto-opcion" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
