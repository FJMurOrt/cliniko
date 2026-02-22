<?php
session_start();
?>
<?php
//VARIABLE PARA EL NOMBRE COMPLETO
$nombre_completo = $_SESSION['nombre'] . " " . $_SESSION['apellidos'];

//VARIABLE EL NOMBRE DE LA FOTO
if (isset($_SESSION['foto_perfil'])) {
    $foto = $_SESSION['foto_perfil'];
} else {
    $foto = "por_defecto.png";
}

$ruta_foto = "../../../uploads/perfiles/" . $foto;

//EN CASO DE QUE LA FOTO DE PROBLEMAS O NO SE ENCUENTRE POR ALGÚN MOTIVO, QUE UTILICE UNA POR DEFECTO.
if (!file_exists($ruta_foto)) {
    $ruta_foto = "../../../uploads/perfiles/por_defecto.png";
}
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <!-- Tus alertas aquí -->
            </div>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Message Center</h6>
                <!-- Tus mensajes aquí -->
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span class="nombre-usuario mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre_completo;?></span>
                <img class="img-profile rounded-circle" src="<?php echo $ruta_foto;?>">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Perfil</a>
                <a class="dropdown-item" href="perfil.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Ajustes</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
