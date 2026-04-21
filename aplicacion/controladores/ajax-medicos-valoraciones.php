<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-medicos-valoraciones-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "medicos" => [], 
        "total_paginas" => 0
    ]);
    exit;
}

//GUARDO EL ID DEL PACIENTE
$id_paciente = $_SESSION["id_usuario"];

$pagina = 1;
if (isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 6;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$especialidad = null;
if(isset($_GET["especialidad"]) && $_GET["especialidad"] !== ""){
    $especialidad = intval($_GET["especialidad"]);
}

$busqueda = null;
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$valoracion = null;
if(isset($_GET["valoracion"]) && $_GET["valoracion"] !== ""){
    $valoracion = $_GET["valoracion"];
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

//PARA SABER EL TOTAL DE MÉDICOS CON CITAS REALIZADAS PARA SABER CUANTÁS PÁINGAS HABRÁ
$total_medicos = contarMedicosConCitasRealizadas($conexion, $id_paciente, $especialidad, $busqueda);
$total_paginas = ceil($total_medicos / $registros);

//PARA OBTENER LOS MEDICOS CON LOS QUE SE TIENEN CITAS REALIZADAS
$medicos = obtenerMedicosConCitasRealizadas($conexion, $id_paciente, $inicio, $registros, $especialidad, $busqueda, $valoracion, $orden);

echo json_encode([
    "medicos" => $medicos,
    "total_paginas" => $total_paginas
]);
?>