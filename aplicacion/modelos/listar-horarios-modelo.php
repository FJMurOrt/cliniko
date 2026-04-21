<?php
//FUNCIÓN PARA OBTENER LOS HORARIOS
function obtenerHorariosMedico($conexion, $id_medico, $fecha = null){
    $sql = "SELECT * FROM disponibilidad_medicos WHERE id_medico = ?";

    if($fecha){
        $sql .= " AND fecha = ?";
    }

    $sql .= " ORDER BY fecha ASC, turno ASC";
    $sql_preparacion = mysqli_prepare($conexion, $sql);

    if($fecha){
        mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $fecha);
    }else{
        mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    }

    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $horarios = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    mysqli_stmt_close($sql_preparacion);
    return $horarios;
}
?>