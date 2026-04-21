<?php
require_once "../configuracion/config.php";
require_once "../modelos/cambiar-contrasena-medico-modelo.php";
session_start();

//VERIFICO ANTES DE NADA EL ID DEL PACIENTE QUE NO HAYA PROBLEMAS
if(!isset($_SESSION["id_usuario"])){
    header("Location: ../../../login.php");
    exit;
}

//LO GUARDO PARA LUEGO
$id_usuario = $_SESSION["id_usuario"];

//GUARDO LOS VALUES DE LOS CAMPOS DE LAS CONTRASEÑAS EN VARIBALES
$contrasena_nueva = trim($_POST["contrasena_nueva"]);
$contrasena_nueva_repetida = trim($_POST["contrasena_nueva_repetida"]);

//VERIFICOS QUE COINCIDAN
if($contrasena_nueva !== $contrasena_nueva_repetida){
    $_SESSION["error_contra"] = "Las contraseñas no coinciden.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//PARA QUE NO SE PUEDA METER OTRA VEZ LA MISMA CONTRASEÑA
$contraseña_que_ya_tiene = obtenerContrasenaActual($conexion, $id_usuario);
if(password_verify($contrasena_nueva, $contraseña_que_ya_tiene)){
    $_SESSION["error_contra"] = "La nueva contraseña no puede ser igual a la que ya tienes.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//SI NO HAY ERRORES, LA ACTUALIZO EN LA BASE DE DATOS
actualizarContrasena($conexion, $id_usuario, $contrasena_nueva);

$_SESSION["contra_cambiada"] = "La contraseña fue actualizada sin problemas.";
header("Location: ../vistas/medico/ajustes-perfil.php");
exit;
?>