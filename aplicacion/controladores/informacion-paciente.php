<?php
require_once "../../configuracion/config.php";

function obtenerPaciente($conexion, $id_paciente) {
    $sql = "SELECT u.nombre, u.apellidos, u.correo, u.telefono, u.foto_perfil, p.direccion, p.nss FROM usuarios u
            INNER JOIN pacientes p ON u.id_usuario = p.id_paciente
            WHERE u.id_usuario = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_paciente);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $paciente = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $paciente;
}