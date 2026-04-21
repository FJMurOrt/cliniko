<?php
//FUNCIÓN PARA ELIMINAR LA NOTA CON EL ID DE LA CITA QUE TENIAMOS
function eliminarNotaPorCita($conexion, $id_cita){
    $sql = "DELETE FROM notas WHERE id_cita = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_cita);
    mysqli_stmt_execute($sql_preparacion);

    $filas_afectadas = mysqli_stmt_affected_rows($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $filas_afectadas > 0;
}
?>