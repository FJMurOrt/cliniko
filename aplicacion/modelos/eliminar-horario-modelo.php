<?php
//FUNCIÓN PARA OBTENER EL HORARIO AL QUE SE VA A ACCEDER Y QUERER ELIMINAR
function obtenerHorario($conexion, $id_disponibilidad, $id_medico){
    $sql = "SELECT fecha, hora_inicio, hora_fin 
            FROM disponibilidad_medicos 
            WHERE id_disponibilidad = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_disponibilidad, $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $horario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $horario;
}

function contarCitasEnHorario($conexion, $id_medico, $fecha, $hora_inicio, $hora_fin){
    $sql = "SELECT COUNT(*) as total FROM citas 
            WHERE id_medico = ? 
            AND DATE(fecha_cita) = ? 
            AND TIME(fecha_cita) BETWEEN ? AND ?
            AND estado NOT IN ('cancelada', 'no_atendida', 'realizada')";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "isss", $id_medico, $fecha, $hora_inicio, $hora_fin);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $total = mysqli_fetch_assoc($resultado)["total"];

    mysqli_stmt_close($sql_preparacion);

    return $total;
}

//PARA FINALMENTE ELIMINAR EL HORARIO
function eliminarHorario($conexion, $id_disponibilidad){
    $sql = "DELETE FROM disponibilidad_medicos WHERE id_disponibilidad = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_disponibilidad);
    mysqli_stmt_execute($sql_preparacion);
    $eliminada = mysqli_stmt_affected_rows($sql_preparacion) > 0;

    mysqli_stmt_close($sql_preparacion);

    return $eliminada;
}
?>