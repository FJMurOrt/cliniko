<?php
require_once "../configuracion/config.php";

//TOTAL DE REGISTROS PARA LA DISPONIBILIDAD
function obtenerTotalDisponibilidad($conexion, $id_medico, $fecha = null){
    if($fecha){
        $sql = "SELECT COUNT(*) AS total FROM disponibilidad_medicos WHERE id_medico = ? AND fecha = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $fecha);
    }else{
        $sql = "SELECT COUNT(*) AS total FROM disponibilidad_medicos WHERE id_medico = ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    }

    mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_bind_result($sql_preparacion, $total);
    mysqli_stmt_fetch($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $total;
}

//PARA OBTENER LA DISPONIBILDIADES
function obtenerDisponibilidad($conexion, $id_medico, $inicio, $registros, $fecha = null){
    if($fecha){
        $sql = "SELECT fecha, turno, hora_inicio, hora_fin FROM disponibilidad_medicos 
                WHERE id_medico = ? AND fecha = ? 
                ORDER BY fecha ASC 
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "isii", $id_medico, $fecha, $registros, $inicio);
    }else{
        $sql = "SELECT fecha, turno, hora_inicio, hora_fin FROM disponibilidad_medicos 
                WHERE id_medico = ? 
                ORDER BY fecha ASC 
                LIMIT ? OFFSET ?";
                
        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iii", $id_medico, $registros, $inicio);
    }

    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $disponibilidad = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($sql_preparacion);

    return $disponibilidad;
}
?>