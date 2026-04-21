<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-citas-canceladas-modelo.php";
session_start();

$id_medico = $_SESSION["id_usuario"];

//PARA LA PAGINACIÓN
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

//PARA CONTAR LAS CITAS
$numero_total_de_citas = contarCitas($conexion, $id_medico, $fecha, $turno, $busqueda);
$total_paginas = ceil($numero_total_de_citas / $registros);

//PARA OBTENER LAS CITAS
$citas = obtenerCitas($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden);

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>