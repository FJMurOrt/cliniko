<?php
//PARA CANCELAR LAS CITAS PENDIENTES DE CONFIRMACIÓN QUE NO SE HAN CONFIRMADO Y YA HA PASADO LA FECHA
function cancelarCitasPendientes($conexion){
    // OBTENEMOS LAS CITAS Y EL CORREO DEL MÉDICO
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

    $api = "CLAVE QUE NO PUEDO SUBIR A GITHUB";
    $url_brevo = "https://api.brevo.com/v3/smtp/email";

    foreach($citas_a_cancelar as $cita){
        $fecha_formato = date("d/m/Y", strtotime($cita["fecha_cita"]));
        $hora_formato = date("H:i", strtotime($cita["fecha_cita"]));

        //INSERTO LA NOTIFICACIÓN
        $mensaje = "Tu cita del ".$fecha_formato." a las ".$hora_formato." fue cancelada por falta de confirmación.";

        $sql_de_la_notificacion = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'cita_cancelada', ?)";

        $preparacion_notificacion = mysqli_prepare($conexion, $sql_de_la_notificacion);
        mysqli_stmt_bind_param($preparacion_notificacion, "is", $cita["id_medico"], $mensaje);
        mysqli_stmt_execute($preparacion_notificacion);

        mysqli_stmt_close($preparacion_notificacion);

        //ENVIO EL CORREO AL MEDICO DE LA CITA CANCELADA PORQUE NO HA CONFIRMADO
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

//PARA CONTAR LAS CITAS PENDIENTES
function contarCitasPendientes($conexion, $id_medico, $fecha = null, $turno = null, $busqueda = null){
    $sqlbusqueda = "";
    if($busqueda){
       $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')"; 
    } 

    if($fecha && $turno){
        $sql = "SELECT COUNT(*) AS total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'
                AND DATE(c.fecha_cita) = ?";

        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
        }
        $sql .= $sqlbusqueda;

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "is", $id_medico, $fecha);
    }else if($fecha){
        $sql = "SELECT COUNT(*) AS total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'
                AND DATE(c.fecha_cita) = ?";

        $sql .= $sqlbusqueda;
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "is", $id_medico, $fecha);
    }else if($turno){
    $sql = "SELECT COUNT(*) AS total FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'pendiente'";

        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
        }else if($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
        }

        $sql .= $sqlbusqueda;
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
    }else{
        $sql = "SELECT COUNT(*) AS total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'";

        $sql .= $sqlbusqueda;
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
    }
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//PARA OBENTER LAS CITAS
function obtenerCitasPendientes($conexion, $id_medico, $inicio, $registros, $fecha = null, $turno = null, $busqueda = null, $orden = null){
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

    if ($fecha && $turno) {
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'
                AND DATE(c.fecha_cita) = ?
                $sqlbusqueda";

        if($turno === "mañana"){
            $sql .= " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
        }else if ($turno === "tarde"){
            $sql .= " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
        }

        $sql .= " ".$sqlorden." LIMIT ? OFFSET ?";
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isii", $id_medico, $fecha, $registros, $inicio);

    }else if($fecha){
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'
                AND DATE(c.fecha_cita) = ?
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isii", $id_medico, $fecha, $registros, $inicio);
    }else if($turno){
    $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE c.id_medico = ? AND c.estado = 'pendiente'
            $sqlbusqueda";

    if($turno === "mañana"){
        $sql .= " AND TIME(c.fecha_cita) >= '09:00:00' AND TIME(c.fecha_cita) < '15:00:00'";
    }else if($turno === "tarde"){
        $sql .= " AND TIME(c.fecha_cita) >= '15:00:00' AND TIME(c.fecha_cita) <= '20:00:00'";
    }

    $sql .= " ".$sqlorden." LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
    }else{
        $sql = "SELECT c.id_cita, c.motivo, c.fecha_cita, u.nombre, u.apellidos FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                WHERE c.id_medico = ? AND c.estado = 'pendiente'
                $sqlbusqueda
                $sqlorden
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
    }
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);
    
    //ARRAY DE CITAS
    $citas = [];
    while ($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);

    return $citas;
}
?>