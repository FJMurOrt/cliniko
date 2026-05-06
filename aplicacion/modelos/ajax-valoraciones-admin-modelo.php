<?php
//FUNCIÓN PARA CONTAR LAS VALORACIÓN Y HACER LA PAGINACIÓN
function contarValoracionesAdmin($conexion, $fecha, $puntuacion, $orden, $estado){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(v.fecha) = '$fecha'";
    }

    $filtro_puntuacion = "";
    if($puntuacion){
        $filtro_puntuacion = " AND v.puntuacion = '$puntuacion'";
    }

    $filtro_reportada_no_reportada = "";
    if($estado){
       $filtro_reportada_no_reportada = " AND v.estado = '$estado'"; 
    }

    $sql = "SELECT COUNT(*) as total FROM valoraciones v
            INNER JOIN usuarios p ON v.id_paciente = p.id_usuario
            INNER JOIN usuarios m ON v.id_medico = m.id_usuario
            WHERE v.id_valoracion IS NOT NULL
            $filtro_fecha
            $filtro_puntuacion
            $filtro_reportada_no_reportada";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN APRA OBTENER LOS DATOS DE LAS VALORACIONES
function obtenerValoracionesAdmin($conexion, $inicio, $registros, $fecha, $puntuacion, $orden, $estado){
    $filtro_fecha = "";
    if($fecha){
       $filtro_fecha = " AND DATE(v.fecha) = '$fecha'"; 
    }

    $filtro_puntuacion = "";
    if($puntuacion){
       $filtro_puntuacion = " AND v.puntuacion = '$puntuacion'"; 
    }

    $filtro_reportada_no_reportada = "";
    if($estado){
        $filtro_reportada_no_reportada = " AND v.estado = '$estado'";
    }

    $filtro_ordenar_mejor_peor = "ORDER BY v.fecha DESC";
    if($orden === "mejor"){
        $filtro_ordenar_mejor_peor = "ORDER BY v.puntuacion DESC";
    }
    if($orden === "peor"){
        $filtro_ordenar_mejor_peor = "ORDER BY v.puntuacion ASC";
    }

    $sql = "SELECT v.id_valoracion, v.puntuacion, v.comentario, v.fecha, v.estado,
            p.nombre AS nombre_paciente, p.apellidos AS apellidos_paciente, p.foto_perfil AS foto_paciente,
            m.nombre AS nombre_medico, m.apellidos AS apellidos_medico, m.foto_perfil AS foto_medico FROM valoraciones v
            INNER JOIN usuarios p ON v.id_paciente = p.id_usuario
            INNER JOIN usuarios m ON v.id_medico = m.id_usuario
            WHERE v.id_valoracion IS NOT NULL
            $filtro_fecha
            $filtro_puntuacion
            $filtro_reportada_no_reportada
            $filtro_ordenar_mejor_peor
            LIMIT ? OFFSET ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $registros, $inicio);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $valoraciones;
}

//FUNCIÓN PARA EDITAR LA VALORACIÓN
function editarValoracionAdmin($conexion, $id_valoracion, $comentario){
    $sql = "UPDATE valoraciones SET comentario = ?, estado = 'no_reportada'
            WHERE id_valoracion = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $comentario, $id_valoracion);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//FUNCIÓN PARA ELIMINAR LA VALORACIÓN
function eliminarValoracionAdmin($conexion, $id_valoracion){
    $sql = "DELETE FROM valoraciones WHERE id_valoracion = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_valoracion);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//FUNCIÓN APRA OBTENER LOS DATOS DE LA VALORACIÓN
function obtenerDatosValoracionParaEliminar($conexion, $id_valoracion){
    $sql = "SELECT v.id_paciente, m.nombre, m.apellidos FROM valoraciones v
            INNER JOIN usuarios m ON v.id_medico = m.id_usuario
            WHERE v.id_valoracion = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_valoracion);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}
?>