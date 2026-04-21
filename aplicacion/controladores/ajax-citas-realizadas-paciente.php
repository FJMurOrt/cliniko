<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../modelos/ajax-citas-realizadas-paciente-modelo.php";
session_start();

if (!isset($_SESSION["id_usuario"])) {
    echo json_encode([
        "error" => 
        "No autorizado"
    ]);
    exit;
}

$id_paciente = $_SESSION["id_usuario"];

//FILTROS
$fecha = null;
if(isset($_GET["fecha"])){
    $fecha = $_GET["fecha"];
}

$busqueda = null;
if(isset($_GET["busqueda"])){
    $busqueda = trim($_GET["busqueda"]);
}

if(isset($_GET["receta"])){
    $receta = $_GET["receta"];
}else{
    $receta = null;
}

$especialidad = null;
if(isset($_GET["especialidad"])){
    $especialidad = intval($_GET["especialidad"]);
}

//PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 3;
$inicio = ($pagina - 1) * $registros;

//PARA CONTAR EL TOTAL DE CITAS
$total_citas = contarCitasPaciente($conexion, $id_paciente, $fecha, $busqueda, $receta, $especialidad);
$total_paginas = ceil($total_citas / $registros);

//PARA OBTENER LOS DATOS DE LAS CITAS
$datos_citas = obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha, $busqueda, $receta, $especialidad);

//FORMATEO LA FECHA Y LA HORA Y DEVUELVE EL ARRAY DE CITAS
$citas = [];
foreach($datos_citas as $fila){
    $fecha_hora = explode(" ", $fila["fecha_cita"]);
    $citas[] = [
        "id_cita" => $fila["id_cita"],
        "nombre" => $fila["nombre"],
        "apellidos" => $fila["apellidos"],
        "foto" => $fila["foto_perfil"],
        "especialidad" => $fila["especialidad"],
        "fecha" => $fecha_hora[0],
        "hora" => $fecha_hora[1],
        "archivo_pdf" => $fila["archivo_pdf"],
        "nota" => $fila["nota"]
    ];
}

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>