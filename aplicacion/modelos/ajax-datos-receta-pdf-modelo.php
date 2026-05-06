<?php
//INFORMACIÓN PARA OBTENER LOS DATOS DE LA CITA A LA QUE SE LE VA A GENERAR LA RECETA
function obtenerDatosCitaParaRecetaPDF($conexion, $id_cita){
    $sql = "SELECT u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente, u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico,
            c.fecha_cita, c.motivo FROM citas c
            INNER JOIN usuarios u_p ON c.id_paciente = u_p.id_usuario
            INNER JOIN usuarios u_m ON c.id_medico = u_m.id_usuario
            WHERE c.id_cita = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_cita);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $datos_de_la_cita = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $datos_de_la_cita;
}
?>