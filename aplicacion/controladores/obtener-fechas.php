<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/obtener-fechas-modelo.php";

//VERIFICO EL ID DEL MEDICO
if(!isset($_GET["id_medico"])) {
    echo json_encode([]);
    exit;
}

//SI EL ID NO FUESE VÁLIDO, NO DEVUELVO NADA.
$id_medico = intval($_GET["id_medico"]);
if($id_medico <= 0) {
    echo json_encode([]);
    exit;
}

//PARA OBTENER LAS FECHAS DE LA DISPONIBILDIAD QUE TIENE
$fechas = obtenerFechasDisponibilidad($conexion, $id_medico);

echo json_encode($fechas);
?>