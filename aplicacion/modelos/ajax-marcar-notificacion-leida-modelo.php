<?php
function marcarNotificacionLeida($conexion, $id_notificacion, $id_usuario){
    $sql = "UPDATE notificaciones SET leida = 'si' WHERE id_notificacion = ? AND id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $id_notificacion, $id_usuario);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);
    
    return true;
}
?>