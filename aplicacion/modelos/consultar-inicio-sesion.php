<?php
require_once "../configuracion/config.php";

function comprobarUsuarioEnBD($conexion, $correo, $contrasena){
    //PREPARAMOS LA CONSULTA
    $consulta = mysqli_prepare($conexion, "SELECT id_usuario, contrasena, habilitado, rol, nombre, apellidos, correo, telefono, fecha_registro, foto_perfil FROM usuarios 
    WHERE correo = ? LIMIT 1");
    
    //LE METEMOS EL CORREO
    mysqli_stmt_bind_param($consulta, "s", $correo);
    
    //Y LO EJECUTAMOS
    mysqli_stmt_execute($consulta);
    
    //SI LA CONSULTA DEL CORREO NOS DEVUELVE UN RESULTADO, COMPROBAMOS LA CONTRASEÑA DE ESE USUARIO
    $resultado = mysqli_stmt_get_result($consulta);
    
    if($fila = mysqli_fetch_assoc($resultado)){
        if(password_verify($contrasena, $fila["contrasena"])){
            mysqli_stmt_close($consulta);
            return $fila;
        }
    }
    mysqli_stmt_close($consulta);
    return false;
}
?>
