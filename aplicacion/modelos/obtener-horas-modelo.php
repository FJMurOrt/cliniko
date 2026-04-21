<?php
//FUNCIÓN PARA OBTENER EL RANGO DE DISPONIBILIAD DE UN MEDICO PARA UN DÍA EN UN TURNO
function obtenerRangoDisponibilidad($conexion, $id_medico, $fecha, $turno){
    $sql = "SELECT hora_inicio, hora_fin FROM disponibilidad_medicos 
            WHERE id_medico = ? AND fecha = ? AND turno = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "iss", $id_medico, $fecha, $turno);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    if ($fila){
        return $fila;
    }else{
        return false;
    }
}

//FUNCIÓN APRA OBTENER LAS HORAS YA RESERVADAS PARA UN DÍA
function obtenerHorasReservadas($conexion, $id_medico, $fecha){
    $sql = "SELECT TIME(fecha_cita) as hora FROM citas 
            WHERE id_medico = ? AND DATE(fecha_cita) = ? AND estado != 'cancelada'";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($sql_preparacion, "is", $id_medico, $fecha);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $horas_reservadas = [];

    while($fila = mysqli_fetch_assoc($resultado)){
        $horas_reservadas[] = substr($fila["hora"], 0, 5);
    }

    mysqli_stmt_close($sql_preparacion);

    return $horas_reservadas;
}

//PARA CALCULAR LAS HORAS DISPONIBLES
function calcularHorasDisponibles($hora_inicio, $hora_fin, $horas_reservadas, $fecha) {
    $inicio = strtotime($hora_inicio);
    $fin = strtotime($hora_fin);
    $horas = [];

    $hora_actual = null;
    if($fecha === date("Y-m-d")){
        $hora_actual = time();
    }

    while($inicio < $fin){
        $fin_cita = $inicio + 3600;
        if($fin_cita > $fin) break;

        $hora_str = date("H:i", $inicio);

        if(in_array($hora_str, $horas_reservadas) || ($hora_actual && $inicio <= $hora_actual)){
            $inicio += 3600;
            continue;
        }

        $horas[] = $hora_str . "-" . date("H:i", $fin_cita);
        $inicio += 3600;
    }

    if(empty($horas)){
        if($fecha === date("Y-m-d")){
            $horas[] = "Sin disponibilidad hoy";
        }else{
            $horas[] = "No quedan más horas";
        }
    }
    return $horas;
}
?>