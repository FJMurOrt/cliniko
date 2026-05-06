<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/informe-historiales-modelo.php";
session_start();

//VERFICIO EL ID DEL ADMIN Y SI HAY PROBLEMAS CANCELO
if(!isset($_SESSION['id_usuario'])){
    exit;
}

//GUARDO LOS HISTORIALES QUE ME DEVUELVE LA FUNCIÓN
$historiales = obtenerTodosLosHistoriales($conexion);

//Y LOS DEVUELVO AL JS
echo json_encode($historiales);
?>