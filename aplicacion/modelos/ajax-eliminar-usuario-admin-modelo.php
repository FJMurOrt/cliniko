<?php
//FUNCIÓN PARA ELIMINAR EL USUARIO DESDE EL PANEL DEL ADMIN
function eliminarUsuarioAdmin($conexion, $id_usuario){
    $nombre_anonimo = "Usuario eliminado";
    $apellidos_anonimo = "Usuario eliminado";
    $correo_anonimo = "eliminado_".$id_usuario."@eliminado.com";

    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, telefono = NULL, foto_perfil = NULL, habilitado = 'no'
            WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "sssi", $nombre_anonimo, $apellidos_anonimo, $correo_anonimo, $id_usuario);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}
?>