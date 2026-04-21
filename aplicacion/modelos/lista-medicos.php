<?php
//FUNCIÓN PARA CONTAR LOS MÉDICOS
function contarMedicos($conexion, $especialidad = null){
    if($especialidad !== null){
        $sql = "SELECT COUNT(DISTINCT u.id_usuario) AS total FROM usuarios u
                INNER JOIN medicos m ON u.id_usuario = m.id_medico
                INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
                WHERE u.rol = 'medico' AND u.habilitado = 'si' AND m.id_especialidad = ?";
                
        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "i", $especialidad);
    }else{
        $sql = "SELECT COUNT(DISTINCT u.id_usuario) AS total FROM usuarios u
                INNER JOIN medicos m ON u.id_usuario = m.id_medico
                INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
                WHERE u.rol = 'medico' AND u.habilitado = 'si'";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
    }

    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//FUNCIÓN PARA OBTENER LOS DATOS DE LOS MÉDICOS
function obtenerMedicos($conexion, $inicio, $registros, $especialidad = null, $orden = null){
    $order_sql = "";
    if($orden === "asc"){
        $order_sql = " ORDER BY u.nombre ASC, u.apellidos ASC";
    }elseif($orden === "desc"){
        $order_sql = " ORDER BY u.nombre DESC, u.apellidos DESC";
    }

    if($especialidad !== null){
        $sql = "SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos, e.nombre AS especialidad 
                FROM usuarios u
                INNER JOIN medicos m ON u.id_usuario = m.id_medico
                INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
                LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                WHERE u.rol = 'medico' 
                  AND u.habilitado = 'si' 
                  AND m.id_especialidad = ?
                $order_sql
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "iii", $especialidad, $registros, $inicio);
    }else{
        $sql = "SELECT DISTINCT u.id_usuario, u.nombre, u.apellidos, e.nombre AS especialidad 
                FROM usuarios u
                INNER JOIN medicos m ON u.id_usuario = m.id_medico
                INNER JOIN disponibilidad_medicos d ON m.id_medico = d.id_medico
                LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
                WHERE u.rol = 'medico' 
                  AND u.habilitado = 'si'
                $order_sql
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($preparacion_sql, "ii", $registros, $inicio);
    }
    mysqli_stmt_execute($preparacion_sql);
    $resultado = mysqli_stmt_get_result($preparacion_sql);

    $medicos = [];
    while ($fila = mysqli_fetch_assoc($resultado)){
        $medicos[] = $fila;
    }

    mysqli_stmt_close($preparacion_sql);
    return $medicos;
}
?>