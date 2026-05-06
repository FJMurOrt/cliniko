<?php
//FUNCIÓN PARA PODER DESHABILITAR AL USUARIO
function deshabilitarUsuario($conexion, $id_usuario){
    $sql = "UPDATE usuarios SET habilitado = 'no' 
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return true;
}
?>