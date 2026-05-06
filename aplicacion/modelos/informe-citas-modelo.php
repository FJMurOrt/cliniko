<?php
//FUNCIÓN PARA OBTENER TODAS LAS CITAS
function obtenerTodasLasCitas($conexion){
    $sql = "SELECT c.id_cita, c.fecha_cita, c.motivo, c.estado, u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM citas c
            INNER JOIN usuarios u_p ON c.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON c.id_medico = u_m.id_usuario
            ORDER BY c.fecha_cita DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $citas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }
    mysqli_stmt_close($preparacion);
    
    return $citas;
}
?>