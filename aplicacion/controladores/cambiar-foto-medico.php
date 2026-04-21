<?php
require_once "../configuracion/config.php";
require_once "../modelos/cambiar-foto-medico-modelo.php";
session_start();

//VERIFICO QUE NO HAY NINGÚN PROBLEMA CON EL ID DEL MEDICO
if(!isset($_SESSION["id_usuario"])){
    header("Location: ../../../login.php");
    exit;
}

//LO GUARDO EN UNA VARIABLE
$id_usuario = $_SESSION["id_usuario"];

//EMPIEZO CON LA VALIDACIÓN DE LA FOTO VERIFICANDO SI SE HA SELECCIONADO UNA.
if(!isset($_FILES["foto"]) || $_FILES["foto"]["error"] !== UPLOAD_ERR_OK){
    $_SESSION["error_foto"] = "No se pudo subir la foto.";
    header("Location: ../vistas/ajustes-perfil.php");
    exit;
}

//VERIFICO LA EXTENSIÓN DE LA FOTO
$archivo = $_FILES["foto"];
$formato = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
$formatos_permitidos = ["jpg", "jpeg", "png"];

if(!in_array($formato, $formatos_permitidos)){
    $_SESSION["error_foto"] = "Solo se permiten imágenes JPG o PNG.";
    header("Location: ../vistas/ajustes-perfil.php");
    exit;
}

//TAMBIÉN QUE NO PESE MÁS DE 2MB
if($archivo["size"] > 2 * 1024 * 1024){
    $_SESSION["error_foto"] = "La foto no puede superar 2MB.";
    header("Location: ../vistas/ajustes-perfil.php");
    exit;
}

//BUSCO EL NOMBRE DE LA FOTO QUE TENGA AHORA PARA PODER BORRAR DE LA CARPETA DE UPLOADS DE LA BASE DE DATOS
$foto_actual = obtenerFotoActual($conexion, $id_usuario);

if($foto_actual && file_exists("../../uploads/perfiles/".$foto_actual)){
    unlink("../../uploads/perfiles/".$foto_actual);
}

//LE DOY UN IDENTIFICADOR UNICO AL NOMBRE DE LA FOTO
$nombre_nuevo = uniqid()."-".$archivo["name"];
$ruta_destino = "../../uploads/perfiles/".$nombre_nuevo;

if(!move_uploaded_file($archivo["tmp_name"], $ruta_destino)){
    $_SESSION["error_foto"] = "Hubo un error al intentar guardar la foto de perfil.";
    header("Location: ../vistas/medico/ajustes-perfil.php");
    exit;
}

//SI NO HUBO NINGÚN PROBLEMA AL PASAR DE LA RUTA TEMPORAL A LA RUTA DESTINO, ACTUALIZO LA INFORMACIÓN EN L BASE DE DATOS
actualizarFoto($conexion, $id_usuario, $nombre_nuevo);

$_SESSION["foto_perfil"] = $nombre_nuevo;
$_SESSION["foto_cambiada"] = "La foto de perfil fue actualizada sin problemas.";
header("Location: ../vistas/medico/ajustes-perfil.php");
exit;
?>