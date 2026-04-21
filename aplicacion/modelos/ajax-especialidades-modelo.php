<?php
//FUNCIÓN PARA OBTENER LAS ESPECIALDIADES
function obtenerEspecialidades($conexion){
    $sql = "SELECT id_especialidad, nombre FROM especialidades ORDER BY nombre ASC";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    //ARRAY DONDE GUARDO LAS ESPECIALIDADES
    $especialidades = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $especialidades[] = $fila;
    }

    mysqli_stmt_close($sql_preparacion);

    return $especialidades;
}
?>