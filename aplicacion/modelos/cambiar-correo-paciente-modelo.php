<?php
//FUNCIÓN PARA VER SI EL CORREO EXISTE YA EN LA BASE DE DATOS PARA OTRO USUARIO
function correoExiste($conexion, $correo, $id_usuario){
    $sql = "SELECT id_usuario FROM usuarios 
            WHERE correo = ? 
            AND id_usuario != ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $correo, $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $existe = mysqli_num_rows($resultado) > 0;
    mysqli_stmt_close($preparacion);

    return $existe;
}
//FUNCIÓN APRA ACTUALZAR EL CORREO
function actualizarCorreo($conexion, $id_usuario, $correo){
    $sql = "UPDATE usuarios SET correo = ? 
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $correo, $id_usuario);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_close($preparacion);

    return true;
}
//FUNCIÓN PARA QUE EL CORREO NO PUEDA VOLVER A SER EL MISMO
function obtenerCorreoActual($conexion, $id_usuario){
    $sql = "SELECT correo FROM usuarios WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["correo"];
}
?>