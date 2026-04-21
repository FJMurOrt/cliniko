<?php
//PARA VERIFICAR SI HAY UNA RESEÑA DEL PACIENTE PARA UN MEDICO
function existe_valoracion($conexion, $id_paciente, $id_medico){
    $sql = "SELECT id_valoracion FROM valoraciones WHERE id_paciente = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_paciente, $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_store_result($sql_preparacion);
    $existe = mysqli_stmt_num_rows($sql_preparacion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $existe;
}

//PARA INSERTAR UNA NUEVA RESEÑA
function insertar_valoracion($conexion, $id_paciente, $id_medico, $puntuacion, $comentario){
    $sql = "INSERT INTO valoraciones (id_paciente, id_medico, puntuacion, comentario, fecha) VALUES (?, ?, ?, ?, NOW())";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iiis", $id_paciente, $id_medico, $puntuacion, $comentario);
    mysqli_stmt_execute($sql_preparacion);
    $ok = mysqli_affected_rows($conexion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $ok;
}

//PARA VERIFICAR QUE EL PACIENTE PUEDE EDITAR O ELIMINAR LA VALORACIÓN
function valoracion_pertenece($conexion, $id_valoracion, $id_paciente){
    $sql = "SELECT id_valoracion FROM valoraciones WHERE id_valoracion = ? AND id_paciente = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_valoracion, $id_paciente);
    mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_store_result($sql_preparacion);
    $pertenece = mysqli_stmt_num_rows($sql_preparacion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $pertenece;
}

//ACTUALIZAR LA VALORACIÓN
function actualizar_valoracion($conexion, $id_valoracion, $puntuacion, $comentario){
    $sql = "UPDATE valoraciones SET puntuacion = ?, comentario = ?, fecha = NOW() WHERE id_valoracion = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "isi", $puntuacion, $comentario, $id_valoracion);
    mysqli_stmt_execute($sql_preparacion);
    $ok = mysqli_affected_rows($conexion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $ok;
}

//PARA ELIMINAR LA VALORACIÓN
function eliminar_valoracion($conexion, $id_valoracion){
    $sql = "DELETE FROM valoraciones WHERE id_valoracion = ?";
    
    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_valoracion);
    mysqli_stmt_execute($sql_preparacion);
    $ok = mysqli_affected_rows($conexion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $ok;
}

//PARA VERIFICAR SI EL PACIENTE PUEDE VALORAR AL MÉDICO
function paciente_puede_valorar($conexion, $id_paciente, $id_medico){
    $sql = "SELECT id_cita FROM citas WHERE id_paciente = ? AND id_medico = ? AND estado = 'realizada' LIMIT 1";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_paciente, $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_store_result($sql_preparacion);
    $puede = mysqli_stmt_num_rows($sql_preparacion) > 0;
    mysqli_stmt_close($sql_preparacion);
    return $puede;
}
?>