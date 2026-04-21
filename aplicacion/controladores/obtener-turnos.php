<?php
header("Content-Type: application/json");
require_once "../configuracion/config.php";
require_once "../modelos/obtener-turnos-modelo.php";

//VERIFICO QEU TENGO LOS DATOS QUE SE ESTÁN ENVIANDO
if(!isset($_GET["id_medico"]) || !isset($_GET["fecha"])){
    echo json_encode([]);
    exit;
}

$id_medico = intval($_GET["id_medico"]);
$fecha = $_GET["fecha"];

//PARA OBTENER LSO TURNOS PARA LA FECHA SELECCIOANDA
$turnos = obtenerTurnosPorFecha($conexion, $id_medico, $fecha);

//DEVUELVO EL JSON
echo json_encode($turnos);
?>