<?php
require_once "../configuracion/config.php";
require_once "../modelos/eliminar-cuenta-modelo.php";
session_start();

//VERFICIO EL ID PARA LUEGO USARLO EN LA FUNCIÓN PARA ELIMINAR LA CUENTA
if(!isset($_SESSION["id_usuario"])){
    header("Location: ../../../login.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

eliminarCuenta($conexion, $id_usuario);

session_destroy();
header("Location: ../../login.php");
exit;
?>