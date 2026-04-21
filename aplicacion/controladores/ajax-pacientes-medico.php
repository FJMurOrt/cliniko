<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-pacientes-medico-modelo.php";
session_start();

$id_medico = $_SESSION["id_usuario"];

//PARA LA PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 6;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$busqueda = "";
if(isset($_GET["busqueda"])){
    $busqueda = trim($_GET["busqueda"]);
}

$historial = null;
if(isset($_GET["historial"]) && $_GET["historial"] !== ""){
    $historial = $_GET["historial"];
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

$edad = null;
if(isset($_GET["edad"]) && $_GET["edad"] !== ""){
    $edad = $_GET["edad"];
}

//PARA CONTAR EL TOTAL DE LOS PACIENTES QUE TIENE EL MÉDICO
$total_pacientes = obtenerTotalPacientes($conexion, $id_medico, $busqueda, $historial, $edad);
$total_paginas = ceil($total_pacientes / $registros);

//PARA OBTENER LSO DATOS DE LOS PACIENTES
$pacientes = obtenerPacientes($conexion, $id_medico, $inicio, $registros, $busqueda, $historial, $orden, $edad);

echo json_encode([
    "pacientes" => $pacientes,
    "total_paginas" => $total_paginas
]);
?>