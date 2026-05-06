<?php
function obtenerDatosUsuario($conexion, $id_usuario){
    $sql = "SELECT u.id_usuario, u.nombre, u.apellidos, u.correo, u.telefono, u.rol, u.foto_perfil, u.fecha_registro, u.habilitado, p.fecha_nacimiento, p.direccion, p.nss,
            m.numero_colegiado, e.nombre AS especialidad
            FROM usuarios u
            LEFT JOIN pacientes p ON u.id_usuario = p.id_paciente
            LEFT JOIN medicos m ON u.id_usuario = m.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE u.id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila;
}
?>