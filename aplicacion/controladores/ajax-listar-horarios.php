<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-listar-horarios-modelo.php";
session_start();

$id_medico = $_SESSION["id_usuario"];

//PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 4;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$fecha = "";
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$turno = "";
if(isset($_GET["turno"]) && $_GET["turno"] !== ""){
    $turno = $_GET["turno"];
}

//CONTAR EL TOTAL DE HORARIOS
$total = contarHorariosMedico($conexion, $id_medico, $fecha, $turno);
$total_paginas = ceil($total / $registros);

//OBTENER LOS HORARIOS
$horarios = obtenerHorariosMedico($conexion, $id_medico, $inicio, $registros, $fecha, $turno);

echo json_encode([
    "horarios" => $horarios,
    "total_paginas" => $total_paginas
]);
?>