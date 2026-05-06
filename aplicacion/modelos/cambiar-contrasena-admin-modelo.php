<?php
//FUNCIÓN PARA ACTUALIZAR LA CONTRASEÑA
function actualizarContrasena($conexion, $id_usuario, $contrasena_nueva){
    //LA HASEO ANTES
    $hash = password_hash($contrasena_nueva, PASSWORD_DEFAULT);
    
    $sql = "UPDATE usuarios SET contrasena = ? 
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $hash, $id_usuario);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_close($preparacion);

    return true;
}

//FUNCIÓN PARA QUE NO SE PUEDA OTRA VEZ LA MISMA CONTRASEÑA
function obtenerContrasenaActual($conexion, $id_usuario){
    $sql = "SELECT contrasena FROM usuarios WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["contrasena"];
}
?>