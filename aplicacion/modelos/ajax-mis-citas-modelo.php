<?php
function contarCitasPaciente($conexion, $id_paciente, $fecha, $estado){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_estado = "";
    if($estado){
        $filtro_estado = " AND c.estado = '$estado'";
    }

    $sql = "SELECT COUNT(*) as total FROM citas c
            WHERE c.id_paciente = ?
            $filtro_fecha
            $filtro_estado";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_paciente);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $fila['total'];
}

function obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha, $estado, $orden, $turno){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_estado = "";
    if($estado){
        $filtro_estado = " AND c.estado = '$estado'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND TIME(c.fecha_cita) BETWEEN '08:00:00' AND '14:00:00'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND TIME(c.fecha_cita) BETWEEN '14:00:01' AND '20:00:00'";
    }

    $sqlorden = " ORDER BY c.fecha_cita DESC";
    if($orden === "asc"){
        $sqlorden = " ORDER BY u.nombre ASC, u.apellidos ASC";
    }else if($orden === "desc"){
        $sqlorden = " ORDER BY u.nombre DESC, u.apellidos DESC";
    }

    $sql = "SELECT c.id_cita, c.id_medico, c.motivo, c.fecha_cita, u.nombre, u.apellidos, c.estado FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            WHERE c.id_paciente = ?
            $filtro_fecha
            $filtro_estado
            $filtro_turno
            $sqlorden
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iii", $id_paciente, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $citas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $fecha_y_hora = explode(" ", $fila["fecha_cita"]);
        $citas[] = [
            "id_cita" => $fila["id_cita"],
            "nombre" => $fila["nombre"],
            "apellidos" => $fila["apellidos"],
            "fecha" => $fecha_y_hora[0],
            "hora" => $fecha_y_hora[1],
            "motivo" => $fila["motivo"],
            "estado" => $fila["estado"]
        ];
    }

    mysqli_stmt_close($sql_preparacion);
    return $citas;
}
?>