<?php
//FUNCIÓN PARA OBTNER EL TOTAL DE PACIENTES PARA LA PAGINACIÓN
function obtenerTotalPacientes($conexion, $id_medico, $busqueda, $historial, $edad){
    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_historial = "";
    if($historial === "disponible"){
        $filtro_historial = " AND h.archivo_pdf IS NOT NULL";
    }else if($historial === "no-disponible"){
        $filtro_historial = " AND h.archivo_pdf IS NULL";
    }

    $filtro_edad = "";
    if($edad === "joven"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 0 AND 30";
    }else if($edad === "adulto"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 31 AND 60";
    }else if($edad === "mayor"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) > 60";
    }

    $sql = "SELECT COUNT(DISTINCT c.id_paciente) as total FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
            WHERE c.id_medico = ?
            $filtro_busqueda
            $filtro_historial
            $filtro_edad";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_medico, $id_medico);
    mysqli_stmt_execute($sql_preparacion);
    $result = mysqli_stmt_get_result($sql_preparacion);
    
    $total = mysqli_fetch_assoc($result)["total"];

    mysqli_stmt_close($sql_preparacion);

    return $total;
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LOS PACIENTES
function obtenerPacientes($conexion, $id_medico, $inicio, $registros, $busqueda, $historial, $orden, $edad){
    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_historial = "";
    if($historial === "disponible"){
        $filtro_historial = " AND h.archivo_pdf IS NOT NULL";
    }else if($historial === "no-disponible"){
        $filtro_historial = " AND h.archivo_pdf IS NULL";
    }

    $filtro_edad = "";
    if($edad === "joven"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 0 AND 30";
    }else if($edad === "adulto"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 31 AND 60";
    }else if($edad === "mayor"){
        $filtro_edad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) > 60";
    }

    $sqlorden = "";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }else if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }

    $sql = "SELECT DISTINCT p.id_paciente, u.nombre, u.apellidos, u.foto_perfil, p.fecha_nacimiento, h.archivo_pdf FROM citas c
            INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
            INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
            LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
            WHERE c.id_medico = ?
            $filtro_busqueda
            $filtro_historial
            $filtro_edad
            $sqlorden
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iiii", $id_medico, $id_medico, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);
    $result = mysqli_stmt_get_result($sql_preparacion);

    $pacientes = [];
    while($fila = mysqli_fetch_assoc($result)){
        $pacientes[] = [
            "id_paciente" => $fila["id_paciente"],
            "nombre" => $fila["nombre"],
            "apellidos" => $fila["apellidos"],
            "foto" => $fila["foto_perfil"],
            "fecha_nacimiento" => $fila["fecha_nacimiento"],
            "archivo_pdf" => $fila["archivo_pdf"]
        ];
    }

    mysqli_stmt_close($sql_preparacion);
    return $pacientes;
}
?>