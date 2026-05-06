<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/informe-valoraciones-modelo.php";
session_start();

//VERIFICO COMO SIEMPRE AL ADMIN AQUÍ
if(!isset($_SESSION['id_usuario'])){
    exit;
}

//GUARDO LAS VALORACIONES EN UNA VARIBALE
$valoraciones = obtenerTodasLasValoraciones($conexion);

//Y LAS DEVUELVO
echo json_encode($valoraciones);
?>