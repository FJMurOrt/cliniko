<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-citas-solicitadas-modelo.php";
session_start();

$id_medico = $_SESSION["id_usuario"];

//CANCELAR LAS CITAS PENDIENTES QUE NO SE HAN LLEGADO A CONFIRMAR
cancelarCitasPendientes($conexion);

//PARA LA PAGINACIÓN
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = intval($_GET["pagina"]);
}

$registros = 5;
$inicio = ($pagina - 1) * $registros;

//FILTROS
$fecha = null;
if(isset($_GET["fecha"]) && $_GET["fecha"] !== ""){
    $fecha = $_GET["fecha"];
}

$turno = null;
if(isset($_GET["turno"]) && $_GET["turno"] !== ""){
    $turno = $_GET["turno"];
}

$busqueda = null;
if(isset($_GET["busqueda"]) && $_GET["busqueda"] !== ""){
    $busqueda = trim($_GET["busqueda"]);
}

$orden = null;
if(isset($_GET["orden"]) && $_GET["orden"] !== ""){
    $orden = $_GET["orden"];
}

//CONTAR EL TOTAL DE CITAS PENDITENTES POR CONFIRMAR QUE HAY PARA SABER CUÁNTAS PÁGINAS TOCA
$total = contarCitasPendientes($conexion, $id_medico, $fecha, $turno, $busqueda);
$total_paginas = ceil($total / $registros);

//OBTENER LOS DATOS DE LAS CITAS
$citas_datos = obtenerCitasPendientes($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden);

//FORMATEO LA FECHA Y LA HORA Y CREO EL ARRAY QUE DEVUELVO EN EL JSON
$citas = [];
foreach($citas_datos as $fila){
    $fecha_y_hora = explode(" ", $fila["fecha_cita"]);
    $citas[] = [
        "id_cita" => $fila["id_cita"],
        "nombre" => $fila["nombre"],
        "apellidos" => $fila["apellidos"],
        "fecha" => $fecha_y_hora[0],
        "hora" => $fecha_y_hora[1],
        "motivo" => $fila["motivo"]
    ];
}

echo json_encode([
    "citas" => $citas,
    "total_paginas" => $total_paginas
]);
?>