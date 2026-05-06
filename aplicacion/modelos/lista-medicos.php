<?php
//CONTAR LOS MEDICOS QUE HAY PARA LA PAGINACIÓN
function contarMedicos($conexion, $especialidad, $busqueda){
    $filtro_especialidad = "";
    if($especialidad){
        $filtro_especialidad = " AND m.id_especialidad = '$especialidad'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql = "SELECT COUNT(DISTINCT u.id_usuario) AS total FROM usuarios u
            INNER JOIN medicos m ON u.id_usuario = m.id_medico
            INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
            WHERE u.rol = 'medico' AND u.habilitado = 'si'
            $filtro_especialidad
            $filtro_busqueda";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);

    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//OBTENER LOS DATOS DE LOS MÉDiCOS
function obtenerMedicos($conexion, $inicio, $registros, $especialidad, $orden, $busqueda){
    $filtro_especialidad = "";
    if($especialidad){
        $filtro_especialidad = " AND m.id_especialidad = '$especialidad'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sqlorden = "";
    if($orden === "asc"){
        $sqlorden = " ORDER BY u.nombre ASC, u.apellidos ASC";
    }else if($orden === "desc"){
        $sqlorden = " ORDER BY u.nombre DESC, u.apellidos DESC";
    }

    $sql = "SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos, e.nombre AS especialidad FROM usuarios u
            INNER JOIN medicos m ON u.id_usuario = m.id_medico
            INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            WHERE u.rol = 'medico' AND u.habilitado = 'si'
            $filtro_especialidad
            $filtro_busqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "ii", $registros, $inicio);
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $medicos = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $medicos[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);
    return $medicos;
}
?>