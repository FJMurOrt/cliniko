<?php
//FUNCIÓN PARA CREAR AL ADMINSITRADOR DESDE EL PANEL DEL ADMIN
function crearAdministrador($conexion, $nombre, $apellidos, $telefono, $correo, $contrasena){
    //PRIMERO HASHEO LA CONTRASEÑA
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    //Y AHORA YA HAGO EL INSERT EN LA TABLA USUARIOS PRIMERO Y LUEGO EN LA DE ADMINISTRADORES
    $sql = "INSERT INTO usuarios (nombre, apellidos, correo, contrasena, telefono, rol, foto_perfil, habilitado) VALUES (?, ?, ?, ?, ?, 'administrador', 'por_defecto.png', 'si')";
    
    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "sssss", $nombre, $apellidos, $correo, $hash, $telefono);
    $resultado = mysqli_stmt_execute($preparacion);

    $id_usuario = mysqli_insert_id($conexion);

    mysqli_stmt_close($preparacion);

    if($resultado){
        $sql_admin = "INSERT INTO administradores (id_administrador) VALUES (?)";

        $prep_admin = mysqli_prepare($conexion, $sql_admin);
        mysqli_stmt_bind_param($prep_admin, "i", $id_usuario);
        mysqli_stmt_execute($prep_admin);

        mysqli_stmt_close($prep_admin);
    }

    return $resultado;
}
?>