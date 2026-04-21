<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-especialidades-modelo.php";

$especialidades = obtenerEspecialidades($conexion);

echo json_encode($especialidades);
?>