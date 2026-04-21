<?php
//FUNCIÓN PARA OBENER LOS DATOS DE LA CITA
function obtener_datos_cita($conexion, $id_cita, $id_paciente){
    $sql = "SELECT c.id_cita, c.fecha_cita, c.motivo, c.estado, c.notas, u_p.nombre AS nombre_paciente, u_p.apellidos AS apellidos_paciente,
            p.nss, p.telefono_contacto AS telefono, u_m.nombre AS nombre_medico, u_m.apellidos AS apellidos_medico FROM citas c
            JOIN pacientes p ON c.id_paciente = p.id_paciente
            JOIN usuarios u_p ON p.id_paciente = u_p.id_usuario
            JOIN medicos m ON c.id_medico = m.id_medico
            JOIN usuarios u_m ON m.id_medico = u_m.id_usuario
            WHERE c.id_cita = ? AND c.id_paciente = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_cita, $id_paciente);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $cita = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);
    return $cita;
}
?>