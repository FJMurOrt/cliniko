<?php
function actualizarEstadoCita($conexion, $id_cita, $id_medico, $nuevo_estado){
    if($nuevo_estado !== "realizada" && $nuevo_estado !== "no_atendida"){
        return false;
    }

    $sql = "UPDATE citas SET estado = ? 
            WHERE id_cita = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);

    if($sql_preparacion){
        mysqli_stmt_bind_param($sql_preparacion, "sii", $nuevo_estado, $id_cita, $id_medico);
        mysqli_stmt_execute($sql_preparacion);

        $filas_afectadas = mysqli_stmt_affected_rows($sql_preparacion);

        mysqli_stmt_close($sql_preparacion);

        if($filas_afectadas > 0){
            return true;
        }
    }
    return false;
}
?>