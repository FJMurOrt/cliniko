<?php
function eliminarCuenta($conexion, $id_usuario){
    $sql = "UPDATE usuarios SET nombre = 'Usuario eliminado', apellidos = 'Usuario eliminado', correo = CONCAT('eliminado_', ?, '@eliminado.com'),
            telefono = NULL,
            foto_perfil = NULL,
            habilitado = 'no'
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $id_usuario, $id_usuario);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return true;
}
?>