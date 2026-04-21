<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../modelos/ajax-disponibilidad-medico-modelo.php";

//COMPROBAR EL ID DEL MÉDICO
$id_medico = 0;
if (isset($_GET["id_medico"])) {
    $id_medico = intval($_GET["id_medico"]);
}

if ($id_medico <= 0) {
    echo json_encode([
        "disponibilidad" => [],
        "total_paginas" => 0
    ]);
    exit;
}

//PARA LA PAGINACIÓN
$pagina = 1;
if (isset($_GET["pagina"])) {
    $pagina = intval($_GET["pagina"]);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//PARA EL FILTRO DE LA FECHA
$fecha = null;
if(isset($_GET["fecha"]) && $_GET["fecha"] != ""){
    $fecha = $_GET["fecha"];
}

//OBTENER TOTAL DE DISPONIBILIDAD PARA LA PAGINACIÓN
$total = obtenerTotalDisponibilidad($conexion, $id_medico, $fecha);
$total_paginas = ceil($total / $registros);

//OBTENER DISPONIBILIDAD
$disponibilidad = obtenerDisponibilidad($conexion, $id_medico, $inicio, $registros, $fecha);

//DEVOLVER JSON
echo json_encode([
    "disponibilidad" => $disponibilidad,
    "total_paginas" => $total_paginas
]);
?>