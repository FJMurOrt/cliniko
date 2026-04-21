<?php
//FUNCIÓN PARA CONTRAR LAS CITAS DEL PACIENTE
function contarCitasPaciente($conexion, $id_paciente, $fecha = null, $estado = null){
    if($fecha && $estado){
        $sql = "SELECT COUNT(*) as total FROM citas c 
                WHERE c.id_paciente = ? 
                AND DATE(c.fecha_cita) = ? 
                AND c.estado = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iss", $id_paciente, $fecha, $estado);
    }elseif($fecha){
        $sql = "SELECT COUNT(*) as total FROM citas c 
                WHERE c.id_paciente = ? 
                AND DATE(c.fecha_cita) = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "is", $id_paciente, $fecha);
    }elseif($estado){
        $sql = "SELECT COUNT(*) as total FROM citas c 
                WHERE c.id_paciente = ? 
                AND c.estado = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "is", $id_paciente, $estado);
    }else{
        $sql = "SELECT COUNT(*) as total FROM citas c 
                WHERE c.id_paciente = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "i", $id_paciente);
    }

    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($sql_preparacion);

    return $fila['total'];
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LAS CITAS
function obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha = null, $estado = null, $orden = null, $turno = null){
    $order_sql = " ORDER BY c.fecha_cita ASC";
    if($orden === "asc"){
        $order_sql = " ORDER BY u.nombre ASC, u.apellidos ASC";
    }elseif($orden === "desc"){
        $order_sql = " ORDER BY u.nombre DESC, u.apellidos DESC";
    }
    
    $turno_sql = "";
    if($turno === "mañana"){
        $turno_sql = " AND TIME(c.fecha_cita) BETWEEN '08:00:00' AND '14:00:00'";
    } elseif($turno === "tarde"){
        $turno_sql = " AND TIME(c.fecha_cita) BETWEEN '14:00:01' AND '20:00:00'";
    }

    if($fecha && $estado){
        $sql = "SELECT c.id_cita, c.id_medico, c.motivo, c.fecha_cita, u.nombre, u.apellidos, c.estado 
                FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                WHERE c.id_paciente = ? AND DATE(c.fecha_cita) = ? AND c.estado = ?
                $turno_sql
                $order_sql
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "issii", $id_paciente, $fecha, $estado, $registros, $inicio);
    }elseif($fecha){
        $sql = "SELECT c.id_cita, c.id_medico, c.motivo, c.fecha_cita, u.nombre, u.apellidos, c.estado 
                FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                WHERE c.id_paciente = ? AND DATE(c.fecha_cita) = ?
                $turno_sql
                $order_sql
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isii", $id_paciente, $fecha, $registros, $inicio);
    }elseif($estado){
        $sql = "SELECT c.id_cita, c.id_medico, c.motivo, c.fecha_cita, u.nombre, u.apellidos, c.estado 
                FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                WHERE c.id_paciente = ? AND c.estado = ?
                $turno_sql
                $order_sql
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isii", $id_paciente, $estado, $registros, $inicio);
    }else{
        $sql = "SELECT c.id_cita, c.id_medico, c.motivo, c.fecha_cita, u.nombre, u.apellidos, c.estado 
                FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                WHERE c.id_paciente = ?
                $turno_sql
                $order_sql
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iii", $id_paciente, $registros, $inicio);
    }

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