<?php
session_start();
require_once "../modelos/consultar-inicio-sesion.php";

//EL ARRAY DONDE VAMOS A GUARDAR LOS MENSAJES DE ERROR
$errores = [];

//VALIDAMOS QUE EL FORMATO DEL CORREO SEA CORRECTO
if(isset($_POST["correo"])){
    $correo = trim($_POST["correo"]);
}else{
    $correo = "";
}

if(empty($correo)){
    $errores[] = "Debes introducir tu correo electrónico.";
}else{
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $errores[] = "El correo no cumple con el formato válido.";
    }
}

//VALIDAMOS QUE EL CAMPO DE LA CONTRASEÑA SEA CORRECTO
if(isset($_POST["contrasena"])){
    $contrasena = trim($_POST["contrasena"]);
}else{
    $contrasena = "";
}

if(empty($contrasena)){
    $errores[] = "Debes introducir tu contraseña.";
}

//CONSULTAMOS EL USUARIO EN LA BASE DE DATOS, ES DECIR, VEMOS SI EL CORREO EXISTE Y SU CONTRASEÑA COINCIDE
if(empty($errores)){
    $usuario_que_inicia_sesion = comprobar_usuario_en_bd($conexion,$correo, $contrasena);

    if(!$usuario_que_inicia_sesion){
        $errores[] = "El correo o la contraseña introducida no es correcto.";
    } else {
        if($usuario_que_inicia_sesion['habilitado'] === "no"){
            header("Location: ../../despues-de-registro.php");
            exit;
        }
    }
}
?>