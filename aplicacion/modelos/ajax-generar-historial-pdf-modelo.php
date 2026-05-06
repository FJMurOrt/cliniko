<?php
//FUNCIÓN PARA OBTENER LOS DATOS DEL PCAIENTE
function obtenerDatosPaciente($conexion, $id_paciente){
    $sql = "SELECT u.nombre, u.apellidos, u.telefono, p.fecha_nacimiento, p.direccion, p.nss FROM usuarios u
            INNER JOIN pacientes p ON u.id_usuario = p.id_paciente
            WHERE u.id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_paciente);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $paciente = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $paciente;
}

//FUNCIÓN PARA OBTENER LOS DATOS DEL MÉDICO
function obtenerDatosMedico($conexion, $id_medico){
    $sql = "SELECT u.nombre, u.apellidos, e.nombre AS especialidad FROM usuarios u
            INNER JOIN medicos m ON u.id_usuario = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE u.id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $medico = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $medico;
}

//FUNCIÓN PARA OBTENER LAS CITAS DEL PACIENTE Y DEL MEDICO
function obtenerCitasPacienteMedico($conexion, $id_paciente, $id_medico){
    $sql = "SELECT fecha_cita, motivo FROM citas
            WHERE id_paciente = ? AND id_medico = ? AND estado = 'realizada'
            ORDER BY fecha_cita DESC";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "ii", $id_paciente, $id_medico);
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