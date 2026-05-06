<?php
require_once "../configuracion/config.php";
require_once "../modelos/cambiar-telefono-paciente-modelo.php";
session_start();

//ME ASEGURO QUE NO HAYA PROBLEMAS CON EL ID DEL PACIENTE
if(!isset($_SESSION["id_usuario"])){
    header("Location: ../../../login.php");
    exit;
}

//LO GUARDO EN UNA VARIBALE PARA LUEGO USARLO EN LA FUNCIÓN
$id_usuario = $_SESSION["id_usuario"];

//GUARDO EN VARIBALES EL VALUE DE LOS CAMPOSs
$telefono = trim($_POST["telefono"]);
$telefono_repetido = trim($_POST["telefono_repetido"]);

//VALIDACIONES
if(empty($telefono) || empty($telefono_repetido)){
    $_SESSION["error_telef"] = "Los campos del teléfono no pueden estar vacíos.";
    header("Location: ../vistas/paciente/ajustes-perfil.php");
    exit;
}

if(!preg_match("/^[0-9]{9}$/", $telefono)){
    $_SESSION["error_telef"] = "El teléfono debe contener exactamente 9 números.";
    header("Location: ../vistas/paciente/ajustes-perfil.php");
    exit;
}

//SI NO COINCIDEN, LANZO UN ERRROR
if($telefono !== $telefono_repetido){
    $_SESSION["error_telef"] = "Los teléfonos no coinciden.";
    header("Location: ../vistas/paciente/ajustes-perfil.php");
    exit;
}

//PARA QUE NO VUELVA A METER EL MISMO TELÉFONO OTRA VEZ
$telefono_que_tiene_ya = obtenerTelefonoActual($conexion, $id_usuario);

if($telefono === $telefono_que_tiene_ya){
    $_SESSION["error_telef"] = "El nuevo teléfono no puede ser igual al que ya tienes.";
    header("Location: ../vistas/paciente/ajustes-perfil.php");
    exit;
}

//Y SI NO HAY ERRORES, LO ACTUALIZO EN LA BASE DE DATOS
actualizarTelefono($conexion, $id_usuario, $telefono);

$_SESSION["telefono_cambiado"] = "El teléfono fue actualizado sin problemas.";
header("Location: ../vistas/paciente/ajustes-perfil.php");
exit;
?>