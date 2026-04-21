<?php
session_start();
require_once "../configuracion/config.php";
require_once "../modelos/nueva-contrasena-controlador-modelo.php";

//VERIFICO QUE HE OBTENIDO LOS DATOS CORRECTAMENTE
$token = "";
if(isset($_POST["token"])){
    $token = $_POST["token"];
}

$contrasena1 = "";
if(isset($_POST["contrasena1"])){
    $contrasena1 = $_POST["contrasena1"];
}

$contrasena2 = "";
if(isset($_POST["contrasena2"])){
    $contrasena2 = $_POST["contrasena2"];
}

//VALIDACIONES
if(empty($token) || empty($contrasena1) || empty($contrasena2)) {
    $_SESSION["errores"] = ["Debes introducir tu nueva contraseña."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

if($contrasena1 !== $contrasena2){
    $_SESSION["errores"] = ["Las contraseñas no coinciden."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

if(strlen($contrasena1) < 8){
    $_SESSION["errores"] = ["La contraseña debe tener como mínimo 8 caracteres."];
    header("Location: ../../cambiar-contrasena.php?token=$token");
    exit;
}

//PRAA VERIFICAR QUE EXISTE UN TOKEN PARA LA RECUPERACION DE LA CONTRASEÑA
$registro = obtenerTokenRecuperacion($conexion, $token);

if(!$registro){
    $_SESSION["errores"] = ["Parece que el enlace no es válido."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

//COMPROBAR QUE EL TOKEN NO ESTÉ CADUCADO
$fecha_actual = date("Y-m-d H:i:s");
if($fecha_actual > $registro["fecha_caduca"]){
    $_SESSION["errores"] = ["El enlace ha caducado. Vuelve a solicitar el cambio de contraseña."];
    header("Location: ../../recuperar-contrasena.php");
    exit;
}

//ACTUALIZAMOS LA CONTRASEÑA HASHEANDOLA ANTES
$hash = password_hash($contrasena1, PASSWORD_DEFAULT);
$actualizado = actualizarContrasena($conexion, $registro["id_usuario"], $hash);

//Y BORRAMOS EL TOKEN PARA QUE NO SE PUEDA VOLVER ACCEDER AL ENLACE PARA RECUPERAR LA CONTRASEÑA SIN PEDIR UNO NUEVO
eliminarToken($conexion, $token);

//Y REDIRIJO A LA CONFIMACIÓN DE QUE SE HA CAMBIADO LA CONTRASEÑA
header("Location: ../../confirmacion-nueva-contrasena.php");
exit;
?>