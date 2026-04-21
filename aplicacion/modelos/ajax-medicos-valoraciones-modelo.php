<?php
//FUNCIÓN PARA CONTAR LOS MÉDICOS CON LOS QUE SE TIENEN CITAS YA REALIZADAS
function contarMedicosConCitasRealizadas($conexion, $id_paciente, $especialidad = null, $busqueda = null){
    $sqlespecialidad = "";
    if($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = $especialidad";
    }

    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sql = "SELECT COUNT(DISTINCT c.id_medico) as total FROM citas c
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            INNER JOIN usuarios u ON m.id_medico = u.id_usuario
            WHERE c.id_paciente = ? AND c.estado = 'realizada'
            $sqlespecialidad
            $sqlbusqueda";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "i", $id_paciente);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    return $fila["total"];
}

//FUNCIÓN PARA OBTENER LOS MÉDICOS CON CITAS REALIZADAS
function obtenerMedicosConCitasRealizadas($conexion, $id_paciente, $inicio, $registros, $especialidad = null, $busqueda = null, $valoracion = null, $orden = null){
    $sqlespecialidad = "";
    if($especialidad){
        $sqlespecialidad = " AND m.id_especialidad = $especialidad";
    }

    $sqlbusqueda = "";
    if($busqueda){
        $sqlbusqueda = " AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%')";
    }

    $sqlorden_alfa = "";
    if($orden === "asc"){
        $sqlorden_alfa = "ORDER BY u.apellidos ASC";
    }elseif($orden === "desc"){
        $sqlorden_alfa = "ORDER BY u.apellidos DESC";
    }

    $sqlorden_punt = "";
    if($valoracion === "mejor"){
        $sqlorden_punt = "ORDER BY v.puntuacion DESC";
    }elseif($valoracion === "peor"){
        $sqlorden_punt = "ORDER BY v.puntuacion ASC";
    }

    if($sqlorden_punt){
        $sqlorden = $sqlorden_punt;
    }else{
        $sqlorden = $sqlorden_alfa;
    }

    $sql = "SELECT DISTINCT m.id_medico, u.nombre, u.apellidos, u.foto_perfil, e.nombre AS especialidad, 
            v.id_valoracion, v.puntuacion, v.comentario FROM citas c
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            INNER JOIN usuarios u ON m.id_medico = u.id_usuario
            LEFT JOIN especialidades e ON m.id_especialidad = e.id_especialidad
            LEFT JOIN valoraciones v ON v.id_medico = m.id_medico AND v.id_paciente = ?
            WHERE c.id_paciente = ?
            AND c.estado = 'realizada'
            $sqlespecialidad
            $sqlbusqueda
            $sqlorden
            LIMIT ? OFFSET ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "iiii", $id_paciente, $id_paciente, $registros, $inicio);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);

    $medicos = [];
    while($fila = mysqli_fetch_assoc($resultado)){
        $especialidad = "Sin especialidad";
        if (isset($fila["especialidad"]) && $fila["especialidad"] != ""){
            $especialidad = $fila["especialidad"];
        }
        $medicos[] = [
            "id_medico" => $fila["id_medico"],
            "nombre" => $fila["nombre"],
            "apellidos" => $fila["apellidos"],
            "foto" => $fila["foto_perfil"],
            "especialidad" => $especialidad,
            "id_valoracion" => $fila["id_valoracion"],
            "puntuacion" => $fila["puntuacion"],
            "comentario" => $fila["comentario"]
        ];
    }
    mysqli_stmt_close($sql_preparacion);

    return $medicos;
}
?>