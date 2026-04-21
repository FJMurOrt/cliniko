<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-notificaciones-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "notificaciones" => [],
    ]);
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$notificaciones = obtenerNotificaciones($conexion, $id_usuario);

echo json_encode([
    "notificaciones" => $notificaciones,
]);
?>