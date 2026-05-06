<?php
//FUNCIÓN PARA CONTAR EL TOTAL DE DISPONIBILDIADES QUE HAY
function obtenerTotalDisponibilidad($conexion, $id_medico, $fecha, $turno){
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

    $sql = "SELECT COUNT(*) AS total FROM disponibilidad_medicos
            WHERE id_medico = ?
            $filtro_fecha
            $filtro_turno";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_bind_result($sql_preparacion, $total);

    mysqli_stmt_fetch($sql_preparacion);

    mysqli_stmt_close($sql_preparacion);

    return $total;
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LA DISPOBIBILDIAD
function obtenerDisponibilidad($conexion, $id_medico, $inicio, $registros, $fecha, $turno){
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

    $sql = "SELECT fecha, turno, hora_inicio, hora_fin FROM disponibilidad_medicos
            WHERE id_medico = ?
            $filtro_fecha
            $filtro_turno
            ORDER BY fecha DESC
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iii", $id_medico, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);
    
    $disponibilidad = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

    mysqli_stmt_close($sql_preparacion);

    return $disponibilidad;
}
?>