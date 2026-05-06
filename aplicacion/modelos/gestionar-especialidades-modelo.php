<?php
//FUNCIÓN PARA OBTENER LAS ESPECIALDIADES
function obtenerEspecialidades($conexion){
    $sql = "SELECT e.id_especialidad, e.nombre, COUNT(m.id_medico) as total_medicos FROM especialidades e
            LEFT JOIN medicos m ON e.id_especialidad = m.id_especialidad
            GROUP BY e.id_especialidad, e.nombre
            ORDER BY e.nombre ASC";

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

//PARA AÑADIR LA ESPECIALIDAD
function anadirEspecialidad($conexion, $nombre){
    $sql = "INSERT INTO especialidades (nombre) VALUES (?)";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "s", $nombre);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//PARA EDITAR LA ESPECIALIDAD
function editarEspecialidad($conexion, $id_especialidad, $nombre){
    $sql = "UPDATE especialidades SET nombre = ? WHERE id_especialidad = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $nombre, $id_especialidad);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//PARA ELIMINAR LA ESPECIALIDAD
function eliminarEspecialidad($conexion, $id_especialidad){
    $sql = "DELETE FROM especialidades WHERE id_especialidad = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_especialidad);
    $resultado = mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);

    return $resultado;
}

//PARA CONTAR EL NÚMERO DE MEDICOS CON LA ESPECIALDIAD ANTES DE PODER ELIMIARLA
function cuantosMedicosHayConEstaEspecialidad($conexion, $id_especialidad){
    $sql = "SELECT COUNT(*) as total FROM medicos WHERE id_especialidad = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_especialidad);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"] > 0;
}

//PARA VER SI EXISTE YA O NO LA ESPECIALIDAD CUANDO VAYAMOS A AGREGAR UNA NUEVA
function especialidadYaExiste($conexion, $nombre){
    $sql = "SELECT COUNT(*) as total FROM especialidades WHERE nombre = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "s", $nombre);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"] > 0;
}
?>