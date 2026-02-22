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
        //GUARDARMOS EN EL SESSION TODOS LOS CAMPOS DEL USUARIO PARA LLEVARNOSLOS AL PANEL DEL INICIO DE SESIÓN
        $_SESSION['id_usuario']    = $usuario_que_inicia_sesion['id_usuario'];
        $_SESSION['habilitado']    = $usuario_que_inicia_sesion['habilitado'];
        $_SESSION['rol']            = $usuario_que_inicia_sesion['rol'];
        $_SESSION['nombre']         = $usuario_que_inicia_sesion['nombre'];
        $_SESSION['apellidos']      = $usuario_que_inicia_sesion['apellidos'];
        $_SESSION['correo']         = $usuario_que_inicia_sesion['correo'];
        $_SESSION['telefono']        = $usuario_que_inicia_sesion['telefono'];
        $_SESSION['fecha_registro'] = $usuario_que_inicia_sesion['fecha_registro'];
        $_SESSION['foto_perfil']    = $usuario_que_inicia_sesion['foto_perfil'];

        if ($usuario_que_inicia_sesion['rol'] === "administrador") {
            header("Location: ../vistas/administrador/index.php");
            exit;
        }
        if($usuario_que_inicia_sesion['habilitado'] === "no"){
            header("Location: ../../despues-de-registro.php");
            exit;
        }
        if ($usuario_que_inicia_sesion['rol'] === "medico") {
            header("Location: ../vistas/medico/index.php");
            exit;
        } 
        elseif ($usuario_que_inicia_sesion['rol'] === "paciente") {
            header("Location: ../vistas/paciente/index.php");
            exit;
        } 
    }
}
//ENVIAMOS EL ARRAY CON LOS ERRORES EN EL SESSION Y LOS MOTRAMOS EN EL LOGIN.PHP
$_SESSION["errores"] = $errores;
header("Location: ../../login.php");
exit;
?>