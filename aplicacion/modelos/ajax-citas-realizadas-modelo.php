<?php
require_once "../configuracion/config.php";

//PARA CONTAR LAS CITAS REALIZADAS
function contarCitasRealizadas($conexion, $id_medico, $fecha = null, $turno = null, $busqueda = null, $receta = null, $observaciones = null){
    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    } 

    if($fecha && $turno){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?";

        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00'";
        }
        $sql .= $sqlbusqueda;

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "is", $id_medico, $fecha);
    }else if($turno){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'";
        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00'";
        }
        $sql .= $sqlbusqueda;

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
    }else{
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'
                $sqlbusqueda";
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
    }

    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);
    return $total;
}

//PARA OBTENER LOS DATOS DE LAS CITAS REALIZADAS
function obtenerCitasRealizadas($conexion, $id_medico, $inicio, $registros, $fecha = null, $turno = null, $busqueda = null, $orden = null, $receta = null, $observaciones = null){
    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sqlorden = "ORDER BY c.fecha_cita DESC";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }
    if($orden === "desc"){
       $sqlorden = "ORDER BY u.apellidos DESC";
    }

    if($fecha && $turno){
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?";


        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00'";
        }
        $sql .= $sqlbusqueda;
        $sql .= " ".$sqlorden." LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isii", $id_medico, $fecha, $registros, $inicio);
    }else if($fecha){
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                $sqlbusqueda
                $sqlorden 
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isii", $id_medico, $fecha, $registros, $inicio);
     }else if($turno){
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'";
                
        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00'";
        }
        $sql .= $sqlbusqueda;
        $sql .= " ".$sqlorden." LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
    }else{
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos
                FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'realizada'
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
    }

    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);
    $citas = [];
    while ($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }
    mysqli_stmt_close($preparacion_sql);
    return $citas;
}
?>