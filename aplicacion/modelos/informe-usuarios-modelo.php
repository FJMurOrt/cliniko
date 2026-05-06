<?php
function obtenerTodosLosUsuarios($conexion){
    $sql = "SELECT u.nombre, u.apellidos, u.correo, u.telefono, u.rol, u.habilitado, u.fecha_registro FROM usuarios u
            WHERE u.rol != 'administrador'
            AND u.nombre != 'Usuario eliminado'
            ORDER BY u.fecha_registro DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $usuarios = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $usuarios[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $usuarios;
}
?>