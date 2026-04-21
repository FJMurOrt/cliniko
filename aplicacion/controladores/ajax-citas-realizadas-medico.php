<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../modelos/ajax-citas-realizadas-medico-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "error" => "No se encontró el id del médico."
    ]);
    exit;
}

$id_medico = $_SESSION["id_usuario"];

//FILTROS
$fecha = "";
if(isset($_GET["fecha"])){
    $fecha = $_GET["fecha"];
}

$busqueda = "";
if(isset($_GET["busqueda"])){
    $busqueda = trim($_GET["busqueda"]);
}

$receta = "";
if(isset($_GET["receta"])){
    $receta = $_GET["receta"];
}

$observaciones = "";
if(isset($_GET["observaciones"])){
    $observaciones = $_GET["observaciones"];
}

//PAGINACIÓN
$pagina = 1;
if (isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 6;
$inicio = ($pagina - 1) * $registros;

//PARA CONTAR EL TOTAL DE CITAS REALZIADAS QEU TEINE EL MÉDICO
$total_citas = contarCitasRealizadasMedico($conexion, $id_medico, $fecha, $busqueda, $receta, $observaciones);
$total_paginas = ceil($total_citas / $registros);

//PAR OBTENER LOS DATOS DE LAS CITAS
$datos_citas = obtenerCitasRealizadasMedico($conexion, $id_medico, $inicio, $registros, $fecha, $busqueda, $receta, $observaciones);

//CREO EL ARRAY Y LO DEVUELVO EN EL JSON
$citas = [];
foreach($datos_citas as $fila){
    $fecha_y_hora = explode(" ", $fila["fecha_cita"]);
    $citas[] = [
        "id_cita" => $fila["id_cita"],
        "nombre" => $fila["nombre"],
        "apellidos" => $fila["apellidos"],
        "foto" => $fila["foto_perfil"],
        "fecha" => $fecha_y_hora[0],
        "hora" => $fecha_y_hora[1],
        "archivo_pdf" => $fila["archivo_pdf"],
        "nota" => $fila["nota"]
    ];
}

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>