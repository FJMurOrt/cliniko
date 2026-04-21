<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-mis-citas-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "citas" => [],
        "total_paginas" => 0
    ]);
    exit;
}

//GUARDO EL ID DEL PACIENTE
$id_paciente = $_SESSION["id_usuario"];

$pagina = 1;
if (isset($_GET["pagina"])) {
    $pagina = intval($_GET["pagina"]);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$fecha = null;
if (isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$estado = null;
if (isset($_GET["estado"]) && $_GET["estado"] !== ""){
    $estado = $_GET["estado"];
}

if (isset($_GET["orden"])){
    $orden = $_GET["orden"];
}else{
    $orden = "";
}

if(isset($_GET['turno'])){
    $turno = $_GET['turno'];
}else{
    $turno = null;
}

//PARA SABER CUANTAS PÁGINAS HARÁ FALTA PARA LAS CITAS
$total_citas = contarCitasPaciente($conexion, $id_paciente, $fecha, $estado);
$total_paginas = ceil($total_citas / $registros);

//PARA OBTENER LAS CITAS DE LOS PACIENTES
$citas = obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha, $estado, $orden, $turno);

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>