<?php
header("Content-Type: application/json; charset=utf-8");
session_start();
require_once "../configuracion/config.php";
require_once "../modelos/obtener-horas-modelo.php";

//VERIFCIO QUE OBTENGO LOS DATOS ENVIADOS
if(!isset($_GET["id_medico"], $_GET["fecha"], $_GET["turno"])){
    echo json_encode([]);
    exit;
}

//SI LO TENGO, LOS GUARDO EN UNA VARIABLE
$id_medico = intval($_GET["id_medico"]);
$fecha = $_GET["fecha"];
$turno = $_GET["turno"];

//PARA OBTENER EL RANGO DE DISPONIBILDIAD
$rango = obtenerRangoDisponibilidad($conexion, $id_medico, $fecha, $turno);
if(!$rango){
    echo json_encode([]);
    exit;
}

//PARA OBTNEER LAS HORAS RESERVADAS
$horas_reservadas = obtenerHorasReservadas($conexion, $id_medico, $fecha);

//PARA CALCULAR LAS HORAS DISPONIBLES
$horas_disponibles = calcularHorasDisponibles($rango["hora_inicio"], $rango["hora_fin"], $horas_reservadas, $fecha);

//Y LO DEVUELVO EN UN JSON
echo json_encode($horas_disponibles);
?>