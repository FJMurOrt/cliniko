<?php
function obtenerFotoActual($conexion, $id_usuario){
    $sql = "SELECT foto_perfil FROM usuarios 
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);

    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["foto_perfil"];
}

function actualizarFoto($conexion, $id_usuario, $nombre_nuevo){
    $sql = "UPDATE usuarios SET foto_perfil = ? 
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $nombre_nuevo, $id_usuario);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return true;
}
?>