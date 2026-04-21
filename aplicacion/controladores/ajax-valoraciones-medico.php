<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-valoraciones-medico-modelo.php";
session_start();

//SI HAY ALGÚN PROBLEMA CON EL ID DEL MÉDICO, NO DEVUELVO NADA
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "valoraciones" => [],
        "total_paginas" => 0
    ]);
    exit;
}

//GUARDO EL ID DEL MÉDCIO EN UNA VARIABLE APRA LUEGO USARLA EN LAS FUNCIONES DEL MODELO
$id_medico = $_SESSION["id_usuario"];

$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

//FILTROS
$busqueda = null;
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$puntuacion = null;
if(isset($_GET["puntuacion"]) && $_GET["puntuacion"] !== ""){
    $puntuacion = $_GET["puntuacion"];
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

$fecha = null;
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$registros = 4;
$inicio = ($pagina - 1) * $registros;

$total = contarValoracionesMedico($conexion, $id_medico, $busqueda);
$total_paginas = ceil($total / $registros);

$valoraciones = obtenerValoracionesMedico($conexion, $id_medico, $inicio, $registros, $busqueda, $puntuacion, $orden, $fecha);

echo json_encode([
    "valoraciones" => $valoraciones,
    "total_paginas" => $total_paginas
]);
?>