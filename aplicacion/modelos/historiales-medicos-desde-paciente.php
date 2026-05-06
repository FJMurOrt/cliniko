<?php
//FUNCIÓN PARA EL TOTAL DE MÉDICOS
function obtenerTotalMedicos($conexion, $id_paciente, $especialidad, $historial, $busqueda){
    $sqlespecialidad = "";
    if($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = $especialidad";
    }

    $sqlhistorial = "";
    if($historial === "disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NOT NULL";
    }
    if($historial === "no-disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NULL";
    }

    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";   
    }

    $sql = "SELECT COUNT(DISTINCT c.id_medico) as total FROM citas c
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            INNER JOIN usuarios u ON m.id_medico = u.id_usuario
            LEFT JOIN historiales_medicos h ON h.id_medico = m.id_medico AND h.id_paciente = ?
            WHERE c.id_paciente = ?
            $sqlespecialidad
            $sqlhistorial
            $sqlbusqueda";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "ii", $id_paciente, $id_paciente);
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total_medicos);
    mysqli_stmt_fetch($preparacion_sql);

    mysqli_stmt_close($preparacion_sql);

    return $total_medicos;
}

//FUNCIÓN PARA OBTENER LOS DATOS DEL MÉDICO
function obtenerTotalMedicosPaciente($conexion, $id_paciente, $inicio, $registros, $especialidad, $historial, $busqueda, $orden){
    $sqlespecialidad = "";
    if($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = $especialidad";
    }

    $sqlhistorial = "";
    if($historial === "disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NOT NULL";
    }
    if($historial === "no-disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NULL";
    }

    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";   
    }

    $sqlorden = "ORDER BY u.apellidos ASC";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }
    if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }

    $sql = "SELECT DISTINCT m.id_medico, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, h.archivo_pdf FROM citas c
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            INNER JOIN usuarios u ON m.id_medico = u.id_usuario
            INNER JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            LEFT JOIN historiales_medicos h 
            ON h.id_medico = m.id_medico AND h.id_paciente = ?
            WHERE c.id_paciente = ?
            $sqlespecialidad
            $sqlhistorial
            $sqlbusqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "iiii", $id_paciente, $id_paciente, $registros, $inicio);
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $medicos = [];
    while ($fila = mysqli_fetch_assoc($resultado)){
        $medicos[] = [
            "id_medico" => $fila["id_medico"],
            "nombre" => $fila["nombre"],
            "apellidos" => $fila["apellidos"],
            "foto" => $fila["foto_perfil"],
            "archivo_pdf" => $fila["archivo_pdf"],
            "especialidad" => $fila["especialidad"]
        ];
    }
    mysqli_stmt_close($preparacion_sql);
    return $medicos;
}
?>