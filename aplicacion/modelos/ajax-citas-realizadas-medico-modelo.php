<?php
require_once "../configuracion/config.php";

//PARA SABER CUANTAS CITAS REALIZADAS TIENE PARA LA PAGINACIÓN
function contarCitasRealizadasMedico($conexion, $id_medico, $fecha = "", $busqueda = "", $receta = "", $observaciones = ""){
    $filtro_busqueda = "";
    if($busqueda != ""){
        $filtro_busqueda = " AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))";
    }

    $filtro_receta = "";
    if($receta === "disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NOT NULL";
    } 
    if($receta === "no-disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NULL";
    }

    $filtro_observaciones = "";
    if($observaciones === "disponible"){
        $filtro_observaciones = " AND n.nota IS NOT NULL";
    } 
    if($observaciones === "no-disponible"){
        $filtro_observaciones = " AND n.nota IS NULL";
    }

    if($fecha != ""){
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_medico = ? 
                AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                $filtro_busqueda
                $filtro_receta
                $filtro_observaciones";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        if($busqueda != ""){
            mysqli_stmt_bind_param($preparacion_sql, "isss", $id_medico, $fecha, $busqueda, $busqueda);
        }else{
            mysqli_stmt_bind_param($preparacion_sql, "is", $id_medico, $fecha);
        }
    }else{
        $sql = "SELECT COUNT(*) as total FROM citas c
                INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_medico = ? 
                AND c.estado = 'realizada'
                $filtro_busqueda
                $filtro_receta
                $filtro_observaciones";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        if($busqueda != ""){
            mysqli_stmt_bind_param($preparacion_sql, "iss", $id_medico, $busqueda, $busqueda);
        }else{
            mysqli_stmt_bind_param($preparacion_sql, "i", $id_medico);
        }
    }
    mysqli_stmt_execute($preparacion_sql);
    mysqli_stmt_bind_result($preparacion_sql, $total);
    mysqli_stmt_fetch($preparacion_sql);
    mysqli_stmt_close($preparacion_sql);

    return $total;
}

//PARA OBTENER LAS CITAS
function obtenerCitasRealizadasMedico($conexion, $id_medico, $inicio, $registros, $fecha = "", $busqueda = "", $receta = "", $observaciones = ""){
    $filtro_busqueda = "";
    if($busqueda != ""){
        $filtro_busqueda = " AND (u.nombre LIKE CONCAT('%', ?, '%') OR u.apellidos LIKE CONCAT('%', ?, '%'))";
    }

    $filtro_receta = "";
    if($receta === "disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NOT NULL";
    } 
    if($receta === "no-disponible"){
        $filtro_receta = " AND r.archivo_pdf IS NULL";
    }

    $filtro_observaciones = "";
    if($observaciones === "disponible"){
        $filtro_observaciones = " AND n.nota IS NOT NULL";
    } 
    if($observaciones === "no-disponible"){
        $filtro_observaciones = " AND n.nota IS NULL";
    }

    if($fecha != ""){
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_medico = ? 
                AND c.estado = 'realizada'
                AND DATE(c.fecha_cita) = ?
                $filtro_busqueda
                $filtro_receta
                $filtro_observaciones
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        if($busqueda != ""){
            mysqli_stmt_bind_param($preparacion_sql, "isssii", $id_medico, $fecha, $busqueda, $busqueda, $registros, $inicio);
        }else{
            mysqli_stmt_bind_param($preparacion_sql, "isii", $id_medico, $fecha, $registros, $inicio);
        }
    }else{
        $sql = "SELECT c.id_cita, c.fecha_cita, u.nombre, u.apellidos, u.foto_perfil, r.archivo_pdf, n.nota FROM citas c
                INNER JOIN usuarios u ON c.id_paciente = u.id_usuario
                LEFT JOIN recetas r ON r.id_cita = c.id_cita
                LEFT JOIN notas n ON n.id_cita = c.id_cita
                WHERE c.id_medico = ? 
                AND c.estado = 'realizada'
                $filtro_busqueda
                $filtro_receta
                $filtro_observaciones
                ORDER BY c.fecha_cita DESC
                LIMIT ? OFFSET ?";

        $preparacion_sql = mysqli_prepare($conexion, $sql);
        if($busqueda != ""){
            mysqli_stmt_bind_param($preparacion_sql, "issii", $id_medico, $busqueda, $busqueda, $registros, $inicio);
        }else{
            mysqli_stmt_bind_param($preparacion_sql, "iii", $id_medico, $registros, $inicio);
        }
    }
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