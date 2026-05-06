<?php
//FUNCIÓN PARA CONTAR CUANTOS USUARIOS HAY Y ASI CALCULAR LAS PÁGINAS
function contarNuevosUsuarios($conexion, $busqueda, $tipo_usuario, $fecha, $id_admin, $estado){
    $sql_lo_que_busco = "";
    if($busqueda){
       $sql_lo_que_busco = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')"; 
    }

    $sql_tipo_de_usuario = "";
    if($tipo_usuario){
        $sql_tipo_de_usuario = " AND u.rol = '$tipo_usuario'";  
    }

    $sql_fecha_de_registro = "";
    if($fecha){
        $sql_fecha_de_registro = " AND DATE(u.fecha_registro) = '$fecha'";
    }

    $exlcuime_a_mi_mismo = "";
    if($id_admin){
        $exlcuime_a_mi_mismo = " AND u.id_usuario != $id_admin";
    }

    $sql_estado = "";
    if($estado){
        $sql_estado = " AND u.habilitado = '$estado'";
    }

    $sql = "SELECT COUNT(*) as total FROM usuarios u
            WHERE u.nombre != 'Usuario eliminado'
            $sql_lo_que_busco
            $sql_tipo_de_usuario
            $sql_fecha_de_registro
            $exlcuime_a_mi_mismo
            $sql_estado";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN APRA OBTENER A LOS USUARIOS CON SUS DATOS
function obtenerNuevosUsuarios($conexion, $inicio, $registros, $busqueda, $tipo_usuario, $fecha, $estado, $id_admin){
    $sql_lo_que_busco = "";
    if($busqueda){
        $sql_lo_que_busco = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql_tipo_de_usuario = "";
    if($tipo_usuario){
       $sql_tipo_de_usuario = " AND u.rol = '$tipo_usuario'"; 
    }

    $sql_fecha_de_registro = "";
    if($fecha){
        $sql_fecha_de_registro = " AND DATE(u.fecha_registro) = '$fecha'";
    }

    $exlcuime_a_mi_mismo = "";
    if($id_admin){
        $exlcuime_a_mi_mismo = " AND u.id_usuario != $id_admin";
    }

    $sql_estado = "";
    if($estado){
        $sql_estado = " AND u.habilitado = '$estado'";
    }

    $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, u.telefono, u.rol, u.foto_perfil, u.fecha_registro, u.habilitado FROM usuarios u
            WHERE u.nombre != 'Usuario eliminado'
            $sql_lo_que_busco
            $sql_tipo_de_usuario
            $sql_fecha_de_registro
            $exlcuime_a_mi_mismo
            $sql_estado
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