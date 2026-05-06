<?php
function contarRecetasAdmin($conexion, $busqueda_paciente, $busqueda_medico, $fecha){
    $buscar_paciente = "";
    if($busqueda_paciente){
        $buscar_paciente = " AND (u_p.nombre LIKE '%$busqueda_paciente%' OR u_p.apellidos LIKE '%$busqueda_paciente%')";
    }

    $buscar_medico = "";
    if($busqueda_medico){
        $buscar_medico = " AND (u_m.nombre LIKE '%$busqueda_medico%' OR u_m.apellidos LIKE '%$busqueda_medico%')"; 
    }

    $fecha_de_subida = "";
    if($fecha){
        $fecha_de_subida = " AND DATE(r.fecha_creacion) = '$fecha'";
    }

    $sql = "SELECT COUNT(*) as total FROM recetas r
            INNER JOIN citas c ON r.id_cita = c.id_cita
            INNER JOIN usuarios u_p ON c.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON c.id_medico = u_m.id_usuario
            WHERE r.id_receta IS NOT NULL
            $buscar_paciente
            $buscar_medico
            $fecha_de_subida";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LAS RECETAS
function obtenerRecetasAdmin($conexion, $inicio, $registros, $busqueda_paciente, $busqueda_medico, $fecha){
    $buscar_paciente = "";
    if($busqueda_paciente) $buscar_paciente = " AND (u_p.nombre LIKE '%$busqueda_paciente%' OR u_p.apellidos LIKE '%$busqueda_paciente%')";

    $buscar_medico = "";
    if($busqueda_medico) $buscar_medico = " AND (u_m.nombre LIKE '%$busqueda_medico%' OR u_m.apellidos LIKE '%$busqueda_medico%')";

    $fecha_de_subida = "";
    if($fecha){
        $fecha_de_subida = " AND DATE(r.fecha_creacion) = '$fecha'";
    }

    $sql = "SELECT r.id_receta, r.archivo_pdf, r.fecha_creacion, c.fecha_cita,
            u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM recetas r
            INNER JOIN citas c ON r.id_cita = c.id_cita
            INNER JOIN usuarios u_p ON c.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON c.id_medico = u_m.id_usuario
            WHERE r.id_receta IS NOT NULL
            $buscar_paciente
            $buscar_medico
            $fecha_de_subida
            ORDER BY r.fecha_creacion DESC
            LIMIT ? OFFSET ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $registros, $inicio);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $recetas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $recetas[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $recetas;
}

//FUNCIÓN PARA ELIMINAR LA RECETA
function eliminarRecetaAdmin($conexion, $id_receta){
    $sql = "DELETE FROM recetas WHERE id_receta = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_receta);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//FUNCIÓN PARA OBTENER EL ID DEL MEDICO DE LA RECETA ANTES DE ELIMINARLO PARA INSERTAR UNA NOTIFICACIÓN
function obtenerIdMedicoReceta($conexion, $id_receta){
    $sql = "SELECT c.id_medico FROM recetas r
            INNER JOIN citas c ON r.id_cita = c.id_cita
            WHERE r.id_receta = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_receta);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);
    
    return $fila["id_medico"];
}
?>