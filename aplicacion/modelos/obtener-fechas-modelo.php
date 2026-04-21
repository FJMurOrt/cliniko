<?php
//FUINCIÓN APRA OBTENER LAS FECHAS DE DISPONIBILIAD QUE TIENE EL MÉDICO
function obtenerFechasDisponibilidad($conexion, $id_medico){
    $hoy = date("Y-m-d");

    $sql = "SELECT DISTINCT fecha FROM disponibilidad_medicos 
            WHERE id_medico = ? AND fecha >= ? 
            ORDER BY fecha ASC";

    $sql_preparacion = mysqli_prepare($conexion, $sql);

    if(!$sql_preparacion){
        return [];
    }

    mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $hoy);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $fechas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $fechas[] = $fila["fecha"];
    }

    mysqli_stmt_close($sql_preparacion);

    return $fechas;
}
?>