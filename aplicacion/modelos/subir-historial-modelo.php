<?php
//FUNCIÓN PARA VER SI EL PACIENTE YA TIENE UN HISTORIAL SUBIDO
function obtenerHistorial($conexion, $id_paciente, $id_medico){
    $sql = "SELECT id_historial, archivo_pdf FROM historiales_medicos 
            WHERE id_paciente = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_paciente, $id_medico);
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

//FUNCIÓN PARA INSERTAR EL HISTORIAL EN CASO DE QUE NO TENGA OTRO SUBIDO
function insertarHistorial($conexion, $id_paciente, $id_medico, $archivo_pdf){
    $sql = "INSERT INTO historiales_medicos (id_paciente, id_medico, archivo_pdf) VALUES (?, ?, ?)";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "iis", $id_paciente, $id_medico, $archivo_pdf);
    $subido = mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $subido;
}

//FUNCIÓN PARA ACTUALIZAR EL HISTORIAL ANTIGUO POR EL NUEVO
function actualizarHistorial($conexion, $id_historial, $archivo_pdf){
    $sql = "UPDATE historiales_medicos SET archivo_pdf = ? WHERE id_historial = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "si", $archivo_pdf, $id_historial);
    $subido = mysqli_stmt_execute($sql_preparacion);
    mysqli_stmt_close($sql_preparacion);

    return $subido;
}