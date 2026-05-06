<?php
require_once "../configuracion/config.php";

function registrarUsuario($conexion, $nombre, $apellidos, $correo, $contrasena, $rol, $telefono, $fecha_nacimiento, $direccion, $nss, $numero_colegiado, $id_especialidad, $foto){
    //HASEAMOS LA CONTRASEÑA PARA MÁS SEGURIDAD
    $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    //INSERTAMOS EN LA TABLA CON MYSQLI_PREPARE PARA APLICAR SEGURIDAD A LA INUYECCIÓN SQL
    $consulta = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, rol, foto_perfil, habilitado) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $habilitado = "no";
    mysqli_stmt_bind_param($consulta, "ssssssss", $nombre, $apellidos, $correo, $contrasena, $telefono, $rol, $foto, $habilitado);
    $resultado = mysqli_stmt_execute($consulta);

    if($resultado){
        $id_usuario = mysqli_insert_id($conexion);

        if($rol == "paciente"){
            //INSERTARMOS EN PACIENTES
            $consultaPaciente = mysqli_prepare($conexion, "INSERT INTO pacientes (id_paciente, fecha_nacimiento, direccion, nss, telefono_contacto) 
                                                       VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($consultaPaciente, "issss", $id_usuario, $fecha_nacimiento, $direccion, $nss, $telefono);
            mysqli_stmt_execute($consultaPaciente);
            mysqli_stmt_close($consultaPaciente);
        }

        if($rol == "medico"){
            //INSERTARMOS EN MEDICOS
            $consultaMedico = mysqli_prepare($conexion, "INSERT INTO medicos (id_medico, id_especialidad, numero_colegiado) 
                                                     VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($consultaMedico, "iis", $id_usuario, $id_especialidad, $numero_colegiado);
            mysqli_stmt_execute($consultaMedico);
            mysqli_stmt_close($consultaMedico);
        }
    }

    mysqli_stmt_close($consulta);
    return $resultado;
}

//FUNCIÓN PARA OBTENER LOS IDS DE LOS ADMINS Y EVNIARLES LA NOTIFICIACIÓN DE QUE SE HA REGISTRADO UN NUEVO USUARIO
function obtenerIdsAdmins($conexion){
    $sql = "SELECT id_administrador FROM administradores";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $admins = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $admins[] = $fila["id_administrador"];
    }

    mysqli_stmt_close($preparacion);

    return $admins;
}

//Y LA FUNCIÓN PARA INSERTAR LA NOTIFICACIÓN EN LA TABLA DE NOTIFICACIONES
function insertarNotificacionAdmin($conexion, $id_admin, $tipo, $mensaje){
    $sql = "INSERT INTO notificaciones (id_usuario, tipo, mensaje) VALUES (?, ?, ?)";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "iss", $id_admin, $tipo, $mensaje);
    mysqli_stmt_execute($preparacion);

    mysqli_stmt_close($preparacion);
}
?>