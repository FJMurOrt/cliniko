<?php
// PARA CONTAR LAS CITAS REALIZADAS
function contarCitasRealizadas($conexion, $id_medico, $fecha, $turno, $busqueda){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND TIME(c.fecha_cita) < '15:00:00'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '15:00:00'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql = "SELECT COUNT(*) as total FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'realizada'
            $filtro_fecha
            $filtro_turno
            $filtro_busqueda";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);

    return $total;
}

// PARA OBTENER LOS DATOS DE LAS CITAS REALIZADAS
function obtenerCitasRealizadas($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND TIME(c.fecha_cita) < '15:00:00'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '15:00:00'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sqlorden = "ORDER BY c.fecha_cita DESC";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }else if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }

    $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'realizada'
            $filtro_fecha
            $filtro_turno
            $filtro_busqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $citas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);
    return $citas;
}
?>