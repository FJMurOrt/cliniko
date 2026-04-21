<?php
//FUNCIÓN PARA OBTENER LOS TURNOS PARA UNA FECHA
function obtenerTurnosPorFecha($conexion, $id_medico, $fecha){
    $sql = "SELECT DISTINCT turno FROM disponibilidad_medicos 
            WHERE id_medico = ? AND fecha = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return [];
    }

    mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $fecha);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $turnos = [];

    while($fila = mysqli_fetch_assoc($resultado)){
        $turnos[] = ucfirst(strtolower($fila["turno"]));
    }

    mysqli_stmt_close($sql_preparacion);

    return $turnos;
}
?>