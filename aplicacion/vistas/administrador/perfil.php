<?php require_once "../../../panel-admin/includes/header.php"; ?>
<?php require_once "../../../panel-admin/includes/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <?php require_once "../../../panel-admin/includes/topbar.php"; ?>
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Ajustes de Perfil</h1>
            <form>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" value="Douglas McGee">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="email" value="douglas@example.com">
                </div>
                <div class="form-group">
                    <label for="password">Nueva contraseña:</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        </div>
    </div>
    <?php require_once "../../../panel-admin/includes/footer.php"; ?>
</div>
