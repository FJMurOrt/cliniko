<?php
function obtenerNotificaciones($conexion, $id_usuario){
    $sql = "SELECT id_notificacion, tipo, mensaje, fecha, leida FROM notificaciones 
            WHERE id_usuario = ?
            AND leida = 'no'
            ORDER BY fecha DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $notificaciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $notificaciones[] = $fila;
    }
    mysqli_stmt_close($preparacion);
    return $notificaciones;
}
?>