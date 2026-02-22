<?php
require_once '../configuracion/config.php';

function comprobar_usuario_en_bd($conexion, $correo, $contrasena){
    $correo = mysqli_real_escape_string($conexion, $correo);
    $sql = "SELECT id_usuario, contrasena, habilitado, rol, nombre, apellidos, correo, telefono, fecha_registro, foto_perfil FROM usuarios WHERE correo = '$correo' LIMIT 1";
    $resultado = mysqli_query($conexion, $sql);

    if($fila = mysqli_fetch_assoc($resultado)) {
        if(password_verify($contrasena, $fila['contrasena'])) {
            return $fila;
        }
    }
    return false;
}
?>
