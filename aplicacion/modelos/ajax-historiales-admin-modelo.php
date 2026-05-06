<?php
//FUNCIÓN PARA CONTAR CUANTOS HISTORIALES HAY Y HACER LA PAGINACIÓN
function contarHistorialesAdmin($conexion, $busqueda_paciente, $busqueda_medico, $fecha){
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
       $fecha_de_subida = " AND DATE(h.fecha_registro) = '$fecha'"; 
    }

    $sql = "SELECT COUNT(*) as total FROM historiales_medicos h
            INNER JOIN usuarios u_p ON h.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON h.id_medico = u_m.id_usuario
            WHERE h.id_historial IS NOT NULL
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

//FUNCIÓN PARA OBTENER LOS DATOS DE LOS HISTORIALES
function obtenerHistorialesAdmin($conexion, $inicio, $registros, $busqueda_paciente, $busqueda_medico, $fecha){
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
        $fecha_de_subida = " AND DATE(h.fecha_registro) = '$fecha'";
    }

    $sql = "SELECT h.id_historial, h.archivo_pdf, h.fecha_registro, u_p.nombre AS nombre_paciente, 
            u_p.apellidos AS apellidos_paciente, u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM historiales_medicos h
            INNER JOIN usuarios u_p ON h.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON h.id_medico = u_m.id_usuario
            WHERE h.id_historial IS NOT NULL
            $buscar_paciente
            $buscar_medico
            $fecha_de_subida
            ORDER BY h.fecha_registro DESC
            LIMIT ? OFFSET ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $registros, $inicio);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $historiales = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $historiales[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $historiales;
}

//FUNCIÓN PARA ELIMINAR UN HISTORIAL MÉDICO
function eliminarHistorialAdmin($conexion, $id_historial){
    $sql = "DELETE FROM historiales_medicos WHERE id_historial = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_historial);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//LO MISMO QUE PARA LAS RECETAS, OBTENDO EL ID DEL MEDICO ANTES DE ELIMINAR EL HSITORIAL APRA PODER INSERTARLE UNA NOTIFICACIÓN
function obtenerIdMedicoHistorial($conexion, $id_historial){
    $sql = "SELECT id_medico FROM historiales_medicos WHERE id_historial = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_historial);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["id_medico"];
}
?>