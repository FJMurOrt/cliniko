<?php
//FUNCIÓN PARA CONTAR LAS CITAS PARA LA PAGINACIÓN
function contarCitasConfirmadas($conexion, $id_medico, $fecha, $turno, $busqueda){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql = "SELECT COUNT(*) as total FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado='confirmada'
            $filtro_fecha
            $filtro_turno
            $filtro_busqueda";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($sql_preparacion);

    return $fila['total'];
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LAS CITAS
function obtenerCitasConfirmadas($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
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

    $sql = "SELECT c.id_cita, c.id_paciente, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado='confirmada'
            $filtro_fecha
            $filtro_turno
            $filtro_busqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iii", $id_medico, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $citas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $fecha_y_hora = explode(" ", $fila["fecha_cita"]);
        $citas[] = [
            "id_cita" => $fila["id_cita"],
            "id_paciente" => $fila["id_paciente"],
            "nombre" => $fila["nombre"],
            "apellidos" => $fila["apellidos"],
            "fecha" => $fecha_y_hora[0],
            "hora" => $fecha_y_hora[1],
            "motivo" => $fila["motivo"]
        ];
    }

    mysqli_stmt_close($sql_preparacion);
    return $citas;
}
?>