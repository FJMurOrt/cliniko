<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ver-usuario-modelo.php";
session_start();

//COMPRUBO QUE NO HAYA PROBLEMA CON EL ID DEL ADMIN
if(!isset($_SESSION["id_usuario"])){
    echo json_encode(["error" => "No autorizado"]);
    exit;
}

//Y RECOJO EL ID DEL USUARIO DEL QUE VAMOS A VER MÁS DATOS
$id_usuario = intval($_GET["id_usuario"]);
$usuario = obtenerDatosUsuario($conexion, $id_usuario);

echo json_encode($usuario);
?>