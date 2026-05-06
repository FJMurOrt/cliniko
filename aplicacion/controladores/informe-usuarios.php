<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../configuracion/config.php";
require_once "../modelos/informe-usuarios-modelo.php";
session_start();

//VERIFICO AL ADMIN
if(!isset($_SESSION['id_usuario'])){
    exit;
}

//GUARDO A LOS USUARIOS
$usuarios = obtenerTodosLosUsuarios($conexion);

//Y LOS DEVUELVO
echo json_encode($usuarios);
?>