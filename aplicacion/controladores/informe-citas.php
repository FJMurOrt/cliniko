<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/informe-citas-modelo.php";
session_start();

//VERIFICO AL ADMIN
if(!isset($_SESSION['id_usuario'])){
    exit;
}

//GUARDO LAS CITAS EN UNA VARIABLE
$citas = obtenerTodasLasCitas($conexion);

//Y LAS DEVUELVO
echo json_encode($citas);
?>