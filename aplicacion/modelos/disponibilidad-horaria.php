<?php
require_once "../configuracion/config.php";

//SE CONSULTA SI EL TURNO YA EXISTE EN LA FECHA
function existeDisponibilidad($conexion, $id_medico, $fecha, $turno){
    $consulta = mysqli_prepare($conexion,
        "SELECT * FROM disponibilidad_medicos WHERE id_medico = ? AND fecha = ? AND turno = ?"
    );

    mysqli_stmt_bind_param($consulta, "iss", $id_medico, $fecha, $turno);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);
    $existe = mysqli_num_rows($resultado) > 0;
    mysqli_stmt_close($consulta);
    
    return $existe;
}

//LO GUARDAMOS
function guardarDisponibilidad($conexion, $id_medico, $fecha, $turno, $hora_inicio, $hora_fin){
    $consulta = mysqli_prepare($conexion,
        "INSERT INTO disponibilidad_medicos (id_medico, fecha, turno, hora_inicio, hora_fin) VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param($consulta, "issss", $id_medico, $fecha, $turno, $hora_inicio, $hora_fin);
    $resultado = mysqli_stmt_execute($consulta);
    
    mysqli_stmt_close($consulta);

    return $resultado;
}
?>