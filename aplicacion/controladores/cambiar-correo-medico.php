<?php
require_once "../configuracion/config.php";
require_once "../modelos/cambiar-correo-medico-modelo.php";
session_start();

//VERIFICO QUE NO HAYA NINGÚN PROBLMA CON EL ID DEL MEDICO
if(!isset($_SESSION["id_usuario"])){
    header("Location: ../../../login.php");
    exit;
}

//LO GUARDO EN UNA VARIABLE
$id_usuario = $_SESSION["id_usuario"];

//Y HAGO LAS VALIDACIONES PARA CAMPO DEL CORREO
$correo = trim($_POST["correo"]);
$correo_repetido = trim($_POST["correo_repetido"]);

//SI NO COINCIDEN LANZO UN ERROR
if($correo !== $correo_repetido){
    $_SESSION["error_correo"] = "Los correos no coinciden.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//PARA QUE EL CORREO NO SEA EL MISMO
$correo_que_ya_tiene_en_la_base_de_datos = obtenerCorreoActual($conexion, $id_usuario);

if($correo === $correo_que_ya_tiene_en_la_base_de_datos){
    $_SESSION["error_correo"] = "El nuevo correo no puede ser igual al que ya tienes.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//SI EL CORREO EXISTE YA EN LA BASE DE DATOS TAMBIÉN LANZO UN CORREO
if(correoExiste($conexion, $correo, $id_usuario)){
    $_SESSION["error_correo"] = "Ese correo ya se encuentra registrado.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//SI NO HAY ERRORES HASTA AQUÍ, LO ACTAULIZO EN LA BASE DE DATOS
actualizarCorreo($conexion, $id_usuario, $correo);

$_SESSION["correo_cambiado"] = "El correo fue actualizado sin problemas.";
header("Location: ../vistas/medico/ajustes-perfil.php");
exit;
?>