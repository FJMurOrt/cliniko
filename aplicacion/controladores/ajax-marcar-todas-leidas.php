<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-marcar-todas-leidas-modelo.php";
session_start();

//VERIFICO EL ID DEL MÉDICO
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//LO GUARDO PARA LA FUNCIÓN
$id_usuario = $_SESSION["id_usuario"];

//SE LAS MARCO TODAS COMO LEIDAS
$leidas = marcarTodasLeidas($conexion, $id_usuario);

//Y DEVUELVO LA CONFIRMACIÓN AL JS
echo json_encode([
    "leidas" => $leidas
    ]);
?>