<?php
function obtenerCorreosTodosUsuarios($conexion){
    $sql = "SELECT correo FROM usuarios 
            WHERE habilitado = 'si' 
            AND rol != 'administrador'
            AND nombre != 'Usuario eliminado'";

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