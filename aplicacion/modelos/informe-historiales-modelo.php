<?php
//FUNCIÓN PARA OBTENER TODOS LOS HISTORIALES
function obtenerTodosLosHistoriales($conexion){
    $sql = "SELECT h.archivo_pdf, h.fecha_registro, u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM historiales_medicos h
            INNER JOIN usuarios u_p ON h.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON h.id_medico = u_m.id_usuario
            ORDER BY h.fecha_registro DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $historiales = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $historiales[] = $fila;
    }
    mysqli_stmt_close($preparacion);

    return $historiales;
}
?>