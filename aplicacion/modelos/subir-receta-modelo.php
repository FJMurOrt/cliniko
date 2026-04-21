<?php
//FUNCIÓN PARA VER SI LA CITA YA TIENE UN RECETA ASOCIADA
function obtenerReceta($conexion, $id_cita){
    $sql = "SELECT id_receta, archivo_pdf FROM recetas WHERE id_cita = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "i", $id_cita);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);
    if($fila){
        return $fila;
    }else{
        return false;
    }
}

//INSERTO LA RECETA SI NO TIENE NINGUNA
function insertarReceta($conexion, $id_cita, $archivo_pdf){
    $sql = "INSERT INTO recetas (id_cita, archivo_pdf) VALUES (?, ?)";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "is", $id_cita, $archivo_pdf);
    $respuesta = mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $respuesta;
}

//ACTUALIZO LA QUE TENIA POR LA NUEVA
function actualizarReceta($conexion, $id_receta, $archivo_pdf){
    $sql = "UPDATE recetas SET archivo_pdf = ? WHERE id_receta = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "si", $archivo_pdf, $id_receta);
    $respuesta = mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $respuesta;
}
?>