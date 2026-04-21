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

//PARA LA ESPECIALIDAD
$especialidad = null;
if(isset($_GET["especialidad"]) && $_GET["especialidad"] !== ""){
    $especialidad = intval($_GET["especialidad"]);
}

//PARA EL ORDEN
if (isset($_GET["orden"])){
    $orden = $_GET["orden"];
}else{
    $orden = "";
}

//EL TOTLA DE MÉDICOS
$total = contarMedicos($conexion, $especialidad);
$total_paginas = ceil($total / $registros);

//LA LISTA DE MÉDICOS CON LA FUNCIÓN
$medicos = obtenerMedicos($conexion, $inicio, $registros, $especialidad, $orden);

//DEVUELVO EL JSON
echo json_encode([
    "medicos" => $medicos,
    "total_paginas" => $total_paginas
]);
?>