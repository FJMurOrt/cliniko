<?php
//FUNCIÓN PARA OBTENER LAS VALORACIONES
function obtenerTodasLasValoraciones($conexion){
    $sql = "SELECT v.puntuacion, v.comentario, v.fecha, v.estado, u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM valoraciones v
            INNER JOIN usuarios u_p ON v.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON v.id_medico = u_m.id_usuario
            ORDER BY v.fecha DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $valoraciones;
}
?>