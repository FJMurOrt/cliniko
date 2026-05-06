<?php
//FUNCIÓN PARA OBTENER TODAS LAS RECETAS
function obtenerTodasLasRecetas($conexion){
    $sql = "SELECT r.archivo_pdf, r.fecha_creacion, u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM recetas r
            INNER JOIN citas c ON r.id_cita = c.id_cita
            INNER JOIN usuarios u_p ON c.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON c.id_medico = u_m.id_usuario
            ORDER BY r.fecha_creacion DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $recetas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $recetas[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $recetas;
}
?>