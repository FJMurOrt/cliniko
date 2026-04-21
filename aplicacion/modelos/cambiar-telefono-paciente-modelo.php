<?php
//FUNCIÓN PARA ACTUALIZAR EL TELEFONO
function actualizarTelefono($conexion, $id_usuario, $telefono){

    $sql = "UPDATE usuarios SET telefono = ? WHERE id_usuario = ?";
    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "si", $telefono, $id_usuario);
    mysqli_stmt_execute($preparacion);
    
    mysqli_stmt_close($preparacion);

    return true;
}

//FUNCIÓN PARA QUE EL TELÉFONO NO VUELVA A SER EL MISMO
function obtenerTelefonoActual($conexion, $id_usuario){
    $sql = "SELECT telefono FROM usuarios WHERE id_usuario = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_usuario);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["telefono"];
}
?>