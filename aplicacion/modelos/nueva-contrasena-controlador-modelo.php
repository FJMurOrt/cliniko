<?php
//BUSCO EL TOKEN PARA VER SI HAY UNO Y ASI SE PEUDA RECUERPAR LA CONTRASEÑA
function obtenerTokenRecuperacion($conexion, $token){
    $sql = "SELECT id_usuario, fecha_caduca FROM recuperacion_de_contrasenas 
            WHERE token = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "s", $token);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $registro = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $registro;
}

//ACTUALIZO LA CONTRASEÑA
function actualizarContrasena($conexion, $id_usuario, $hash){
    $sql = "UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "si", $hash, $id_usuario);
    mysqli_stmt_execute($sql_preparacion);

    $ok = mysqli_stmt_affected_rows($sql_preparacion) > 0;

    mysqli_stmt_close($sql_preparacion);

    return $ok;
}

//Y ELIMINO EL TOKEN PARA QUE NO S EPUEDA VOLVER ACCEDER AL ENLACE
function eliminarToken($conexion, $token){
    $sql = "DELETE FROM recuperacion_de_contrasenas WHERE token = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "s", $token);
    mysqli_stmt_execute($sql_preparacion);

    mysqli_stmt_close($sql_preparacion);
}
?>