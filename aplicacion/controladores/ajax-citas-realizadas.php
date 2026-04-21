<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../modelos/ajax-citas-realizadas-modelo.php";
session_start();

$id_medico = $_SESSION['id_usuario'];

//PARA LA PAGINACIÓN
$pagina = 1;
if(isset($_GET['pagina'])){
    $pagina = intval($_GET['pagina']);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//LOS FILTROS
$fecha = null;
if(isset($_GET['fecha']) && $_GET['fecha'] !== ""){
    $fecha = $_GET['fecha'];
}

$turno = null;
if(isset($_GET['turno']) && $_GET['turno'] !== ""){
    $turno = $_GET['turno'];
}

$busqueda = null;
if(isset($_GET['busqueda']) && $_GET['busqueda'] !== ""){
    $busqueda = trim($_GET['busqueda']);
}

$orden = null;
if(isset($_GET['orden']) && $_GET['orden'] !== ""){
    $orden = $_GET['orden'];
}

//PARA CONTAR CUANTAS CITAS REALIZADAS HAY Y HACER LA PAGINACIÓN
$total = contarCitasRealizadas($conexion, $id_medico, $fecha, $turno, $busqueda);
$total_paginas = ceil($total / $registros);

//PARA OBTENER LOS DATOS DE LA CITAS REALZIADAS
$citas_raw = obtenerCitasRealizadas($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden);

//EL ARRAY DE CITAS QUE DEVUELVO EN EL JSON Y ADEMÁS FORMATEO LA FECHA Y LA HORA
$citas = [];
foreach ($citas_raw as $fila) {
    $fecha_y_hora = explode(" ", $fila['fecha_cita']);
    $citas[] = [
        "id_cita" => $fila['id_cita'],
        "nombre" => $fila['nombre'],
        "apellidos" => $fila['apellidos'],
        "fecha" => $fecha_y_hora[0],
        "hora" => $fecha_y_hora[1],
        "motivo" => $fila['motivo']
    ];
}

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>