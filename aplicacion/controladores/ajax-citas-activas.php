<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-citas-activas-modelo.php";
session_start();

$id_medico = $_SESSION["id_usuario"];

//PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$fecha = null;
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$turno = null;
if(isset($_GET["turno"]) && $_GET["turno"] !== ""){
    $turno = $_GET["turno"];
}

$busqueda = null;
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

//CONTAR EL TOTAL DE CITAS ACTIVAS QUE HABRÁ PARA LAS PÁGINAS
$total_numero_citas = contarCitasConfirmadas($conexion, $id_medico, $fecha, $turno, $busqueda);
$total_paginas = ceil($total_numero_citas / $registros);

//FUNCIÓN PARA OBTENER LAS CITAS
$citas = obtenerCitasConfirmadas($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden);

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>