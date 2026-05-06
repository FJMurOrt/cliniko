<?php
//FUNCIÓN PARA CONTAR LOS HORAROS Y HACER LA PAGINACIÓN
function contarHorariosMedico($conexion, $id_medico, $fecha, $turno){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND fecha = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND turno = 'mañana'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND turno = 'tarde'";
    }

    $sql = "SELECT COUNT(*) as total FROM disponibilidad_medicos
            WHERE id_medico = ?
            $filtro_fecha
            $filtro_turno";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $fila["total"];
}

//PARA OBTENER LOS DATOS DE LOS HORARIOS
function obtenerHorariosMedico($conexion, $id_medico, $inicio, $registros, $fecha, $turno){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND fecha = '$fecha'";
    }

    $filtro_turno = "";
    if($turno === "mañana"){
        $filtro_turno = " AND turno = 'mañana'";
    }else if($turno === "tarde"){
        $filtro_turno = " AND turno = 'tarde'";
    }

    $sql = "SELECT id_disponibilidad, fecha, turno, hora_inicio, hora_fin FROM disponibilidad_medicos
            WHERE id_medico = ?
            $filtro_fecha
            $filtro_turno
            ORDER BY fecha DESC, turno DESC
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iii", $id_medico, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $horarios = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $horarios[] = $fila;
    }

    mysqli_stmt_close($sql_preparacion);

    return $horarios;
}
?>