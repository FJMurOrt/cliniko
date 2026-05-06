<?php
//FUNCIÓN PARA OBTENER EL TOTAL DE USUARIOS HABUILTIADOS Y NO HABILITADOS
function obtenerTotalUsuarios($conexion){
    //PARA LOS HABILTIADOS
    $sql_habilitados = "SELECT COUNT(*) AS total FROM usuarios
                        WHERE rol != 'administrador' AND habilitado = 'si' AND nombre != 'Usuario eliminado'";

    $preparacion = mysqli_prepare($conexion, $sql_habilitados);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $habilitados);
    mysqli_stmt_fetch($preparacion);
    mysqli_stmt_close($preparacion);

    //PARA LOS DESHABILTADOS
    $sql_deshabilitados = "SELECT COUNT(*) AS total FROM usuarios
                           WHERE rol != 'administrador' AND habilitado = 'no' AND nombre != 'Usuario eliminado'";

    $preparacion = mysqli_prepare($conexion, $sql_deshabilitados);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $deshabilitados);
    mysqli_stmt_fetch($preparacion);
    mysqli_stmt_close($preparacion);

    return [
        "habilitados" => $habilitados,
        "deshabilitados" => $deshabilitados
    ];
}

//FUNCIÓN DE LAS CITAS QUE HAY POR ESTADO PARA MOSTRARLAS EN LA GRÁFICA
function obtenerCitasPorEstado($conexion){
    //EL SQL PARA LAS PENEDIENTES POR CONFIRMAR
    $sql_pendiente = "SELECT COUNT(*) FROM citas 
                      WHERE estado = 'pendiente'";

    $preparacion = mysqli_prepare($conexion, $sql_pendiente);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $pendiente);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //EL SQL PARA LAS CONFIRMADAS
    $sql_confirmada = "SELECT COUNT(*) FROM citas 
                       WHERE estado = 'confirmada'";

    $preparacion = mysqli_prepare($conexion, $sql_confirmada);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $confirmada);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //EL SQL PARA LAS CANCELADAS
    $sql_cancelada = "SELECT COUNT(*) FROM citas 
                      WHERE estado = 'cancelada'";

    $preparacion = mysqli_prepare($conexion, $sql_cancelada);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $cancelada);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //EL SQL PARA LAS REALIZADAS
    $sql_realizada = "SELECT COUNT(*) FROM citas 
                      WHERE estado = 'realizada'";

    $preparacion = mysqli_prepare($conexion, $sql_realizada);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $realizada);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //EL SQL PARA LAS NO ATENDIDAS
    $sql_no_atendida = "SELECT COUNT(*) FROM citas 
                        WHERE estado = 'no_atendida'";

    $preparacion = mysqli_prepare($conexion, $sql_no_atendida);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $no_atendida);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    return [
        "pendiente" => $pendiente,
        "confirmada" => $confirmada,
        "cancelada" => $cancelada,
        "realizada" => $realizada,
        "no_atendida" => $no_atendida
    ];
}

//FUNCIÓN PARA OBTENER LAS ÚLTIMAS NOTIFICACIONES DEL ADMINISTRADOR
function obtenerUltimasNotificaciones($conexion, $id_admin){
    $sql = "SELECT mensaje, fecha FROM notificaciones
            WHERE id_usuario = ? AND leida = 'no'
            ORDER BY fecha DESC
            LIMIT 4";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_admin);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $notificaciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $notificaciones[] = $fila;
    }
    mysqli_stmt_close($preparacion);

    return $notificaciones;
}

//FUNCIÓN PARA OBTENER EL TOTAL DE LAS VALORACIONES QUE SE HAYAN REPORTADO
function obtenerValoracionesReportadas($conexion){
    $sql = "SELECT u.nombre, u.apellidos, v.comentario FROM valoraciones v
            INNER JOIN pacientes p ON v.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            WHERE v.estado = 'reportada'
            ORDER BY v.fecha DESC
            LIMIT 4";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }
    mysqli_stmt_close($preparacion);

    return $valoraciones;
}

//FUNCIÓN PARA OBTENER EL TOTAL DE USUARIOS PENDIENTES POR HABILITAR
function obtenerTotalPendientes($conexion){
    $sql = "SELECT COUNT(*) AS total FROM usuarios
            WHERE habilitado = 'no' AND rol != 'administrador' AND nombre != 'Usuario eliminado'";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $total);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    return $total;
}

//TOTAL DE DOCUMENTOS QUE SE HAYAN SUBIDO HOY, TANTO RECETAS COMO HSITORIALES.
function obtenerDocumentosHoy($conexion){
    //PARA LAS RECETAS
    $sql_recetas = "SELECT COUNT(*) FROM recetas WHERE DATE(fecha_creacion) = CURDATE()";

    $preparacion = mysqli_prepare($conexion, $sql_recetas);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $recetas);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //PARA LOS HISTORIALES
    $sql_historiales = "SELECT COUNT(*) FROM historiales_medicos WHERE DATE(fecha_registro) = CURDATE()";

    $preparacion = mysqli_prepare($conexion, $sql_historiales);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $historiales);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    return [
        "recetas" => $recetas,
        "historiales" => $historiales
    ];
}

//FUNCIÓN PARA OBTENER EL NÚMERO DE VALORACIONES QUE HAY POR PUNTUACIÓN
function obtenerValoracionesPorEstrellas($conexion){
    //PARA CONTAR CUANTAS DE 1 ESTRELLA
    $sql_1 = "SELECT COUNT(*) FROM valoraciones WHERE puntuacion = 1";

    $preparacion = mysqli_prepare($conexion, $sql_1);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $una);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //PARA CONTAR CUANTAS DE 2 ESTRELLAS
    $sql_2 = "SELECT COUNT(*) FROM valoraciones WHERE puntuacion = 2";

    $preparacion = mysqli_prepare($conexion, $sql_2);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $dos);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //PARA CONTAR CUANTAS DE 3 ESTRELLAS
    $sql_3 = "SELECT COUNT(*) FROM valoraciones WHERE puntuacion = 3";

    $preparacion = mysqli_prepare($conexion, $sql_3);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $tres);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //PARA CONTAR CUANTAS DE 4 ESTRELLAS
    $sql_4 = "SELECT COUNT(*) FROM valoraciones WHERE puntuacion = 4";

    $preparacion = mysqli_prepare($conexion, $sql_4);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $cuatro);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    //PARA CONTAR CUANTAS DE 5 ESTRELLAS
    $sql_5 = "SELECT COUNT(*) FROM valoraciones WHERE puntuacion = 5";

    $preparacion = mysqli_prepare($conexion, $sql_5);
    mysqli_stmt_execute($preparacion);
    mysqli_stmt_bind_result($preparacion, $cinco);
    mysqli_stmt_fetch($preparacion);

    mysqli_stmt_close($preparacion);

    return [
        "una" => $una,
        "dos" => $dos,
        "tres" => $tres,
        "cuatro" => $cuatro,
        "cinco" => $cinco
    ];
}
?>