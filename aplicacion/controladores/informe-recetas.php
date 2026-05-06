<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/informe-recetas-modelo.php";
session_start();

//VERICACIÓN PARA QUE EL ID DEL ADMIN NO DE PROBLEMAS
if(!isset($_SESSION['id_usuario'])){
    exit;
}

//GUARDO LAS RECETAS
$recetas = obtenerTodasLasRecetas($conexion);

//LAS DEVUELVO
echo json_encode($recetas);
?>