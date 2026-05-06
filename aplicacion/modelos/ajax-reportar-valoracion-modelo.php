<?php
//FUNCIÓN PARA MARCAR UNA VALORACIÓN COMO REPORTADA EN LA BASE DE DATOS
function reportarValoracion($conexion, $id_valoracion){
    $sql = "UPDATE valoraciones SET estado = 'reportada' WHERE id_valoracion = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_valoracion);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return true;
}

//PARA OBTENER LOS DATOS DE LA VALORACIÓN
function obtenerDatosValoracion($conexion, $id_valoracion){
    $sql = "SELECT v.comentario, v.puntuacion, u.nombre, u.apellidos FROM valoraciones v
            INNER JOIN usuarios u ON v.id_paciente = u.id_usuario
            WHERE v.id_valoracion = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_valoracion);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA OBTENER LOS CORREOS DE LOS ADMIN
function obtenerCorreosAdmins($conexion){
    $sql = "SELECT u.correo, u.id_usuario FROM usuarios u
            INNER JOIN administradores a ON u.id_usuario = a.id_administrador";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $admins = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $admins[] = $fila;
    }
    mysqli_stmt_close($preparacion);

    return $admins;
}
?>