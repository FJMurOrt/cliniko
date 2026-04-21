<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="../../../panel-medico/img/logo.png" style="width:30px;">
        </div>
        <div class="sidebar-brand-text mx-3">
            <img src="../../../panel-medico/img/titulo_panel.png" style="height:30px;">
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="gestionar-disponibilidad.php">
            <i class="far fa-calendar-alt"></i>
            <span>Gestionar Disponibilidad</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="ver-horarios.php">
            <i class="fas fa-clock"></i>
            <span>Mis Horarios</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapsePerfil"
            aria-expanded="true" aria-controls="collapsePerfil" role="button">
            <i class="fas fa-book"></i>
            <span>Citas</span>
        </a>
        <div id="collapsePerfil" class="collapse" aria-labelledby="headingPerfil" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded mt-3 desplegable-citas">
                <a class="collapse-item opcion-cita" href="citas-activas.php" style="white-space: normal;"><i class="fas fa-calendar-check mr-2"></i>Citas activas</a>
                <a class="collapse-item opcion-cita" href="citas-realizadas.php" style="white-space: normal;"><i class="fas fa-check mr-2"></i>Citas realizadas</a>
                <a class="collapse-item opcion-cita" href="citas-solicitadas.php" style="white-space: normal;"><i class="fas fa-exclamation-circle mr-2"></i>Citas solicitadas</a>
                <a class="collapse-item opcion-cita" href="citas-canceladas.php" style="white-space: normal;"><i class="fas fa-calendar-times mr-2"></i>Citas canceladas</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="historiales-medicos.php">
            <i class="fas fa-file-medical"></i>
            <span>Historiales Médicos</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="recetas-medicas.php">
            <i class="fa fa-medkit"></i>
            <span>Gestionar Recetas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="mis-valoraciones.php">
            <i class="fas fa-star"></i>
            <span>Mis Valoraciones</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="mis-notificaciones.php">
            <i class="fa fa-bell"></i>
            <span>Notificaciones</span>
        </a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="https://mis-anotaciones.infinityfreeapp.com/?i=1" target="_blank" rel="noopener">
        <i class="fas fa-sticky-note"></i>
        <span>¡Mis Notas!</span>
    </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="ajustes-perfil.php">
            <i class="fa fa-cog"></i>
            <span>Ajustes de Perfil</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler-->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
