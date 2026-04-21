<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/historiales-medicos-desde-paciente.php";
session_start();

//COMPROBAR QUE EL ID DEL PACIENTE
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "medicos" => [],
        "total_paginas" => 0
    ]);
    exit;
}

$id_paciente = $_SESSION["id_usuario"];

//PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

//FILTROS
$especialidad = null;
if(isset($_GET["especialidad"]) && $_GET["especialidad"] !== ""){
    $especialidad = intval($_GET["especialidad"]);
}

$historial = null;
if(isset($_GET["historial"]) && $_GET["historial"] !== ""){
    $historial = $_GET["historial"];
}

$busqueda = null;
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

$registros = 2;
$inicio = ($pagina - 1) * $registros;

//OBTENER TOTAL DE MÉDICOS
$total_medicos = obtenerTotalMedicos($conexion, $id_paciente, $especialidad, $historial, $busqueda);
$total_paginas = ceil($total_medicos / $registros);

//OBTENER DATOS DE LOS MÉDICOS
$medicos = obtenerTotalMedicosPaciente($conexion, $id_paciente, $inicio, $registros, $especialidad, $historial, $busqueda, $orden);

//DEVOLVER JSON
echo json_encode([
    "medicos" => $medicos,
    "total_paginas" => $total_paginas
]);
?>