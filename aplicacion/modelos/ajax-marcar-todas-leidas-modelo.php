<?php
//FUNCIÓN PARA MARCAR TODAS LAS NOTICACIONES DEL USUARIO COMO LEIDAS
function marcarTodasLeidas($conexion, $id_usuario){
    $sql = "UPDATE notificaciones SET leida = 'si' WHERE id_usuario = ? AND leida = 'no'";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    $ok = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $ok;
}
?>