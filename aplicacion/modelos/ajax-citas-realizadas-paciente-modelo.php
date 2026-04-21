<?php
require_once "../configuracion/config.php";

//CONTAR LAS CITAS QUE HABRÁ PARA LA PAGINACIÓN
function contarCitasPaciente($conexion, $id_paciente, $fecha = null, $busqueda = null, $receta = null, $especialidad = null){
    $sqlreceta = "";
    if($receta === "disponible"){
        $sqlreceta = " AND r.archivo_pdf IS NOT NULL";
    }

    if($receta === "no-disponible"){
        $sqlreceta = " AND r.archivo_pdf IS NULL";
    }

    $sqlespecialidad = "";
    if ($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = " . $especialidad;
    }else{
        $sqlespecialidad = "";
    }

    if($fecha && $busqueda){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                $sqlreceta
                $sqlespecialidad
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isss", $id_paciente, $fecha, $busqueda, $busqueda);
    }elseif ($fecha){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                $sqlreceta
                $sqlespecialidad
                AND DATE(c.fecha_cita) = ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "is", $id_paciente, $fecha);
    }elseif ($busqueda){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                $sqlreceta
                $sqlespecialidad
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iss", $id_paciente, $busqueda, $busqueda);
    }else{
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                $sqlreceta
                $sqlespecialidad";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $id_paciente);
    }
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//PARA OBTENER LAS CITAS
function obtenerCitasPaciente($conexion, $id_paciente, $inicio, $registros, $fecha = null, $busqueda = null, $receta = null, $especialidad = null){
    $sqlreceta = "";
    if($receta === "disponible"){
        $sqlreceta = " AND r.archivo_pdf IS NOT NULL";
    }

    if($receta === "no-disponible"){
        $sqlreceta = " AND r.archivo_pdf IS NULL";
    }
    $sqlespecialidad = "";
    if ($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = " . $especialidad;
    }else{
        $sqlespecialidad = "";
    }

    if($fecha && $busqueda){
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN especialidades e ON e.id_especialidad = m.id_especialidad
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))
                $sqlreceta
                $sqlespecialidad
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isssii", $id_paciente, $fecha, $busqueda, $busqueda, $registros, $inicio);
    }elseif($fecha){
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN especialidades e ON e.id_especialidad = m.id_especialidad
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                $sqlreceta
                $sqlespecialidad
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "isii", $id_paciente, $fecha, $registros, $inicio);
    }elseif($busqueda){
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN especialidades e ON e.id_especialidad = m.id_especialidad
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))
                $sqlreceta
                $sqlespecialidad
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "issii", $id_paciente, $busqueda, $busqueda, $registros, $inicio);
    }else{
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_medico = u.id_usuario
                INNER JOIN medicos m ON m.id_medico = u.id_usuario
                LEFT JOIN especialidades e ON e.id_especialidad = m.id_especialidad
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_paciente = ? AND c.estado = 'realizada'
                $sqlreceta
                $sqlespecialidad
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $id_paciente, $registros, $inicio);
    }
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $citas = [];
    while ($fila = mysqli_fetch_assoc($resultado)){
        $citas[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);

    return $citas;
}
?>