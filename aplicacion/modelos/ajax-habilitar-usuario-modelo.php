<?php
function habilitarUsuario($conexion, $id_usuario){
    $sql = "UPDATE usuarios SET habilitado = 'si' WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return true;
}

function obtenerDatosUsuario($conexion, $id_usuario){
    $sql = "SELECT nombre, apellidos, correo FROM usuarios WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}
?>