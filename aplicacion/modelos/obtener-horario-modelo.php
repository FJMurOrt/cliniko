<?php
//FUNCIÓN PARA OBTENER EL HORARIO DEL MEDICO POR SU ID
function obtenerHorarioPorId($conexion, $id_disponibilidad, $id_medico){
    $sql = "SELECT * FROM disponibilidad_medicos 
            WHERE id_disponibilidad = ? AND id_medico = ?";

    $sql_preparacion = mysqli_prepare($conexion, $sql);
    if(!$sql_preparacion){
        return false;
    }

    mysqli_stmt_bind_param($sql_preparacion, "ii", $id_disponibilidad, $id_medico);
    mysqli_stmt_execute($sql_preparacion);

    $resultado = mysqli_stmt_get_result($sql_preparacion);
    $horario = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($sql_preparacion);

    if($horario){
        return $horario;
    }else{
        return false;
    }
}

//FUNCIÓN PARA OBTENER LAS HORAS SEGGÚN EL TURNO
function obtenerHorasPorTurno($turno){
    if($turno === "mañana"){
        return ["09:00","10:00","11:00","12:00","13:00","14:00"];
    }elseif($turno === "tarde"){
        return ["16:00","17:00","18:00","19:00","20:00"];
    }else{
        return [];
    }
}
?>