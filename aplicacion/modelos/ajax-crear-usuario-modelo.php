<?php
//FUNCIÓN PARA CREAR EL USUARIO EN LA TABLA USUARIOS
function crearUsuarioAdmin($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $foto){
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, rol, foto_perfil, habilitado) VALUES (?, ?, ?, ?, ?, ?, ?, 'no')";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "sssssss", $nombre, $apellidos, $correo, $hash, $telefono, $rol, $foto);
    $resultado = mysqli_stmt_execute($preparacion);
    $id_usuario = mysqli_insert_id($conexion);

    mysqli_stmt_close($preparacion);

    return $id_usuario;
}


//FUNCIÓN PARA CREAR EL USUARIO EN LA TABLA PACIENTES
function crearPacienteAdmin($conexion, $id_usuario, $fecha_nacimiento, $direccion, $nss, $telefono){
    $sql = "INSERT INTO pacientes (id_paciente, fecha_nacimiento, direccion, nss, telefono_contacto) VALUES (?, ?, ?, ?, ?)";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "issss", $id_usuario, $fecha_nacimiento, $direccion, $nss, $telefono);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);
}

//FUNCIÓN PARA CREAR EL USUAIO EN LA TABLA MÉDICOS
function crearMedicoAdmin($conexion, $id_usuario, $id_especialidad, $numero_colegiado){
    $sql = "INSERT INTO medicos (id_medico, id_especialidad, numero_colegiado) VALUES (?, ?, ?)";
    
    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "iis", $id_usuario, $id_especialidad, $numero_colegiado);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);
}
?>