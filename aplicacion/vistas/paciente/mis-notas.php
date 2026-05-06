<?php require_once "../../../panel-paciente/includes/header.php";?>
<?php require_once "../../../panel-paciente/includes/sidebar.php";?>

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content" style="flex: 1; display: flex; flex-direction: column;">
        <?php require_once "../../../panel-paciente/includes/topbar.php";?>
        <div class="container-fluid" style="flex: 1; padding: 0;">
            <iframe src="https://mis-notas.infinityfreeapp.com/" style="width: 100%; height: 100%; min-height: 500px; border: none; display: block;"></iframe>
        </div>
    </div>
    <?php require_once "../../../panel-paciente/includes/footer.php";?>
</div>