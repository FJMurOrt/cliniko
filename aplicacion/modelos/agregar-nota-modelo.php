<?php
function guardarNota($conexion, $id_cita, $nota){
    //COMPRUEBO SI YA EXISTE UNA NOTA PARA ESTA CITA
    $sql = "SELECT id_nota FROM notas WHERE id_cita = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_cita);
    mysqli_stmt_execute($sql_preparacion);
    $resultado = mysqli_stmt_get_result($sql_preparacion);

    if($fila = mysqli_fetch_assoc($resultado)){
        //SI YA HAY UNA NOTA, ENTONCES LA SUSTITUYO
        $sql_actualizacion = "UPDATE notas SET nota = ?, fecha = NOW() WHERE id_nota = ?";

        $sql_preparacion_actualizacion_de_nota = mysqli_prepare($conexion, $sql_actualizacion);
        mysqli_stmt_bind_param($sql_preparacion_actualizacion_de_nota, "si", $nota, $fila["id_nota"]);
        mysqli_stmt_execute($sql_preparacion_actualizacion_de_nota);

        mysqli_stmt_close($sql_preparacion_actualizacion_de_nota);
    }else{
        //SI NO EXISTE, PUES SIMPLEMENTE LA INSERTO
        $sql_insert_de_la_nota = "INSERT INTO notas (id_cita, nota) VALUES (?, ?)";
        
        $sql_preparacion_del_insert = mysqli_prepare($conexion, $sql_insert_de_la_nota);
        mysqli_stmt_bind_param($sql_preparacion_del_insert, "is", $id_cita, $nota);
        mysqli_stmt_execute($sql_preparacion_del_insert);

        mysqli_stmt_close($sql_preparacion_del_insert);
    }
    mysqli_stmt_close($sql_preparacion);

    return true;
}
?>