<?php
//FUNCIÓN PARA CONTAR CUANTAS VALORACIONES HAY PARA PODER CREAR LA PAGINACIÓN
function contarValoracionesMedico($conexion, $id_medico, $busqueda = null){
    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql = "SELECT COUNT(*) as total FROM valoraciones 
            WHERE id_medico = ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "i", $id_medico);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($preparacion);

    return $fila["total"];
}

//FUNCIÓN APRA OBTENER LA INFORMACIÓN DE LAS VALORACIONES
function obtenerValoracionesMedico($conexion, $id_medico, $inicio, $registros, $busqueda = null, $puntuacion = null, $orden = null, $fecha = null){
    $sqlbusqueda = "";
    if($busqueda) $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";

    $sqlorden = "ORDER BY v.fecha DESC";
    if($puntuacion === "mejor"){
        $sqlorden = "ORDER BY v.puntuacion DESC";
    }
    if($puntuacion === "peor"){
        $sqlorden = "ORDER BY v.puntuacion ASC";
    }
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }       
    if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }     
    if($fecha === "recientes"){
        $sqlorden = "ORDER BY v.fecha DESC";
    }
    if($fecha === "antiguas"){
        $sqlorden = "ORDER BY v.fecha ASC";
    }

    $sql = "SELECT v.id_valoracion, v.puntuacion, v.comentario, v.fecha, u.nombre, u.apellidos, u.foto_perfil FROM valoraciones v
            INNER JOIN usuarios u ON v.id_paciente = u.id_usuario
            WHERE v.id_medico = ?
            $sqlbusqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion, "iii", $id_medico, $registros, $inicio);
    mysqli_stmt_execute($preparacion);
    $resultado = mysqli_stmt_get_result($preparacion);

    $valoraciones = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $valoraciones[] = $fila;
    }

    mysqli_stmt_close($preparacion);

    return $valoraciones;
}
?>