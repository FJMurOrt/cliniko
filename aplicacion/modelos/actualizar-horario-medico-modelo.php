<?php
//FUNCIÓN PARA OBTENER LA DISPOINIBILDIAD QUE VAMOS A ACTUALIZAR
function obtenerDisponibilidad($conexion, $id_disponibilidad, $id_medico){
    $sql = "SELECT * FROM disponibilidad_medicos 
            WHERE id_disponibilidad = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_disponibilidad, $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $fila;
}

//PARA VER SI HAY CITAS QUE SE QUEDEN FUERA DEL HORARIO NUEVO
function contarCitasFueraHorario($conexion, $id_medico, $fecha, $hora_inicio, $hora_fin){
    $sql = "SELECT COUNT(*) as total FROM citas 
            WHERE id_medico = ? 
            AND DATE(fecha_cita) = ? 
            AND estado NOT IN ('cancelada', 'no_atendida', 'realizada')
            AND (TIME(fecha_cita) < ? OR TIME(fecha_cita) >= ?)";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "isss", $id_medico, $fecha, $hora_inicio, $hora_fin);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $fila["total"];
}

//PARA ACTUALIZAR LA DISPONIBILIDAD EN LA TABLA
function actualizarDisponibilidad($conexion, $hora_inicio, $hora_fin, $id_disponibilidad){
    $sql = "UPDATE disponibilidad_medicos SET hora_inicio = ?, hora_fin = ? 
            WHERE id_disponibilidad = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ssi", $hora_inicio, $hora_fin, $id_disponibilidad);
    $actualizado = mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $actualizado;
}
?>