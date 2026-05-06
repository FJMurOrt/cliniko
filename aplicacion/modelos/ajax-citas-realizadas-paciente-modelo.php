<?php
//FUNCIÓN PARA CONTAR LAS CITAS DE LOS PACIENTES
function contarCitasPaciente($conexion, $id_paciente, $fecha, $busqueda, $receta, $especialidad){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_receta = "";
    if($receta === "disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NOT NULL";
    }else if($receta === "no-disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NULL";
    }

    $filtro_especialidad = "";
    if($especialidad){
        $filtro_especialidad = " AND m.id_especialidad = $especialidad";
    }

    $sql = "SELECT COUNT(*) as total FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            INNER JOIN medicos m ON m.id_medico = u.id_usuario
            LEFT JOIN recetas r ON r.id_cita = c.id_cita
            WHERE c.id_paciente = ? AND c.estado = 'realizada'
            $filtro_fecha
            $filtro_busqueda
            $filtro_receta
            $filtro_especialidad";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "i", $id_paciente);
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);

    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LAS CITAS DEL PACIENTE
function obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha, $busqueda, $receta, $especialidad){
    $filtro_fecha = "";
    if($fecha){
        $filtro_fecha = " AND DATE(c.fecha_cita) = '$fecha'";
    }

    $filtro_busqueda = "";
    if($busqueda){
        $filtro_busqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $filtro_receta = "";
    if($receta === "disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NOT NULL";
    }else if($receta === "no-disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NULL";
    }

    $filtro_especialidad = "";
    if($especialidad){
        $filtro_especialidad = " AND m.id_especialidad = $especialidad";
    }

    $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, r.archivo_pdf, n.nota FROM citas c
            INNER JOIN usuarios u ON c.id_medico = u.id_usuario
            INNER JOIN medicos m ON m.id_medico = u.id_usuario
            LEFT JOIN especialidades e ON e.id_especialidad = m.id_especialidad
            LEFT JOIN recetas r ON r.id_cita = c.id_cita
            LEFT JOIN notas n ON n.id_cita = c.id_cita
            WHERE c.id_paciente = ? AND c.estado = 'realizada'
            $filtro_fecha
            $filtro_busqueda
            $filtro_receta
            $filtro_especialidad
            ORDER BY c.fecha_cita DESC
            LIMIT ? OFFSET ?";

    $preparacion_sql = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($preparacion_sql, "iii", $id_paciente, $registros, $inicio);
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $citas = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);
    return $citas;
}
?>