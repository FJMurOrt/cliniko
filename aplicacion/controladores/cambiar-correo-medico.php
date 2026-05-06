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

//VALIDACIONES
if(empty($correo) || empty($correo_repetido)){
    $_SESSION["error_correo"] = "Los campos del correo no pueden estar vacíos.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
    $_SESSION["error_correo"] = "El correo no cumple con el formato válido.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

$partes = explode("@", $correo);
$usuario = $partes[0];

if(!preg_match("/^[A-Za-z0-9._-]+$/", $usuario)){
    $_SESSION["error_correo"] = "El correo solo puede contener letras, números, '.', '-' o '_'";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

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