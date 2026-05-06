<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-deshabilitar-usuario-modelo.php";
session_start();

//VERFICO EL ID DEL ADMIN PARA PDOER HACER ESTO Y SI NO, CANCELO
if(!isset($_SESSION["id_usuario"])){
    echo json_encode([
        "usuario_deshabilitado" => false
        ]);
    exit;
}

//Y RECOJO EL ID QUE VIENE POR EL GET DEL USUARIO QUE VOY A DESHABILITAR
$id_usuario = intval($_GET["id_usuario"]);
deshabilitarUsuario($conexion, $id_usuario);

echo json_encode([
    "usuario_deshabilitado" => true
    ]);
?>