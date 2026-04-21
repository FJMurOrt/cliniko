<?php
session_start();
require_once "../configuracion/config.php";
require_once "../modelos/actualizar-horario-medico-modelo.php";

//PARA MOSTRAR LOS ERRORES LUEGO, LOS GUARDO EN UN ARRAY ANTES
$errores = [];

//RECOGEMOS LOS DATOS
$id_disponibilidad = null;
if(isset($_POST["id_disponibilidad"])){
    $id_disponibilidad = $_POST["id_disponibilidad"];
}

$hora_inicio = null;
if(isset($_POST["hora_inicio"])){
    $hora_inicio = $_POST["hora_inicio"];
}

$hora_fin = null;
if(isset($_POST["hora_fin"])){
    $hora_fin = $_POST["hora_fin"];
}

$id_medico = null;
if(isset($_SESSION["id_medico"])){
    $id_medico = $_SESSION["id_medico"];
}

//COMPRUEBO QUE TENGO EL ID DE LA DISPONIBILIDAD A LA QUE ESTOY INTENTANDO ACCEDER Y QUE TENGO TAMBIÉN EL ID DEL MÉDICO DEL PANEL
if(!$id_disponibilidad || !$id_medico){
    $errores[] = "Hubo un problema al intentar identicar el id del médico o la disponibilidad.";
}

//OBTENGO LOS DATOS DEL HORARIO AL QUE QUIERO ACCEDER CON EL ID DE LA DISPONIBILIDAD Y DEL MÉDICO
if(empty($errores)){
    $horario = obtenerDisponibilidad($conexion, $id_disponibilidad, $id_medico);

    if(!$horario){
        $errores[] = "Horario no encontrado";
    }else{
        $turno = $horario["turno"];
        $fecha = $horario["fecha"];
    }
}

//CON ESTO VALIDO LAS HORAS DE MANERA QUE LA HORA DE INCIIO NO PUEDE SER MAYOR A LA FINALIZACIÓN
if(empty($errores)){
    if($hora_inicio >= $hora_fin){
        $errores[] = "La hora de inicio debe ser menor que la de fin";
    }
}

//VALIDO TAMBIÉN EL TURNO Y QUE LA HORA ESTA DENTRO DEL TURNO
if(empty($errores)){
    $horas_manana = ["09:00","10:00","11:00","12:00","13:00","14:00"];
    $horas_tarde  = ["16:00","17:00","18:00","19:00","20:00"];

    $horas_turno = $horas_tarde;
    if($turno === "mañana"){
        $horas_turno = $horas_manana;
    }

    if(!in_array($hora_inicio, $horas_turno) || !in_array($hora_fin, $horas_turno)){
        $errores[] = "Horas fuera del turno";
    }
}

//COMPRUEBO QUE NO SE QUEDEN CITAS FUERA AL ACTUALIZAR AL NUEVO HORARIO
if(empty($errores)){
    $total = contarCitasFueraHorario($conexion, $id_medico, $fecha, $hora_inicio, $hora_fin);

    if($total > 0){
        $errores[] = "Ya existen citas en horas que quieres eliminar";
    }
}

//SI HAY ERRORES, VUELVO A CARGAR LA PÁGINA Y SE MOSTRARÍAN EN EL HTML DE EDITAR HORARIO
if(!empty($errores)){
    $_SESSION["errores"] = $errores;
    header("Location: ../vistas/medico/editar-horario.php?id=$id_disponibilidad");
    exit;
}

//Y SI SIGUE, PUES SE ACTUALIZA EL HORARIO
actualizarDisponibilidad($conexion, $hora_inicio, $hora_fin, $id_disponibilidad);

$_SESSION["actualizado"] = "La disponibilidad fue actualizada correctamente.";
header("Location: ../vistas/medico/ver-horarios.php");
exit;
?>