<?php
//FUNCIÓN PARA CONTAR LOS USUARIOS PARA LA PAGINACIÓN
function contarUsuariosEnviar($conexion, $busqueda, $rol, $fecha, $estado){
    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_tipo_usuario = "";
    if($rol){
        $filtro_tipo_usuario = " AND u.rol = '$rol'"; 
    }

    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(u.fecha_registro) = '$fecha'"; 
    }

    $filtro_estado = "";
    if($estado){
        $filtro_estado = " AND u.habilitado = '$estado'";
    }

    $sql = "SELECT COUNT(*) as total FROM usuarios u
            WHERE u.rol != 'administrador'
            AND u.nombre != 'Usuario eliminado'
            $filtro_busqueda
            $filtro_tipo_usuario
            $filtro_fecha
            $filtro_estado";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LOS USUARIOS
function obtenerUsuariosEnviar($conexion, $inicio, $registros, $busqueda, $rol, $fecha, $estado){
    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_tipo_usuario = "";
    if($rol){
        $filtro_tipo_usuario = " AND u.rol = '$rol'"; 
    }

    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(u.fecha_registro) = '$fecha'";
    }

    $filtro_estado = "";
    if($estado){
        $filtro_estado = " AND u.habilitado = '$estado'";
    }

    $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, u.rol, u.foto_perfil, u.habilitado FROM usuarios u
            WHERE u.rol != 'administrador'
            AND u.nombre != 'Usuario eliminado'
            $filtro_busqueda
            $filtro_tipo_usuario
            $filtro_fecha
            $filtro_estado
            ORDER BY u.fecha_registro DESC
            LIMIT ? OFFSET ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $registros, $inicio);
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