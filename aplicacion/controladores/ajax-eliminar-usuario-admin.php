<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../configuracion/config.php";
require_once "../modelos/ajax-eliminar-usuario-admin-modelo.php";
session_start();

//VERIFICAMOS EL ID DEL ADMIN COMO SIEMPRE
if(!isset($_SESSION["id_usuario"])){
    exit;
}

//GUARDO EL ID DEL USUARIO QUE RECIBO DEL JS QUE VOY A ELIMINAR
$id_usuario = intval($_GET["id_usuario"]);

$resultado = eliminarUsuarioAdmin($conexion, $id_usuario);

echo json_encode([
    "eliminado" => $resultado
    ]);
?>