<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/lista-medicos.php";

//PAGFINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$especialidad = "";
if(isset($_GET["especialidad"]) && $_GET["especialidad"] !== ""){
    $especialidad = intval($_GET["especialidad"]);
}

$orden = "";
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

$busqueda = "";
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

//EL TOTLA DE MÉDICOS
$total = contarMedicos($conexion, $especialidad, $busqueda);
$total_paginas = ceil($total / $registros);

//LA LISTA DE MÉDICOS CON LA FUNCIÓN
$medicos = obtenerMedicos($conexion, $inicio, $registros, $especialidad, $orden, $busqueda);

//DEVUELVO EL JSON
echo json_encode([
    "medicos" => $medicos,
    "total_paginas" => $total_paginas
]);
?>