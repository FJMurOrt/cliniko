<?php
//FUNCIÓN PARA PODER SABER LA SIGUINETE CITA QUE LE TOCA ATENDER, ES DECIR, LA SIGUIENTE CITA CONFIRMADA
function obtenerProximaCitaMedico($conexion, $id_medico){
    $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil FROM citas c
            INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'confirmada'
            AND c.fecha_cita >= NOW()
            ORDER BY c.fecha_cita ASC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER CUANTÁS CITAS HA ATENDIDO EN LA FECHA DE ACTUAL
function obtenerCitasHoy($conexion, $id_medico){
    $sql = "SELECT COUNT(*) as total FROM citas
            WHERE id_medico = ? AND estado = 'realizada'
            AND DATE(fecha_cita) = CURDATE()";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA SABER CUANTAS CITAS TIENE POR CONFIRMAR
function obtenerCitasPendientesMedico($conexion, $id_medico){
    $sql = "SELECT COUNT(*) as total FROM citas
            WHERE id_medico = ? AND estado = 'pendiente'";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA SABER A CUANTAS PACIENTES EN TOTAL HA ATENDIDO SIN CONTAR REPETIDOS CLARO
function obtenerTotalPacientesMedico($conexion, $id_medico){
    $sql = "SELECT COUNT(DISTINCT id_paciente) as total FROM citas
            WHERE id_medico = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA SABER QUIÉN FUE EL ÚLTIMO PACIENTE AL QUE ATENDIÓ
function obtenerUltimoPaciente($conexion, $id_medico){
    $sql = "SELECT u.nombre, u.apellidos, u.foto_perfil, c.fecha_cita FROM citas c
            INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'realizada'
            ORDER BY c.fecha_cita DESC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER LA PUNTUACIÓN MEDIA QUE TIENE DE LAS VALORACIONES
function obtenerPuntuacionMedia($conexion, $id_medico){
    $sql = "SELECT ROUND(AVG(puntuacion), 1) as media FROM valoraciones
            WHERE id_medico = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["media"];
}

//PARA SABER CUANTAS VALORACIONES EN TOTAL LE HAN HECHO
function obtenerUltimasValoracionesMedico($conexion, $id_medico){
    $sql = "SELECT v.puntuacion, v.comentario, u.nombre, u.apellidos FROM valoraciones v
            INNER JOIN usuarios u ON v.id_paciente = u.id_usuario
            WHERE v.id_medico = ?
            ORDER BY v.fecha DESC
            LIMIT 3";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $valoraciones;
}

//Y PARA MOSTRAR SI TIENE NOTIFIACIONES NO LEÍDAS
function obtenerNotificacionesNoLeidasMedico($conexion, $id_medico){
    $sql = "SELECT mensaje, fecha FROM notificaciones
            WHERE id_usuario = ? AND leida = 'no'
            ORDER BY fecha DESC
            LIMIT 3";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $notificaciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $notificaciones[] = $fila;
    }
    
    mysqli_stmt_close($preparacion);

    return $notificaciones;
}
?>