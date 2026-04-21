<?php
//FUNCION PARA CONTAR EL TOTAL DE PACIENTES PARA EL NÚMERO DE PÁGINAS
function obtenerTotalPacientes($conexion, $id_medico, $busqueda = "", $historial = null, $edad = null){
    $sqlhistorial = "";
    if($historial === "disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NOT NULL";
    }
    if($historial === "no-disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NULL";
    }

    $sqledad = "";
    if($edad === "joven"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 0 AND 30";
    }  
    if($edad === "adulto"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 31 AND 60"; 
    } 
    if($edad === "mayor"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) > 60";
    }

    if($busqueda != ""){
        $sql = "SELECT COUNT(DISTINCT c.id_paciente) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
                WHERE c.id_medico = ? 
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))
                $sqlhistorial
                $sqledad";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iiss", $id_medico, $id_medico, $busqueda, $busqueda);
    }else{
        $sql = "SELECT COUNT(DISTINCT c.id_paciente) as total FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
                WHERE c.id_medico = ?
                $sqlhistorial
                $sqledad";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "ii", $id_medico, $id_medico);
    }

    mysqli_stmt_execute($sql_preparacion);
    $result = mysqli_stmt_get_result($sql_preparacion);
    $total = mysqli_fetch_assoc($result)["total"];

    mysqli_stmt_close($sql_preparacion);
    return $total;
}

function obtenerPacientes($conexion, $id_medico, $inicio, $registros, $busqueda = "", $historial = null, $orden = null, $edad = null){
    $sqlhistorial = "";
    if($historial === "disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NOT NULL";
    }
    if($historial === "no-disponible"){
        $sqlhistorial = " AND h.archivo_pdf IS NULL";
    } 

    $sqlorden = "";
    if($orden === "asc"){
        $sqlorden = "ORDER BY u.apellidos ASC";
    }
    if($orden === "desc"){
        $sqlorden = "ORDER BY u.apellidos DESC";
    }

    $sqledad = "";
    if($edad === "joven"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 0 AND 30";
    }  
    if($edad === "adulto"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) BETWEEN 31 AND 60"; 
    } 
    if($edad === "mayor"){
        $sqledad = " AND TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) > 60";
    }
    
    if($busqueda != ""){
        $sql = "SELECT DISTINCT p.id_paciente, u.nombre, u.apellidos, u.foto_perfil, p.fecha_nacimiento, h.archivo_pdf FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
                WHERE c.id_medico = ? 
                AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))
                $sqlhistorial
                $sqledad
                $sqlorden
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iissii", $id_medico, $id_medico, $busqueda, $busqueda, $registros, $inicio);
    }else{
        $sql = "SELECT DISTINCT p.id_paciente, u.nombre, u.apellidos, u.foto_perfil, p.fecha_nacimiento, h.archivo_pdf FROM citas c
                INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
                INNER JOIN usuarios u ON p.id_paciente = u.id_usuario
                LEFT JOIN historiales_medicos h ON h.id_paciente = p.id_paciente AND h.id_medico = ?
                WHERE c.id_medico = ?
                $sqlhistorial
                $sqledad
                $sqlorden 
                LIMIT ? OFFSET ?";

        $sql_preparacion = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($sql_preparacion, "iiii", $id_medico, $id_medico, $registros, $inicio);
    }

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