<?php
require_once "../configuracion/config.php";

function contarCitasConfirmadas($conexion, $id_medico, $fecha = null, $turno = null, $busqueda = null){
    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    } 

    if($fecha && $turno){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND DATE(c.fecha_cita) = ?
                AND ((TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00' AND ?='mañana')
                    OR
                    (TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00' AND ?='tarde'))
                $sqlbusqueda";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isss", $id_medico, $fecha, $turno, $turno);
    }elseif($fecha){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND DATE(c.fecha_cita) = ?
                $sqlbusqueda";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $fecha);
    }elseif($turno){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND ((TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00' AND ?='mañana')
                    OR
                    (TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00' AND ?='tarde'))
                $sqlbusqueda";
                
        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iss", $id_medico, $turno, $turno);
    }else{
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                $sqlbusqueda";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    }
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($sql_preparacion);

    return $fila['total'];
}

function obtenerCitasConfirmadas($conexion, $id_medico, $inicio, $registros, $fecha = null, $turno = null, $busqueda = null, $orden = null){
    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sqlorden = "ORDER BY c.fecha_cita ASC";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }
    if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }

    if($fecha && $turno){
        $sql = "SELECT c.id_cita, c.id_paciente, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND DATE(c.fecha_cita) = ?
                AND ((TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00' AND ?='mañana')
                    OR
                    (TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00' AND ?='tarde'))
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isssii", $id_medico, $fecha, $turno, $turno, $registros, $inicio);
    }elseif($fecha){
        $sql = "SELECT c.id_cita, c.id_paciente, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND DATE(c.fecha_cita) = ?
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isii", $id_medico, $fecha, $registros, $inicio);
    }elseif ($turno){
        $sql = "SELECT c.id_cita, c.id_paciente, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                AND ((TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00' AND ?='mañana')
                    OR
                    (TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00' AND ?='tarde'))
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "issii", $id_medico, $turno, $turno, $registros, $inicio);
    }else{
        $sql = "SELECT c.id_cita, c.id_paciente, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado='confirmada'
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iii", $id_medico, $registros, $inicio);
    }
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $citas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
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