<?php
// PARA CANCELAR LAS CITAS PENDIENTES QUE NO SE HAN CONFIRMADO Y YA HA PASADO LA FECHA
function cancelarCitasPendientes($conexion){
    $sql_obtener = "SELECT c.id_cita, c.id_medico, c.fecha_cita, u.correo FROM citas c
                    INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                    WHERE c.estado = 'pendiente' AND c.fecha_cita < NOW()";

    $resultado = mysqli_query($conexion, $sql_obtener);

    $citas_a_cancelar = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $citas_a_cancelar[] = $fila;
    }

    $sql = "UPDATE citas SET estado = 'cancelada', notas = 'Cancelada por falta de confirmación' 
            WHERE estado = 'pendiente' AND fecha_cita < NOW()";
    mysqli_query($conexion, $sql);

    $api = "CLAVE_DE_LA_API_BREVO";
    $url_brevo = "https://api.brevo.com/v3/smtp/email";

    foreach($citas_a_cancelar as $cita){
        $fecha_formato = date("d/m/Y", strtotime($cita["fecha_cita"]));
        $hora_formato = date("H:i", strtotime($cita["fecha_cita"]));

        $mensaje = "Tu cita del ".$fecha_formato." a las ".$hora_formato." fue cancelada por falta de confirmación.";

        $sql_notif = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'cita_cancelada', ?)";
        $prep_notif = mysqli_prepare($conexion, $sql_notif);
        mysqli_stmt_bind_param($prep_notif, "is", $cita["id_medico"], $mensaje);
        mysqli_stmt_execute($prep_notif);
        mysqli_stmt_close($prep_notif);

        $asunto = "Cita cancelada por falta de confirmación";
        $mensaje_correo = "<h2>Cita cancelada por falta de confirmación</h2>";
        $mensaje_correo .= "<p>La cita del ".$fecha_formato." a las ".$hora_formato." ha sido cancelada automáticamente por falta de confirmación.</p>";
        $mensaje_correo .= "<p>Saludos cordiales,</p>";
        $mensaje_correo .= "<p>El equipo de Clíniko</p>";

        $correoEmail = [
            "sender" => ["name" => "Clíniko", "email" => "francisco.javier.muriel.orta@ieslaarboleda.es"],
            "to" => [["email" => $cita["correo"]]],
            "subject" => $asunto,
            "htmlContent" => $mensaje_correo
        ];

        $curl = curl_init($url_brevo);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "api-key: $api",
            "Content-Type: application/json",
            "accept: application/json"
        ]);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($correoEmail));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        curl_close($curl);
    }
}

// PARA CONTAR LAS CITAS PENDIENTES
function contarCitasPendientes($conexion, $id_medico, $fecha, $turno, $busqueda){
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

    $sql = "SELECT COUNT(*) AS total FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'pendiente'
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

// PARA OBTENER LAS CITAS
function obtenerCitasPendientes($conexion, $id_medico, $inicio, $registros, $fecha, $turno, $busqueda, $orden){
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

    $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'pendiente'
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