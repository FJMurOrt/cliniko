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
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
    </li>

    <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'perfil.php'){ echo 'active'; } ?>">
        <a class="nav-link" href="perfil.php">
            <i class="fas fa-user-cog"></i> <!-- icono de ajustes -->
            <span>Ajustes de Perfil</span>
        </a>
    </li>


    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Aquí va todo tu menú completo, pacientes, médicos, citas, valoraciones -->
    <!-- Por ejemplo, copia lo que ya tenías en tu index.html -->
</ul>
