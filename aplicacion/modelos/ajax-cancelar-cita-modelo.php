<?php
require_once "../configuracion/config.php";

function cancelarCita($conexion, $id_cita, $id_paciente) {
    $sql = "UPDATE citas SET estado = 'cancelada' 
            WHERE id_cita = ? 
            AND id_paciente = ? 
            AND (estado = 'pendiente' OR estado = 'confirmada')";

    $sql_preparacion = mysqli_prepare($conexion, $sql);

    if($sql_preparacion){
        mysqli_stmt_bind_param($sql_preparacion, "ii", $id_cita, $id_paciente);
        mysqli_stmt_execute($sql_preparacion);
        $filas_afectadas = mysqli_stmt_affected_rows($sql_preparacion);
        mysqli_stmt_close($sql_preparacion);

        if($filas_afectadas > 0){
            return true;
        }
    }
    return false;
}

//FUNCIÓN APRA COGER LOS DATOS DE LA CITA PARA PODER MOSTRAR LA INFORMACIÓN EN LA NOTIFIACIÓN
function obtenerDatosCitaParaNotificacion($conexion, $id_cita){
    $sql = "SELECT c.id_medico, c.fecha_cita, u.nombre, u.apellidos FROM citas c
            INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
            WHERE c.id_cita = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_cita);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}

//Y LUEGO YA LA INSERTO
function insertarNotificacionMedico($conexion, $id_medico, $mensaje){
    $sql = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, 'cita_cancelada', ?)";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "is", $id_medico, $mensaje);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);
}

//FUNCIÓN PARA OBTENER EL CORREO DEL MÉDICO PARA PODER ENVIARLE EL CORREO DESPUÉS DE CANCELAR LA CITA
function obtenerCorreoMedico($conexion, $id_medico){
    $sql = "SELECT correo FROM usuarios WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["correo"];
}
?>