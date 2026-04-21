<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-marcar-notificacion-leida-modelo.php";
session_start();

if(!isset($_SESSION["id_usuario"])){
    echo json_encode(["ok" => false]);
    exit;
}

$id_notificacion = intval($_GET["id_notificacion"]);
$id_usuario = $_SESSION["id_usuario"];

$resultado = marcarNotificacionLeida($conexion, $id_notificacion, $id_usuario);

echo json_encode([
    "leida" => $resultado
    ]);
?>