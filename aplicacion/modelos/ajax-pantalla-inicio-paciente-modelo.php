<?php
//FUNCIÓN PARA SABER CUÁL ES LA PRÓXIMA CITA
function obtenerProximaCita($conexion, $id_paciente){
    $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            WHERE c.id_paciente = ? AND c.estado = 'confirmada'
            AND c.fecha_cita >= NOW()
            ORDER BY c.fecha_cita ASC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER LAS NOTIFICACIONES QUE HAYA NO LEÍDAS
function obtenerNotificacionesNoLeidas($conexion, $id_paciente){
    $sql = "SELECT id_notificacion, mensaje, fecha FROM notificaciones
            WHERE id_usuario = ? AND leida = 'no'
            ORDER BY fecha DESC
            LIMIT 3";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $notificaciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $notificaciones[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $notificaciones;
}

//FUNCIÓN PARA SABER EL MÉDICO DE LA ÚLTIMA CITA QUE TUVO EL PACIENTE
function obtenerUltimoMedico($conexion, $id_paciente){
    $sql = "SELECT u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_paciente = ? AND c.estado = 'realizada'
            ORDER BY c.fecha_cita DESC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER CON QUE MÉDICO ES CON EL QUE MÁS CITAS HA LLEGADO A TENER
function obtenerMedicoHabitual($conexion, $id_paciente){
    $sql = "SELECT u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, COUNT(c.id_cita) as total FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE c.id_paciente = ? AND c.estado = 'realizada'
            GROUP BY c.id_medico
            ORDER BY total DESC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER LA ÚLTIMA RECETA QUE SE LA HA SUBIDO AL PACIENTE
function obtenerUltimaReceta($conexion, $id_paciente){
    $sql = "SELECT r.archivo_pdf, r.fecha_creacion, u.nombre, u.apellidos FROM recetas r
            INNER JOIN citas c ON r.id_cita = c.id_cita
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            WHERE c.id_paciente = ?
            ORDER BY r.fecha_creacion DESC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER EL ÚLTIMO HISTORIAL SUBIDO
function obtenerUltimoHistorial($conexion, $id_paciente){
    $sql = "SELECT h.archivo_pdf, h.fecha_registro, u.nombre, u.apellidos FROM historiales_medicos h
            INNER JOIN usuarios u ON h.id_medico = u.id_usuario
            WHERE h.id_paciente = ?
            ORDER BY h.fecha_registro DESC
            LIMIT 1";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);
    
    mysqli_stmt_close($preparacion);

    return $fila;
}

//FUNCIÓN PARA SABER EL TOTAL DE CITAS REALIZADAS DEL PACIENTE
function obtenerTotalCitasRealizadas($conexion, $id_paciente){
    $sql = "SELECT COUNT(*) as total FROM citas
            WHERE id_paciente = ? AND estado = 'realizada'";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA SABER LAS ÚLTIMAS VALORACIONES QUE HA HECHO EL PACIENTE
function obtenerUltimasValoraciones($conexion, $id_paciente){
    $sql = "SELECT v.puntuacion, v.comentario, u.nombre, u.apellidos FROM valoraciones v
            INNER JOIN usuarios u ON v.id_medico = u.id_usuario
            WHERE v.id_paciente = ?
            ORDER BY v.fecha DESC
            LIMIT 3";
            
    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }
    mysqli_stmt_close($preparacion);

    return $valoraciones;
}
?>