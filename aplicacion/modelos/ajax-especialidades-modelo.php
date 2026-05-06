<?php
//FUNCIÓN PARA CARGAR LAS ESPECIALIDADES
function obtenerEspecialidades($conexion){
    $sql = "SELECT id_especialidad, nombre FROM especialidades ORDER BY nombre ASC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $especialidades = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $especialidades[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $especialidades;
}
?>